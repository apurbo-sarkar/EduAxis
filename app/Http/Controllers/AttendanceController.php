<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use App\Models\Attendance;

class AttendanceController extends Controller
{

    public function index(): View
    {
        $student = Auth::guard('student')->user();
        $attendance = Attendance::where('student_id', $student->student_id)->first();
        if (!$attendance) {
            $attendance = (object) [
                'days_present' => 0,
                'days_late' => 0,
                'days_absent' => 0,
                'days_excused' => 0,
                'days_total' => 0,
            ];
        } else {
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
        }
        $countedDays = $attendance->days_present + $attendance->days_late + $attendance->days_absent;

        $percentage = $countedDays > 0
            ? round(($attendance->days_present + $attendance->days_late) / $countedDays * 100, 2)
            : 0;

        return view('student.attendance', [
            'student' => $student,
            'attendance'  => $attendance,
            'daysPresent' => $attendance->days_present,
            'daysLate' => $attendance->days_late,
            'daysAbsent' => $attendance->days_absent,
            'daysExcused' => $attendance->days_excused,
            'daysTotal' => $attendance->days_total,
            'percentage' => $percentage,
        ]);
    }
}
