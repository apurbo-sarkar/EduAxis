<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use App\Models\Student;
use App\Models\ClassModel;
use App\Models\Attendance;
use App\Models\Mathematics;
use App\Models\EnglishLanguage;
use App\Models\Literature;
use App\Models\Announcement;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class AcademicDashboardController extends Controller
{
    public function index()
    {
        $studentId = auth()->id();
        $student = Student::find($studentId);

        if (!$student || !$student->student_class) {
            return view('student.dashboard', [
                'schedules' => collect(),
                'attendanceCounts' => ['P'=>0,'A'=>0,'L'=>0,'E'=>0],
                'grades' => [],
            ]);
        }

        $class = ClassModel::where('name', $student->student_class)->first();
        if (!$class) {
            return view('student.dashboard', [
                'schedules' => collect(),
                'attendanceCounts' => ['P'=>0,'A'=>0,'L'=>0,'E'=>0],
                'grades' => [],
            ]);
        }

        $now = Carbon::now('Asia/Dhaka');
        $today = $now->format('l');

        $schedules = Schedule::with(['classModel','subject'])
            ->where('class_id',$class->class_id)
            ->where('day_name',$today)
            ->orderBy('start_time')
            ->get()
            ->map(function($schedule) use($now){
                $schedule->is_current = false;
                try{
                    $start = Carbon::createFromFormat('H:i:s',$schedule->start_time,'Asia/Dhaka');
                    $end = Carbon::createFromFormat('H:i:s',$schedule->end_time,'Asia/Dhaka');
                    if($now->between($start,$end)) $schedule->is_current = true;
                } catch (\Exception $e){}
                return $schedule;
            });

        $attendance = Attendance::where('student_id',$student->student_id)
            ->where('current_year',$now->year)
            ->first();

        $attendanceCounts = ['P'=>0,'A'=>0,'L'=>0,'E'=>0];
        if($attendance){
            $months = ['January','February','March','April','May','June','July','August','September','October','November','December'];
            foreach($months as $month){
                $monthData = $attendance->$month ?? '';
                $letters = str_split($monthData);
                foreach($letters as $letter){
                    if(array_key_exists($letter,$attendanceCounts)){
                        $attendanceCounts[$letter]++;
                    }
                }
            }
        }

        $grades = [];

        $mathGrade = $student->mathematics()->latest('updated_at')->first();
        if ($mathGrade) $grades[] = [
            'subject' => 'Mathematics',
            'marks' => $mathGrade->marks_obtained,
            'grade' => $mathGrade->grade_obtained,
        ];

        $englishGrade = $student->englishLanguage()->latest('updated_at')->first();
        if ($englishGrade) $grades[] = [
            'subject' => 'English Language',
            'marks' => $englishGrade->marks_obtained,
            'grade' => $englishGrade->grade_obtained,
        ];

        $literatureGrade = $student->literature()->latest('updated_at')->first();
        if ($literatureGrade) $grades[] = [
            'subject' => 'Literature',
            'marks' => $literatureGrade->marks_obtained,
            'grade' => $literatureGrade->grade_obtained,
        ];

        $notifications = Announcement::orderBy('publish_at', 'desc')
            ->take(5)
            ->get();

        return view('student.dashboard', compact('schedules','attendanceCounts','grades','notifications'));

    }
}




