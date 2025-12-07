<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudentRegistrationController; 
use App\Http\Controllers\StudentLoginController; 
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\StudentReportController;

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
//hi i am hafsa