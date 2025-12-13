<?php

namespace App\Http\Controllers;

use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class TeacherController extends Controller
{
    /**
     * Handle teacher registration (POST)
     */
    public function register(Request $request)
    {
        // Validate the incoming request
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'dob' => 'required|date',
            'gender' => 'required|in:Male,Female,Other',
            'phone' => 'required|string|max:20',
            'email' => 'required|email|unique:teachers,email',
            'username' => 'required|string|unique:teachers,username|max:255',
            'password' => 'required|string|min:8|confirmed',
            'present_address' => 'required|string',
            'permanent_address' => 'required|string',
            'national_id' => 'nullable|string|max:50',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Handle photo upload
        $photoPath = null;
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('teacher_photos', 'public');
        }

        // Create teacher record
        Teacher::create([
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'],
            'dob' => $validated['dob'],
            'gender' => $validated['gender'],
            'phone' => $validated['phone'],
            'email' => $validated['email'],
            'username' => $validated['username'],
            'password' => Hash::make($validated['password']),
            'present_address' => $validated['present_address'],
            'permanent_address' => $validated['permanent_address'],
            'national_id' => $validated['national_id'],
            'photo' => $photoPath,
        ]);

        // Redirect to login page with success message
        return redirect()->route('teacher.login.form')
            ->with('success', 'Registration successful! Please login to continue.');
        }
        //handle update
        public function update(Request $request, $id)
        {
        // Validate the incoming data
        $request->validate([
            'first_name'        => 'required|string|max:255',
            'last_name'         => 'required|string|max:255',
            'email'             => 'required|email|unique:teachers,email,' . $id,
            'phone'             => 'nullable|string|max:20',
            'dob'               => 'nullable|date',
            'gender'            => 'nullable|string|in:Male,Female,Other',
            'national_id'       => 'nullable|string|max:50',
            'present_address'   => 'nullable|string|max:500',
            'permanent_address' => 'nullable|string|max:500',
        ]);

        // Find the teacher by ID
        $teacher = Teacher::findOrFail($id);

        // Update the teacher data
        $teacher->update($request->all());

        // Redirect back to dashboard with success message
        return redirect()->route('teacher.dashboard')
                         ->with('success', 'Profile updated successfully!');
       }

}