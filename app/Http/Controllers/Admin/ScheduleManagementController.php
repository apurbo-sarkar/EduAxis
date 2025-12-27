<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use App\Models\ClassModel;
use App\Models\Subject;
use App\Models\Schedule;
use Carbon\Carbon;

class ScheduleManagementController extends Controller
{
    /**
     * Display the schedule management index page
     */
    public function index(): View
    {
        $classes = ClassModel::orderBy('name')->get();
        $subjects = Subject::orderBy('name')->get();
        
        return view('admin.schedule.index', compact('classes', 'subjects'));
    }

    /**
     * Get schedules for a specific class (AJAX)
     */
    public function getClassSchedules(Request $request)
    {
        $classId = $request->input('class_id');
        
        if (!$classId) {
            return response()->json(['schedules' => []]);
        }

        $schedules = Schedule::with(['subject', 'classModel'])
            ->where('class_id', $classId)
            ->orderBy('day_name')
            ->orderBy('start_time')
            ->get();

        return response()->json(['schedules' => $schedules]);
    }

    /**
     * Show the form for creating a new class
     */
    public function createClass(): View
    {
        return view('admin.schedule.create-class');
    }

    /**
     * Store a newly created class
     */
    public function storeClass(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:classes,name',
            'description' => 'nullable|string|max:1000',
        ]);

        ClassModel::create($validated);

        return redirect()->route('admin.schedule.index')
            ->with('success', 'Class created successfully!');
    }

    /**
     * Show the form for creating a new subject
     */
    public function createSubject(): View
    {
        return view('admin.schedule.create-subject');
    }

    /**
     * Store a newly created subject
     */
    public function storeSubject(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:subjects,name',
        ]);

        Subject::create($validated);

        return redirect()->route('admin.schedule.index')
            ->with('success', 'Subject created successfully!');
    }

    /**
     * Store a new schedule
     */
    public function storeSchedule(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'class_id' => 'required|exists:classes,class_id',
            'subject_id' => 'required|exists:subjects,subject_id',
            'day_name' => 'required|in:Sunday,Monday,Tuesday,Wednesday,Thursday,Friday,Saturday',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'location' => 'required|string|max:255',
            'teacher_name' => 'required|string|max:255',
        ]);

        Schedule::create($validated);

        return redirect()->route('admin.schedule.index')
            ->with('success', 'Schedule created successfully!');
    }

    /**
     * Show the form for editing a schedule
     */
    public function editSchedule($id): View
    {
        $schedule = Schedule::with(['subject', 'classModel'])->findOrFail($id);
        $classes = ClassModel::orderBy('name')->get();
        $subjects = Subject::orderBy('name')->get();
        
        return view('admin.schedule.edit', compact('schedule', 'classes', 'subjects'));
    }

    /**
     * Update the specified schedule
     */
    public function updateSchedule(Request $request, $id): RedirectResponse
    {
        $schedule = Schedule::findOrFail($id);

        $validated = $request->validate([
            'class_id' => 'required|exists:classes,class_id',
            'subject_id' => 'required|exists:subjects,subject_id',
            'day_name' => 'required|in:Sunday,Monday,Tuesday,Wednesday,Thursday,Friday,Saturday',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'location' => 'required|string|max:255',
            'teacher_name' => 'required|string|max:255',
        ]);

        $schedule->update($validated);

        return redirect()->route('admin.schedule.index')
            ->with('success', 'Schedule updated successfully!');
    }

    /**
     * Remove the specified schedule
     */
    public function destroySchedule($id): RedirectResponse
    {
        $schedule = Schedule::findOrFail($id);
        $schedule->delete();

        return redirect()->route('admin.schedule.index')
            ->with('success', 'Schedule deleted successfully!');
    }

    /**
     * Delete a class
     */
    public function destroyClass($id): RedirectResponse
    {
        $class = ClassModel::findOrFail($id);
        
        // Check if there are students in this class
        $studentCount = \App\Models\Student::where('student_class', $class->name)->count();
        
        if ($studentCount > 0) {
            return redirect()->route('admin.schedule.index')
                ->with('error', 'Cannot delete class with enrolled students!');
        }

        $class->delete();

        return redirect()->route('admin.schedule.index')
            ->with('success', 'Class deleted successfully!');
    }

    /**
     * Delete a subject
     */
    public function destroySubject($id): RedirectResponse
    {
        $subject = Subject::findOrFail($id);
        
        // Check if subject is being used in schedules
        $scheduleCount = Schedule::where('subject_id', $id)->count();
        
        if ($scheduleCount > 0) {
            return redirect()->route('admin.schedule.index')
                ->with('error', 'Cannot delete subject that is assigned to schedules!');
        }

        $subject->delete();

        return redirect()->route('admin.schedule.index')
            ->with('success', 'Subject deleted successfully!');
    }
}