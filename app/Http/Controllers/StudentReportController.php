<?php

namespace App\Http\Controllers;
use App\Models\Student;
use App\Models\Mathematics;
use App\Models\EnglishLanguage;
use App\Models\Literature;
use Illuminate\Http\Request;

class StudentReportController extends Controller
{
    public function show()
    {
        $studentId = auth()->id();
        $math = Mathematics::where('student_id', $studentId)->first();
        $english = EnglishLanguage::where('student_id', $studentId)->first();
        $literature = Literature::where('student_id', $studentId)->first();
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

        return view('student.result', [
            'studentId' => $studentId,
            'subjects' => $subjects,
            'overallAverage' => $overallAverage,
            'overallGrade' => $overallGrade,
        ]);
    }
    private function calculateGrade($marks)
    {
        if ($marks >= 90) return 'A';
        if ($marks >= 80) return 'B';
        if ($marks >= 70) return 'C';
        if ($marks >= 60) return 'D';
        return 'F';
    }
}
