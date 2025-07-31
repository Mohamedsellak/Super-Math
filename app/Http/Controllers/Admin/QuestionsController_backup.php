<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Question;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;

class QuestionsController extends Controller
{
    private $fileRenameMap = []; // Track file renames during merge

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        return view('admin.questions.index', [
            'questions' => Question::Paginate(10)->sortByDesc('created_at'),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('admin.questions.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'question' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'options' => 'required|string',
            'answer' => 'required|string',
            'difficulty' => ['required', Rule::in(['easy', 'medium', 'hard'])],
            'question_type' => ['required', Rule::in(['Multiple Choice', 'True/False', 'Open Ended', 'Fill in the Blank'])],
            'education_level' => ['required', Rule::in(['Elementary', 'Middle School', 'High School', 'University'])],
            'institution' => 'required|string|max:255',
            'source' => 'required|string|max:255',
            'year' => 'required|integer|min:1900|max:' . date('Y'),
            'region' => 'required|string|max:255',
            'uf' => 'required|string|size:2',
            'doc' => 'required|file|mimes:doc,docx|max:10240', // 10MB max for documents
            'answer_doc' => 'required|file|mimes:doc,docx|max:10240', // 10MB max for answer documents
        ]);

        // Handle image upload (stored in public storage)
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('questions/images', 'public');
        }

        // Handle document upload (stored in private storage for security) - Document is required
        $docPath = $request->file('doc')->store('questions/documents', 'local');

        // Handle answer document upload (stored in private storage for security) - Answer Document is required
        $answerDocPath = $request->file('answer_doc')->store('questions/answer_documents', 'local');

        // Create the question
        $question = Question::create([
            'question' => $validated['question'],
            'image' => $imagePath,
            'options' => $validated['options'],
            'answer' => $validated['answer'],
            'difficulty' => $validated['difficulty'],
            'question_type' => $validated['question_type'],
            'education_level' => $validated['education_level'],
            'institution' => $validated['institution'],
            'source' => $validated['source'],
            'year' => $validated['year'],
            'region' => $validated['region'],
            'uf' => strtoupper($validated['uf']),
            'doc' => $docPath,
            'answer_doc' => $answerDocPath,
        ]);

