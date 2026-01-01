<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class UserManagementController extends Controller
{
    /**
     * Display user management dashboard
     */
    
    public function index()
{
    $totalStudents = Student::count();
    $totalTeachers = Teacher::count();
    $activeStudents = Student::where('status', 'active')->count();
    $activeTeachers = Teacher::where('status', 'active')->count();

    return view('admin.users.index', compact(
        'totalStudents',
        'totalTeachers',
        'activeStudents',
        'activeTeachers'
    ));
}

    /*
    |--------------------------------------------------------------------------
    | STUDENT MANAGEMENT
    |--------------------------------------------------------------------------
    */

    /**
     * Display list of students
     */
    public function students(Request $request)
    {
        $query = Student::query();

        // Search functionality
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('full_name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('student_id', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        // Filter by status
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        // Filter by class/semester
        if ($request->has('class') && $request->class != '') {
            $query->where('class', $request->class);
        }

        $students = $query->orderBy('created_at', 'desc')->paginate(15);

        return view('admin.users.students.index', compact('students'));
    }

    /**
     * Show form to create new student
     */
    public function createStudent()
    {
        return view('admin.users.students.create');
    }

    /**
     * Store new student
     */
    public function storeStudent(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'full_name' => 'required|string|max:255',
            'email' => 'required|email|unique:students,email',
            'password' => 'required|string|min:8|confirmed',
            'student_id' => 'required|string|unique:students,student_id',
            'phone' => 'nullable|string|max:20',
            'date_of_birth' => 'nullable|date',
            'gender' => 'nullable|in:male,female,other',
            'address' => 'nullable|string',
            'class' => 'nullable|string|max:50',
            'section' => 'nullable|string|max:10',
            'roll_number' => 'nullable|string|max:50',
            'guardian_name' => 'nullable|string|max:255',
            'guardian_phone' => 'nullable|string|max:20',
            'status' => 'required|in:active,inactive,suspended',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $student = Student::create([
            'full_name' => $request->full_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'student_id' => $request->student_id,
            'phone' => $request->phone,
            'date_of_birth' => $request->date_of_birth,
            'gender' => $request->gender,
            'address' => $request->address,
            'class' => $request->class,
            'section' => $request->section,
            'roll_number' => $request->roll_number,
            'guardian_name' => $request->guardian_name,
            'guardian_phone' => $request->guardian_phone,
            'status' => $request->status,
        ]);

        return redirect()->route('admin.users.students')
            ->with('success', 'Student created successfully!');
    }

    /**
     * Show form to edit student
     */
    public function editStudent($id)
    {
        $student = Student::findOrFail($id);
        return view('admin.users.students.edit', compact('student'));
    }

    /**
     * Update student
     */
    public function updateStudent(Request $request, $id)
    {
        $student = Student::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'full_name' => 'required|string|max:255',
            'email' => ['required', 'email', Rule::unique('students')->ignore($student->id)],
            'password' => 'nullable|string|min:8|confirmed',
            'student_id' => ['required', 'string', Rule::unique('students')->ignore($student->id)],
            'phone' => 'nullable|string|max:20',
            'date_of_birth' => 'nullable|date',
            'gender' => 'nullable|in:male,female,other',
            'address' => 'nullable|string',
            'class' => 'nullable|string|max:50',
            'section' => 'nullable|string|max:10',
            'roll_number' => 'nullable|string|max:50',
            'guardian_name' => 'nullable|string|max:255',
            'guardian_phone' => 'nullable|string|max:20',
            'status' => 'required|in:active,inactive,suspended',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $updateData = [
            'full_name' => $request->full_name,
            'email' => $request->email,
            'student_id' => $request->student_id,
            'phone' => $request->phone,
            'date_of_birth' => $request->date_of_birth,
            'gender' => $request->gender,
            'address' => $request->address,
            'class' => $request->class,
            'section' => $request->section,
            'roll_number' => $request->roll_number,
            'guardian_name' => $request->guardian_name,
            'guardian_phone' => $request->guardian_phone,
            'status' => $request->status,
        ];

        // Only update password if provided
        if ($request->filled('password')) {
            $updateData['password'] = Hash::make($request->password);
        }

        $student->update($updateData);

        return redirect()->route('admin.users.students')
            ->with('success', 'Student updated successfully!');
    }

    /**
     * Delete student
     */
    public function deleteStudent($id)
    {
        $student = Student::findOrFail($id);
        $student->delete();

        return redirect()->route('admin.users.students')
            ->with('success', 'Student deleted successfully!');
    }

    /*
    |--------------------------------------------------------------------------
    | TEACHER MANAGEMENT
    |--------------------------------------------------------------------------
    */

    /**
     * Display list of teachers
     */
    public function teachers(Request $request)
    {
        $query = Teacher::query();

        // Search functionality
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('full_name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('teacher_id', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        // Filter by status
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        // Filter by department
        if ($request->has('department') && $request->department != '') {
            $query->where('department', $request->department);
        }

        $teachers = $query->orderBy('created_at', 'desc')->paginate(15);

        return view('admin.users.teachers.index', compact('teachers'));
    }

    /**
     * Show form to create new teacher
     */
    public function createTeacher()
    {
        return view('admin.users.teachers.create');
    }

    /**
     * Store new teacher
     */
    public function storeTeacher(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'full_name' => 'required|string|max:255',
            'email' => 'required|email|unique:teachers,email',
            'password' => 'required|string|min:8|confirmed',
            'teacher_id' => 'required|string|unique:teachers,teacher_id',
            'phone' => 'nullable|string|max:20',
            'date_of_birth' => 'nullable|date',
            'gender' => 'nullable|in:male,female,other',
            'address' => 'nullable|string',
            'department' => 'nullable|string|max:100',
            'designation' => 'nullable|string|max:100',
            'qualification' => 'nullable|string|max:255',
            'joining_date' => 'nullable|date',
            'salary' => 'nullable|numeric|min:0',
            'status' => 'required|in:active,inactive,on_leave',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $teacher = Teacher::create([
            'full_name' => $request->full_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'teacher_id' => $request->teacher_id,
            'phone' => $request->phone,
            'date_of_birth' => $request->date_of_birth,
            'gender' => $request->gender,
            'address' => $request->address,
            'department' => $request->department,
            'designation' => $request->designation,
            'qualification' => $request->qualification,
            'joining_date' => $request->joining_date,
            'salary' => $request->salary,
            'status' => $request->status,
        ]);

        return redirect()->route('admin.users.teachers')
            ->with('success', 'Teacher created successfully!');
    }

    /**
     * Show form to edit teacher
     */
    public function editTeacher($id)
    {
        $teacher = Teacher::findOrFail($id);
        return view('admin.users.teachers.edit', compact('teacher'));
    }

    /**
     * Update teacher
     */
    public function updateTeacher(Request $request, $id)
    {
        $teacher = Teacher::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'full_name' => 'required|string|max:255',
            'email' => ['required', 'email', Rule::unique('teachers')->ignore($teacher->id)],
            'password' => 'nullable|string|min:8|confirmed',
            'teacher_id' => ['required', 'string', Rule::unique('teachers')->ignore($teacher->id)],
            'phone' => 'nullable|string|max:20',
            'date_of_birth' => 'nullable|date',
            'gender' => 'nullable|in:male,female,other',
            'address' => 'nullable|string',
            'department' => 'nullable|string|max:100',
            'designation' => 'nullable|string|max:100',
            'qualification' => 'nullable|string|max:255',
            'joining_date' => 'nullable|date',
            'salary' => 'nullable|numeric|min:0',
            'status' => 'required|in:active,inactive,on_leave',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $updateData = [
            'full_name' => $request->full_name,
            'email' => $request->email,
            'teacher_id' => $request->teacher_id,
            'phone' => $request->phone,
            'date_of_birth' => $request->date_of_birth,
            'gender' => $request->gender,
            'address' => $request->address,
            'department' => $request->department,
            'designation' => $request->designation,
            'qualification' => $request->qualification,
            'joining_date' => $request->joining_date,
            'salary' => $request->salary,
            'status' => $request->status,
        ];

        // Only update password if provided
        if ($request->filled('password')) {
            $updateData['password'] = Hash::make($request->password);
        }

        $teacher->update($updateData);

        return redirect()->route('admin.users.teachers')
            ->with('success', 'Teacher updated successfully!');
    }

    /**
     * Delete teacher
     */
    public function deleteTeacher($id)
    {
        $teacher = Teacher::findOrFail($id);
        $teacher->delete();

        return redirect()->route('admin.users.teachers')
            ->with('success', 'Teacher deleted successfully!');
    }
}