<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudentRegistrationController;
use App\Http\Controllers\StudentLoginController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\StudentReportController;
use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\AdminRegistrationController;
use App\Http\Controllers\AdminLoginController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\Admin\AttendanceManagementController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\TeacherloginController;
use App\Http\Controllers\Admin\ScheduleManagementController;
use App\Http\Controllers\Admin\StudentReportManagementController;
use App\Http\Controllers\AcademicDashboardController;

Route::get('/', function () {
    return view('welcome');
});

/*
|--------------------------------------------------------------------------
| Student Routes
|--------------------------------------------------------------------------
*/

Route::get('/student/register', function () {
    return view('student.register');
})->name('student.register');


Route::post('/student/register', [StudentRegistrationController::class, 'store'])
     ->name('student.register.store');


Route::get('/student/login', [StudentLoginController::class, 'showLoginForm'])->name('student.login');
Route::post('/student/login', [StudentLoginController::class, 'login'])->name('student.login.attempt');
Route::post('/student/logout', [StudentLoginController::class, 'logout'])->name('student.logout');


Route::get('/student/dashboard', function () {
    return view('student.dashboard');
})->middleware('auth:student')->name('student.dashboard');


Route::middleware(['auth:student'])->group(function () {
    Route::get('/student/schedule', [ScheduleController::class, 'index'])
        ->name('student.schedule');
    Route::get('/student/attendance', [AttendanceController::class, 'index'])
        ->name('student.attendance');
    Route::get('/student/result', [StudentReportController::class, 'show'])
        ->name('student.result');
    Route::get('/student/announcement', [AnnouncementController::class, 'index'])
        ->name('student.announcement');
    Route::get('/student/dashboard', [AcademicDashboardController::class, 'index'])
        ->name('student.dashboard');
});



/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/

Route::get('/admin/register', function () {
    return view('admin.register');
})->name('admin.register');

Route::post('/admin/register', [AdminRegistrationController::class, 'store'])
    ->name('admin.register.store');

// Admin login routes
Route::get('/admin/login', [AdminLoginController::class, 'showLoginForm'])->name('admin.login');
Route::post('/admin/login', [AdminLoginController::class, 'login'])->name('admin.login.attempt');
Route::post('/admin/logout', [AdminLoginController::class, 'logout'])->name('admin.logout');

// Admin dashboard (protected)
Route::middleware(['auth:admin'])->prefix('admin')->name('admin.')->group(function () {
   
    // Dashboard
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    // Attendance Management Routes
    Route::prefix('attendance')->name('attendance.')->group(function () {
        Route::get('/', [AttendanceManagementController::class, 'index'])->name('index');
        Route::post('/store', [AttendanceManagementController::class, 'store'])->name('store');
        Route::get('/view', [AttendanceManagementController::class, 'view'])->name('view');
        Route::get('/reports', [AttendanceManagementController::class, 'reports'])->name('reports');
        Route::post('/mark', [AttendanceManagementController::class, 'mark'])->name('mark');
        Route::get('/export', [AttendanceManagementController::class, 'export'])->name('export');
    });

    // Schedule Management Routes
    Route::prefix('schedule')->name('schedule.')->group(function () {
        Route::get('/', [ScheduleManagementController::class, 'index'])->name('index');
        Route::get('/get-schedules', [ScheduleManagementController::class, 'getClassSchedules'])->name('get-schedules');
        Route::post('/store', [ScheduleManagementController::class, 'storeSchedule'])->name('store');
        Route::get('/edit/{id}', [ScheduleManagementController::class, 'editSchedule'])->name('edit');
        Route::put('/update/{id}', [ScheduleManagementController::class, 'updateSchedule'])->name('update');
        Route::delete('/{id}', [ScheduleManagementController::class, 'destroySchedule'])->name('destroy');
        Route::post('/class/store', [ScheduleManagementController::class, 'storeClass'])->name('class.store');
        Route::delete('/class/{id}', [ScheduleManagementController::class, 'destroyClass'])->name('class.destroy');
        Route::post('/subject/store', [ScheduleManagementController::class, 'storeSubject'])->name('subject.store');
        Route::delete('/subject/{id}', [ScheduleManagementController::class, 'destroySubject'])->name('subject.destroy');
    });

    // Student Report Management Routes
    Route::prefix('student-reports')->name('student-reports.')->group(function () {
        Route::get('/', [StudentReportManagementController::class, 'index'])->name('index');
        Route::get('/edit/{id}', [StudentReportManagementController::class, 'edit'])->name('edit');
        Route::put('/update/{id}', [StudentReportManagementController::class, 'update'])->name('update');
    });
});

/*
|--------------------------------------------------------------------------
| Teacher Routes
|--------------------------------------------------------------------------
*/

// Welcome page (landing page)
Route::get('/teacher/welcome', function () {
    return view('teacher.welcome');
})->name('welcome');

// Registration routes
Route::get('/teacher/register', function () {
    return view('teacher.teachers');
})->name('teacher.register.form');

Route::post('/teacher/register', [TeacherController::class, 'register'])
    ->name('teacher.register');

// Login routes
Route::get('/teacher/login', function () {
    return view('teacher.login');
})->name('teacher.login.form');

Route::post('/teacher/login', [TeacherloginController::class, 'login'])
    ->name('teacher.login');

// Dashboard route (protected - requires authentication)
Route::get('/teacher/dashboard', [TeacherloginController::class, 'dashboard'])
    ->name('teacher.dashboard');

// Logout route
Route::post('/teacher/logout', [TeacherloginController::class, 'logout'])
    ->name('teacher.logout');

// Update 
Route::put('/teacher/{id}/update', [TeacherController::class, 'update'])
    ->name('teacher.update');
