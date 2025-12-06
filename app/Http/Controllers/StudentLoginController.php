<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class StudentLoginController extends Controller
{
    public function showLoginForm(): View
    {
        return view('student.login');
    }
    public function login(Request $request): RedirectResponse
    {
        $validatedData = $request->validate([
            'admissionNumber' => 'required|string', 
            'password' => 'required',
        ]);
        $credentials = [
            'admission_number' => $validatedData['admissionNumber'],
            'password' => $validatedData['password'],
        ];
        if (Auth::guard('student')->attempt($credentials)) { 
            $request->session()->regenerate();

            return redirect()->intended('/student/dashboard'); 
        }
        return back()->withErrors([
            'admissionNumber' => 'Login details are incorrect.',
        ])->onlyInput('admissionNumber');
    }
    public function logout(Request $request): RedirectResponse
    {

        Auth::guard('student')->logout(); 

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/student/login');
    }
}
