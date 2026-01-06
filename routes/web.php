<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudentRegistrationController;
use App\Http\Controllers\StudentLoginController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\StudentReportController;
use App\Http\Controllers\StudentProfileController;
use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\AdminRegistrationController;
use App\Http\Controllers\AdminLoginController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\Admin\AttendanceManagementController;
use App\Http\Controllers\TeacherController;
use App\Http\Controllers\TeacherloginController;
use App\Http\Controllers\Admin\ScheduleManagementController;
use App\Http\Controllers\Admin\StudentReportManagementController;
use App\Http\Controllers\Admin\AdminFeeController;
use App\Http\Controllers\Student\StudentPaymentController;
use App\Http\Controllers\AcademicDashboardController;
use App\Http\Controllers\AssignmentController;
use App\Http\Controllers\StudyMaterialController;
use App\Http\Controllers\StudentAssignmentController;
use App\Http\Controllers\TeacherAttendanceController;
use App\Http\Controllers\GradeStudentController;

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
    Route::get('/student/profile', [StudentProfileController::class, 'edit'])
        ->name('student.profile.edit');
    Route::put('/student/profile', [StudentProfileController::class, 'update'])
        ->name('student.profile.update');
});

##Assignment

Route::middleware(['auth:student'])->group(function () {
    Route::get('/student/assignments', [StudentAssignmentController::class, 'index'])
        ->name('student.assignments.index');
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

// Admin dashboard & Management (protected)
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
        // Class & Subject Management
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

    // Admin Fee Management Routes (Fixed Middleware and Nesting)
    Route::prefix('fee-management')->name('fee.')->group(function () {
        // Fee Management Dashboard
        Route::get('/', [AdminFeeController::class, 'index'])->name('index');
        
        // Invoices
        Route::get('/invoices', [AdminFeeController::class, 'invoices'])->name('invoices');
        Route::get('/invoices/create', [AdminFeeController::class, 'createInvoice'])->name('invoices.create');
        Route::post('/invoices/store', [AdminFeeController::class, 'storeInvoice'])->name('invoices.store');
        Route::get('/invoices/{id}', [AdminFeeController::class, 'viewInvoice'])->name('invoices.view');
        
        // Payments
        Route::get('/payments', [AdminFeeController::class, 'payments'])->name('payments');
        // Note: Check if you prefer 'fee.payments.record' or just 'payments.record' based on your view links
        Route::post('/payments/record/{invoiceId}', [AdminFeeController::class, 'recordPayment'])->name('payments.record');
        
        // Student Fee Details
        Route::get('/student/{studentId}', [AdminFeeController::class, 'studentFeeDetails'])->name('student.details');
        
        // Fee Structures
        Route::get('/structures', [AdminFeeController::class, 'feeStructures'])->name('structures');
        // Note: Changed to name('structures.store') for consistency
        Route::post('/structures/store', [AdminFeeController::class, 'storeFeeStructure'])->name('structures.store');
    });
    // Student Management Routes
    Route::prefix('students')->name('students.')->group(function () {
    Route::get('/', [App\Http\Controllers\Admin\StudentManagementController::class, 'index'])->name('index');
    Route::get('/create', [App\Http\Controllers\Admin\StudentManagementController::class, 'create'])->name('create');
    Route::post('/store', [App\Http\Controllers\Admin\StudentManagementController::class, 'store'])->name('store');
    Route::get('/{id}', [App\Http\Controllers\Admin\StudentManagementController::class, 'show'])->name('show');
    Route::get('/{id}/edit', [App\Http\Controllers\Admin\StudentManagementController::class, 'edit'])->name('edit');
    Route::put('/{id}', [App\Http\Controllers\Admin\StudentManagementController::class, 'update'])->name('update');
    Route::delete('/{id}', [App\Http\Controllers\Admin\StudentManagementController::class, 'destroy'])->name('destroy');
});
});

// Student Payment Routes (Fixed to use auth:student)
Route::middleware(['auth:student'])->prefix('student')->name('student.')->group(function () {
    
    // Payslip & Invoices
    Route::get('/payslip', [StudentPaymentController::class, 'payslip'])->name('payslip');
    Route::get('/invoice/{id}', [StudentPaymentController::class, 'viewInvoice'])->name('invoice.view');
    Route::get('/payment/{invoiceId}/initiate', [StudentPaymentController::class, 'initiatePayment'])->name('payment.initiate');
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

    
##Assignment

// Assignment routes
Route::prefix('teacher')->group(function () {

// Show all assignments
Route::get('/assignments', [AssignmentController::class, 'index'])
    ->name('teacher.assignmentindex');

// Show create assignment form
Route::get('/assignments/create', [AssignmentController::class, 'create'])
    ->name('assignments.create');

// Store uploaded assignment
Route::post('/assignments', [AssignmentController::class, 'store'])
    ->name('assignments.store');

// Download assignment file
Route::get('/assignments/{id}/download', [AssignmentController::class, 'download'])
    ->name('assignments.download');

// Delete assignment
Route::delete('/assignments/{id}', [AssignmentController::class, 'destroy'])
    ->name('assignments.destroy');

});


##Study Materials 

Route::get('/studymaterials', [StudyMaterialController::class, 'index'])
    ->name('studymaterials.index');

Route::post('/studymaterials', [StudyMaterialController::class, 'store']);
Route::delete('/studymaterials/{id}', [StudyMaterialController::class, 'destroy']);


#Attendance

// Show attendance page
Route::get('/teacher/attendance', [TeacherAttendanceController::class, 'index'])
     ->name('teacher.attendance');

Route::post('/teacher/attendance/store', [TeacherAttendanceController::class, 'store'])
     ->name('teacher.attendance.store');


#Marking Students

Route::get('/gradestudents', [GradeStudentController::class, 'index'])->name('teacher.gradestudents');
Route::post('/gradestudents', [GradeStudentController::class, 'storemarks'])->name('teacher.storemarks');

