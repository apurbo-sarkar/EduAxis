<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use App\Models\Student;
use App\Models\ClassModel;
use App\Models\Schedule;
use Carbon\Carbon;

class ScheduleController extends Controller
{
    public function index(): View
    {
        $student = Auth::guard('student')->user();
        $classModel = ClassModel::where('name', $student->student_class)->first();

        $schedules = collect(); 
        if ($classModel) {
            $schedules = Schedule::with(['subject', 'classModel'])
                ->where('class_id', $classModel->class_id)
                ->get();
        }
        $weekStart = Carbon::now()->startOfWeek(Carbon::SUNDAY); 
        $weekDays = [];
        for ($i = 0; $i < 7; $i++) {
            $weekDays[] = $weekStart->copy()->addDays($i);
        }
        $timeSlots = $schedules->pluck('start_time')->unique()->sortBy(function($time) {
            return Carbon::parse($time);
        })->values();
        $scheduleByDayTime = [];
        foreach ($schedules as $schedule) {
            $scheduleByDayTime[$schedule->day_name][$schedule->start_time][] = $schedule;
        }
        return view('student.schedule', compact(
            'student',
            'classModel',
            'weekStart', 
            'weekDays', 
            'timeSlots', 
            'scheduleByDayTime',
            'schedules'
        ));
    }
}
