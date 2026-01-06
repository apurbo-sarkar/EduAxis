<?php
namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Student;
use Carbon\Carbon;
use Illuminate\Http\Request;

class TeacherAttendanceController extends Controller
{
    /**
     * Show class selector and students
     */
    public function index(Request $request)
    {
        $students = null;

        if ($request->filled('class')) {
            $students = Student::where('student_class', 'Grade ' . $request->class)
                               ->orderBy('admission_number')
                               ->get();
        }

        return view('teacher.attendance', compact('students'));
    }

    /**
     * Store or update attendance
     */
    public function store(Request $request)
    {
        // Validate the incoming request
        $request->validate([
            'class' => 'required|integer|min:1|max:10',
            'attendance' => 'required|array',
            'attendance.*' => 'in:P,A,L,E',
        ]);

        // Get the current month and year
        $currentMonth = Carbon::now()->format('F'); // e.g., "January"
        $currentYear = Carbon::now()->year; // e.g., 2026

        // Loop through the attendance data for each student
        foreach ($request->attendance as $studentId => $status) {
            // Find or create the attendance record for the student in the current year
            $attendance = Attendance::firstOrCreate(
                [
                    'student_id' => $studentId,
                    'current_year' => $currentYear,
                ]
            );

            // Update the current month's column with the status (P, A, L, E)
            $attendance->update([$currentMonth => $status]);
        }

        // Redirect with success message
        return redirect()
            ->route('teacher.attendance', ['class' => $request->class])
            ->with('success', 'Attendance saved successfully.');
    }
}
