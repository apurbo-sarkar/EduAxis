<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Attendance Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .table-responsive {
            overflow-x: auto;
        }
        .table th, .table td {
            white-space: nowrap;
            min-width: 80px;
        }
        .table th:first-child, .table td:first-child {
            position: sticky;
            left: 0;
            background-color: #fff;
            z-index: 10;
            min-width: 150px;
        }
        .table thead th:first-child {
            z-index: 11;
        }
    </style>
</head>
<body>
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Attendance Management</h2>
        <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">Back to Dashboard</a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card mb-4">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Update Attendance</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.attendance.store') }}" method="POST">
                @csrf
                <div class="row g-3">
                    <div class="col-md-3">
                        <label class="form-label">Student *</label>
                        <select name="student_id" class="form-select" required>
                            <option value="">-- Select Student --</option>
                            @foreach($students as $stu)
                                <option value="{{ $stu->student_id }}">
                                    {{ $stu->name ?? $stu->student_name ?? 'Student #'.$stu->student_id }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label">Year *</label>
                        <input type="number" name="current_year" class="form-control" 
                               value="{{ date('Y') }}" min="2020" max="2100" required>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Month *</label>
                        <select name="month" class="form-select" required>
                            @php
                                $months = ['January','February','March','April','May','June',
                                          'July','August','September','October','November','December'];
                                $currentMonth = date('F');
                            @endphp
                            @foreach($months as $m)
                                <option value="{{ $m }}" {{ $m == $currentMonth ? 'selected' : '' }}>
                                    {{ $m }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Attendance Value</label>
                        <input type="text" name="value" class="form-control" 
                               placeholder="e.g., PPPALAEPP (P=Present, L=Late, A=Absent, E=Excused)">
                        <small class="text-muted">Leave empty to clear attendance</small>
                    </div>
                </div>

                <div class="mt-3">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-save"></i> Save Attendance
                    </button>
                    <button type="reset" class="btn btn-secondary">
                        <i class="bi bi-x-circle"></i> Reset
                    </button>
                </div>
            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-header bg-secondary text-white">
            <h5 class="mb-0">Attendance Records</h5>
        </div>
        <div class="card-body">
            @if($attendances->count() > 0)
                <div class="table-responsive">
                    <table class="table table-bordered table-striped table-hover">
                        <thead class="table-dark">
                            <tr>
                                <th>Student Name</th>
                                <th>Year</th>
                                @foreach(['January','February','March','April','May','June',
                                         'July','August','September','October','November','December'] as $m)
                                    <th>{{ $m }}</th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($attendances as $a)
                                <tr>
                                    <td>
                                        <strong>{{ $a->student->name ?? $a->student->student_name ?? 'Student #'.$a->student_id }}</strong>
                                    </td>
                                    <td>{{ $a->current_year }}</td>
                                    @foreach(['January','February','March','April','May','June',
                                             'July','August','September','October','November','December'] as $m)
                                        <td class="text-center">
                                            @if($a->$m)
                                                @php
                                                    // Get the attendance string
                                                    $attendance = strtoupper($a->$m);
                                                    
                                                    // Count each type of attendance
                                                    $presentCount = substr_count($attendance, 'P');
                                                    $lateCount = substr_count($attendance, 'L');
                                                    $absentCount = substr_count($attendance, 'A');
                                                    $excusedCount = substr_count($attendance, 'E');
                                                    
                                                    // Attended days = Present + Late
                                                    $attendedDays = $presentCount + $lateCount;
                                                    
                                                    // Days that count for percentage = Present + Late + Absent
                                                    // (Excused days don't count against the student)
                                                    $countedDays = $presentCount + $lateCount + $absentCount;
                                                    
                                                    // Total days including excused
                                                    $totalDays = $presentCount + $lateCount + $absentCount + $excusedCount;
                                                    
                                                    // Calculate percentage (attended / counted days)
                                                    $percentage = $countedDays > 0 ? round(($attendedDays / $countedDays) * 100, 1) : 0;
                                                    
                                                    // Determine badge color based on percentage
                                                    $badgeClass = 'bg-success';
                                                    if ($percentage < 75) {
                                                        $badgeClass = 'bg-danger';
                                                    } elseif ($percentage < 85) {
                                                        $badgeClass = 'bg-warning text-dark';
                                                    }
                                                @endphp
                                                <div class="d-flex flex-column align-items-center">
                                                    <span class="badge {{ $badgeClass }} mb-1">
                                                        {{ $attendedDays }}/{{ $countedDays }} ({{ $percentage }}%)
                                                    </span>
                                                    @if($excusedCount > 0)
                                                        <small class="text-muted" style="font-size: 0.7rem;">
                                                            +{{ $excusedCount }}E
                                                        </small>
                                                    @endif
                                                </div>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                    @endforeach
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="alert alert-info mb-0">
                    <i class="bi bi-info-circle"></i> No attendance records found. Start by adding attendance for students.
                </div>
            @endif
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>