<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class StudentManagementController extends Controller
{
    /**
     * Display a listing of students
     */
    public function index(Request $request)
    {
        $query = Student::query();

        // Search functionality
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('full_name', 'LIKE', "%{$search}%")
                  ->orWhere('admission_number', 'LIKE', "%{$search}%")
                  ->orWhere('student_email', 'LIKE', "%{$search}%")
                  ->orWhere('student_class', 'LIKE', "%{$search}%");
            });
        }

        // Filter by class
        if ($request->has('class') && $request->class != '') {
            $query->where('student_class', $request->class);
        }

        // Filter by gender
        if ($request->has('gender') && $request->gender != '') {
            $query->where('gender', $request->gender);
        }

        // Order by latest
        $students = $query->orderBy('created_at', 'desc')->paginate(15);
        
        // Get unique classes for filter dropdown
        $classes = Student::select('student_class')
                         ->distinct()
                         ->orderBy('student_class')
                         ->pluck('student_class');

        return view('admin.students.index', compact('students', 'classes'));
    }

    /**
     * Show the form for creating a new student
     */
    public function create()
    {
        return view('admin.students.create');
    }

    /**
     * Store a newly created student in database
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'full_name' => 'required|string|max:255',
            'admission_number' => 'required|string|max:50|unique:students,admission_number',
            'date_of_birth' => 'required|date|before:today',
            'gender' => 'required|in:Male,Female,Other',
            'student_class' => 'required|string|max:50',
            'blood_group' => 'nullable|string|max:10',
            'student_email' => 'required|email|max:255|unique:students,student_email',
            'password' => 'required|string|min:8|confirmed',
            'parent1_name' => 'required|string|max:255',
            'parent1_phone' => 'required|string|max:20',
            'parent1_email' => 'nullable|email|max:255',
            'parent2_name' => 'nullable|string|max:255',
            'parent2_phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
            'emergency_contact_name' => 'nullable|string|max:255',
            'emergency_contact_phone' => 'nullable|string|max:20',
            'medical_notes' => 'nullable|string|max:1000',
            'academic_status' => 'nullable|in:Active,Inactive,Suspended,Graduated',
            'status_remarks' => 'nullable|string|max:500',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                           ->withErrors($validator)
                           ->withInput();
        }

        $studentData = $request->except(['password', 'password_confirmation']);
        $studentData['password'] = Hash::make($request->password);
        $studentData['terms_agreed'] = true;

        Student::create($studentData);

        return redirect()->route('admin.students.index')
                       ->with('success', 'Student created successfully!');
    }

    /**
     * Show the form for editing the specified student
     */
    public function edit($id)
    {
        $student = Student::findOrFail($id);
        return view('admin.students.edit', compact('student'));
    }

    /**
     * Update the specified student in database
     */
    public function update(Request $request, $id)
    {
        $student = Student::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'full_name' => 'required|string|max:255',
            'admission_number' => [
                'required',
                'string',
                'max:50',
                Rule::unique('students', 'admission_number')->ignore($student->student_id, 'student_id')
            ],
            'date_of_birth' => 'required|date|before:today',
            'gender' => 'required|in:Male,Female,Other',
            'student_class' => 'required|string|max:50',
            'blood_group' => 'nullable|string|max:10',
            'student_email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('students', 'student_email')->ignore($student->student_id, 'student_id')
            ],
            'password' => 'nullable|string|min:8|confirmed',
            'parent1_name' => 'required|string|max:255',
            'parent1_phone' => 'required|string|max:20',
            'parent1_email' => 'nullable|email|max:255',
            'parent2_name' => 'nullable|string|max:255',
            'parent2_phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
            'emergency_contact_name' => 'nullable|string|max:255',
            'emergency_contact_phone' => 'nullable|string|max:20',
            'medical_notes' => 'nullable|string|max:1000',
            'academic_status' => 'nullable|in:Active,Inactive,Suspended,Graduated',
            'status_remarks' => 'nullable|string|max:500',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                           ->withErrors($validator)
                           ->withInput();
        }

        $studentData = $request->except(['password', 'password_confirmation']);
        
        // Only update password if provided
        if ($request->filled('password')) {
            $studentData['password'] = Hash::make($request->password);
        }

        $student->update($studentData);

        return redirect()->route('admin.students.index')
                       ->with('success', 'Student updated successfully!');
    }

    /**
     * Remove the specified student from database
     */
    public function destroy($id)
    {
        $student = Student::findOrFail($id);
        $student->delete();

        return redirect()->route('admin.students.index')
                       ->with('success', 'Student deleted successfully!');
    }

    /**
     * Show detailed view of a student
     */
    public function show($id)
    {
        $student = Student::findOrFail($id);
        return view('admin.students.show', compact('student'));
    }
}