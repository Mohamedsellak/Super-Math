<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\CreditHistory;
use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class UserQuestionsController extends Controller
{
    public function index()
    {
        // This method will handle the logic for displaying a list of questions.
        // You can retrieve questions from the database and return a view.
        return view('user.questions.index', ['questions' => Question::all()]);
    }

    /**
     * Handle the download request for selected questions.
     */
    public function download(Request $request)
    {
        $selectedQuestions = $request->input('selected_questions', []);

        if (is_string($selectedQuestions)) {
            $selectedQuestions = json_decode($selectedQuestions, true);
        }

        // Validate the selected questions
        if (empty($selectedQuestions)) {
            return redirect()->back()->with('error', 'No questions selected for download.');
        }

        if (Auth::user()->credit < count($selectedQuestions)) {
            return redirect()->back()->with('error', 'Insufficient credits for download.');
        }

        if (count($selectedQuestions) === 1) {
            // Handle single question download
            $question = Question::find($selectedQuestions[0]);
            if (!$question) {
                return redirect()->back()->with('error', 'Question not found.');
            }
            return $this->downloadSingleDocument($question);
        }

        // Handle multiple questions download
        return $this->downloadMultipleDocuments($selectedQuestions);

    }

    /**
     * Download the document file with question and answer merged into one document using ZIP approach
     */
    public function downloadSingleDocument(Question $question)
    {
        // Check if question document exists
        if (!$question->doc || !Storage::disk('local')->exists($question->doc)) {
            abort(404, 'Question document not found.');
        }

        try {
            $questionDocPath = Storage::disk('local')->path($question->doc);
            $answerDocPath = null;
            
            // Check if answer document exists
            if ($question->answer_doc && Storage::disk('local')->exists($question->answer_doc)) {
                $answerDocPath = Storage::disk('local')->path($question->answer_doc);
            }

            // Generate temporary file for download
            $tempPath = storage_path('app/temp/merged_question_' . $question->id . '_' . time() . '.docx');

            // Ensure temp directory exists
            if (!file_exists(dirname($tempPath))) {
                mkdir(dirname($tempPath), 0755, true);
            }

            // Use a simple file-based approach first to test OLE preservation
            if ($answerDocPath) {
                $this->mergeDocumentsMinimalIntervention($questionDocPath, $answerDocPath, $tempPath);
            } else {
                // If no answer document, just copy the question document
                copy($questionDocPath, $tempPath);
            }

            $fileName = 'question_' . $question->id . '_complete_document.docx';

            // Decrement user's credit
            auth()->user()->decrement('credit');

            // Add credit history
            CreditHistory::create([
                'user_id' => auth()->user()->id,
                'action' => 'Download',
                'amount' => '- 1',
                'description' => 'Download question document (ID: ' . $question->id . ')',
            ]);

            // Return download response and delete temp file after download
            return response()->download($tempPath, $fileName)->deleteFileAfterSend(true);

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error creating merged document: ' . $e->getMessage());
        }
    }

    /**
     * Minimal intervention approach - preserve OLE objects by doing minimal modification
     */
    private function mergeDocumentsMinimalIntervention($questionDocPath, $answerDocPath, $outputPath)
    {
        try {
            // Start by copying the question document (preserves all its OLE objects)
            copy($questionDocPath, $outputPath);

            // Now we'll append the answer content using the simplest possible method
            $tempDir = storage_path('app/temp/minimal_merge_' . time());
            mkdir($tempDir, 0755, true);

            // Extract the answer document to get its content
            $answerExtractDir = $tempDir . '/answer';
            mkdir($answerExtractDir, 0755, true);
            $this->extractDocx($answerDocPath, $answerExtractDir);

            // Extract the output document (which is currently just the question doc)
            $outputExtractDir = $tempDir . '/output';
            mkdir($outputExtractDir, 0755, true);
            $this->extractDocx($outputPath, $outputExtractDir);

            // Read both document XMLs
            $outputDocXmlPath = $outputExtractDir . '/word/document.xml';
            $answerDocXmlPath = $answerExtractDir . '/word/document.xml';

            if (file_exists($outputDocXmlPath) && file_exists($answerDocXmlPath)) {
                $outputXml = file_get_contents($outputDocXmlPath);
                $answerXml = file_get_contents($answerDocXmlPath);

                // Use simple string manipulation to append answer content
                $mergedXml = $this->appendAnswerContentSimple($outputXml, $answerXml);
                file_put_contents($outputDocXmlPath, $mergedXml);
            }

            // Copy any additional media from answer if it doesn't conflict
            $this->copyNonConflictingMedia($answerExtractDir, $outputExtractDir);

            // Recreate the DOCX
            $this->createDocx($outputExtractDir, $outputPath);

            // Clean up
            $this->removeDirectory($tempDir);

        } catch (\Exception $e) {
            // Fallback to just copying the question document
            copy($questionDocPath, $outputPath);
            throw new \Exception("Minimal merge failed: " . $e->getMessage());
        }
    }

    /**
     * Simple string-based XML content appending
     */
    private function appendAnswerContentSimple($questionXml, $answerXml)
    {
        // Extract the body content from answer XML
        $answerDoc = new \DOMDocument();
        $answerDoc->loadXML($answerXml);
        $answerBody = $answerDoc->getElementsByTagName('body')->item(0);

        $questionDoc = new \DOMDocument();
        $questionDoc->loadXML($questionXml);
        $questionBody = $questionDoc->getElementsByTagName('body')->item(0);

        if ($answerBody && $questionBody) {
            // Add a simple page break
            $pageBreak = $questionDoc->createElementNS(
                'http://schemas.openxmlformats.org/wordprocessingml/2006/main',
                'w:p'
            );
            $pageBreakRun = $questionDoc->createElementNS(
                'http://schemas.openxmlformats.org/wordprocessingml/2006/main',
                'w:r'
            );
            $br = $questionDoc->createElementNS(
                'http://schemas.openxmlformats.org/wordprocessingml/2006/main',
                'w:br'
            );
            $br->setAttribute('w:type', 'page');
            $pageBreakRun->appendChild($br);
            $pageBreak->appendChild($pageBreakRun);
            $questionBody->appendChild($pageBreak);

            // Add answer title
            $answerTitle = $questionDoc->createElementNS(
                'http://schemas.openxmlformats.org/wordprocessingml/2006/main',
                'w:p'
            );
            $answerTitleRun = $questionDoc->createElementNS(
                'http://schemas.openxmlformats.org/wordprocessingml/2006/main',
                'w:r'
            );
            $answerTitleText = $questionDoc->createElementNS(
                'http://schemas.openxmlformats.org/wordprocessingml/2006/main',
                'w:t',
                'ANSWER:'
            );
            $answerTitleRun->appendChild($answerTitleText);
            $answerTitle->appendChild($answerTitleRun);
            $questionBody->appendChild($answerTitle);

            // Import all answer content
            foreach ($answerBody->childNodes as $child) {
                if ($child->nodeType === XML_ELEMENT_NODE) {
                    $imported = $questionDoc->importNode($child, true);
                    $questionBody->appendChild($imported);
                }
            }
        }

        return $questionDoc->saveXML();
    }

    /**
     * Copy media files that don't conflict
     */
    private function copyNonConflictingMedia($answerDir, $outputDir)
    {
        $answerMediaDir = $answerDir . '/word/media';
        $outputMediaDir = $outputDir . '/word/media';

        if (is_dir($answerMediaDir)) {
            if (!is_dir($outputMediaDir)) {
                mkdir($outputMediaDir, 0755, true);
            }

            $files = scandir($answerMediaDir);
            foreach ($files as $file) {
                if ($file !== '.' && $file !== '..') {
                    $sourcePath = $answerMediaDir . '/' . $file;
                    $destPath = $outputMediaDir . '/' . $file;
                    
                    // Only copy if it doesn't already exist
                    if (!file_exists($destPath)) {
                        copy($sourcePath, $destPath);
                    }
                }
            }
        }

        // Copy embeddings if they don't exist
        $answerEmbeddingsDir = $answerDir . '/word/embeddings';
        $outputEmbeddingsDir = $outputDir . '/word/embeddings';

        if (is_dir($answerEmbeddingsDir) && !is_dir($outputEmbeddingsDir)) {
            $this->copyDirectory($answerEmbeddingsDir, $outputEmbeddingsDir);
        }
    }

    /**
     * Conservative merge that better preserves OLE objects by maintaining original structure
     */
    private function mergeDocumentsUsingZipConservative($questionDocPath, $answerDocPath, $outputPath)
    {
        // Create temporary directories
        $tempDir = storage_path('app/temp/merge_conservative_' . time());
        $questionDir = $tempDir . '/question';
        $answerDir = $tempDir . '/answer';
        $mergedDir = $tempDir . '/merged';

        try {
            // Create directories
            mkdir($questionDir, 0755, true);
            mkdir($answerDir, 0755, true);
            mkdir($mergedDir, 0755, true);

            // Extract both documents
            $this->extractDocx($questionDocPath, $questionDir);
            $this->extractDocx($answerDocPath, $answerDir);

            // Start with the question document as the base (preserves its OLE objects)
            $this->copyDirectory($questionDir, $mergedDir);

            // Read and merge the XML content more carefully
            $this->mergeXmlContentConservative($questionDir, $answerDir, $mergedDir);

            // Merge media and embeddings with unique naming
            $this->mergeMediaFilesConservative($answerDir, $mergedDir);

            // Update content types and relationships
            $this->updateContentTypes($answerDir, $mergedDir);
            $this->updateRelationships($answerDir, $mergedDir);

            // Create the final DOCX file
            $this->createDocx($mergedDir, $outputPath);

        } finally {
            // Clean up temporary directories
            if (is_dir($tempDir)) {
                $this->removeDirectory($tempDir);
            }
        }
    }

    /**
     * Conservative XML content merging that preserves OLE object structure
     */
    private function mergeXmlContentConservative($questionDir, $answerDir, $mergedDir)
    {
        $questionDocXml = file_get_contents($mergedDir . '/word/document.xml');
        $answerDocXml = file_get_contents($answerDir . '/word/document.xml');

        // Parse XML documents
        $questionDoc = new \DOMDocument();
        $questionDoc->preserveWhiteSpace = false;
        $questionDoc->formatOutput = true;
        $questionDoc->loadXML($questionDocXml);

        $answerDoc = new \DOMDocument();
        $answerDoc->preserveWhiteSpace = false;
        $answerDoc->formatOutput = true;
        $answerDoc->loadXML($answerDocXml);

        // Get the body elements
        $questionBody = $questionDoc->getElementsByTagName('body')->item(0);
        $answerBody = $answerDoc->getElementsByTagName('body')->item(0);

        // Instead of complex merging, just append answer content at the end
        if ($answerBody && $answerBody->hasChildNodes()) {
            // Add page break before answer
            $pageBreakParagraph = $questionDoc->createElementNS(
                'http://schemas.openxmlformats.org/wordprocessingml/2006/main',
                'w:p'
            );
            $pageBreakRun = $questionDoc->createElementNS(
                'http://schemas.openxmlformats.org/wordprocessingml/2006/main',
                'w:r'
            );
            $pageBreak = $questionDoc->createElementNS(
                'http://schemas.openxmlformats.org/wordprocessingml/2006/main',
                'w:br'
            );
            $pageBreak->setAttribute('w:type', 'page');
            $pageBreakRun->appendChild($pageBreak);
            $pageBreakParagraph->appendChild($pageBreakRun);
            $questionBody->appendChild($pageBreakParagraph);

            // Add answer title
            $answerTitleParagraph = $questionDoc->createElementNS(
                'http://schemas.openxmlformats.org/wordprocessingml/2006/main',
                'w:p'
            );
            $answerTitleRun = $questionDoc->createElementNS(
                'http://schemas.openxmlformats.org/wordprocessingml/2006/main',
                'w:r'
            );
            $answerTitleProps = $questionDoc->createElementNS(
                'http://schemas.openxmlformats.org/wordprocessingml/2006/main',
                'w:rPr'
            );
            $answerTitleBold = $questionDoc->createElementNS(
                'http://schemas.openxmlformats.org/wordprocessingml/2006/main',
                'w:b'
            );
            $answerTitleSize = $questionDoc->createElementNS(
                'http://schemas.openxmlformats.org/wordprocessingml/2006/main',
                'w:sz'
            );
            $answerTitleSize->setAttribute('w:val', '28');
            $answerTitleColor = $questionDoc->createElementNS(
                'http://schemas.openxmlformats.org/wordprocessingml/2006/main',
                'w:color'
            );
            $answerTitleColor->setAttribute('w:val', '008000');
            
            $answerTitleProps->appendChild($answerTitleBold);
            $answerTitleProps->appendChild($answerTitleSize);
            $answerTitleProps->appendChild($answerTitleColor);
            $answerTitleRun->appendChild($answerTitleProps);
            
            $answerTitleText = $questionDoc->createElementNS(
                'http://schemas.openxmlformats.org/wordprocessingml/2006/main',
                'w:t',
                'ANSWER'
            );
            $answerTitleRun->appendChild($answerTitleText);
            $answerTitleParagraph->appendChild($answerTitleRun);
            $questionBody->appendChild($answerTitleParagraph);

            // Add line break after title
            $lineBreakParagraph = $questionDoc->createElementNS(
                'http://schemas.openxmlformats.org/wordprocessingml/2006/main',
                'w:p'
            );
            $questionBody->appendChild($lineBreakParagraph);

            // Import and append answer content with minimal modification
            foreach ($answerBody->childNodes as $node) {
                if ($node->nodeType === XML_ELEMENT_NODE) {
                    $importedNode = $questionDoc->importNode($node, true);
                    $questionBody->appendChild($importedNode);
                }
            }
        }

        // Save the merged XML
        file_put_contents($mergedDir . '/word/document.xml', $questionDoc->saveXML());
    }

    /**
     * Conservative media file merging with better OLE preservation
     */
    private function mergeMediaFilesConservative($answerDir, $mergedDir)
    {
        // Merge media files (images, etc.) - but be more careful with naming
        $answerMediaDir = $answerDir . '/word/media';
        $mergedMediaDir = $mergedDir . '/word/media';

        if (is_dir($answerMediaDir)) {
            if (!is_dir($mergedMediaDir)) {
                mkdir($mergedMediaDir, 0755, true);
            }

            $existingFiles = is_dir($mergedMediaDir) ? scandir($mergedMediaDir) : [];
            $fileCounter = count($existingFiles) - 2; // Subtract . and ..

            $files = scandir($answerMediaDir);
            foreach ($files as $file) {
                if ($file !== '.' && $file !== '..') {
                    $sourcePath = $answerMediaDir . '/' . $file;
                    
                    // Try to preserve original filename if possible, otherwise rename
                    $destPath = $mergedMediaDir . '/' . $file;
                    if (file_exists($destPath)) {
                        $pathInfo = pathinfo($file);
                        $newFileName = $pathInfo['filename'] . '_answer_' . $fileCounter . '.' . $pathInfo['extension'];
                        $destPath = $mergedMediaDir . '/' . $newFileName;
                        $fileCounter++;
                    }
                    copy($sourcePath, $destPath);
                }
            }
        }

        // Merge embeddings (OLE objects) - CRITICAL for equation editing
        $answerEmbeddingsDir = $answerDir . '/word/embeddings';
        $mergedEmbeddingsDir = $mergedDir . '/word/embeddings';

        if (is_dir($answerEmbeddingsDir)) {
            if (!is_dir($mergedEmbeddingsDir)) {
                mkdir($mergedEmbeddingsDir, 0755, true);
            }

            // Copy all embedding files preserving exact structure and filenames
            $embeddingFiles = scandir($answerEmbeddingsDir);
            foreach ($embeddingFiles as $file) {
                if ($file !== '.' && $file !== '..') {
                    $sourcePath = $answerEmbeddingsDir . '/' . $file;
                    $destPath = $mergedEmbeddingsDir . '/' . $file;
                    
                    // If file exists, create unique name but preserve extension
                    if (file_exists($destPath)) {
                        $pathInfo = pathinfo($file);
                        $counter = 1;
                        do {
                            $newFileName = $pathInfo['filename'] . '_' . $counter . '.' . $pathInfo['extension'];
                            $destPath = $mergedEmbeddingsDir . '/' . $newFileName;
                            $counter++;
                        } while (file_exists($destPath));
                    }
                    
                    copy($sourcePath, $destPath);
                }
            }
        }

        // Copy any OLE-related directories that might exist
        $oleDirectories = ['customXml', 'docProps'];
        foreach ($oleDirectories as $oleDir) {
            $sourceOleDir = $answerDir . '/' . $oleDir;
            $mergedOleDir = $mergedDir . '/' . $oleDir;
            
            if (is_dir($sourceOleDir) && !is_dir($mergedOleDir)) {
                $this->copyDirectory($sourceOleDir, $mergedOleDir);
            }
        }
    }

    /**
     * Merge two DOCX documents using ZIP manipulation to preserve OLE objects
     */
    private function mergeDocumentsUsingZip($questionDocPath, $answerDocPath, $outputPath)
    {
        // Create temporary directories
        $tempDir = storage_path('app/temp/merge_' . time());
        $questionDir = $tempDir . '/question';
        $answerDir = $tempDir . '/answer';
        $mergedDir = $tempDir . '/merged';

        try {
            // Create directories
            mkdir($questionDir, 0755, true);
            mkdir($answerDir, 0755, true);
            mkdir($mergedDir, 0755, true);

            // Extract both documents
            $this->extractDocx($questionDocPath, $questionDir);
            $this->extractDocx($answerDocPath, $answerDir);

            // Merge the documents
            $this->mergeExtractedDocuments($questionDir, $answerDir, $mergedDir);

            // Create the final DOCX file
            $this->createDocx($mergedDir, $outputPath);

        } finally {
            // Clean up temporary directories
            if (is_dir($tempDir)) {
                $this->removeDirectory($tempDir);
            }
        }
    }

    /**
     * Extract DOCX file (ZIP archive)
     */
    private function extractDocx($docxPath, $extractDir)
    {
        $zip = new \ZipArchive();
        if ($zip->open($docxPath) === TRUE) {
            $zip->extractTo($extractDir);
            $zip->close();
        } else {
            throw new \Exception("Cannot open DOCX file: $docxPath");
        }
    }

    /**
     * Merge extracted DOCX documents
     */
    private function mergeExtractedDocuments($questionDir, $answerDir, $mergedDir)
    {
        // Copy question document as base
        $this->copyDirectory($questionDir, $mergedDir);

        // Read the main document XML from question
        $questionDocXml = file_get_contents($mergedDir . '/word/document.xml');

        // Read the main document XML from answer
        $answerDocXml = file_get_contents($answerDir . '/word/document.xml');

        // Parse XML to merge content
        $mergedXml = $this->mergeDocumentXml($questionDocXml, $answerDocXml);

        // Write merged XML
        file_put_contents($mergedDir . '/word/document.xml', $mergedXml);

        // Merge media files (images, OLE objects, etc.)
        $this->mergeMediaFiles($answerDir, $mergedDir);

        // Update relationships and content types
        $this->updateRelationships($answerDir, $mergedDir);
        $this->updateContentTypes($answerDir, $mergedDir);
    }

    /**
     * Merge document XML content with professional header
     */
    private function mergeDocumentXml($questionXml, $answerXml)
    {
        // Load XML documents
        $questionDoc = new \DOMDocument();
        $questionDoc->loadXML($questionXml);

        $answerDoc = new \DOMDocument();
        $answerDoc->loadXML($answerXml);

        // Get the body element from question document
        $questionBody = $questionDoc->getElementsByTagName('body')->item(0);

        // Create a new body to reorganize content
        $newBody = $questionDoc->createElementNS(
            'http://schemas.openxmlformats.org/wordprocessingml/2006/main',
            'w:body'
        );

        // Add SuperMath header for single document
        $this->addSuperMathHeaderSingle($questionDoc, $newBody);

        // Add page break after header
        $this->addPageBreak($questionDoc, $newBody);

        // Add question section title
        $this->addSectionTitleSingle($questionDoc, $newBody, 'QUESTION', '0000FF');

        // Copy original question content
        foreach ($questionBody->childNodes as $element) {
            if ($element->nodeType === XML_ELEMENT_NODE) {
                $importedElement = $questionDoc->importNode($element, true);
                $newBody->appendChild($importedElement);
            }
        }

        // Add page break before answer
        $this->addPageBreak($questionDoc, $newBody);

        // Add answer section title
        $this->addSectionTitleSingle($questionDoc, $newBody, 'ANSWER', '008000');

        // Get all content from answer document body
        $answerBody = $answerDoc->getElementsByTagName('body')->item(0);
        $answerElements = $answerBody->childNodes;

        // Import and append answer content with relationship ID updates
        foreach ($answerElements as $element) {
            if ($element->nodeType === XML_ELEMENT_NODE) {
                $importedElement = $questionDoc->importNode($element, true);
                // Update any relationship IDs in the imported content
                $this->updateElementRelationshipIds($importedElement, $questionDoc);
                $newBody->appendChild($importedElement);
            }
        }

        // Replace the old body with the new one
        $questionBody->parentNode->replaceChild($newBody, $questionBody);

        return $questionDoc->saveXML();
    }

    /**
     * Update relationship IDs in XML elements to preserve OLE object links
     */
    private function updateElementRelationshipIds($element, $doc)
    {
        // Find all elements that might contain relationship IDs
        if ($element->hasAttributes()) {
            foreach ($element->attributes as $attr) {
                if (strpos($attr->name, 'id') !== false && strpos($attr->value, 'rId') !== false) {
                    // This is a relationship ID that might need updating
                    // For now, we'll preserve the original IDs as much as possible
                    // In a more complex implementation, we'd maintain a mapping of old to new IDs
                }
            }
        }

        // Recursively update child elements
        if ($element->hasChildNodes()) {
            foreach ($element->childNodes as $child) {
                if ($child->nodeType === XML_ELEMENT_NODE) {
                    $this->updateElementRelationshipIds($child, $doc);
                }
            }
        }
    }

    /**
     * Add SuperMath header for single document
     */
    private function addSuperMathHeaderSingle($doc, $body)
    {
        // Add SuperMath title
        $titleElement = $doc->createElementNS(
            'http://schemas.openxmlformats.org/wordprocessingml/2006/main',
            'w:p'
        );
        
        // Center alignment for title
        $titlePProps = $doc->createElementNS(
            'http://schemas.openxmlformats.org/wordprocessingml/2006/main',
            'w:pPr'
        );
        $titleJc = $doc->createElementNS(
            'http://schemas.openxmlformats.org/wordprocessingml/2006/main',
            'w:jc'
        );
        $titleJc->setAttribute('w:val', 'center');
        $titlePProps->appendChild($titleJc);
        $titleElement->appendChild($titlePProps);
        
        $titleRun = $doc->createElementNS(
            'http://schemas.openxmlformats.org/wordprocessingml/2006/main',
            'w:r'
        );
        
        $titleRunProps = $doc->createElementNS(
            'http://schemas.openxmlformats.org/wordprocessingml/2006/main',
            'w:rPr'
        );
        
        $titleBold = $doc->createElementNS(
            'http://schemas.openxmlformats.org/wordprocessingml/2006/main',
            'w:b'
        );
        
        $titleSize = $doc->createElementNS(
            'http://schemas.openxmlformats.org/wordprocessingml/2006/main',
            'w:sz'
        );
        $titleSize->setAttribute('w:val', '48');
        
        $titleColor = $doc->createElementNS(
            'http://schemas.openxmlformats.org/wordprocessingml/2006/main',
            'w:color'
        );
        $titleColor->setAttribute('w:val', '1f4e79');
        
        $titleRunProps->appendChild($titleBold);
        $titleRunProps->appendChild($titleSize);
        $titleRunProps->appendChild($titleColor);
        $titleRun->appendChild($titleRunProps);

        $titleText = $doc->createElementNS(
            'http://schemas.openxmlformats.org/wordprocessingml/2006/main',
            'w:t',
            'SuperMath'
        );
        $titleRun->appendChild($titleText);
        $titleElement->appendChild($titleRun);
        $body->appendChild($titleElement);

        // Add subtitle
        $subtitleElement = $doc->createElementNS(
            'http://schemas.openxmlformats.org/wordprocessingml/2006/main',
            'w:p'
        );
        
        $subtitlePProps = $doc->createElementNS(
            'http://schemas.openxmlformats.org/wordprocessingml/2006/main',
            'w:pPr'
        );
        $subtitleJc = $doc->createElementNS(
            'http://schemas.openxmlformats.org/wordprocessingml/2006/main',
            'w:jc'
        );
        $subtitleJc->setAttribute('w:val', 'center');
        $subtitlePProps->appendChild($subtitleJc);
        $subtitleElement->appendChild($subtitlePProps);
        
        $subtitleRun = $doc->createElementNS(
            'http://schemas.openxmlformats.org/wordprocessingml/2006/main',
            'w:r'
        );
        
        $subtitleRunProps = $doc->createElementNS(
            'http://schemas.openxmlformats.org/wordprocessingml/2006/main',
            'w:rPr'
        );
        
        $subtitleSize = $doc->createElementNS(
            'http://schemas.openxmlformats.org/wordprocessingml/2006/main',
            'w:sz'
        );
        $subtitleSize->setAttribute('w:val', '24');
        
        $subtitleColor = $doc->createElementNS(
            'http://schemas.openxmlformats.org/wordprocessingml/2006/main',
            'w:color'
        );
        $subtitleColor->setAttribute('w:val', '666666');
        
        $subtitleRunProps->appendChild($subtitleSize);
        $subtitleRunProps->appendChild($subtitleColor);
        $subtitleRun->appendChild($subtitleRunProps);

        $subtitleText = $doc->createElementNS(
            'http://schemas.openxmlformats.org/wordprocessingml/2006/main',
            'w:t',
            'Advanced Mathematical Problem Solving Platform'
        );
        $subtitleRun->appendChild($subtitleText);
        $subtitleElement->appendChild($subtitleRun);
        $body->appendChild($subtitleElement);

        // Add spacing
        $this->addLineBreakSingle($doc, $body);

        // Add document info
        $infoElement = $doc->createElementNS(
            'http://schemas.openxmlformats.org/wordprocessingml/2006/main',
            'w:p'
        );
        
        $infoPProps = $doc->createElementNS(
            'http://schemas.openxmlformats.org/wordprocessingml/2006/main',
            'w:pPr'
        );
        $infoJc = $doc->createElementNS(
            'http://schemas.openxmlformats.org/wordprocessingml/2006/main',
            'w:jc'
        );
        $infoJc->setAttribute('w:val', 'center');
        $infoPProps->appendChild($infoJc);
        $infoElement->appendChild($infoPProps);
        
        $infoRun = $doc->createElementNS(
            'http://schemas.openxmlformats.org/wordprocessingml/2006/main',
            'w:r'
        );
        
        $infoRunProps = $doc->createElementNS(
            'http://schemas.openxmlformats.org/wordprocessingml/2006/main',
            'w:rPr'
        );
        
        $infoSize = $doc->createElementNS(
            'http://schemas.openxmlformats.org/wordprocessingml/2006/main',
            'w:sz'
        );
        $infoSize->setAttribute('w:val', '20');
        
        $infoColor = $doc->createElementNS(
            'http://schemas.openxmlformats.org/wordprocessingml/2006/main',
            'w:color'
        );
        $infoColor->setAttribute('w:val', '888888');
        
        $infoRunProps->appendChild($infoSize);
        $infoRunProps->appendChild($infoColor);
        $infoRun->appendChild($infoRunProps);

        $currentDate = now()->format('F j, Y');
        $infoText = $doc->createElementNS(
            'http://schemas.openxmlformats.org/wordprocessingml/2006/main',
            'w:t',
            "Complete Question Package | Generated on {$currentDate}"
        );
        $infoRun->appendChild($infoText);
        $infoElement->appendChild($infoRun);
        $body->appendChild($infoElement);

        // Add decorative line
        $this->addLineBreakSingle($doc, $body);
        $this->addDecorativeLineSingle($doc, $body);
        $this->addLineBreakSingle($doc, $body);
    }

    /**
     * Add section title for single document
     */
    private function addSectionTitleSingle($doc, $body, $title, $color)
    {
        $titleElement = $doc->createElementNS(
            'http://schemas.openxmlformats.org/wordprocessingml/2006/main',
            'w:p'
        );
        
        $titlePProps = $doc->createElementNS(
            'http://schemas.openxmlformats.org/wordprocessingml/2006/main',
            'w:pPr'
        );
        
        $titleSpacing = $doc->createElementNS(
            'http://schemas.openxmlformats.org/wordprocessingml/2006/main',
            'w:spacing'
        );
        $titleSpacing->setAttribute('w:before', '480');
        $titleSpacing->setAttribute('w:after', '240');
        $titlePProps->appendChild($titleSpacing);
        $titleElement->appendChild($titlePProps);
        
        $titleRun = $doc->createElementNS(
            'http://schemas.openxmlformats.org/wordprocessingml/2006/main',
            'w:r'
        );
        
        $titleRunProps = $doc->createElementNS(
            'http://schemas.openxmlformats.org/wordprocessingml/2006/main',
            'w:rPr'
        );
        
        $titleBold = $doc->createElementNS(
            'http://schemas.openxmlformats.org/wordprocessingml/2006/main',
            'w:b'
        );
        
        $titleSize = $doc->createElementNS(
            'http://schemas.openxmlformats.org/wordprocessingml/2006/main',
            'w:sz'
        );
        $titleSize->setAttribute('w:val', '32');
        
        $titleColor = $doc->createElementNS(
            'http://schemas.openxmlformats.org/wordprocessingml/2006/main',
            'w:color'
        );
        $titleColor->setAttribute('w:val', $color);
        
        $titleRunProps->appendChild($titleBold);
        $titleRunProps->appendChild($titleSize);
        $titleRunProps->appendChild($titleColor);
        $titleRun->appendChild($titleRunProps);

        $titleText = $doc->createElementNS(
            'http://schemas.openxmlformats.org/wordprocessingml/2006/main',
            'w:t',
            $title
        );
        $titleRun->appendChild($titleText);
        $titleElement->appendChild($titleRun);
        $body->appendChild($titleElement);

        // Add underline
        $underlineElement = $doc->createElementNS(
            'http://schemas.openxmlformats.org/wordprocessingml/2006/main',
            'w:p'
        );
        
        $underlineRun = $doc->createElementNS(
            'http://schemas.openxmlformats.org/wordprocessingml/2006/main',
            'w:r'
        );
        
        $underlineRunProps = $doc->createElementNS(
            'http://schemas.openxmlformats.org/wordprocessingml/2006/main',
            'w:rPr'
        );
        
        $underlineColor = $doc->createElementNS(
            'http://schemas.openxmlformats.org/wordprocessingml/2006/main',
            'w:color'
        );
        $underlineColor->setAttribute('w:val', $color);
        
        $underlineRunProps->appendChild($underlineColor);
        $underlineRun->appendChild($underlineRunProps);

        $underlineText = $doc->createElementNS(
            'http://schemas.openxmlformats.org/wordprocessingml/2006/main',
            'w:t',
            str_repeat('▬', 50)
        );
        $underlineRun->appendChild($underlineText);
        $underlineElement->appendChild($underlineRun);
        $body->appendChild($underlineElement);

        $this->addLineBreakSingle($doc, $body);
    }

    /**
     * Add decorative line for single document
     */
    private function addDecorativeLineSingle($doc, $body)
    {
        $lineElement = $doc->createElementNS(
            'http://schemas.openxmlformats.org/wordprocessingml/2006/main',
            'w:p'
        );
        
        $linePProps = $doc->createElementNS(
            'http://schemas.openxmlformats.org/wordprocessingml/2006/main',
            'w:pPr'
        );
        $lineJc = $doc->createElementNS(
            'http://schemas.openxmlformats.org/wordprocessingml/2006/main',
            'w:jc'
        );
        $lineJc->setAttribute('w:val', 'center');
        $linePProps->appendChild($lineJc);
        $lineElement->appendChild($linePProps);
        
        $lineRun = $doc->createElementNS(
            'http://schemas.openxmlformats.org/wordprocessingml/2006/main',
            'w:r'
        );
        
        $lineRunProps = $doc->createElementNS(
            'http://schemas.openxmlformats.org/wordprocessingml/2006/main',
            'w:rPr'
        );
        
        $lineColor = $doc->createElementNS(
            'http://schemas.openxmlformats.org/wordprocessingml/2006/main',
            'w:color'
        );
        $lineColor->setAttribute('w:val', '1f4e79');
        
        $lineRunProps->appendChild($lineColor);
        $lineRun->appendChild($lineRunProps);

        $lineText = $doc->createElementNS(
            'http://schemas.openxmlformats.org/wordprocessingml/2006/main',
            'w:t',
            '═══════════════════════════════════════════════════════════════════'
        );
        $lineRun->appendChild($lineText);
        $lineElement->appendChild($lineRun);
        $body->appendChild($lineElement);
    }

    /**
     * Add line break for single document
     */
    private function addLineBreakSingle($doc, $body)
    {
        $breakElement = $doc->createElementNS(
            'http://schemas.openxmlformats.org/wordprocessingml/2006/main',
            'w:p'
        );
        $body->appendChild($breakElement);
    }

    /**
     * Merge media files (images, OLE objects, embeddings)
     */
    private function mergeMediaFiles($answerDir, $mergedDir)
    {
        $answerMediaDir = $answerDir . '/word/media';
        $mergedMediaDir = $mergedDir . '/word/media';

        if (is_dir($answerMediaDir)) {
            if (!is_dir($mergedMediaDir)) {
                mkdir($mergedMediaDir, 0755, true);
            }

            // Copy all media files from answer document
            $files = scandir($answerMediaDir);
            foreach ($files as $file) {
                if ($file !== '.' && $file !== '..') {
                    $sourcePath = $answerMediaDir . '/' . $file;
                    $destPath = $mergedMediaDir . '/' . $file;

                    // Rename if file already exists
                    $counter = 1;
                    $originalDestPath = $destPath;
                    while (file_exists($destPath)) {
                        $pathInfo = pathinfo($originalDestPath);
                        $destPath = $pathInfo['dirname'] . '/' . $pathInfo['filename'] . '_' . $counter . '.' . $pathInfo['extension'];
                        $counter++;
                    }

                    copy($sourcePath, $destPath);
                }
            }
        }

        // Also copy embeddings directory if it exists (for OLE objects like MathType)
        $answerEmbeddingsDir = $answerDir . '/word/embeddings';
        $mergedEmbeddingsDir = $mergedDir . '/word/embeddings';

        if (is_dir($answerEmbeddingsDir)) {
            if (!is_dir($mergedEmbeddingsDir)) {
                mkdir($mergedEmbeddingsDir, 0755, true);
            }
            $this->copyDirectory($answerEmbeddingsDir, $mergedEmbeddingsDir);
        }
    }

    /**
     * Update relationships to include answer document references
     */
    private function updateRelationships($answerDir, $mergedDir)
    {
        $answerRelsPath = $answerDir . '/word/_rels/document.xml.rels';
        $mergedRelsPath = $mergedDir . '/word/_rels/document.xml.rels';

        if (file_exists($answerRelsPath) && file_exists($mergedRelsPath)) {
            $answerRels = file_get_contents($answerRelsPath);
            $mergedRels = file_get_contents($mergedRelsPath);

            // Parse and merge relationships
            $answerDoc = new \DOMDocument();
            $answerDoc->loadXML($answerRels);

            $mergedDoc = new \DOMDocument();
            $mergedDoc->loadXML($mergedRels);

            $answerRelationships = $answerDoc->getElementsByTagName('Relationship');
            $mergedRelationships = $mergedDoc->getElementsByTagName('Relationships')->item(0);

            foreach ($answerRelationships as $rel) {
                $importedRel = $mergedDoc->importNode($rel, true);
                $mergedRelationships->appendChild($importedRel);
            }

            file_put_contents($mergedRelsPath, $mergedDoc->saveXML());
        }
    }

    /**
     * Create DOCX file from directory
     */
    private function createDocx($sourceDir, $outputPath)
    {
        $zip = new \ZipArchive();
        if ($zip->open($outputPath, \ZipArchive::CREATE | \ZipArchive::OVERWRITE) === TRUE) {
            $this->addDirectoryToZip($zip, $sourceDir, '');
            $zip->close();
        } else {
            throw new \Exception("Cannot create DOCX file: $outputPath");
        }
    }

    /**
     * Add directory contents to ZIP
     */
    private function addDirectoryToZip($zip, $sourceDir, $zipPath)
    {
        $files = scandir($sourceDir);
        foreach ($files as $file) {
            if ($file !== '.' && $file !== '..') {
                $filePath = $sourceDir . '/' . $file;
                $zipFilePath = $zipPath ? $zipPath . '/' . $file : $file;

                if (is_dir($filePath)) {
                    $this->addDirectoryToZip($zip, $filePath, $zipFilePath);
                } else {
                    $zip->addFile($filePath, $zipFilePath);
                }
            }
        }
    }

    /**
     * Copy directory recursively
     */
    private function copyDirectory($source, $destination)
    {
        if (!is_dir($destination)) {
            mkdir($destination, 0755, true);
        }

        $files = scandir($source);
        foreach ($files as $file) {
            if ($file !== '.' && $file !== '..') {
                $sourcePath = $source . '/' . $file;
                $destPath = $destination . '/' . $file;

                if (is_dir($sourcePath)) {
                    $this->copyDirectory($sourcePath, $destPath);
                } else {
                    copy($sourcePath, $destPath);
                }
            }
        }
    }

    /**
     * Remove directory recursively
     */
    private function removeDirectory($dir)
    {
        if (is_dir($dir)) {
            $files = scandir($dir);
            foreach ($files as $file) {
                if ($file !== '.' && $file !== '..') {
                    $filePath = $dir . '/' . $file;
                    if (is_dir($filePath)) {
                        $this->removeDirectory($filePath);
                    } else {
                        unlink($filePath);
                    }
                }
            }
            rmdir($dir);
        }
    }

    /**
     * Download multiple documents merged into one document with questions first, then answers
     */
    public function downloadMultipleDocuments(array $questionIds)
    {
        $questions = Question::whereIn('id', $questionIds)->get();
        if ($questions->isEmpty()) {
            return redirect()->back()->with('error', 'No valid questions found for download.');
        }

        try {
            // Generate temporary file for download
            $tempPath = storage_path('app/temp/merged_questions_' . time() . '.docx');

            // Ensure temp directory exists
            if (!file_exists(dirname($tempPath))) {
                mkdir(dirname($tempPath), 0755, true);
            }

            // Create the merged document
            $this->mergeMultipleDocuments($questions, $tempPath);

            $fileName = 'questions_package_' . count($questions) . '_items_' . time() . '.docx';

            // Decrement user's credit
            auth()->user()->decrement('credit', count($questionIds));

            // Add credit history
            CreditHistory::create([
                'user_id' => auth()->user()->id,
                'action' => 'Download',
                'amount' => '- ' . count($questionIds),
                'description' => 'Downloaded multiple question package (' . count($questionIds) . ' questions): ' . implode(', ', $questionIds),
            ]);

            // Return download response and delete temp file after download
            return response()->download($tempPath, $fileName)->deleteFileAfterSend(true);

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error creating merged document: ' . $e->getMessage());
        }
    }

    /**
     * Merge multiple documents with all questions first, then all answers
     */
    private function mergeMultipleDocuments($questions, $outputPath)
    {
        // Create temporary directories
        $tempDir = storage_path('app/temp/merge_multiple_' . time());
        $mergedDir = $tempDir . '/merged';

        try {
            // Create directories
            mkdir($mergedDir, 0755, true);

            // Start with the first question document as base
            $firstQuestion = $questions->first();
            if (!$firstQuestion->doc || !Storage::disk('local')->exists($firstQuestion->doc)) {
                throw new \Exception("First question document not found.");
            }

            $firstQuestionPath = Storage::disk('local')->path($firstQuestion->doc);
            $this->extractDocx($firstQuestionPath, $mergedDir);

            // Create the master document XML
            $masterDocXml = $this->createMasterDocumentXml($questions);

            // Write the master XML
            file_put_contents($mergedDir . '/word/document.xml', $masterDocXml);

            // Merge all media files and embeddings from all documents
            $this->mergeAllMediaFiles($questions, $mergedDir);

            // Update relationships for all documents
            $this->updateAllRelationships($questions, $mergedDir);

            // Create the final DOCX file
            $this->createDocx($mergedDir, $outputPath);

        } finally {
            // Clean up temporary directories
            if (is_dir($tempDir)) {
                $this->removeDirectory($tempDir);
            }
        }
    }

    /**
     * Create master document XML with all questions first, then all answers
     */
    private function createMasterDocumentXml($questions)
    {
        // Create new document
        $masterDoc = new \DOMDocument();
        $masterDoc->formatOutput = true;

        // Create root document element
        $document = $masterDoc->createElementNS(
            'http://schemas.openxmlformats.org/wordprocessingml/2006/main',
            'w:document'
        );
        $document->setAttributeNS(
            'http://www.w3.org/2000/xmlns/',
            'xmlns:w',
            'http://schemas.openxmlformats.org/wordprocessingml/2006/main'
        );
        $masterDoc->appendChild($document);

        // Create body
        $body = $masterDoc->createElementNS(
            'http://schemas.openxmlformats.org/wordprocessingml/2006/main',
            'w:body'
        );
        $document->appendChild($body);

        // Add SuperMath header with logo and company info
        $this->addSuperMathHeader($masterDoc, $body, count($questions));

        // Add page break after header
        $this->addPageBreak($masterDoc, $body);

        // Add title for questions section
        $this->addSectionTitle($masterDoc, $body, 'QUESTIONS SECTION', '0000FF');

        // Add all questions first
        $questionNumber = 1;
        foreach ($questions as $question) {
            if ($question->doc && Storage::disk('local')->exists($question->doc)) {
                $this->addQuestionToDocument($masterDoc, $body, $question, $questionNumber);
                $questionNumber++;
            }
        }

        // Add page break before answers
        $this->addPageBreak($masterDoc, $body);

        // Add title for answers section
        $this->addSectionTitle($masterDoc, $body, 'ANSWERS SECTION', '008000');

        // Add all answers in the same order
        $answerNumber = 1;
        foreach ($questions as $question) {
            if ($question->answer_doc && Storage::disk('local')->exists($question->answer_doc)) {
                $this->addAnswerToDocument($masterDoc, $body, $question, $answerNumber);
                $answerNumber++;
            }
        }

        return $masterDoc->saveXML();
    }

    /**
     * Add SuperMath professional header to document
     */
    private function addSuperMathHeader($doc, $body, $questionCount)
    {
        // Add SuperMath title
        $titleElement = $doc->createElementNS(
            'http://schemas.openxmlformats.org/wordprocessingml/2006/main',
            'w:p'
        );
        
        // Center alignment for title
        $titlePProps = $doc->createElementNS(
            'http://schemas.openxmlformats.org/wordprocessingml/2006/main',
            'w:pPr'
        );
        $titleJc = $doc->createElementNS(
            'http://schemas.openxmlformats.org/wordprocessingml/2006/main',
            'w:jc'
        );
        $titleJc->setAttribute('w:val', 'center');
        $titlePProps->appendChild($titleJc);
        $titleElement->appendChild($titlePProps);
        
        $titleRun = $doc->createElementNS(
            'http://schemas.openxmlformats.org/wordprocessingml/2006/main',
            'w:r'
        );
        
        $titleRunProps = $doc->createElementNS(
            'http://schemas.openxmlformats.org/wordprocessingml/2006/main',
            'w:rPr'
        );
        
        $titleBold = $doc->createElementNS(
            'http://schemas.openxmlformats.org/wordprocessingml/2006/main',
            'w:b'
        );
        
        $titleSize = $doc->createElementNS(
            'http://schemas.openxmlformats.org/wordprocessingml/2006/main',
            'w:sz'
        );
        $titleSize->setAttribute('w:val', '48');
        
        $titleColor = $doc->createElementNS(
            'http://schemas.openxmlformats.org/wordprocessingml/2006/main',
            'w:color'
        );
        $titleColor->setAttribute('w:val', '1f4e79');
        
        $titleRunProps->appendChild($titleBold);
        $titleRunProps->appendChild($titleSize);
        $titleRunProps->appendChild($titleColor);
        $titleRun->appendChild($titleRunProps);

        $titleText = $doc->createElementNS(
            'http://schemas.openxmlformats.org/wordprocessingml/2006/main',
            'w:t',
            'SuperMath'
        );
        $titleRun->appendChild($titleText);
        $titleElement->appendChild($titleRun);
        $body->appendChild($titleElement);

        // Add subtitle
        $subtitleElement = $doc->createElementNS(
            'http://schemas.openxmlformats.org/wordprocessingml/2006/main',
            'w:p'
        );
        
        $subtitlePProps = $doc->createElementNS(
            'http://schemas.openxmlformats.org/wordprocessingml/2006/main',
            'w:pPr'
        );
        $subtitleJc = $doc->createElementNS(
            'http://schemas.openxmlformats.org/wordprocessingml/2006/main',
            'w:jc'
        );
        $subtitleJc->setAttribute('w:val', 'center');
        $subtitlePProps->appendChild($subtitleJc);
        $subtitleElement->appendChild($subtitlePProps);
        
        $subtitleRun = $doc->createElementNS(
            'http://schemas.openxmlformats.org/wordprocessingml/2006/main',
            'w:r'
        );
        
        $subtitleRunProps = $doc->createElementNS(
            'http://schemas.openxmlformats.org/wordprocessingml/2006/main',
            'w:rPr'
        );
        
        $subtitleSize = $doc->createElementNS(
            'http://schemas.openxmlformats.org/wordprocessingml/2006/main',
            'w:sz'
        );
        $subtitleSize->setAttribute('w:val', '24');
        
        $subtitleColor = $doc->createElementNS(
            'http://schemas.openxmlformats.org/wordprocessingml/2006/main',
            'w:color'
        );
        $subtitleColor->setAttribute('w:val', '666666');
        
        $subtitleRunProps->appendChild($subtitleSize);
        $subtitleRunProps->appendChild($subtitleColor);
        $subtitleRun->appendChild($subtitleRunProps);

        $subtitleText = $doc->createElementNS(
            'http://schemas.openxmlformats.org/wordprocessingml/2006/main',
            'w:t',
            'Advanced Mathematical Problem Solving Platform'
        );
        $subtitleRun->appendChild($subtitleText);
        $subtitleElement->appendChild($subtitleRun);
        $body->appendChild($subtitleElement);

        // Add spacing
        $this->addLineBreak($doc, $body);

        // Add document info
        $infoElement = $doc->createElementNS(
            'http://schemas.openxmlformats.org/wordprocessingml/2006/main',
            'w:p'
        );
        
        $infoPProps = $doc->createElementNS(
            'http://schemas.openxmlformats.org/wordprocessingml/2006/main',
            'w:pPr'
        );
        $infoJc = $doc->createElementNS(
            'http://schemas.openxmlformats.org/wordprocessingml/2006/main',
            'w:jc'
        );
        $infoJc->setAttribute('w:val', 'center');
        $infoPProps->appendChild($infoJc);
        $infoElement->appendChild($infoPProps);
        
        $infoRun = $doc->createElementNS(
            'http://schemas.openxmlformats.org/wordprocessingml/2006/main',
            'w:r'
        );
        
        $infoRunProps = $doc->createElementNS(
            'http://schemas.openxmlformats.org/wordprocessingml/2006/main',
            'w:rPr'
        );
        
        $infoSize = $doc->createElementNS(
            'http://schemas.openxmlformats.org/wordprocessingml/2006/main',
            'w:sz'
        );
        $infoSize->setAttribute('w:val', '20');
        
        $infoColor = $doc->createElementNS(
            'http://schemas.openxmlformats.org/wordprocessingml/2006/main',
            'w:color'
        );
        $infoColor->setAttribute('w:val', '888888');
        
        $infoRunProps->appendChild($infoSize);
        $infoRunProps->appendChild($infoColor);
        $infoRun->appendChild($infoRunProps);

        $currentDate = now()->format('F j, Y');
        $infoText = $doc->createElementNS(
            'http://schemas.openxmlformats.org/wordprocessingml/2006/main',
            'w:t',
            "Question Package - {$questionCount} Questions | Generated on {$currentDate}"
        );
        $infoRun->appendChild($infoText);
        $infoElement->appendChild($infoRun);
        $body->appendChild($infoElement);

        // Add decorative line
        $this->addLineBreak($doc, $body);
        $this->addDecorativeLine($doc, $body);
        $this->addLineBreak($doc, $body);
    }

    /**
     * Add decorative line separator
     */
    private function addDecorativeLine($doc, $body)
    {
        $lineElement = $doc->createElementNS(
            'http://schemas.openxmlformats.org/wordprocessingml/2006/main',
            'w:p'
        );
        
        $linePProps = $doc->createElementNS(
            'http://schemas.openxmlformats.org/wordprocessingml/2006/main',
            'w:pPr'
        );
        $lineJc = $doc->createElementNS(
            'http://schemas.openxmlformats.org/wordprocessingml/2006/main',
            'w:jc'
        );
        $lineJc->setAttribute('w:val', 'center');
        $linePProps->appendChild($lineJc);
        $lineElement->appendChild($linePProps);
        
        $lineRun = $doc->createElementNS(
            'http://schemas.openxmlformats.org/wordprocessingml/2006/main',
            'w:r'
        );
        
        $lineRunProps = $doc->createElementNS(
            'http://schemas.openxmlformats.org/wordprocessingml/2006/main',
            'w:rPr'
        );
        
        $lineColor = $doc->createElementNS(
            'http://schemas.openxmlformats.org/wordprocessingml/2006/main',
            'w:color'
        );
        $lineColor->setAttribute('w:val', '1f4e79');
        
        $lineRunProps->appendChild($lineColor);
        $lineRun->appendChild($lineRunProps);

        $lineText = $doc->createElementNS(
            'http://schemas.openxmlformats.org/wordprocessingml/2006/main',
            'w:t',
            '═══════════════════════════════════════════════════════════════════'
        );
        $lineRun->appendChild($lineText);
        $lineElement->appendChild($lineRun);
        $body->appendChild($lineElement);
    }

    /**
     * Add section title to document
     */
    private function addSectionTitle($doc, $body, $title, $color)
    {
        $titleElement = $doc->createElementNS(
            'http://schemas.openxmlformats.org/wordprocessingml/2006/main',
            'w:p'
        );
        
        // Add paragraph properties for spacing
        $titlePProps = $doc->createElementNS(
            'http://schemas.openxmlformats.org/wordprocessingml/2006/main',
            'w:pPr'
        );
        
        $titleSpacing = $doc->createElementNS(
            'http://schemas.openxmlformats.org/wordprocessingml/2006/main',
            'w:spacing'
        );
        $titleSpacing->setAttribute('w:before', '480');
        $titleSpacing->setAttribute('w:after', '240');
        $titlePProps->appendChild($titleSpacing);
        $titleElement->appendChild($titlePProps);
        
        $titleRun = $doc->createElementNS(
            'http://schemas.openxmlformats.org/wordprocessingml/2006/main',
            'w:r'
        );
        
        $titleRunProps = $doc->createElementNS(
            'http://schemas.openxmlformats.org/wordprocessingml/2006/main',
            'w:rPr'
        );
        
        $titleBold = $doc->createElementNS(
            'http://schemas.openxmlformats.org/wordprocessingml/2006/main',
            'w:b'
        );
        
        $titleSize = $doc->createElementNS(
            'http://schemas.openxmlformats.org/wordprocessingml/2006/main',
            'w:sz'
        );
        $titleSize->setAttribute('w:val', '32');
        
        $titleColor = $doc->createElementNS(
            'http://schemas.openxmlformats.org/wordprocessingml/2006/main',
            'w:color'
        );
        $titleColor->setAttribute('w:val', $color);
        
        $titleRunProps->appendChild($titleBold);
        $titleRunProps->appendChild($titleSize);
        $titleRunProps->appendChild($titleColor);
        $titleRun->appendChild($titleRunProps);

        $titleText = $doc->createElementNS(
            'http://schemas.openxmlformats.org/wordprocessingml/2006/main',
            'w:t',
            $title
        );
        $titleRun->appendChild($titleText);
        $titleElement->appendChild($titleRun);
        $body->appendChild($titleElement);

        // Add underline after section title
        $underlineElement = $doc->createElementNS(
            'http://schemas.openxmlformats.org/wordprocessingml/2006/main',
            'w:p'
        );
        
        $underlineRun = $doc->createElementNS(
            'http://schemas.openxmlformats.org/wordprocessingml/2006/main',
            'w:r'
        );
        
        $underlineRunProps = $doc->createElementNS(
            'http://schemas.openxmlformats.org/wordprocessingml/2006/main',
            'w:rPr'
        );
        
        $underlineColor = $doc->createElementNS(
            'http://schemas.openxmlformats.org/wordprocessingml/2006/main',
            'w:color'
        );
        $underlineColor->setAttribute('w:val', $color);
        
        $underlineRunProps->appendChild($underlineColor);
        $underlineRun->appendChild($underlineRunProps);

        $underlineText = $doc->createElementNS(
            'http://schemas.openxmlformats.org/wordprocessingml/2006/main',
            'w:t',
            str_repeat('▬', 50)
        );
        $underlineRun->appendChild($underlineText);
        $underlineElement->appendChild($underlineRun);
        $body->appendChild($underlineElement);

        // Add spacing after title
        $this->addLineBreak($doc, $body);
    }

    /**
     * Add page break to document
     */
    private function addPageBreak($doc, $body)
    {
        $pageBreakElement = $doc->createElementNS(
            'http://schemas.openxmlformats.org/wordprocessingml/2006/main',
            'w:p'
        );
        $pageBreakRun = $doc->createElementNS(
            'http://schemas.openxmlformats.org/wordprocessingml/2006/main',
            'w:r'
        );
        $pageBreakBr = $doc->createElementNS(
            'http://schemas.openxmlformats.org/wordprocessingml/2006/main',
            'w:br'
        );
        $pageBreakBr->setAttribute('w:type', 'page');
        $pageBreakRun->appendChild($pageBreakBr);
        $pageBreakElement->appendChild($pageBreakRun);
        $body->appendChild($pageBreakElement);
    }

    /**
     * Add line break to document
     */
    private function addLineBreak($doc, $body)
    {
        $breakElement = $doc->createElementNS(
            'http://schemas.openxmlformats.org/wordprocessingml/2006/main',
            'w:p'
        );
        $body->appendChild($breakElement);
    }

    /**
     * Add question content to document
     */
    private function addQuestionToDocument($doc, $body, $question, $questionNumber)
    {
        // Add question header
        $headerElement = $doc->createElementNS(
            'http://schemas.openxmlformats.org/wordprocessingml/2006/main',
            'w:p'
        );
        
        $headerRun = $doc->createElementNS(
            'http://schemas.openxmlformats.org/wordprocessingml/2006/main',
            'w:r'
        );
        
        $headerRunProps = $doc->createElementNS(
            'http://schemas.openxmlformats.org/wordprocessingml/2006/main',
            'w:rPr'
        );
        
        $headerBold = $doc->createElementNS(
            'http://schemas.openxmlformats.org/wordprocessingml/2006/main',
            'w:b'
        );
        
        $headerSize = $doc->createElementNS(
            'http://schemas.openxmlformats.org/wordprocessingml/2006/main',
            'w:sz'
        );
        $headerSize->setAttribute('w:val', '24');
        
        $headerRunProps->appendChild($headerBold);
        $headerRunProps->appendChild($headerSize);
        $headerRun->appendChild($headerRunProps);

        $headerText = $doc->createElementNS(
            'http://schemas.openxmlformats.org/wordprocessingml/2006/main',
            'w:t',
            "Question {$questionNumber} (ID: {$question->id})"
        );
        $headerRun->appendChild($headerText);
        $headerElement->appendChild($headerRun);
        $body->appendChild($headerElement);

        // Add question content
        $this->addDocumentContent($doc, $body, $question->doc);
        
        // Add separator
        $this->addSeparator($doc, $body);
    }

    /**
     * Add answer content to document
     */
    private function addAnswerToDocument($doc, $body, $question, $answerNumber)
    {
        // Add answer header
        $headerElement = $doc->createElementNS(
            'http://schemas.openxmlformats.org/wordprocessingml/2006/main',
            'w:p'
        );
        
        $headerRun = $doc->createElementNS(
            'http://schemas.openxmlformats.org/wordprocessingml/2006/main',
            'w:r'
        );
        
        $headerRunProps = $doc->createElementNS(
            'http://schemas.openxmlformats.org/wordprocessingml/2006/main',
            'w:rPr'
        );
        
        $headerBold = $doc->createElementNS(
            'http://schemas.openxmlformats.org/wordprocessingml/2006/main',
            'w:b'
        );
        
        $headerSize = $doc->createElementNS(
            'http://schemas.openxmlformats.org/wordprocessingml/2006/main',
            'w:sz'
        );
        $headerSize->setAttribute('w:val', '24');
        
        $headerColor = $doc->createElementNS(
            'http://schemas.openxmlformats.org/wordprocessingml/2006/main',
            'w:color'
        );
        $headerColor->setAttribute('w:val', '008000');
        
        $headerRunProps->appendChild($headerBold);
        $headerRunProps->appendChild($headerSize);
        $headerRunProps->appendChild($headerColor);
        $headerRun->appendChild($headerRunProps);

        $headerText = $doc->createElementNS(
            'http://schemas.openxmlformats.org/wordprocessingml/2006/main',
            'w:t',
            "Answer {$answerNumber} (Question ID: {$question->id})"
        );
        $headerRun->appendChild($headerText);
        $headerElement->appendChild($headerRun);
        $body->appendChild($headerElement);

        // Add answer content
        $this->addDocumentContent($doc, $body, $question->answer_doc);
        
        // Add separator
        $this->addSeparator($doc, $body);
    }

    /**
     * Add document content to master document
     */
    private function addDocumentContent($doc, $body, $documentPath)
    {
        try {
            $docPath = Storage::disk('local')->path($documentPath);
            $tempDir = storage_path('app/temp/extract_' . time() . '_' . rand(1000, 9999));
            mkdir($tempDir, 0755, true);

            // Extract document
            $this->extractDocx($docPath, $tempDir);

            // Read document XML
            $docXmlPath = $tempDir . '/word/document.xml';
            if (file_exists($docXmlPath)) {
                $docXml = file_get_contents($docXmlPath);
                $sourceDoc = new \DOMDocument();
                $sourceDoc->loadXML($docXml);

                // Get body content
                $sourceBody = $sourceDoc->getElementsByTagName('body')->item(0);
                if ($sourceBody) {
                    foreach ($sourceBody->childNodes as $element) {
                        if ($element->nodeType === XML_ELEMENT_NODE) {
                            $importedElement = $doc->importNode($element, true);
                            $body->appendChild($importedElement);
                        }
                    }
                }
            }

            // Clean up
            $this->removeDirectory($tempDir);

        } catch (\Exception $e) {
            // If extraction fails, add a placeholder
            $placeholder = $doc->createElementNS(
                'http://schemas.openxmlformats.org/wordprocessingml/2006/main',
                'w:p'
            );
            $placeholderRun = $doc->createElementNS(
                'http://schemas.openxmlformats.org/wordprocessingml/2006/main',
                'w:r'
            );
            $placeholderText = $doc->createElementNS(
                'http://schemas.openxmlformats.org/wordprocessingml/2006/main',
                'w:t',
                '[Content could not be loaded]'
            );
            $placeholderRun->appendChild($placeholderText);
            $placeholder->appendChild($placeholderRun);
            $body->appendChild($placeholder);
        }
    }

    /**
     * Add professional separator line between content
     */
    private function addSeparator($doc, $body)
    {
        $separatorElement = $doc->createElementNS(
            'http://schemas.openxmlformats.org/wordprocessingml/2006/main',
            'w:p'
        );
        
        // Add paragraph properties for spacing
        $separatorPProps = $doc->createElementNS(
            'http://schemas.openxmlformats.org/wordprocessingml/2006/main',
            'w:pPr'
        );
        
        $separatorSpacing = $doc->createElementNS(
            'http://schemas.openxmlformats.org/wordprocessingml/2006/main',
            'w:spacing'
        );
        $separatorSpacing->setAttribute('w:before', '240');
        $separatorSpacing->setAttribute('w:after', '240');
        $separatorPProps->appendChild($separatorSpacing);
        
        $separatorJc = $doc->createElementNS(
            'http://schemas.openxmlformats.org/wordprocessingml/2006/main',
            'w:jc'
        );
        $separatorJc->setAttribute('w:val', 'center');
        $separatorPProps->appendChild($separatorJc);
        $separatorElement->appendChild($separatorPProps);
        
        $separatorRun = $doc->createElementNS(
            'http://schemas.openxmlformats.org/wordprocessingml/2006/main',
            'w:r'
        );
        
        $separatorRunProps = $doc->createElementNS(
            'http://schemas.openxmlformats.org/wordprocessingml/2006/main',
            'w:rPr'
        );
        
        $separatorColor = $doc->createElementNS(
            'http://schemas.openxmlformats.org/wordprocessingml/2006/main',
            'w:color'
        );
        $separatorColor->setAttribute('w:val', 'CCCCCC');
        
        $separatorRunProps->appendChild($separatorColor);
        $separatorRun->appendChild($separatorRunProps);
        
        $separatorText = $doc->createElementNS(
            'http://schemas.openxmlformats.org/wordprocessingml/2006/main',
            'w:t',
            '● ● ● ● ● ● ● ● ● ● ● ● ● ● ● ● ● ● ● ● ● ● ● ● ● ● ● ● ● ●'
        );
        $separatorRun->appendChild($separatorText);
        $separatorElement->appendChild($separatorRun);
        $body->appendChild($separatorElement);

        // Add line break after separator
        $this->addLineBreak($doc, $body);
    }

    /**
     * Merge all media files from all documents
     */
    private function mergeAllMediaFiles($questions, $mergedDir)
    {
        $mediaCounter = 1;
        $embeddingCounter = 1;

        foreach ($questions as $question) {
            // Process question document
            if ($question->doc && Storage::disk('local')->exists($question->doc)) {
                $this->mergeDocumentMedia($question->doc, $mergedDir, $mediaCounter, $embeddingCounter);
            }

            // Process answer document
            if ($question->answer_doc && Storage::disk('local')->exists($question->answer_doc)) {
                $this->mergeDocumentMedia($question->answer_doc, $mergedDir, $mediaCounter, $embeddingCounter);
            }
        }
    }

    /**
     * Merge media files from a single document
     */
    private function mergeDocumentMedia($documentPath, $mergedDir, &$mediaCounter, &$embeddingCounter)
    {
        $tempDir = storage_path('app/temp/media_extract_' . time() . '_' . rand(1000, 9999));
        
        try {
            mkdir($tempDir, 0755, true);
            $docPath = Storage::disk('local')->path($documentPath);
            $this->extractDocx($docPath, $tempDir);

            // Merge media files
            $sourceMediaDir = $tempDir . '/word/media';
            $targetMediaDir = $mergedDir . '/word/media';

            if (is_dir($sourceMediaDir)) {
                if (!is_dir($targetMediaDir)) {
                    mkdir($targetMediaDir, 0755, true);
                }

                $files = scandir($sourceMediaDir);
                foreach ($files as $file) {
                    if ($file !== '.' && $file !== '..') {
                        $sourcePath = $sourceMediaDir . '/' . $file;
                        $pathInfo = pathinfo($file);
                        $newFileName = $pathInfo['filename'] . '_' . $mediaCounter . '.' . $pathInfo['extension'];
                        $destPath = $targetMediaDir . '/' . $newFileName;
                        copy($sourcePath, $destPath);
                        $mediaCounter++;
                    }
                }
            }

            // Merge embeddings (OLE objects)
            $sourceEmbeddingsDir = $tempDir . '/word/embeddings';
            $targetEmbeddingsDir = $mergedDir . '/word/embeddings';

            if (is_dir($sourceEmbeddingsDir)) {
                if (!is_dir($targetEmbeddingsDir)) {
                    mkdir($targetEmbeddingsDir, 0755, true);
                }

                $files = scandir($sourceEmbeddingsDir);
                foreach ($files as $file) {
                    if ($file !== '.' && $file !== '..') {
                        $sourcePath = $sourceEmbeddingsDir . '/' . $file;
                        $pathInfo = pathinfo($file);
                        $newFileName = $pathInfo['filename'] . '_' . $embeddingCounter . '.' . $pathInfo['extension'];
                        $destPath = $targetEmbeddingsDir . '/' . $newFileName;
                        copy($sourcePath, $destPath);
                        $embeddingCounter++;
                    }
                }
            }

            // Copy OLE-related files that are essential for equation editing
            $this->copyOleRelatedFiles($tempDir, $mergedDir);

        } finally {
            if (is_dir($tempDir)) {
                $this->removeDirectory($tempDir);
            }
        }
    }

    /**
     * Copy OLE-related files that are essential for equation editing
     */
    private function copyOleRelatedFiles($sourceDir, $targetDir)
    {
        // Copy customXml directory (important for OLE objects)
        $sourceCustomXmlDir = $sourceDir . '/customXml';
        $targetCustomXmlDir = $targetDir . '/customXml';
        
        if (is_dir($sourceCustomXmlDir) && !is_dir($targetCustomXmlDir)) {
            $this->copyDirectory($sourceCustomXmlDir, $targetCustomXmlDir);
        }

        // Copy theme directory
        $sourceThemeDir = $sourceDir . '/word/theme';
        $targetThemeDir = $targetDir . '/word/theme';
        
        if (is_dir($sourceThemeDir) && !is_dir($targetThemeDir)) {
            $this->copyDirectory($sourceThemeDir, $targetThemeDir);
        }

        // Copy settings files that may contain OLE configuration
        $oleFiles = [
            'word/webSettings.xml',
            'word/settings.xml',
            'word/fontTable.xml',
            'word/styles.xml'
        ];
        
        foreach ($oleFiles as $oleFile) {
            $sourcePath = $sourceDir . '/' . $oleFile;
            $targetPath = $targetDir . '/' . $oleFile;
            
            if (file_exists($sourcePath) && !file_exists($targetPath)) {
                if (!is_dir(dirname($targetPath))) {
                    mkdir(dirname($targetPath), 0755, true);
                }
                copy($sourcePath, $targetPath);
            }
        }

        // Copy docProps directory (document properties)
        $sourceDocPropsDir = $sourceDir . '/docProps';
        $targetDocPropsDir = $targetDir . '/docProps';
        
        if (is_dir($sourceDocPropsDir) && !is_dir($targetDocPropsDir)) {
            $this->copyDirectory($sourceDocPropsDir, $targetDocPropsDir);
        }
    }

    /**
     * Update relationships for all documents
     */
    private function updateAllRelationships($questions, $mergedDir)
    {
        $mergedRelsPath = $mergedDir . '/word/_rels/document.xml.rels';
        
        if (!file_exists($mergedRelsPath)) {
            return;
        }

        $mergedRels = file_get_contents($mergedRelsPath);
        $mergedDoc = new \DOMDocument();
        $mergedDoc->loadXML($mergedRels);
        $mergedRelationships = $mergedDoc->getElementsByTagName('Relationships')->item(0);

        $relId = 1000; // Start with high ID to avoid conflicts

        foreach ($questions as $question) {
            // Process question document relationships
            if ($question->doc && Storage::disk('local')->exists($question->doc)) {
                $this->addDocumentRelationships($question->doc, $mergedDoc, $mergedRelationships, $relId, $mergedDir);
            }

            // Process answer document relationships
            if ($question->answer_doc && Storage::disk('local')->exists($question->answer_doc)) {
                $this->addDocumentRelationships($question->answer_doc, $mergedDoc, $mergedRelationships, $relId, $mergedDir);
            }
        }

        file_put_contents($mergedRelsPath, $mergedDoc->saveXML());
    }

    /**
     * Add relationships from a single document
     */
    private function addDocumentRelationships($documentPath, $mergedDoc, $mergedRelationships, &$relId, $mergedDir)
    {
        $tempDir = storage_path('app/temp/rels_extract_' . time() . '_' . rand(1000, 9999));
        
        try {
            mkdir($tempDir, 0755, true);
            $docPath = Storage::disk('local')->path($documentPath);
            $this->extractDocx($docPath, $tempDir);

            $sourceRelsPath = $tempDir . '/word/_rels/document.xml.rels';
            
            if (file_exists($sourceRelsPath)) {
                $sourceRels = file_get_contents($sourceRelsPath);
                $sourceDoc = new \DOMDocument();
                $sourceDoc->loadXML($sourceRels);

                $sourceRelationships = $sourceDoc->getElementsByTagName('Relationship');
                foreach ($sourceRelationships as $rel) {
                    $type = $rel->getAttribute('Type');
                    $target = $rel->getAttribute('Target');
                    
                    // Skip duplicate core relationships but preserve OLE and media relationships
                    if ($this->shouldPreserveRelationship($type)) {
                        $newRel = $mergedDoc->importNode($rel, true);
                        $newRel->setAttribute('Id', 'rId' . $relId);
                        
                        // Update target paths for media and embeddings to match renamed files
                        if (strpos($target, 'media/') !== false || strpos($target, 'embeddings/') !== false) {
                            $pathInfo = pathinfo($target);
                            $newTarget = $pathInfo['dirname'] . '/' . $pathInfo['filename'] . '_' . $relId . '.' . $pathInfo['extension'];
                            $newRel->setAttribute('Target', $newTarget);
                        }
                        
                        $mergedRelationships->appendChild($newRel);
                        $relId++;
                    }
                }
            }

            // Also copy any additional relationship files for OLE objects
            $this->copyOleRelationshipFiles($tempDir, $mergedDir);

        } finally {
            if (is_dir($tempDir)) {
                $this->removeDirectory($tempDir);
            }
        }
    }

    /**
     * Determine if a relationship should be preserved in the merged document
     */
    private function shouldPreserveRelationship($type)
    {
        // Preserve OLE object relationships and media relationships
        $preserveTypes = [
            'http://schemas.openxmlformats.org/officeDocument/2006/relationships/oleObject',
            'http://schemas.openxmlformats.org/officeDocument/2006/relationships/image',
            'http://schemas.openxmlformats.org/officeDocument/2006/relationships/hyperlink',
            'http://schemas.microsoft.com/office/2006/relationships/oleObject',
            'http://schemas.openxmlformats.org/officeDocument/2006/relationships/package'
        ];
        
        return in_array($type, $preserveTypes);
    }

    /**
     * Copy OLE-specific relationship files
     */
    private function copyOleRelationshipFiles($sourceDir, $targetDir)
    {
        // Copy embeddings relationship files
        $sourceEmbeddingRelsDir = $sourceDir . '/word/embeddings/_rels';
        $targetEmbeddingRelsDir = $targetDir . '/word/embeddings/_rels';
        
        if (is_dir($sourceEmbeddingRelsDir)) {
            if (!is_dir($targetEmbeddingRelsDir)) {
                mkdir($targetEmbeddingRelsDir, 0755, true);
            }
            $this->copyDirectory($sourceEmbeddingRelsDir, $targetEmbeddingRelsDir);
        }

        // Copy any custom XML relationship files
        $sourceCustomXmlRelsDir = $sourceDir . '/customXml/_rels';
        $targetCustomXmlRelsDir = $targetDir . '/customXml/_rels';
        
        if (is_dir($sourceCustomXmlRelsDir)) {
            if (!is_dir($targetCustomXmlRelsDir)) {
                mkdir($targetCustomXmlRelsDir, 0755, true);
            }
            $this->copyDirectory($sourceCustomXmlRelsDir, $targetCustomXmlRelsDir);
        }
    }

    /**
     * Update content types to include OLE object types
     */
    private function updateContentTypes($answerDir, $mergedDir)
    {
        $answerContentTypesPath = $answerDir . '/[Content_Types].xml';
        $mergedContentTypesPath = $mergedDir . '/[Content_Types].xml';

        if (file_exists($answerContentTypesPath) && file_exists($mergedContentTypesPath)) {
            $answerContentTypes = file_get_contents($answerContentTypesPath);
            $mergedContentTypes = file_get_contents($mergedContentTypesPath);

            // Parse content types XML
            $answerDoc = new \DOMDocument();
            $answerDoc->loadXML($answerContentTypes);

            $mergedDoc = new \DOMDocument();
            $mergedDoc->loadXML($mergedContentTypes);

            // Get the Types element
            $mergedTypes = $mergedDoc->getElementsByTagName('Types')->item(0);
            $answerDefaults = $answerDoc->getElementsByTagName('Default');
            $answerOverrides = $answerDoc->getElementsByTagName('Override');

            // Add Default types from answer document (important for OLE objects)
            foreach ($answerDefaults as $default) {
                $extension = $default->getAttribute('Extension');
                
                // Check if this extension already exists
                $xpath = new \DOMXPath($mergedDoc);
                $existing = $xpath->query("//Default[@Extension='$extension']");
                
                if ($existing->length === 0) {
                    $importedDefault = $mergedDoc->importNode($default, true);
                    $mergedTypes->appendChild($importedDefault);
                }
            }

            // Add Override types from answer document
            foreach ($answerOverrides as $override) {
                $partName = $override->getAttribute('PartName');
                
                // Check if this part already exists
                $xpath = new \DOMXPath($mergedDoc);
                $existing = $xpath->query("//Override[@PartName='$partName']");
                
                if ($existing->length === 0) {
                    $importedOverride = $mergedDoc->importNode($override, true);
                    $mergedTypes->appendChild($importedOverride);
                }
            }

            file_put_contents($mergedContentTypesPath, $mergedDoc->saveXML());
        }
    }

}
