<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Attendance;
use App\Models\Student;

class AttendanceManagementController extends Controller
{
    // Show attendance page
    public function index()
    {
        $students = Student::all();
        $attendances = Attendance::with('student')->get();

        // Process attendance data for display
        foreach ($attendances as $attendance) {
            $months = [
                'January', 'February', 'March', 'April', 'May', 'June',
                'July', 'August', 'September', 'October', 'November', 'December'
            ];

            $present = 0;
            $late = 0;
            $absent = 0;
            $excused = 0;

            foreach ($months as $month) {
                $data = $attendance->$month;

                if ($data === null) {
                    continue;
                }
                
                // Count attendance status for each day in the month
                for ($i = 0; $i < strlen($data); $i++) {
                    $status = $data[$i];

                    if ($status === 'P') $present++;
                    if ($status === 'L') $late++;
                    if ($status === 'A') $absent++;
                    if ($status === 'E') $excused++;
                }
            }

            // Add computed properties
            $attendance->days_present = $present;
            $attendance->days_late = $late;
            $attendance->days_absent = $absent;
            $attendance->days_excused = $excused;
            $attendance->days_total = $present + $late + $absent + $excused;

            // Calculate attendance percentage
            $countedDays = $present + $late + $absent;
            $attendance->percentage = $countedDays > 0
                ? round(($present + $late) / $countedDays * 100, 2)
                : 0;
        }

        return view('admin.attendance', compact('students', 'attendances'));
    }

    // Store or Update attendance record
    public function store(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:students,student_id',
            'current_year' => 'required|integer',
            'month' => 'required|string',
            'value' => 'nullable|string|max:50'
        ]);

        // Find or create attendance record for student and year
        $record = Attendance::firstOrCreate(
            [
                'student_id' => $request->student_id,
                'current_year' => $request->current_year
            ]
        );

        // Update selected month with attendance value
        // Value format: "PPPALPAEE" where P=Present, L=Late, A=Absent, E=Excused
        $record->{$request->month} = $request->value;
        $record->save();

        return back()->with('success', 'Attendance updated successfully!');
    }

    // View attendance records with detailed breakdown
    public function view()
    {
        $attendances = Attendance::with('student')->get();

        // Process attendance data similar to index
        foreach ($attendances as $attendance) {
            $months = [
                'January', 'February', 'March', 'April', 'May', 'June',
                'July', 'August', 'September', 'October', 'November', 'December'
            ];

            $present = 0;
            $late = 0;
            $absent = 0;
            $excused = 0;

            foreach ($months as $month) {
                $data = $attendance->$month;

                if ($data === null) {
                    continue;
                }

                for ($i = 0; $i < strlen($data); $i++) {
                    $status = $data[$i];

                    if ($status === 'P') $present++;
                    if ($status === 'L') $late++;
                    if ($status === 'A') $absent++;
                    if ($status === 'E') $excused++;
                }
            }

            $attendance->days_present = $present;
            $attendance->days_late = $late;
            $attendance->days_absent = $absent;
            $attendance->days_excused = $excused;
            $attendance->days_total = $present + $late + $absent + $excused;

            $countedDays = $present + $late + $absent;
            $attendance->percentage = $countedDays > 0
                ? round(($present + $late) / $countedDays * 100, 2)
                : 0;
        }

        return view('admin.attendance.view', compact('attendances'));
    }

    // Attendance reports with statistics
    public function reports()
    {
        $attendances = Attendance::with('student')->get();

        // Process attendance data for reports
        $reportData = [];
        
        foreach ($attendances as $attendance) {
            $months = [
                'January', 'February', 'March', 'April', 'May', 'June',
                'July', 'August', 'September', 'October', 'November', 'December'
            ];

            $present = 0;
            $late = 0;
            $absent = 0;
            $excused = 0;

            foreach ($months as $month) {
                $data = $attendance->$month;

                if ($data === null) {
                    continue;
                }

                for ($i = 0; $i < strlen($data); $i++) {
                    $status = $data[$i];

                    if ($status === 'P') $present++;
                    if ($status === 'L') $late++;
                    if ($status === 'A') $absent++;
                    if ($status === 'E') $excused++;
                }
            }

            $total = $present + $late + $absent + $excused;
            $countedDays = $present + $late + $absent;
            $percentage = $countedDays > 0
                ? round(($present + $late) / $countedDays * 100, 2)
                : 0;

            $reportData[] = [
                'student' => $attendance->student,
                'year' => $attendance->current_year,
                'present' => $present,
                'late' => $late,
                'absent' => $absent,
                'excused' => $excused,
                'total' => $total,
                'percentage' => $percentage
            ];
        }

        return view('admin.attendance.reports', compact('reportData'));
    }

    // Mark attendance (alias for store)
    public function mark(Request $request)
    {
        return $this->store($request);
    }

    // Export attendance data
    public function export()
    {
        $attendances = Attendance::with('student')->get();

        // Process data for export
        $exportData = [];
        
        foreach ($attendances as $attendance) {
            $months = [
                'January', 'February', 'March', 'April', 'May', 'June',
                'July', 'August', 'September', 'October', 'November', 'December'
            ];

            $present = 0;
            $late = 0;
            $absent = 0;
            $excused = 0;

            foreach ($months as $month) {
                $data = $attendance->$month;

                if ($data === null) {
                    continue;
                }

                for ($i = 0; $i < strlen($data); $i++) {
                    $status = $data[$i];

                    if ($status === 'P') $present++;
                    if ($status === 'L') $late++;
                    if ($status === 'A') $absent++;
                    if ($status === 'E') $excused++;
                }
            }

            $total = $present + $late + $absent + $excused;
            $countedDays = $present + $late + $absent;
            $percentage = $countedDays > 0
                ? round(($present + $late) / $countedDays * 100, 2)
                : 0;

            $exportData[] = [
                'Student Name' => $attendance->student->name ?? 'N/A',
                'Year' => $attendance->current_year,
                'Days Present' => $present,
                'Days Late' => $late,
                'Days Absent' => $absent,
                'Days Excused' => $excused,
                'Total Days' => $total,
                'Attendance %' => $percentage
            ];
        }

        // For now, return as JSON (you can implement CSV/Excel export later)
        return response()->json($exportData);
        
        // Uncomment below if you want to redirect back with a message
        // return back()->with('info', 'Export functionality coming soon!');
    }
}