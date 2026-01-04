<?php

namespace App\Http\Controllers;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StudentProfileController extends Controller
{
    public function edit()
    {
        $student = Auth::user();

        return view('student.profile', compact('student'));
    }

    public function update(Request $request)
    {
        $student = Auth::user();

        $validated = $request->validate([
            'full_name'        => 'required|string|max:255',
            'student_email'    => 'required|email|max:255',
            'parent1_phone'    => 'nullable|string|max:20',
            'address'          => 'nullable|string|max:500',
        ]);

        $student->update($validated);

        return redirect()
            ->route('student.profile.edit')
            ->with('success', 'Profile updated successfully.');
    }
}

