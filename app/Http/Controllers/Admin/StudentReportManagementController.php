<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\Mathematics;
use App\Models\EnglishLanguage;
use App\Models\Literature;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StudentReportManagementController extends Controller
{
    /**
     * Display list of all students with their results
     */
    public function index()
    {
        if (!Auth::guard('admin')->check()) {
            return redirect()->route('admin.login');
        }

        $students = Student::all();
        
        $studentsData = [];
        foreach ($students as $student) {
            $math = Mathematics::where('student_id', $student->student_id)->first();
            $english = EnglishLanguage::where('student_id', $student->student_id)->first();
            $literature = Literature::where('student_id', $student->student_id)->first();

            $subjects = [
                'Mathematics' => $math,
                'English Language' => $english,
                'Literature' => $literature
            ];

            $totalMarks = 0;
            $subjectCount = 0;

            foreach ($subjects as $subject) {
                if ($subject) {
                    $totalMarks += $subject->marks_obtained;
                    $subjectCount++;
                }
            }

            $overallAverage = $subjectCount ? round($totalMarks / $subjectCount, 2) : 0;
            $overallGrade = $this->calculateGrade($overallAverage);

            $studentsData[] = [
                'student' => $student,
                'overallAverage' => $overallAverage,
                'overallGrade' => $overallGrade,
                'subjects' => $subjects,
            ];
        }

        return view('admin.student-reports.index', [
            'studentsData' => $studentsData
        ]);
    }

    /**
     * Show form to edit student status
     */
    public function edit($id)
    {
        if (!Auth::guard('admin')->check()) {
            return redirect()->route('admin.login');
        }

        $student = Student::findOrFail($id);
        
        $math = Mathematics::where('student_id', $student->student_id)->first();
        $english = EnglishLanguage::where('student_id', $student->student_id)->first();
        $literature = Literature::where('student_id', $student->student_id)->first();

        $subjects = [
            'Mathematics' => $math,
            'English Language' => $english,
            'Literature' => $literature
        ];

        $totalMarks = 0;
        $subjectCount = 0;

        foreach ($subjects as $subject) {
            if ($subject) {
                $totalMarks += $subject->marks_obtained;
                $subjectCount++;
            }
        }

        $overallAverage = $subjectCount ? round($totalMarks / $subjectCount, 2) : 0;
        $overallGrade = $this->calculateGrade($overallAverage);

        return view('admin.student-reports.edit', [
            'student' => $student,
            'subjects' => $subjects,
            'overallAverage' => $overallAverage,
            'overallGrade' => $overallGrade,
        ]);
    }

    /**
     * Update student status
     */
    public function update(Request $request, $id)
    {
        if (!Auth::guard('admin')->check()) {
            return redirect()->route('admin.login');
        }

        $request->validate([
            'academic_status' => 'required|string|in:Excellent,Good,Satisfactory,Needs Improvement,Poor',
            'status_remarks' => 'nullable|string|max:1000',
        ]);

        $student = Student::findOrFail($id);
        $student->academic_status = $request->academic_status;
        $student->status_remarks = $request->status_remarks;
        $student->save();

        return redirect()->route('admin.student-reports.index')
            ->with('success', 'Student status updated successfully!');
    }

    /**
     * Calculate grade based on marks
     */
    private function calculateGrade($marks)
    {
        if ($marks >= 90) return 'A';
        if ($marks >= 80) return 'B';
        if ($marks >= 70) return 'C';
        if ($marks >= 60) return 'D';
        return 'F';
    }
}