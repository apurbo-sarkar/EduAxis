<?php

namespace App\Http\Controllers;

use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class TeacherloginController extends Controller
{
    // Show welcome page with login/register options
    public function welcome()
    {
        return view('teacher.welcome');
    }

    // Show login form
    public function showLogin()
    {
        return view('teacher.login');
    }

    // Handle login
    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        $teacher = Teacher::where('username', $request->username)->first();

        if ($teacher && Hash::check($request->password, $teacher->password)) {
            Session::put('teacher_id', $teacher->id);
            Session::put('teacher_name', $teacher->first_name . ' ' . $teacher->last_name);

            return redirect('/teacher/dashboard')->with('success', 'Login successful!');
        }

        return back()->with('error', 'Invalid username or password');
    }

    // Show dashboard
    public function dashboard()
    {
        if (!Session::has('teacher_id')) {
            return redirect('/teacher/login')->with('error', 'Please login first');
        }

        $teacherId = Session::get('teacher_id');
        $teacher = Teacher::find($teacherId);

        return view('teacher.dashboard', compact('teacher'));
    }

    // Handle logout
    public function logout()
    {
        Session::flush();
        return redirect('/teacher/login')->with('success', 'Logged out successfully');
    }
}