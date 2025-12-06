<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;

class StudentRegistrationController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        $validatedData = $request->validate([
            'fullName' => 'required|string|max:255',
            'admissionNumber' => 'required|string|max:255|unique:students,admission_number', 
            'dob' => 'required|date',
            'gender' => 'required|string|in:Male,Female,Other',
            'studentClass' => 'required|string|max:255',
            'bloodGroup' => 'nullable|string|max:5',
            'email' => 'nullable|email|max:255',
            'password' => 'required|string|min:8|confirmed',
            'parent1Name' => 'required|string|max:255',
            'parent1Phone' => 'required|string|max:20',
            'parent1Email' => 'required|email|max:255',
            'parent2Name' => 'nullable|string|max:255',
            'parent2Phone' => 'nullable|string|max:20',
            'address' => 'required|string',
            'emergencyName' => 'required|string|max:255',
            'emergencyPhone' => 'required|string|max:20',
            'medicalNotes' => 'nullable|string',
            'terms' => 'required|accepted',
        ]);

        try {
            $studentClass = $validatedData['studentClass'];
            if (is_numeric($studentClass)) {
                $studentClass = 'Grade ' . $studentClass;
            }
            Student::create([
                'full_name' => $validatedData['fullName'],
                'admission_number' => $validatedData['admissionNumber'],
                'date_of_birth' => $validatedData['dob'],
                'gender' => $validatedData['gender'],
                'student_class' => $studentClass,
                'blood_group' => $validatedData['bloodGroup'],
                'student_email' => $validatedData['email'],
                'password' => Hash::make($validatedData['password']),
                'parent1_name' => $validatedData['parent1Name'],
                'parent1_phone' => $validatedData['parent1Phone'],
                'parent1_email' => $validatedData['parent1Email'],
                'parent2_name' => $validatedData['parent2Name'] ?? null,
                'parent2_phone' => $validatedData['parent2Phone'] ?? null,
                'address' => $validatedData['address'],
                'emergency_contact_name' => $validatedData['emergencyName'],
                'emergency_contact_phone' => $validatedData['emergencyPhone'],
                'medical_notes' => $validatedData['medicalNotes'] ?? null,
                'terms_agreed' => true,
            ]);

            return redirect()->route('student.login')->with('success', 'Registration successful! You can now log in.');

        } catch (\Exception $e) {
            return back()->withInput()->withErrors(['error' => 'Registration failed: ' . $e->getMessage()]);
        }
    }
}
