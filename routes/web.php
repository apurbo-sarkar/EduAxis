<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudentRegistrationController;
use App\Http\Controllers\StudentLoginController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\StudentReportController;
use App\Http\Controllers\AdminRegistrationController;
use App\Http\Controllers\AdminLoginController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\Admin\AttendanceManagementController;


Route::get('/', function () {
    return view('welcome');
});


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
});
