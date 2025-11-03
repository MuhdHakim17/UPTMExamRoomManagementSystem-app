<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LecturerLoginController extends Controller
{
    // Show login form
    public function showLogin()
    {
        return view('Lecturer-Login');
    }

    // Handle login form submission
    public function login(Request $request)
    {
       $request->validate([
            'lecturer_id' => 'required|string',
            'password' => 'required|string',
        ]);


// 🔎 Find lecturer by ID
        $lecturer = DB::table('lecturers')->where('lecturer_id', $request->lecturer_id)->first();

        
        if (!$lecturer) {
            return back()->with('error', 'Invalid Lecturer ID.');
        }

        // 🔒 If you store password in plain text:
        if ($request->password !== $lecturer->password) {
            return back()->with('error', 'Incorrect password.');
        }
        session(['lecturer_id' => $lecturer->lecturer_id]);
        return redirect()->route('lecturer.homepage');
    }

    // Logout function
    public function logout()
    {
        session()->flush();
        return redirect('/lecturer/login')->with('success', 'You have logged out.');
    }
    
}
