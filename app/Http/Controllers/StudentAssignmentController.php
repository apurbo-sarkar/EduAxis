<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Assignment;
use Illuminate\Support\Facades\Auth;

class StudentAssignmentController extends Controller
{
    // Show all assignments for the logged-in student
    public function index()
    {
        // 1️⃣ Get the logged-in student
        $student = Auth::user(); // or Auth::guard('student')->user() if using a custom guard

        // 2️⃣ Extract numeric class (e.g., "Class 5" → 5)
        $studentClassNumber = (int) filter_var(
            $student->student_class,
            FILTER_SANITIZE_NUMBER_INT
        );

        // 3️⃣ Get assignments for this class
        $assignments = Assignment::where('class', $studentClassNumber)
            ->orderBy('due_date', 'asc')
            ->get();

        // 4️⃣ Pass to the student assignment view
        return view('student.assignment', compact('assignments'));
    }
}
