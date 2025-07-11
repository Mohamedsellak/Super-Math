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

    // update email
    public function updateEmail(Request $request)
    {
        $request->validate([
            'email' => 'required|email|max:255|unique:users',
            'current_password' => 'required',
        ]);

        $user = auth()->user();
        if (!password_verify($request->current_password, $user->password)) {
            return redirect()->back()->withInput()->withErrors(['current_password' => 'The provided password is incorrect.']);
        }

        $user->email = $request->email;
        $user->save();

        return redirect()->route('profile.index')->with('success', 'Email updated successfully.');
    }

    // edit password
    public function editPassword()
    {
        return view('profile.edit-password', [
            'user' => auth()->user()
        ]);
    }

    // update password
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => [
                'required',
                'string',
                'min:6',
                'confirmed',          // Must match password_confirmation
            ],
        ]);

        $user = auth()->user();

        if (!password_verify($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'The current password is incorrect.']);
        }

        $user->password = bcrypt($request->password);
        $user->save();

        return redirect()->route('profile.index')->with('success', 'Password updated successfully.');
    }


    // edit profile name and other details
    public function editInfo()
    {
        return view('profile.edit-info', [
            'user' => auth()->user()
        ]);
    }

    public function updateInfo(Request $request){
        $request->validate([
            "first_name"=>"required|string|max:255",
            "last_name"=>"required|string|max:255",
            "phone"=>"required|string|max:15",
            "institution"=>"nullable|string|max:15",


        ]);

        $user = auth()->user();
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->phone = $request->phone;
        $user->institution = $request->institution;
        $user->save();
        return redirect()->route('profile.index')->with('success', 'Profile updated successfully.');
    }
}
