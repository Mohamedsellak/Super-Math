<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProfileController extends Controller
{


    // show the profile page
    public function index()
    {
        return view('profile.index', [
            'user' => auth()->user()
        ]);
    }

    //
    /**
     * Show the email edit form.
     */
    public function editEmail()
    {
        return view('profile.edit-email', [
            'user' => auth()->user()
        ]);
    }

    // edit password
    public function editPassword()
    {
        return view('profile.edit-password', [
            'user' => auth()->user()
        ]);
    }


    // edit profile name and other details
    public function editProfile()
    {
        return view('profile.edit-info', [
            'user' => auth()->user()
        ]);
    }
}
