<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
class AdminLoginController extends Controller
{
    public function showLogin()
    {
        return view('Admin-Login');
    }

    public function login(Request $request)
    {
         $request->validate([
        'admin_id' => 'required|string',
        'password' => 'required|string',
    ]);

    // Fetch admin record
    $admin = DB::table('admins')->where('admin_id', $request->admin_id)->first();

    // 🧩 If admin not found
    if (!$admin) {
        return back()->with('error', 'Invalid Admin ID.');
    }

    // 🧩 If password does not match
    if ($request->password !== $admin->password) {
        return back()->with('error', 'Incorrect password.');
    }

    // ✅ Login successful
    session(['admin_id' => $admin->admin_id]);
    return redirect()->route('admin.homepage');
    
    }

    public function logout()
    {
        session()->flush();
        return redirect('/admin/login')->with('success', 'Logged out successfully.');
    }
}
