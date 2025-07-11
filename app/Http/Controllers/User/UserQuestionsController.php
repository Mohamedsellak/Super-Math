<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Question;
use Illuminate\Http\Request;

class UserQuestionsController extends Controller
{
    public function index()
    {
        // This method will handle the logic for displaying a list of questions.
        // You can retrieve questions from the database and return a view.
        return view('user.questions.index', ['questions' => Question::all()]);
    }
}