        return redirect()
            ->route('admin.questions.index', $question)
            ->with('success', 'Question created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Question $question)
    {
        return view('admin.questions.show', [
            'question' => $question,
        ]);
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Question $question)
    {
        //
        return view('admin.questions.edit', [
            'question' => $question,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */

    public function update(Request $request, Question $question)
    {
        $validated = $request->validate([
            'question' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'options' => 'required|string',
            'answer' => 'required|string',
            'difficulty' => ['required', Rule::in(['easy', 'medium', 'hard'])],
            'question_type' => ['required', Rule::in(['Multiple Choice', 'True/False', 'Open Ended', 'Fill in the Blank'])],
            'education_level' => ['required', Rule::in(['Elementary', 'Middle School', 'High School', 'University'])],
            'institution' => 'required|string|max:255',
            'source' => 'required|string|max:255',
            'year' => 'required|integer|min:1900|max:' . date('Y'),
            'region' => 'required|string|max:255',
            'uf' => 'required|string|size:2',
            'doc' => 'nullable|file|mimes:doc,docx|max:10240', // Optional on update
            'answer_doc' => 'nullable|file|mimes:doc,docx|max:10240', // Optional on update
        ]);

        // Handle image upload
        $imagePath = $question->image;
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($question->image) {
                Storage::disk('public')->delete($question->image);
            }
            $imagePath = $request->file('image')->store('questions/images', 'public');
        }

        // Handle document upload
        $docPath = $question->doc;
        if ($request->hasFile('doc')) {
            // Delete old document if exists
            if ($question->doc) {
                Storage::disk('local')->delete($question->doc);
            }
            $docPath = $request->file('doc')->store('questions/documents', 'local');
        }

        // Handle answer document upload
        $answerDocPath = $question->answer_doc;
        if ($request->hasFile('answer_doc')) {
            // Delete old answer document if exists
            if ($question->answer_doc) {
                Storage::disk('local')->delete($question->answer_doc);
            }
            $answerDocPath = $request->file('answer_doc')->store('questions/answer_documents', 'local');
        }

        // Ensure document is always present (either existing or newly uploaded)
        if (!$docPath) {
            return redirect()->back()->withErrors(['doc' => 'A document is required for this question.'])->withInput();
        }

        // Ensure answer document is always present (either existing or newly uploaded)
        if (!$answerDocPath) {
            return redirect()->back()->withErrors(['answer_doc' => 'An answer document is required for this question.'])->withInput();
        }

        // Update the question
        $question->update([
            'question' => $validated['question'],
            'image' => $imagePath,
            'options' => $validated['options'],
            'answer' => $validated['answer'],
            'difficulty' => $validated['difficulty'],
            'question_type' => $validated['question_type'],
            'education_level' => $validated['education_level'],
            'institution' => $validated['institution'],
            'source' => $validated['source'],
            'year' => $validated['year'],
            'region' => $validated['region'],
            'uf' => strtoupper($validated['uf']),
            'doc' => $docPath,
            'answer_doc' => $answerDocPath,
        ]);

        return redirect()
            ->route('admin.questions.index', $question)
            ->with('success', 'Question updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Question $question)
    {
        // Delete associated files
        if ($question->image) {
            Storage::disk('public')->delete($question->image);
        }

        if ($question->doc) {
            Storage::disk('local')->delete($question->doc);
        }

        if ($question->answer_doc) {
            Storage::disk('local')->delete($question->answer_doc);
        }        // Delete the question
        $question->delete();

        return redirect()
            ->route('admin.questions.index')
            ->with('success', 'Question deleted successfully!');
    }

    /**
     * Download the merged document file using simplified approach to preserve MathType equations
     */
    public function downloadDocument(Question $question)
    {
        if (!$question->doc || !Storage::disk('local')->exists($question->doc)) {
            abort(404, 'Question document not found.');
        }

        if (!$question->answer_doc || !Storage::disk('local')->exists($question->answer_doc)) {
            abort(404, 'Answer document not found.');
        }

        try {
            $questionDocPath = Storage::disk('local')->path($question->doc);
            $answerDocPath = Storage::disk('local')->path($question->answer_doc);

            // Use the new DocxMergeService to preserve MathType equations
            $docxMerger = new \App\Services\DocxMergeService();
            $mergedPath = $docxMerger->merge(
                [$questionDocPath, $answerDocPath],
                'question_' . $question->id . '_merged_' . time() . '.docx'
            );

            $fileName = 'question_' . $question->id . '_complete_document.docx';

            // Return download response and delete temp file after download
            return response()->download($mergedPath, $fileName)->deleteFileAfterSend(true);

        } catch (\Exception $e) {
            \Log::error('Document merge error: ' . $e->getMessage());
            abort(500, 'Error merging documents: ' . $e->getMessage());
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

        // STEP 1: Merge all media and embedding files first and get rename mapping
        $fileRenameMap = $this->mergeMediaFiles($answerDir, $mergedDir);

        // STEP 2: Merge OLE relationship files to preserve editability
        $this->mergeOleRelationshipFiles($answerDir, $mergedDir, $fileRenameMap);

        // STEP 3: Update relationships with proper ID mapping and file rename mapping
        $relationshipMap = $this->updateRelationships($answerDir, $mergedDir, $fileRenameMap);

        // STEP 4: Update content types
        $this->updateContentTypes($answerDir, $mergedDir, $fileRenameMap);

        // STEP 5: Merge document content with corrected relationship references
        $this->mergeDocumentContent($questionDir, $answerDir, $mergedDir, $relationshipMap);
    }    /**
     * Merge media files (images, OLE objects, embeddings) with proper conflict resolution
     */
    private function mergeMediaFiles($answerDir, $mergedDir)
    {
        $fileRenameMap = []; // Track file renames: original -> new name

        // Merge media directory (images, etc.)
        $fileRenameMap = array_merge($fileRenameMap,
            $this->mergeDirectoryContentsWithMapping($answerDir . '/word/media', $mergedDir . '/word/media'));

        // Merge embeddings directory (OLE objects like MathType) - MOST IMPORTANT
        $embeddingRenameMap = $this->mergeDirectoryContentsWithMapping($answerDir . '/word/embeddings', $mergedDir . '/word/embeddings');
        $fileRenameMap = array_merge($fileRenameMap, $embeddingRenameMap);

        // Store the file rename map for later use in relationship updates
        $this->fileRenameMap = $fileRenameMap;

        // Merge any other OLE-related directories
        $oleDirectories = [
            '/word/charts',
            '/word/drawings',
            '/word/theme',
            '/word/diagrams',
            '/customXml'
        ];

        foreach ($oleDirectories as $dir) {
            $answerPath = $answerDir . $dir;
            $mergedPath = $mergedDir . $dir;

            if (is_dir($answerPath)) {
                $dirRenameMap = $this->mergeDirectoryContentsWithMapping($answerPath, $mergedPath);
                $fileRenameMap = array_merge($fileRenameMap, $dirRenameMap);
            }
        }

        // Copy any activeX directories (for embedded objects)
        $answerActiveXDir = $answerDir . '/word/activeX';
        $mergedActiveXDir = $mergedDir . '/word/activeX';

        if (is_dir($answerActiveXDir)) {
            if (!is_dir($mergedActiveXDir)) {
                mkdir($mergedActiveXDir, 0755, true);
            }
            $this->copyDirectory($answerActiveXDir, $mergedActiveXDir);
        }

        // Copy any object binary files (objectX.bin)
        $this->copyObjectBinaryFiles($answerDir, $mergedDir);

        // Copy any math type specific files
        $this->copyMathTypeFiles($answerDir, $mergedDir);

        // Copy OLE object settings and metadata files
        $this->copyOleMetadataFiles($answerDir, $mergedDir);

        return $fileRenameMap;
    }

    /**
     * Copy OLE object metadata and settings files
     */
    private function copyOleMetadataFiles($answerDir, $mergedDir)
    {
        // Copy app.xml which contains application metadata for OLE objects
        $answerAppPath = $answerDir . '/docProps/app.xml';
        $mergedAppPath = $mergedDir . '/docProps/app.xml';

        if (file_exists($answerAppPath)) {
            $this->mergeAppProperties($answerAppPath, $mergedAppPath);
        }

        // Copy core.xml which contains core document properties
        $answerCorePath = $answerDir . '/docProps/core.xml';
        $mergedCorePath = $mergedDir . '/docProps/core.xml';

        if (file_exists($answerCorePath)) {
            $this->mergeCoreProperties($answerCorePath, $mergedCorePath);
        }

        // Copy custom.xml if it exists (for custom OLE properties)
        $answerCustomPath = $answerDir . '/docProps/custom.xml';
        $mergedCustomPath = $mergedDir . '/docProps/custom.xml';

        if (file_exists($answerCustomPath)) {
            $this->mergeCustomProperties($answerCustomPath, $mergedCustomPath);
        }

        // Copy settings.xml which can contain OLE object settings
        $answerSettingsPath = $answerDir . '/word/settings.xml';
        $mergedSettingsPath = $mergedDir . '/word/settings.xml';

        if (file_exists($answerSettingsPath)) {
            $this->mergeSettings($answerSettingsPath, $mergedSettingsPath);
        }
    }

    /**
     * Merge app properties
     */
    private function mergeAppProperties($answerAppPath, $mergedAppPath)
    {
        if (!file_exists($mergedAppPath)) {
            copy($answerAppPath, $mergedAppPath);
            return;
        }

        try {
            $answerApp = new \DOMDocument();
            $answerApp->load($answerAppPath);

            $mergedApp = new \DOMDocument();
            $mergedApp->load($mergedAppPath);

            // Update application name to indicate it contains merged content
            $appElement = $mergedApp->getElementsByTagName('Application')->item(0);
            if ($appElement) {
                $appElement->textContent = 'Microsoft Office Word with MathType Objects';
            }

            file_put_contents($mergedAppPath, $mergedApp->saveXML());
        } catch (\Exception $e) {
            \Log::warning("Could not merge app properties: " . $e->getMessage());
        }
    }

    /**
     * Merge core properties
     */
    private function mergeCoreProperties($answerCorePath, $mergedCorePath)
    {
        if (!file_exists($mergedCorePath)) {
            copy($answerCorePath, $mergedCorePath);
            return;
        }

        try {
            $mergedCore = new \DOMDocument();
            $mergedCore->load($mergedCorePath);

            // Update modified time
            $modifiedElement = $mergedCore->getElementsByTagName('modified')->item(0);
            if ($modifiedElement) {
                $modifiedElement->textContent = date('c');
            }

            file_put_contents($mergedCorePath, $mergedCore->saveXML());
        } catch (\Exception $e) {
            \Log::warning("Could not merge core properties: " . $e->getMessage());
        }
    }

    /**
     * Merge custom properties (for OLE object custom data)
     */
    private function mergeCustomProperties($answerCustomPath, $mergedCustomPath)
    {
        if (!file_exists($mergedCustomPath)) {
            copy($answerCustomPath, $mergedCustomPath);
            return;
        }

        try {
            $answerCustom = new \DOMDocument();
            $answerCustom->load($answerCustomPath);

            $mergedCustom = new \DOMDocument();
            $mergedCustom->load($mergedCustomPath);

            $mergedPropertiesElement = $mergedCustom->getElementsByTagName('Properties')->item(0);

            // Get existing property names to avoid duplicates
            $existingPropertyNames = [];
            foreach ($mergedCustom->getElementsByTagName('property') as $property) {
                $existingPropertyNames[] = $property->getAttribute('name');
            }

            // Add new custom properties from answer document
            foreach ($answerCustom->getElementsByTagName('property') as $property) {
                $propertyName = $property->getAttribute('name');
                if (!in_array($propertyName, $existingPropertyNames)) {
                    $importedProperty = $mergedCustom->importNode($property, true);
                    $mergedPropertiesElement->appendChild($importedProperty);
                    $existingPropertyNames[] = $propertyName;
                }
            }

            file_put_contents($mergedCustomPath, $mergedCustom->saveXML());
        } catch (\Exception $e) {
            \Log::warning("Could not merge custom properties: " . $e->getMessage());
        }
    }

    /**
     * Merge settings (for OLE object settings)
     */
    private function mergeSettings($answerSettingsPath, $mergedSettingsPath)
    {
        if (!file_exists($mergedSettingsPath)) {
            copy($answerSettingsPath, $mergedSettingsPath);
            return;
        }

        try {
            $answerSettings = new \DOMDocument();
            $answerSettings->load($answerSettingsPath);

            $mergedSettings = new \DOMDocument();
            $mergedSettings->load($mergedSettingsPath);

            $mergedSettingsElement = $mergedSettings->getElementsByTagName('settings')->item(0);

            // Merge specific OLE-related settings
            $oleSettings = [
                'embedTrueTypeFonts',
                'doNotPromptForConvert',
                'defaultTableStyle',
                'activeWritingStyle'
            ];

            foreach ($oleSettings as $settingName) {
                $answerSetting = $answerSettings->getElementsByTagName($settingName)->item(0);
                $mergedSetting = $mergedSettings->getElementsByTagName($settingName)->item(0);

                if ($answerSetting && !$mergedSetting) {
                    $importedSetting = $mergedSettings->importNode($answerSetting, true);
                    $mergedSettingsElement->appendChild($importedSetting);
                }
            }

            file_put_contents($mergedSettingsPath, $mergedSettings->saveXML());
        } catch (\Exception $e) {
            \Log::warning("Could not merge settings: " . $e->getMessage());
        }
    }

    /**
     * Copy MathType specific files that are needed for equation editability
     */
    private function copyMathTypeFiles($answerDir, $mergedDir)
    {
        // MathType files can be in various locations
        $mathTypeLocations = [
            '/word/media',
            '/word/embeddings',
            '/word',
            '/customXml',
            '/docProps'
        ];

        foreach ($mathTypeLocations as $location) {
            $sourceDir = $answerDir . $location;
            $targetDir = $mergedDir . $location;

            if (is_dir($sourceDir)) {
                $files = scandir($sourceDir);
                foreach ($files as $file) {
                    if ($file !== '.' && $file !== '..') {
                        $sourcePath = $sourceDir . '/' . $file;

                        // Look for MathType related files
                        if (is_file($sourcePath) && (
                            preg_match('/\.emf$/i', $file) ||
                            preg_match('/\.wmf$/i', $file) ||
                            preg_match('/oleObject\d*\.bin$/i', $file) ||
                            preg_match('/mathtype/i', $file) ||
                            preg_match('/equation/i', $file) ||
                            strpos(strtolower($file), 'ole') !== false
                        )) {
                            if (!is_dir($targetDir)) {
                                mkdir($targetDir, 0755, true);
                            }

                            $targetPath = $this->resolveFileNameConflict($targetDir . '/' . $file, $file);

                            // Use binary-safe copy for OLE object files
                            $this->copyOleFile($sourcePath, $targetPath);

                            \Log::info("Copied MathType file: {$file} -> " . basename($targetPath));
                        }
                    }
                }
            }
        }
    }

    /**
     * Binary-safe copy for OLE object files
     */
    private function copyOleFile($sourcePath, $targetPath)
    {
        // Use binary mode to ensure OLE object data integrity
        $sourceHandle = fopen($sourcePath, 'rb');
        $targetHandle = fopen($targetPath, 'wb');

        if ($sourceHandle && $targetHandle) {
            while (!feof($sourceHandle)) {
                $chunk = fread($sourceHandle, 8192); // Read in 8KB chunks
                fwrite($targetHandle, $chunk);
            }
            fclose($sourceHandle);
            fclose($targetHandle);

            // Verify file integrity
            if (filesize($sourcePath) !== filesize($targetPath)) {
                \Log::error("OLE file copy size mismatch: " . basename($sourcePath));
            }
        } else {
            // Fallback to regular copy
            copy($sourcePath, $targetPath);
        }
    }

    /**
     * Merge OLE relationship files to preserve object editability
     */
    private function mergeOleRelationshipFiles($answerDir, $mergedDir, $fileRenameMap)
    {
        // Merge embedding relationship files (critical for OLE object editability)
        $this->mergeEmbeddingRelationships($answerDir, $mergedDir, $fileRenameMap);

        // Copy any OLE-specific files that maintain object links
        $this->copyOleSpecificFiles($answerDir, $mergedDir);

        // Merge font table and other supporting files
        $this->mergeSupportingOleFiles($answerDir, $mergedDir);
    }

    /**
     * Merge embedding relationship files (embeddings/_rels/*.rels)
     */
    private function mergeEmbeddingRelationships($answerDir, $mergedDir, $fileRenameMap)
    {
        $answerEmbeddingRelsDir = $answerDir . '/word/embeddings/_rels';
        $mergedEmbeddingRelsDir = $mergedDir . '/word/embeddings/_rels';

        if (!is_dir($answerEmbeddingRelsDir)) {
            return;
        }

        if (!is_dir($mergedEmbeddingRelsDir)) {
            mkdir($mergedEmbeddingRelsDir, 0755, true);
        }

        $files = scandir($answerEmbeddingRelsDir);
        foreach ($files as $file) {
            if ($file !== '.' && $file !== '..' && pathinfo($file, PATHINFO_EXTENSION) === 'rels') {
                $sourceFile = $answerEmbeddingRelsDir . '/' . $file;
                $targetFile = $mergedEmbeddingRelsDir . '/' . $file;

                // Check if the corresponding embedding file was renamed
                $embeddingFileName = str_replace('.rels', '', $file);
                if (isset($fileRenameMap[$embeddingFileName])) {
                    $newEmbeddingFileName = $fileRenameMap[$embeddingFileName];
                    $targetFile = $mergedEmbeddingRelsDir . '/' . $newEmbeddingFileName . '.rels';
                }

                // Copy the relationship file
                copy($sourceFile, $targetFile);

                \Log::info("Copied OLE relationship file: {$file} -> " . basename($targetFile));
            }
        }
    }

    /**
     * Copy OLE-specific files that maintain object editability
     */
    private function copyOleSpecificFiles($answerDir, $mergedDir)
    {
        // Copy font table files which are needed for proper OLE rendering
        $answerFontTablePath = $answerDir . '/word/fontTable.xml';
        $mergedFontTablePath = $mergedDir . '/word/fontTable.xml';

        if (file_exists($answerFontTablePath)) {
            // Merge font tables instead of overwriting
            $this->mergeFontTables($answerFontTablePath, $mergedFontTablePath);
        }

        // Copy any .bin files in the word directory (OLE object data)
        $answerWordDir = $answerDir . '/word';
        $mergedWordDir = $mergedDir . '/word';

        if (is_dir($answerWordDir)) {
            $files = scandir($answerWordDir);
            foreach ($files as $file) {
                if (pathinfo($file, PATHINFO_EXTENSION) === 'bin') {
                    $sourceFile = $answerWordDir . '/' . $file;
                    $targetFile = $this->resolveFileNameConflict($mergedWordDir . '/' . $file, $file);
                    $this->copyOleFile($sourceFile, $targetFile);
                }
            }
        }
    }

    /**
     * Merge supporting OLE files
     */
    private function mergeSupportingOleFiles($answerDir, $mergedDir)
    {
        // Copy styles.xml to ensure proper OLE object styling
        $answerStylesPath = $answerDir . '/word/styles.xml';
        $mergedStylesPath = $mergedDir . '/word/styles.xml';

        if (file_exists($answerStylesPath)) {
            $this->mergeStyles($answerStylesPath, $mergedStylesPath);
        }

        // Copy numbering.xml if it exists (for equation numbering)
        $answerNumberingPath = $answerDir . '/word/numbering.xml';
        $mergedNumberingPath = $mergedDir . '/word/numbering.xml';

        if (file_exists($answerNumberingPath)) {
            $this->mergeNumbering($answerNumberingPath, $mergedNumberingPath);
        }
    }

    /**
     * Merge font tables to include all fonts needed for OLE objects
     */
    private function mergeFontTables($answerFontTablePath, $mergedFontTablePath)
    {
        if (!file_exists($mergedFontTablePath)) {
            copy($answerFontTablePath, $mergedFontTablePath);
            return;
        }

        try {
            $answerFontTable = new \DOMDocument();
            $answerFontTable->load($answerFontTablePath);

            $mergedFontTable = new \DOMDocument();
            $mergedFontTable->load($mergedFontTablePath);

            $mergedFontsElement = $mergedFontTable->getElementsByTagName('fonts')->item(0);

            // Get existing font names to avoid duplicates
            $existingFonts = [];
            foreach ($mergedFontTable->getElementsByTagName('font') as $font) {
                $existingFonts[] = $font->getAttribute('w:name');
            }

            // Add new fonts from answer document
            foreach ($answerFontTable->getElementsByTagName('font') as $font) {
                $fontName = $font->getAttribute('w:name');
                if (!in_array($fontName, $existingFonts)) {
                    $importedFont = $mergedFontTable->importNode($font, true);
                    $mergedFontsElement->appendChild($importedFont);
                    $existingFonts[] = $fontName;
                }
            }

            file_put_contents($mergedFontTablePath, $mergedFontTable->saveXML());
        } catch (\Exception $e) {
            \Log::warning("Could not merge font tables: " . $e->getMessage());
        }
    }

    /**
     * Merge styles to ensure OLE objects render correctly
     */
    private function mergeStyles($answerStylesPath, $mergedStylesPath)
    {
        if (!file_exists($mergedStylesPath)) {
            copy($answerStylesPath, $mergedStylesPath);
            return;
        }

        try {
            $answerStyles = new \DOMDocument();
            $answerStyles->load($answerStylesPath);

            $mergedStyles = new \DOMDocument();
            $mergedStyles->load($mergedStylesPath);

            $mergedStylesElement = $mergedStyles->getElementsByTagName('styles')->item(0);

            // Get existing style IDs to avoid duplicates
            $existingStyleIds = [];
            foreach ($mergedStyles->getElementsByTagName('style') as $style) {
                $existingStyleIds[] = $style->getAttribute('w:styleId');
            }

            // Add new styles from answer document
            foreach ($answerStyles->getElementsByTagName('style') as $style) {
                $styleId = $style->getAttribute('w:styleId');
                if (!in_array($styleId, $existingStyleIds)) {
                    $importedStyle = $mergedStyles->importNode($style, true);
                    $mergedStylesElement->appendChild($importedStyle);
                    $existingStyleIds[] = $styleId;
                }
            }

            file_put_contents($mergedStylesPath, $mergedStyles->saveXML());
        } catch (\Exception $e) {
            \Log::warning("Could not merge styles: " . $e->getMessage());
        }
    }

    /**
     * Merge numbering files for equation numbering
     */
    private function mergeNumbering($answerNumberingPath, $mergedNumberingPath)
    {
        if (!file_exists($mergedNumberingPath)) {
            copy($answerNumberingPath, $mergedNumberingPath);
            return;
        }

        try {
            $answerNumbering = new \DOMDocument();
            $answerNumbering->load($answerNumberingPath);

            $mergedNumbering = new \DOMDocument();
            $mergedNumbering->load($mergedNumberingPath);

            $mergedNumberingElement = $mergedNumbering->getElementsByTagName('numbering')->item(0);

            // Get existing numbering IDs to avoid duplicates
            $existingNumIds = [];
            foreach ($mergedNumbering->getElementsByTagName('num') as $num) {
                $existingNumIds[] = $num->getAttribute('w:numId');
            }
            foreach ($mergedNumbering->getElementsByTagName('abstractNum') as $abstractNum) {
                $existingNumIds[] = 'abstract_' . $abstractNum->getAttribute('w:abstractNumId');
            }

            // Add new numbering from answer document with ID adjustments
            $this->mergeNumberingDefinitions($answerNumbering, $mergedNumbering, $mergedNumberingElement, $existingNumIds);

            file_put_contents($mergedNumberingPath, $mergedNumbering->saveXML());
        } catch (\Exception $e) {
            \Log::warning("Could not merge numbering: " . $e->getMessage());
        }
    }

    /**
     * Merge numbering definitions with proper ID management
     */
    private function mergeNumberingDefinitions($answerNumbering, $mergedNumbering, $mergedNumberingElement, $existingNumIds)
    {
        // Add abstract numbering definitions
        foreach ($answerNumbering->getElementsByTagName('abstractNum') as $abstractNum) {
            $abstractNumId = $abstractNum->getAttribute('w:abstractNumId');
            if (!in_array('abstract_' . $abstractNumId, $existingNumIds)) {
                $importedAbstractNum = $mergedNumbering->importNode($abstractNum, true);
                $mergedNumberingElement->appendChild($importedAbstractNum);
                $existingNumIds[] = 'abstract_' . $abstractNumId;
            }
        }

        // Add numbering instances
        foreach ($answerNumbering->getElementsByTagName('num') as $num) {
            $numId = $num->getAttribute('w:numId');
            if (!in_array($numId, $existingNumIds)) {
                $importedNum = $mergedNumbering->importNode($num, true);
                $mergedNumberingElement->appendChild($importedNum);
                $existingNumIds[] = $numId;
            }
        }
    }

    /**
     * Merge directory contents with proper naming conflict resolution and return rename mapping
     */
    private function mergeDirectoryContentsWithMapping($sourceDir, $targetDir)
    {
        $renameMap = [];

        if (!is_dir($sourceDir)) {
            return $renameMap;
        }

        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0755, true);
        }

        $files = scandir($sourceDir);
        foreach ($files as $file) {
            if ($file !== '.' && $file !== '..') {
                $sourcePath = $sourceDir . '/' . $file;
                $targetPath = $targetDir . '/' . $file;

                if (is_dir($sourcePath)) {
                    $subDirRenameMap = $this->mergeDirectoryContentsWithMapping($sourcePath, $targetPath);
                    $renameMap = array_merge($renameMap, $subDirRenameMap);
                } else {
                    // Handle file naming conflicts
                    $finalTargetPath = $this->resolveFileNameConflict($targetPath, $file);
                    $finalFileName = basename($finalTargetPath);

                    // Track if file was renamed
                    if ($finalFileName !== $file) {
                        $renameMap[$file] = $finalFileName;
                    }

                    copy($sourcePath, $finalTargetPath);
                }
            }
        }

        return $renameMap;
    }

    /**
     * Resolve file naming conflicts by adding unique suffixes
     */
    private function resolveFileNameConflict($originalPath, $fileName)
    {
        $targetPath = $originalPath;
        $counter = 1;

        while (file_exists($targetPath)) {
            $pathInfo = pathinfo($fileName);
            $baseName = $pathInfo['filename'];
            $extension = isset($pathInfo['extension']) ? '.' . $pathInfo['extension'] : '';

            $newFileName = $baseName . '_ans_' . $counter . $extension;
            $targetPath = dirname($originalPath) . '/' . $newFileName;
            $counter++;
        }

        // Log the rename for debugging
        if ($targetPath !== $originalPath) {
            \Log::info("File renamed: {$fileName} -> " . basename($targetPath));
        }

        return $targetPath;
    }

    /**
     * Copy object binary files (like objectX.bin) which contain OLE object data
     */
    private function copyObjectBinaryFiles($answerDir, $mergedDir)
    {
        // Look for object files in the word directory
        $answerWordDir = $answerDir . '/word';
        $mergedWordDir = $mergedDir . '/word';

        if (!is_dir($answerWordDir)) {
            return;
        }

        $files = scandir($answerWordDir);
        foreach ($files as $file) {
            // Copy any object*.bin files or similar OLE object files
            if (preg_match('/^object\d+\.bin$/i', $file) ||
                preg_match('/^oleObject\d+\.bin$/i', $file) ||
                preg_match('/^.*\.emf$/i', $file) ||
                preg_match('/^.*\.wmf$/i', $file)) {

                $sourcePath = $answerWordDir . '/' . $file;
                $targetPath = $mergedWordDir . '/' . $file;

                // Resolve naming conflicts
                $finalTargetPath = $this->resolveFileNameConflict($targetPath, $file);
                $this->copyOleFile($sourcePath, $finalTargetPath);
            }
        }
    }

    /**
     * Update relationships with proper ID mapping and return the mapping
     */
    private function updateRelationships($answerDir, $mergedDir, $fileRenameMap = [])
    {
        $answerRelsPath = $answerDir . '/word/_rels/document.xml.rels';
        $mergedRelsPath = $mergedDir . '/word/_rels/document.xml.rels';

        if (!file_exists($answerRelsPath) || !file_exists($mergedRelsPath)) {
            return [];
        }

        $answerRels = new \DOMDocument();
        $answerRels->load($answerRelsPath);

        $mergedRels = new \DOMDocument();
        $mergedRels->load($mergedRelsPath);

        $mergedRelationshipsNode = $mergedRels->getElementsByTagName('Relationships')->item(0);

        // Get existing relationship IDs to avoid conflicts
        $existingIds = [];
        foreach ($mergedRels->getElementsByTagName('Relationship') as $rel) {
            $existingIds[] = $rel->getAttribute('Id');
        }

        $relationshipMap = [];
        $counter = 100; // Start from a high number to avoid conflicts

        // Process each relationship from answer document
        foreach ($answerRels->getElementsByTagName('Relationship') as $rel) {
            $oldId = $rel->getAttribute('Id');
            $target = $rel->getAttribute('Target');
            $type = $rel->getAttribute('Type');

            // Generate new unique ID
            do {
                $newId = 'rId' . $counter;
                $counter++;
            } while (in_array($newId, $existingIds));

            $existingIds[] = $newId;
            $relationshipMap[$oldId] = $newId;

            // Create new relationship element
            $newRel = $mergedRels->createElement('Relationship');
            $newRel->setAttribute('Id', $newId);
            $newRel->setAttribute('Type', $type);

            // Update target path for renamed files using the file rename map
            $updatedTarget = $this->getUpdatedTargetPath($target, $answerDir, $mergedDir, $fileRenameMap);
            $newRel->setAttribute('Target', $updatedTarget);

            // For OLE object relationships, add additional attributes to maintain editability
            if (strpos($type, 'oleObject') !== false ||
                strpos($type, 'package') !== false ||
                strpos($target, 'embeddings/') !== false) {

                // Copy any additional attributes that maintain OLE object functionality
                foreach ($rel->attributes as $attr) {
                    if ($attr->name !== 'Id' && $attr->name !== 'Type' && $attr->name !== 'Target') {
                        $newRel->setAttribute($attr->name, $attr->value);
                    }
                }

                \Log::info("Added OLE relationship: {$oldId} -> {$newId} for target: {$updatedTarget}");
            }

            $mergedRelationshipsNode->appendChild($newRel);
        }

        // Save updated relationships
        file_put_contents($mergedRelsPath, $mergedRels->saveXML());

        return $relationshipMap;
    }

    /**
     * Get updated target path for files that may have been renamed
     */
    private function getUpdatedTargetPath($originalTarget, $answerDir, $mergedDir, $fileRenameMap = [])
    {
        // Extract the file name from the target
        $fileName = basename($originalTarget);

        // Check if this file was renamed using our rename map
        if (isset($fileRenameMap[$fileName])) {
            $newFileName = $fileRenameMap[$fileName];
            return dirname($originalTarget) . '/' . $newFileName;
        }

        // Handle media files
        if (strpos($originalTarget, 'media/') === 0) {
            $mediaDir = $mergedDir . '/word/media';

            if (is_dir($mediaDir)) {
                // Check if original file exists
                if (file_exists($mediaDir . '/' . $fileName)) {
                    return $originalTarget;
                }

                // Look for renamed version
                $files = scandir($mediaDir);
                foreach ($files as $file) {
                    if (strpos($file, pathinfo($fileName, PATHINFO_FILENAME) . '_ans_') === 0) {
                        return 'media/' . $file;
                    }
                }
            }
        }

        // Handle embeddings files (OLE objects)
        if (strpos($originalTarget, 'embeddings/') === 0) {
            $embeddingsDir = $mergedDir . '/word/embeddings';

            if (is_dir($embeddingsDir)) {
                if (file_exists($embeddingsDir . '/' . $fileName)) {
                    return $originalTarget;
                }

                $files = scandir($embeddingsDir);
                foreach ($files as $file) {
                    if (strpos($file, pathinfo($fileName, PATHINFO_FILENAME) . '_ans_') === 0) {
                        return 'embeddings/' . $file;
                    }
                }
            }
        }

        return $originalTarget;
    }

    /**
     * Merge document content with proper relationship mapping
     */
    private function mergeDocumentContent($questionDir, $answerDir, $mergedDir, $relationshipMap)
    {
        // Read the answer document XML
        $answerDocPath = $answerDir . '/word/document.xml';
        if (!file_exists($answerDocPath)) {
            return;
        }

        $answerDocXml = file_get_contents($answerDocPath);

        // Update all relationship references in answer document
        foreach ($relationshipMap as $oldId => $newId) {
            $answerDocXml = str_replace('r:id="' . $oldId . '"', 'r:id="' . $newId . '"', $answerDocXml);
            $answerDocXml = str_replace('r:embed="' . $oldId . '"', 'r:embed="' . $newId . '"', $answerDocXml);
            $answerDocXml = str_replace('r:pict="' . $oldId . '"', 'r:pict="' . $newId . '"', $answerDocXml);
            $answerDocXml = str_replace('r:link="' . $oldId . '"', 'r:link="' . $newId . '"', $answerDocXml);

            // Additional OLE object relationship patterns
            $answerDocXml = str_replace('r:objectId="' . $oldId . '"', 'r:objectId="' . $newId . '"', $answerDocXml);
            $answerDocXml = str_replace('ole:ObjectID="' . $oldId . '"', 'ole:ObjectID="' . $newId . '"', $answerDocXml);
        }

        // Load the current merged document
        $mergedDocPath = $mergedDir . '/word/document.xml';
        $mergedDoc = new \DOMDocument();
        $mergedDoc->preserveWhiteSpace = true; // Important for OLE objects
        $mergedDoc->formatOutput = false; // Don't reformat OLE object XML
        $mergedDoc->load($mergedDocPath);

        // Load the updated answer document
        $answerDoc = new \DOMDocument();
        $answerDoc->preserveWhiteSpace = true; // Important for OLE objects
        $answerDoc->formatOutput = false; // Don't reformat OLE object XML
        $answerDoc->loadXML($answerDocXml);

        // Ensure both documents have proper namespace declarations
        $this->ensureOleNamespaces($mergedDoc);
        $this->ensureOleNamespaces($answerDoc);

        // Get body elements
        $mergedBody = $mergedDoc->getElementsByTagName('body')->item(0);
        $answerBody = $answerDoc->getElementsByTagName('body')->item(0);

        // Add page break
        $this->addPageBreak($mergedDoc, $mergedBody);

        // Add answer section title
        $this->addAnswerSectionTitle($mergedDoc, $mergedBody);

        // Import answer content with special handling for OLE objects
        if ($answerBody) {
            foreach ($answerBody->childNodes as $answerElement) {
                if ($answerElement->nodeType === XML_ELEMENT_NODE) {
                    // Special handling for elements containing OLE objects
                    if ($this->containsOleObject($answerElement)) {
                        \Log::info("Importing paragraph with OLE object");
                        $importedElement = $this->importOleElement($mergedDoc, $answerElement);
                    } else {
                        $importedElement = $mergedDoc->importNode($answerElement, true);
                    }
                    $mergedBody->appendChild($importedElement);
                }
            }
        }

        // Save the merged document with proper formatting
        $xmlString = $mergedDoc->saveXML();

        // Ensure proper XML declaration and formatting for Word
        if (strpos($xmlString, '<?xml') === false) {
            $xmlString = '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>' . "\n" . $xmlString;
        }

        // Final validation and fix for OLE object references
        $xmlString = $this->validateAndFixOleReferences($xmlString);

        file_put_contents($mergedDocPath, $xmlString);
    }

    /**
     * Validate and fix OLE object references in the final XML
     */
    private function validateAndFixOleReferences($xmlString)
    {
        // Ensure OLE object tags have proper structure
        $olePatterns = [
            // Fix object elements that might be missing required attributes
            '/<(w:object[^>]*?)>/' => '<$1>',
            // Ensure oleObject elements have proper namespace
            '/<oleObject/' => '<o:oleObject',
            '/<\/oleObject>/' => '</o:oleObject>',
            // Fix any namespace issues with shapes
            '/<shape/' => '<v:shape',
            '/<\/shape>/' => '</v:shape>',
        ];

        foreach ($olePatterns as $pattern => $replacement) {
            $xmlString = preg_replace($pattern, $replacement, $xmlString);
        }

        // Validate that all OLE object references are properly formed
        if (preg_match_all('/<o:oleObject[^>]*>/i', $xmlString, $matches)) {
            \Log::info("Found " . count($matches[0]) . " OLE objects in final document");
        }

        return $xmlString;
    }

    /**
     * Check if an element contains OLE objects
     */
    private function containsOleObject($element)
    {
        // Check if element contains OLE object tags
        $oleTagPatterns = [
            'object',
            'oleObject',
            'embed',
            'package',
            'OLEObject',
            'w:object',
            'o:OLEObject',
            'v:shape',
            'w:pict'
        ];

        $xmlString = $element->ownerDocument->saveXML($element);

        foreach ($oleTagPatterns as $pattern) {
            if (stripos($xmlString, $pattern) !== false) {
                return true;
            }
        }

        return false;
    }

    /**
     * Import OLE element with proper namespace preservation
     */
    private function importOleElement($targetDoc, $sourceElement)
    {
        // Create a temporary document to handle namespaces properly
        $tempDoc = new \DOMDocument();
        $tempDoc->preserveWhiteSpace = true;
        $tempDoc->formatOutput = false;

        // Import the source document's root element to get all namespaces
        $sourceDoc = $sourceElement->ownerDocument;
        $sourceRoot = $sourceDoc->documentElement;

        // Create a temporary root with all namespace declarations
        $tempRoot = $tempDoc->createElementNS(
            $sourceRoot->namespaceURI ?: 'http://schemas.openxmlformats.org/wordprocessingml/2006/main',
            $sourceRoot->nodeName
        );
        $tempDoc->appendChild($tempRoot);

        // Copy all namespace declarations from source document
        if ($sourceRoot) {
            foreach ($sourceRoot->attributes as $attr) {
                if (strpos($attr->name, 'xmlns') === 0) {
                    $tempRoot->setAttributeNode($tempDoc->importNode($attr, true));
                }
            }
        }

        // Add common OLE namespaces if they don't exist
        $oleNamespaces = [
            'xmlns:w' => 'http://schemas.openxmlformats.org/wordprocessingml/2006/main',
            'xmlns:o' => 'urn:schemas-microsoft-com:office:office',
            'xmlns:v' => 'urn:schemas-microsoft-com:vml',
            'xmlns:r' => 'http://schemas.openxmlformats.org/officeDocument/2006/relationships'
        ];

        foreach ($oleNamespaces as $prefix => $uri) {
            if (!$tempRoot->hasAttribute($prefix)) {
                $tempRoot->setAttribute($prefix, $uri);
            }
        }

        // Copy the actual element
        $importedElement = $tempDoc->importNode($sourceElement, true);
        $tempRoot->appendChild($importedElement);

        // Import the properly namespaced element into target document
        $finalElement = $targetDoc->importNode($importedElement, true);

        return $finalElement;
    }

    /**
     * Ensure OLE namespaces are properly declared in the document
     */
    private function ensureOleNamespaces($doc)
    {
        $root = $doc->documentElement;
        if (!$root) {
            return;
        }

        $oleNamespaces = [
            'xmlns:w' => 'http://schemas.openxmlformats.org/wordprocessingml/2006/main',
            'xmlns:o' => 'urn:schemas-microsoft-com:office:office',
            'xmlns:v' => 'urn:schemas-microsoft-com:vml',
            'xmlns:r' => 'http://schemas.openxmlformats.org/officeDocument/2006/relationships',
            'xmlns:wp' => 'http://schemas.openxmlformats.org/drawingml/2006/wordprocessingDrawing',
            'xmlns:a' => 'http://schemas.openxmlformats.org/drawingml/2006/main'
        ];

        foreach ($oleNamespaces as $prefix => $uri) {
            if (!$root->hasAttribute($prefix)) {
                $root->setAttribute($prefix, $uri);
            }
        }
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
     * Add answer section title
     */
    private function addAnswerSectionTitle($doc, $body)
    {
        $titleElement = $doc->createElementNS(
            'http://schemas.openxmlformats.org/wordprocessingml/2006/main',
            'w:p'
        );
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
        $titleRunProps->appendChild($titleBold);
        $titleRunProps->appendChild($titleSize);
        $titleRun->appendChild($titleRunProps);

        $titleText = $doc->createElementNS(
            'http://schemas.openxmlformats.org/wordprocessingml/2006/main',
            'w:t',
            'ANSWER SECTION'
        );
        $titleRun->appendChild($titleText);
        $titleElement->appendChild($titleRun);
        $body->appendChild($titleElement);
    }

    /**
     * Update content types to include all media and OLE object types from answer document
     */
    private function updateContentTypes($answerDir, $mergedDir, $fileRenameMap = [])
    {
        $answerTypesPath = $answerDir . '/[Content_Types].xml';
        $mergedTypesPath = $mergedDir . '/[Content_Types].xml';

        if (!file_exists($answerTypesPath) || !file_exists($mergedTypesPath)) {
            return;
        }

        $answerTypes = new \DOMDocument();
        $answerTypes->load($answerTypesPath);

        $mergedTypes = new \DOMDocument();
        $mergedTypes->load($mergedTypesPath);

        $mergedTypesRoot = $mergedTypes->getElementsByTagName('Types')->item(0);

        // Get existing content types to avoid duplicates
        $existingTypes = [];
        $existingOverrides = [];

        foreach ($mergedTypes->getElementsByTagName('Default') as $default) {
            $existingTypes[$default->getAttribute('Extension')] = $default->getAttribute('ContentType');
        }

        foreach ($mergedTypes->getElementsByTagName('Override') as $override) {
            $existingOverrides[] = $override->getAttribute('PartName');
        }

        // Add new default types from answer document
        foreach ($answerTypes->getElementsByTagName('Default') as $default) {
            $extension = $default->getAttribute('Extension');
            $contentType = $default->getAttribute('ContentType');

            if (!isset($existingTypes[$extension])) {
                $newDefault = $mergedTypes->createElement('Default');
                $newDefault->setAttribute('Extension', $extension);
                $newDefault->setAttribute('ContentType', $contentType);
                $mergedTypesRoot->appendChild($newDefault);
                $existingTypes[$extension] = $contentType;
            }
        }

        // Add new override types from answer document
        foreach ($answerTypes->getElementsByTagName('Override') as $override) {
            $partName = $override->getAttribute('PartName');
            $contentType = $override->getAttribute('ContentType');

            // Update part name if it references renamed files
            $updatedPartName = $this->updatePartNameForRenamedFiles($partName, $answerDir, $mergedDir, $fileRenameMap);

            if (!in_array($updatedPartName, $existingOverrides)) {
                $newOverride = $mergedTypes->createElement('Override');
                $newOverride->setAttribute('PartName', $updatedPartName);
                $newOverride->setAttribute('ContentType', $contentType);
                $mergedTypesRoot->appendChild($newOverride);
                $existingOverrides[] = $updatedPartName;
            }
        }

        file_put_contents($mergedTypesPath, $mergedTypes->saveXML());
    }

    /**
     * Update part names in content types for renamed files
     */
    private function updatePartNameForRenamedFiles($partName, $answerDir, $mergedDir, $fileRenameMap = [])
    {
        // Extract the file name from the part name
        $fileName = basename($partName);

        // Check if this file was renamed using our rename map
        if (isset($fileRenameMap[$fileName])) {
            $newFileName = $fileRenameMap[$fileName];
            return dirname($partName) . '/' . $newFileName;
        }

        // Handle media files
        if (strpos($partName, '/word/media/') !== false) {
            $mediaDir = $mergedDir . '/word/media';

            if (is_dir($mediaDir) && !file_exists($mediaDir . '/' . $fileName)) {
                // Look for renamed version
                $files = scandir($mediaDir);
                foreach ($files as $file) {
                    if (strpos($file, pathinfo($fileName, PATHINFO_FILENAME) . '_ans_') === 0) {
                        return '/word/media/' . $file;
                    }
                }
            }
        }

        // Handle embeddings
        if (strpos($partName, '/word/embeddings/') !== false) {
            $embeddingsDir = $mergedDir . '/word/embeddings';

            if (is_dir($embeddingsDir) && !file_exists($embeddingsDir . '/' . $fileName)) {
                $files = scandir($embeddingsDir);
                foreach ($files as $file) {
                    if (strpos($file, pathinfo($fileName, PATHINFO_FILENAME) . '_ans_') === 0) {
                        return '/word/embeddings/' . $file;
                    }
                }
            }
        }

        // Handle object files
        if (strpos($partName, '/word/object') !== false || strpos($partName, '/word/oleObject') !== false) {
            $wordDir = $mergedDir . '/word';

            if (!file_exists($wordDir . '/' . $fileName)) {
                $files = scandir($wordDir);
                foreach ($files as $file) {
                    if (strpos($file, pathinfo($fileName, PATHINFO_FILENAME) . '_ans_') === 0) {
                        return '/word/' . $file;
                    }
                }
            }
        }

        return $partName;
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
}
