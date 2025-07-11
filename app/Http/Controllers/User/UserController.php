<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
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
