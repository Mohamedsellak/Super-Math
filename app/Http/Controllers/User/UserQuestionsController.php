<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\CreditHistory;
use App\Models\Question;
use App\Models\Subject;
use App\Models\Topic;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class UserQuestionsController extends Controller
{
    public function index()
    {
        // Get questions - relationships are already defined in models
        $questions = Question::all();
        $subjects = Subject::all();
        
        return view('user.questions.index', [
            'questions' => $questions,
            'subjects' => $subjects
        ]);
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
     * Download the question and answer documents as a ZIP file
     */
    public function downloadSingleDocument(Question $question)
    {
        // Check if question document exists
        if (!$question->doc || !Storage::disk('local')->exists($question->doc)) {
            abort(404, 'Question document not found.');
        }

        if (!$question->answer_doc || !Storage::disk('local')->exists($question->answer_doc)) {
            abort(404, 'Answer document not found.');
        }

        try {
            $questionDocPath = Storage::disk('local')->path($question->doc);
            $answerDocPath = Storage::disk('local')->path($question->answer_doc);

            // Create temporary ZIP file
            $zipFileName = 'question_' . $question->id . '_documents_' . time() . '.zip';
            $tempZipPath = storage_path('app/temp/' . $zipFileName);

            // Ensure temp directory exists
            if (!file_exists(storage_path('app/temp'))) {
                mkdir(storage_path('app/temp'), 0755, true);
            }

            // Create ZIP archive
            $zip = new \ZipArchive();
            if ($zip->open($tempZipPath, \ZipArchive::CREATE) !== TRUE) {
                throw new \Exception('Cannot create ZIP file');
            }

            // Add question document to ZIP
            $questionFileName = 'Question.docx';
            $zip->addFile($questionDocPath, $questionFileName);

            // Add answer document to ZIP
            $answerFileName = 'Answer.docx';
            $zip->addFile($answerDocPath, $answerFileName);

            // Close ZIP file
            $zip->close();

            $downloadFileName = 'question_' . $question->id . '_documents.zip';

            // Decrement user's credit
            $user = Auth::user();
            $user->credit = $user->credit - 1;
            $user->save();

            // Add credit history
            CreditHistory::create([
                'user_id' => $user->id,
                'action' => 'Download',
                'amount' => '- 1',
                'description' => 'Download question document (ID: ' . $question->id . ')',
            ]);

            // Return download response and delete temp file after download
            return response()->download($tempZipPath, $downloadFileName)->deleteFileAfterSend(true);

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error creating ZIP file: ' . $e->getMessage());
        }
    }

    /**
     * Download multiple documents with simple Q/R file naming structure
     */
    public function downloadMultipleDocuments(array $questionIds)
    {
        $questions = Question::whereIn('id', $questionIds)->get();
        if ($questions->isEmpty()) {
            return redirect()->back()->with('error', 'No valid questions found for download.');
        }

        try {
            // Create temporary ZIP file for all questions
            $masterZipFileName = 'questions_package_' . count($questions) . '_items_' . time() . '.zip';
            $tempMasterZipPath = storage_path('app/temp/' . $masterZipFileName);

            // Ensure temp directory exists
            if (!file_exists(storage_path('app/temp'))) {
                mkdir(storage_path('app/temp'), 0755, true);
            }

            // Create master ZIP archive
            $masterZip = new \ZipArchive();
            if ($masterZip->open($tempMasterZipPath, \ZipArchive::CREATE) !== TRUE) {
                throw new \Exception('Cannot create master ZIP file');
            }

            // Add each question with simple Q/R naming structure
            $questionNumber = 1;
            foreach ($questions as $question) {
                if ($question->doc && Storage::disk('local')->exists($question->doc) &&
                    $question->answer_doc && Storage::disk('local')->exists($question->answer_doc)) {
                    
                    $questionDocPath = Storage::disk('local')->path($question->doc);
                    $answerDocPath = Storage::disk('local')->path($question->answer_doc);

                    // Add question document with Q naming
                    $questionFileName = 'Q' . $questionNumber . '.doc';
                    $masterZip->addFile($questionDocPath, $questionFileName);

                    // Add answer document with R naming
                    $answerFileName = 'R' . $questionNumber . '.doc';
                    $masterZip->addFile($answerDocPath, $answerFileName);

                    $questionNumber++;
                }
            }

            // Close master ZIP file
            $masterZip->close();

            $downloadFileName = 'questions_package_' . count($questions) . '_items.zip';

            // Decrement user's credit
            $user = Auth::user();
            $user->credit = $user->credit - count($questionIds);
            $user->save();

            // Add credit history
            CreditHistory::create([
                'user_id' => $user->id,
                'action' => 'Download',
                'amount' => '- ' . count($questionIds),
                'description' => 'Downloaded multiple question package (' . count($questionIds) . ' questions): ' . implode(', ', $questionIds),
            ]);

            // Return download response and delete temp file after download
            return response()->download($tempMasterZipPath, $downloadFileName)->deleteFileAfterSend(true);

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error creating ZIP package: ' . $e->getMessage());
        }
    }

    /**
     * Get topics by subject ID for AJAX requests
     */
    public function getTopics($subjectId)
    {
        $topics = Topic::where('subject_id', $subjectId)->select('id', 'name')->get();
        return response()->json($topics);
    }
}
