<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Question;
use Illuminate\Http\Request;
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

        if (auth()->user()->credit < count($selectedQuestions)) {
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
     * Download the document file securely
     */
    public function downloadSingleDocument(Question $question)
    {
        if (!$question->doc || !Storage::disk('local')->exists($question->doc)) {
            abort(404, 'Document not found.');
        }

        $filePath = Storage::disk('local')->path($question->doc);
        $fileName = 'question_' . $question->id . '_document.' . pathinfo($question->doc, PATHINFO_EXTENSION);

        // Decrement user's credit
        auth()->user()->decrement('credit');

        // add credit history
        // CreditHistory::create([
        //     'user_id' => auth()->id(),
        //     'action' => 'download',
        //     'amount' => '- 1',
        //     'description' => 'Downloaded question document: ' . $question->id,
        // ]);

        return response()->download($filePath, $fileName);
    }

    /**
     * Download multiple documents as a zip file
     */
    public function downloadMultipleDocuments(array $questionIds)
    {
        // $questions = Question::whereIn('id', $questionIds)->get();
        // if ($questions->isEmpty()) {
        //     return redirect()->back()->with('error', 'No valid questions found for download.');
        // }
        // $zip = new \ZipArchive();
        // $zipFileName = 'questions_' . now()->timestamp . '.zip';
        // $zipFilePath = storage_path('app/' . $zipFileName);
        // if ($zip->open($zipFilePath, \ZipArchive::CREATE | \ZipArchive::OVERWRITE) !== true) {
        //     return redirect()->back()->with('error', 'Could not create zip file.');
        // }
        // foreach ($questions as $question) {
        //     if ($question->doc && Storage::disk('local')->exists($question->doc)) {
        //         $filePath = Storage::disk('local')->path($question->doc);
        //         $zip->addFile($filePath, 'question_' . $question->id . '_document.' . pathinfo($question->doc, PATHINFO_EXTENSION));
        //     }
        // }
        // $zip->close();

        // Decrement user's credit
        // auth()->user()->decrement('credit', count($questionIds));

        // add credit history
        // CreditHistory::create([
        //     'user_id' => auth()->id(),
        //     'action' => 'download',
        //     'amount' => '- count($questionIds)',
        //     'description' => 'Downloaded multiple question documents: ' . implode(', ', $questionIds),
        // ]);
        // return response()->download($zipFilePath)->deleteFileAfterSend(true);
    }

}
