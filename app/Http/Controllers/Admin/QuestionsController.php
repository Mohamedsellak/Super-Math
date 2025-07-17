<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Question;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\Element\AbstractElement;
use PhpOffice\PhpWord\Element\Section;

class QuestionsController extends Controller
{
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
     * Download the merged document file using ZIP-based approach to preserve OLE objects
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

            // Generate temporary file for download
            $tempPath = storage_path('app/temp/merged_question_' . $question->id . '_' . time() . '.docx');

            // Ensure temp directory exists
            if (!file_exists(dirname($tempPath))) {
                mkdir(dirname($tempPath), 0755, true);
            }

            // Use ZIP-based merging to preserve OLE objects
            $this->mergeDocumentsUsingZip($questionDocPath, $answerDocPath, $tempPath);

            $fileName = 'question_' . $question->id . '_complete_document.docx';

            // Return download response and delete temp file after download
            return response()->download($tempPath, $fileName)->deleteFileAfterSend(true);

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
    }

    /**
     * Merge document XML content
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

        // Add page break
        $pageBreakElement = $questionDoc->createElementNS(
            'http://schemas.openxmlformats.org/wordprocessingml/2006/main',
            'w:p'
        );
        $pageBreakRun = $questionDoc->createElementNS(
            'http://schemas.openxmlformats.org/wordprocessingml/2006/main',
            'w:r'
        );
        $pageBreakBr = $questionDoc->createElementNS(
            'http://schemas.openxmlformats.org/wordprocessingml/2006/main',
            'w:br'
        );
        $pageBreakBr->setAttribute('w:type', 'page');
        $pageBreakRun->appendChild($pageBreakBr);
        $pageBreakElement->appendChild($pageBreakRun);
        $questionBody->appendChild($pageBreakElement);

        // Add answer section title
        $titleElement = $questionDoc->createElementNS(
            'http://schemas.openxmlformats.org/wordprocessingml/2006/main',
            'w:p'
        );
        $titleRun = $questionDoc->createElementNS(
            'http://schemas.openxmlformats.org/wordprocessingml/2006/main',
            'w:r'
        );
        $titleRunProps = $questionDoc->createElementNS(
            'http://schemas.openxmlformats.org/wordprocessingml/2006/main',
            'w:rPr'
        );
        $titleBold = $questionDoc->createElementNS(
            'http://schemas.openxmlformats.org/wordprocessingml/2006/main',
            'w:b'
        );
        $titleSize = $questionDoc->createElementNS(
            'http://schemas.openxmlformats.org/wordprocessingml/2006/main',
            'w:sz'
        );
        $titleSize->setAttribute('w:val', '32');
        $titleRunProps->appendChild($titleBold);
        $titleRunProps->appendChild($titleSize);
        $titleRun->appendChild($titleRunProps);

        $titleText = $questionDoc->createElementNS(
            'http://schemas.openxmlformats.org/wordprocessingml/2006/main',
            'w:t',
            'ANSWER SECTION'
        );
        $titleRun->appendChild($titleText);
        $titleElement->appendChild($titleRun);
        $questionBody->appendChild($titleElement);

        // Get all content from answer document body
        $answerBody = $answerDoc->getElementsByTagName('body')->item(0);
        $answerElements = $answerBody->childNodes;

        // Import and append answer content
        foreach ($answerElements as $element) {
            if ($element->nodeType === XML_ELEMENT_NODE) {
                $importedElement = $questionDoc->importNode($element, true);
                $questionBody->appendChild($importedElement);
            }
        }

        return $questionDoc->saveXML();
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

        // Also copy embeddings directory if it exists (for OLE objects)
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
}
