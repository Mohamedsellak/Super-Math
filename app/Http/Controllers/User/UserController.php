<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{

    /**
     * Show the user dashboard.
     */
    public function index()
    {
        return view('user.dashboard');
    }
}
