<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Question;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class QuestionsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        return view('admin.questions.index', [
            'questions' => Question::all(),
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
        ]);

        // Handle image upload (stored in public storage)
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('questions/images', 'public');
        }

        // Handle document upload (stored in private storage for security) - Document is required
        $docPath = $request->file('doc')->store('questions/documents', 'local');

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
        
        // Ensure document is always present (either existing or newly uploaded)
        if (!$docPath) {
            return redirect()->back()->withErrors(['doc' => 'A document is required for this question.'])->withInput();
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

        // Delete the question
        $question->delete();

        return redirect()
            ->route('admin.questions.index')
            ->with('success', 'Question deleted successfully!');
    }

    /**
     * Download the document file securely
     */
    public function downloadDocument(Question $question)
    {
        if (!$question->doc || !Storage::disk('local')->exists($question->doc)) {
            abort(404, 'Document not found.');
        }

        $filePath = Storage::disk('local')->path($question->doc);
        $fileName = 'question_' . $question->id . '_document.' . pathinfo($question->doc, PATHINFO_EXTENSION);

        return response()->download($filePath, $fileName);
    }
}
