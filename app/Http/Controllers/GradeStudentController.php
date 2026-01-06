<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\Mathematics;
use App\Models\EnglishLanguage;
use App\Models\Literature;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GradeStudentController extends Controller
{
    // Show form with students (if class selected)
    public function index(Request $request)
    {
        $students = collect(); // empty collection by default
        $selectedClass = null;

        if ($request->filled('class')) {
            $selectedClass = $request->input('class'); // e.g. "Grade 1"

            // Fetch students for the selected class
            $students = Student::where('student_class', $selectedClass)->get();
        }

        return view('teacher.gradestudents', compact('students', 'selectedClass'));
    }

    // Store marks
    public function storemarks(Request $request)
{
    DB::beginTransaction();

    try {

        // ---------- MATH ----------
        if ($request->has('math')) {
            foreach ($request->math as $studentId => $marks) {

                Mathematics::updateOrCreate(
                    ['student_id' => $studentId],
                    [
                        'quiz' => $marks['quiz'] ?? 0,
                        'assignment' => $marks['assignment'] ?? 0,
                        'mid_exam' => $marks['mid_exam'] ?? 0,
                        'final_exam' => $marks['final_exam'] ?? 0,
                        'marks_obtained' =>
                            ($marks['quiz'] ?? 0) +
                            ($marks['assignment'] ?? 0) +
                            ($marks['mid_exam'] ?? 0) +
                            ($marks['final_exam'] ?? 0),
                        'grade_obtained' => null,
                    ]
                );
            }
        }

        // ---------- ENGLISH ----------
        if ($request->has('english')) {
            foreach ($request->english as $studentId => $marks) {

                EnglishLanguage::updateOrCreate(
                    ['student_id' => $studentId],
                    [
                        'quiz' => $marks['quiz'] ?? 0,
                        'assignment' => $marks['assignment'] ?? 0,
                        'mid_exam' => $marks['mid_exam'] ?? 0,
                        'final_exam' => $marks['final_exam'] ?? 0,
                        'marks_obtained' =>
                            ($marks['quiz'] ?? 0) +
                            ($marks['assignment'] ?? 0) +
                            ($marks['mid_exam'] ?? 0) +
                            ($marks['final_exam'] ?? 0),
                        'grade_obtained' => null,
                    ]
                );
            }
        }

        // ---------- LITERATURE ----------
        if ($request->has('literature')) {
            foreach ($request->literature as $studentId => $marks) {

                Literature::updateOrCreate(
                    ['student_id' => $studentId],
                    [
                        'quiz' => $marks['quiz'] ?? 0,
                        'assignment' => $marks['assignment'] ?? 0,
                        'mid_exam' => $marks['mid_exam'] ?? 0,
                        'final_exam' => $marks['final_exam'] ?? 0,
                        'marks_obtained' =>
                            ($marks['quiz'] ?? 0) +
                            ($marks['assignment'] ?? 0) +
                            ($marks['mid_exam'] ?? 0) +
                            ($marks['final_exam'] ?? 0),
                        'grade_obtained' => null,
                    ]
                );
            }
        }

        DB::commit();
        return back()->with('success', 'Marks saved successfully.');

    } catch (\Throwable $e) {
        DB::rollBack();
        return back()->with('error', $e->getMessage());
    }
}

}
