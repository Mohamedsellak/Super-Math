<?php

namespace App\Services;

use ZipArchive;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class DocxMergeService
{
    public function merge(array $docxFiles, string $outputFilename = 'merged.docx')
    {
        $outputPath = storage_path("app/temp/{$outputFilename}");
        
        // Ensure temp directory exists
        if (!file_exists(storage_path('app/temp'))) {
            mkdir(storage_path('app/temp'), 0755, true);
        }

        try {
            // Use the first document as the base
            $baseFile = $docxFiles[0];
            $baseZip = new ZipArchive;
            
            if ($baseZip->open($baseFile) !== TRUE) {
                throw new \Exception("Cannot open base document: {$baseFile}");
            }
            
            $baseZip->extractTo(storage_path('app/temp/base'));
            $baseZip->close();

            // Load the base document XML
            $baseDocPath = storage_path('app/temp/base/word/document.xml');
            $bodyXml = simplexml_load_string(file_get_contents($baseDocPath));
            $bodyXml->registerXPathNamespace('w', 'http://schemas.openxmlformats.org/wordprocessingml/2006/main');

            // Get the body element from base document
            $body = $bodyXml->xpath('//w:body')[0];

            // Add page break before answer section
            $this->addPageBreak($body);
            
            // Add answer section title
            $this->addAnswerSectionTitle($body);

            // Iterate over the remaining documents (answer documents)
            for ($i = 1; $i < count($docxFiles); $i++) {
                $tempPath = storage_path("app/temp/doc{$i}");
                $zip = new ZipArchive;
                
                if ($zip->open($docxFiles[$i]) !== TRUE) {
                    Log::warning("Cannot open document: {$docxFiles[$i]}");
                    continue;
                }
                
                $zip->extractTo($tempPath);
                $zip->close();

                // Load the next document XML
                $nextXml = simplexml_load_string(file_get_contents("$tempPath/word/document.xml"));
                $nextXml->registerXPathNamespace('w', 'http://schemas.openxmlformats.org/wordprocessingml/2006/main');

                $nextBody = $nextXml->xpath('//w:body')[0];

                // Merge content from next document into base document
                foreach ($nextBody->children() as $child) {
                    // Skip sectPr (section properties) as we want to keep the base document's formatting
                    if ($child->getName() !== 'sectPr') {
                        $dom = dom_import_simplexml($body);
                        $imported = $dom->ownerDocument->importNode(dom_import_simplexml($child), true);
                        $dom->appendChild($imported);
                    }
                }

                // Merge supporting files (media, embeddings, relationships)
                $this->mergeFolder("$tempPath/word/media", storage_path('app/temp/base/word/media'));
                $this->mergeFolder("$tempPath/word/embeddings", storage_path('app/temp/base/word/embeddings'));
                $this->mergeRelationships("$tempPath/word/_rels", storage_path('app/temp/base/word/_rels'));
            }

            // Save the modified XML back
            file_put_contents($baseDocPath, $bodyXml->asXML());

            // Zip everything back to a new .docx
            $this->zipFolder(storage_path('app/temp/base'), $outputPath);

            // Clean up temporary directories
            $this->deleteDirectory(storage_path('app/temp/base'));
            for ($i = 1; $i < count($docxFiles); $i++) {
                $this->deleteDirectory(storage_path("app/temp/doc{$i}"));
            }

            return $outputPath;

        } catch (\Exception $e) {
            // Clean up on error
            $this->deleteDirectory(storage_path('app/temp'));
            throw $e;
        }
    }

    private function addPageBreak($body)
    {
        $pageBreak = $body->addChild('w:p', '', 'http://schemas.openxmlformats.org/wordprocessingml/2006/main');
        $run = $pageBreak->addChild('w:r', '', 'http://schemas.openxmlformats.org/wordprocessingml/2006/main');
        $br = $run->addChild('w:br', '', 'http://schemas.openxmlformats.org/wordprocessingml/2006/main');
        $br->addAttribute('w:type', 'page');
    }

    private function addAnswerSectionTitle($body)
    {
        $titleParagraph = $body->addChild('w:p', '', 'http://schemas.openxmlformats.org/wordprocessingml/2006/main');
        $run = $titleParagraph->addChild('w:r', '', 'http://schemas.openxmlformats.org/wordprocessingml/2006/main');
        
        // Add formatting for the title
        $runProps = $run->addChild('w:rPr', '', 'http://schemas.openxmlformats.org/wordprocessingml/2006/main');
        $runProps->addChild('w:b', '', 'http://schemas.openxmlformats.org/wordprocessingml/2006/main'); // Bold
        $size = $runProps->addChild('w:sz', '', 'http://schemas.openxmlformats.org/wordprocessingml/2006/main');
        $size->addAttribute('w:val', '32'); // 16pt font size
        
        $text = $run->addChild('w:t', 'ANSWER SECTION', 'http://schemas.openxmlformats.org/wordprocessingml/2006/main');
    }

    private function mergeFolder($source, $destination)
    {
        if (!is_dir($source)) {
            return;
        }
        
        if (!is_dir($destination)) {
            mkdir($destination, 0777, true);
        }

        foreach (scandir($source) as $file) {
            if (!in_array($file, ['.', '..'])) {
                $sourcePath = "$source/$file";
                $destPath = "$destination/$file";
                
                // Handle file name conflicts by adding suffix
                $counter = 1;
                while (file_exists($destPath)) {
                    $pathInfo = pathinfo($file);
                    $name = $pathInfo['filename'];
                    $extension = isset($pathInfo['extension']) ? '.' . $pathInfo['extension'] : '';
                    $destPath = "$destination/{$name}_ans_{$counter}{$extension}";
                    $counter++;
                }
                
                copy($sourcePath, $destPath);
            }
        }
    }

    private function mergeRelationships($source, $destination)
    {
        if (!is_dir($source)) {
            return;
        }
        
        if (!is_dir($destination)) {
            mkdir($destination, 0777, true);
        }

        // For relationships, we need to be more careful to avoid ID conflicts
        foreach (scandir($source) as $file) {
            if (!in_array($file, ['.', '..']) && pathinfo($file, PATHINFO_EXTENSION) === 'rels') {
                $sourcePath = "$source/$file";
                $destPath = "$destination/$file";
                
                if (file_exists($destPath)) {
                    // Merge relationship files instead of overwriting
                    $this->mergeRelationshipFile($sourcePath, $destPath);
                } else {
                    copy($sourcePath, $destPath);
                }
            }
        }
    }

    private function mergeRelationshipFile($sourcePath, $destPath)
    {
        try {
            $sourceXml = simplexml_load_string(file_get_contents($sourcePath));
            $destXml = simplexml_load_string(file_get_contents($destPath));
            
            // Get existing relationship IDs to avoid conflicts
            $existingIds = [];
            foreach ($destXml->Relationship as $rel) {
                $existingIds[] = (string)$rel['Id'];
            }
            
            // Add relationships from source, generating new IDs if needed
            $counter = 100; // Start from high number to avoid conflicts
            foreach ($sourceXml->Relationship as $rel) {
                $newId = (string)$rel['Id'];
                
                // Generate new ID if conflict exists
                while (in_array($newId, $existingIds)) {
                    $newId = 'rId' . $counter;
                    $counter++;
                }
                
                $existingIds[] = $newId;
                
                // Add the relationship to destination
                $newRel = $destXml->addChild('Relationship');
                $newRel->addAttribute('Id', $newId);
                $newRel->addAttribute('Type', (string)$rel['Type']);
                $newRel->addAttribute('Target', (string)$rel['Target']);
            }
            
            file_put_contents($destPath, $destXml->asXML());
            
        } catch (\Exception $e) {
            Log::warning("Could not merge relationship file {$sourcePath}: " . $e->getMessage());
            // Fall back to simple copy
            copy($sourcePath, $destPath);
        }
    }

    private function zipFolder($folder, $zipFile)
    {
        $zip = new ZipArchive;
        
        if ($zip->open($zipFile, ZipArchive::CREATE | ZipArchive::OVERWRITE) !== TRUE) {
            throw new \Exception("Cannot create ZIP file: {$zipFile}");
        }

        $files = new \RecursiveIteratorIterator(
            new \RecursiveDirectoryIterator($folder),
            \RecursiveIteratorIterator::LEAVES_ONLY
        );

        foreach ($files as $name => $file) {
            if (!$file->isDir()) {
                $filePath = $file->getRealPath();
                $relativePath = substr($filePath, strlen($folder) + 1);
                
                // Normalize path separators for cross-platform compatibility
                $relativePath = str_replace('\\', '/', $relativePath);
                
                $zip->addFile($filePath, $relativePath);
            }
        }

        $zip->close();
    }

    private function deleteDirectory($dir)
    {
        if (!file_exists($dir)) {
            return;
        }

        foreach (scandir($dir) as $item) {
            if ($item === '.' || $item === '..') {
                continue;
            }
            
            $path = $dir . DIRECTORY_SEPARATOR . $item;
            
            if (is_dir($path)) {
                $this->deleteDirectory($path);
            } else {
                unlink($path);
            }
        }

        rmdir($dir);
    }
}
