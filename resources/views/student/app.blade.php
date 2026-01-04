<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>Student Portal</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">

        <style>
            body {
            overflow-x: hidden;
            background-color: #f4f7fa;
            }
            .header {
            height: 55px;
            background: #343a40;
            color: #fff;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            z-index: 1000;
            padding: 10px 20px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            }
            .sidebar {
            width: 250px;
            height: 100vh;
            position: fixed;
            top: 55px;
            left: 0;
            background: #343a40;
            padding-top: 20px;
            overflow-y: auto;
            transition: all 0.3s ease;
            z-index: 999;
            }
            .sidebar .nav-link {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 20px;
            color: #fff;
            font-size: 15px;
            transition: background-color 0.2s;
            }
            .sidebar .nav-link:hover {
            background: #0b5ed7;
            }
            .sidebar .nav-link.active {
            background: #0d6efd;
            font-weight: bold;
            }
            .content {
            margin-left: 250px;
            margin-top: 70px;
            padding: 20px;
            transition: margin-left 0.3s ease;
            }
            @media (max-width: 768px) {
            .sidebar {
                left: -250px;
            }
            .sidebar.active {
                left: 0;
            }
            .content {
                margin-left: 0;
            }

            .overlay.active {
                position: fixed;
                top: 0;
                left: 0;
                height: 100%;
                width: 100%;
                background: rgba(0, 0, 0, 0.5);
                z-index: 998;
            }
            }
        </style>

        @stack('styles')

    </head>

    <body>
        <div class="content">
            @yield('content')

            <header class="header d-flex justify-content-between align-items-center">
                <i class="bi bi-list d-md-none fs-3" id="menuToggle" style="cursor:pointer;"></i>
                <h5 class="m-0 fw-bold">Student Portal</h5>
                <div class="d-flex align-items-center gap-3">
                <div class="position-relative" style="cursor:pointer;">
                    <i class="bi bi-bell fs-4"></i>
                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                    3
                    </span>
                </div>
                <div class="dropdown">
                    <a class="dropdown-toggle text-white text-decoration-none" href="#" data-bs-toggle="dropdown">
                    <i class="bi bi-person-circle me-1"></i> 
                    Account 
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                    <li><a class="dropdown-item" href="#"><i class="bi bi-person me-2"></i> My Profile</a></li>
                    <li><a class="dropdown-item" href="#"><i class="bi bi-gear me-2"></i> Settings</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li>
                        <a class="dropdown-item text-danger" href="#" 
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <i class="bi bi-box-arrow-right me-2"></i> Logout
                        </a>
                    </li>
                    </ul>
                </div>

                </div>
            </header>

            <nav class="sidebar" id="sidebar">
                <a href="{{ route('student.dashboard') }}" 
                    class="nav-link {{ request()->routeIs('student.dashboard') ? 'active' : '' }}">
                    <i class="bi bi-house"></i> Dashboard
                </a>

                <a href="{{ route('student.schedule') }}" 
                    class="nav-link {{ request()->routeIs('student.schedule') ? 'active' : '' }}">
                    <i class="bi bi-calendar-week"></i> My Schedule
                </a>

                <a href="{{ route('student.attendance') }}" 
                    class="nav-link {{ request()->routeIs('student.attendance') ? 'active' : '' }}">
                    <i class="bi bi-clipboard-check"></i> Attendance
                </a>

                <a href="{{ route('student.result') }}" 
                    class="nav-link {{ request()->routeIs('student.result') ? 'active' : '' }}">
                    <i class="bi bi-bar-chart-line"></i> Progress
                </a>

                <a href="{{ route('student.assignments.index') }}" 
                class="nav-link {{ request()->routeIs('student.assignments.index') ? 'active' : '' }}">
                    <i class="bi bi-journal-text"></i> Assignments
                </a>

                 <!-- NEW: Payslip Link -->
                <a href="{{ route('student.payslip') }}"
                    class="nav-link {{ request()->routeIs('student.payslip') ? 'active' : '' }}">
                    <i class="bi bi-receipt"></i> Payslip
                </a>

                <hr class="text-secondary mx-3">

                <a href="{{ route('student.announcement') }}" 
                    class="nav-link {{ request()->routeIs('student.announcement') ? 'active' : '' }}">
                    <i class="bi bi-megaphone"></i> Announcements
                </a>

                <a href="{{ route('student.profile.edit') }}" 
                    class="nav-link {{ request()->routeIs('student.profile.edit') ? 'active' : '' }}">
                    <i class="bi bi-person-gear"></i> Profile Management
                </a>

                <a href="#" class="nav-link text-danger"
                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="bi bi-box-arrow-left"></i> Logout
                </a>
            </nav>
            <div class="overlay" id="overlay"></div>
                <form id="logout-form" action="{{ route('student.logout') }}" method="POST" style="display: none;">
                    @csrf 
                </form>
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

            <script>
                const menuToggle = document.getElementById("menuToggle");
                const sidebar = document.getElementById("sidebar");
                const overlay = document.getElementById("overlay");

                menuToggle.addEventListener("click", () => {
                sidebar.classList.toggle("active");
                overlay.classList.toggle("active");
                });

                overlay.addEventListener("click", () => {
                sidebar.classList.remove("active");
                overlay.classList.remove("active");
                });
            </script>        
        </div>

        @stack('scripts')

    </body>
</html>
