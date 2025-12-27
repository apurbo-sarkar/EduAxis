<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class AdminDashboardController extends Controller
{
    /**
     * Display the admin dashboard.
     *
     * @return View|RedirectResponse
     */
    public function index()
    {
        // Check if admin is authenticated using the 'admin' guard
        if (!Auth::guard('admin')->check()) {
            return redirect()->route('admin.login')->withErrors([
                'error' => 'Please login to access the admin dashboard.',
            ]);
        }

        // Get the authenticated admin user using the 'admin' guard
        $admin = Auth::guard('admin')->user();

        // Prepare data for the dashboard view
        $data = [
            'admin_name' => $admin?->full_name ?? 'Admin',
            'features' => $this->getDashboardFeatures(),
        ];

        // Render the admin dashboard view
        return view('admin.dashboard', $data);
    }
     
    /**
     * Get the dashboard features/cards configuration.
     *
     * @return array
     */
    protected function getDashboardFeatures(): array
    {
        return [
            [
                'title' => 'Schedule Management',
                'description' => 'Create, edit, and manage class schedules, subjects, and time tables for all classes.',
                'route_name' => 'admin.schedule.index',
                'icon' => 'fas fa-calendar-alt',
            ],
            [
                'title' => 'Attendance Monitoring',
                'description' => 'View, mark, and generate attendance reports for all students and classes.',
                'route_name' => 'admin.attendance.index',
                'icon' => 'fas fa-clipboard-check',
            ],
            [
                'title' => 'Student Report Cards',
                'description' => 'Generate student report cards, view academic performance, and set student academic status.',
                'route_name' => 'admin.student-reports.index',
                'icon' => 'fas fa-file-alt',
            ],
            [
                'title' => 'Fee Management',
                'description' => 'Manage student fees, create invoices, track payments, and generate fee reports.',
                'route_name' => 'admin.fee.index',
                'icon' => 'fas fa-dollar-sign',
            ],
        ];
    }
}