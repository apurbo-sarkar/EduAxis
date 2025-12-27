<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Report Cards - Admin</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 20px;
        }

        .container {
            max-width: 1400px;
            margin: 0 auto;
        }

        .header {
            background: white;
            padding: 25px 30px;
            border-radius: 15px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
            margin-bottom: 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .header h1 {
            color: #2d3748;
            font-size: 28px;
        }

        .header h1 i {
            color: #dc3545;
            margin-right: 10px;
        }

        .back-btn {
            background: #dc3545;
            color: white;
            padding: 10px 25px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s;
        }

        .back-btn:hover {
            background: #c82333;
            transform: translateY(-2px);
        }

        .success-message {
            background: #28a745;
            color: white;
            padding: 15px 20px;
            border-radius: 8px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .students-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
            gap: 25px;
        }

        .student-card {
            background: white;
            border-radius: 15px;
            padding: 25px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            transition: all 0.3s;
        }

        .student-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.15);
        }

        .student-header {
            display: flex;
            align-items: center;
            gap: 15px;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 2px solid #f0f0f0;
        }

        .student-avatar {
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, #667eea, #764ba2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 24px;
            font-weight: bold;
        }

        .student-info h3 {
            color: #2d3748;
            font-size: 20px;
            margin-bottom: 5px;
        }

        .student-info p {
            color: #718096;
            font-size: 14px;
        }

        .performance {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 10px;
            margin-bottom: 15px;
        }

        .performance-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
        }

        .performance-row:last-child {
            margin-bottom: 0;
        }

        .performance-label {
            color: #4a5568;
            font-weight: 600;
        }

        .performance-value {
            color: #2d3748;
            font-weight: bold;
        }

        .average-badge {
            display: inline-block;
            padding: 5px 15px;
            border-radius: 20px;
            font-weight: bold;
            font-size: 16px;
        }

        .grade-A { background: #d4edda; color: #155724; }
        .grade-B { background: #cfe2ff; color: #084298; }
        .grade-C { background: #fff3cd; color: #856404; }
        .grade-D { background: #ffe5d0; color: #974c00; }
        .grade-F { background: #f8d7da; color: #842029; }

        .status-badge {
            display: inline-block;
            padding: 8px 16px;
            border-radius: 20px;
            font-weight: 600;
            font-size: 14px;
            margin-bottom: 15px;
        }

        .status-excellent { background: #d4edda; color: #155724; }
        .status-good { background: #d1ecf1; color: #0c5460; }
        .status-satisfactory { background: #fff3cd; color: #856404; }
        .status-needs-improvement { background: #ffe5d0; color: #974c00; }
        .status-poor { background: #f8d7da; color: #842029; }
        .status-not-set { background: #e9ecef; color: #495057; }

        .edit-btn {
            display: block;
            width: 100%;
            background: linear-gradient(135deg, #dc3545, #c82333);
            color: white;
            padding: 12px;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            text-align: center;
            transition: all 0.3s;
        }

        .edit-btn:hover {
            background: linear-gradient(135deg, #c82333, #bd2130);
            transform: translateY(-2px);
        }

        .subjects-summary {
            font-size: 13px;
            color: #718096;
            margin-bottom: 15px;
        }

        .no-students {
            background: white;
            padding: 60px;
            border-radius: 15px;
            text-align: center;
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
        }

        .no-students i {
            font-size: 60px;
            color: #cbd5e0;
            margin-bottom: 20px;
        }

        .no-students h2 {
            color: #4a5568;
            margin-bottom: 10px;
        }

        .no-students p {
            color: #718096;
        }

        @media (max-width: 768px) {
            .students-grid {
                grid-template-columns: 1fr;
            }
            
            .header {
                flex-direction: column;
                gap: 15px;
                text-align: center;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1><i class="fas fa-file-alt"></i>Student Report Cards</h1>
            <a href="{{ route('admin.dashboard') }}" class="back-btn">
                <i class="fas fa-arrow-left"></i> Back to Dashboard
            </a>
        </div>

        @if(session('success'))
            <div class="success-message">
                <i class="fas fa-check-circle"></i>
                {{ session('success') }}
            </div>
        @endif

        @if(count($studentsData) > 0)
            <div class="students-grid">
                @foreach($studentsData as $data)
                    <div class="student-card">
                        <div class="student-header">
                            <div class="student-avatar">
                                {{ strtoupper(substr($data['student']->full_name, 0, 1)) }}
                            </div>
                            <div class="student-info">
                                <h3>{{ $data['student']->full_name }}</h3>
                                <p><i class="fas fa-id-card"></i> {{ $data['student']->admission_number }}</p>
                                <p><i class="fas fa-graduation-cap"></i> {{ $data['student']->student_class }}</p>
                            </div>
                        </div>

                        <div class="performance">
                            <div class="performance-row">
                                <span class="performance-label">Overall Average:</span>
                                <span class="performance-value">
                                    {{ $data['overallAverage'] }}%
                                    <span class="average-badge grade-{{ $data['overallGrade'] }}">
                                        {{ $data['overallGrade'] }}
                                    </span>
                                </span>
                            </div>
                        </div>

                        <div class="subjects-summary">
                            <strong>Subjects:</strong>
                            @php
                                $subjectNames = [];
                                foreach($data['subjects'] as $name => $subject) {
                                    if($subject) {
                                        $subjectNames[] = $name . ' (' . $subject->marks_obtained . '%)';
                                    }
                                }
                                echo implode(', ', $subjectNames) ?: 'No subjects found';
                            @endphp
                        </div>

                        @if($data['student']->academic_status)
                            <div style="margin-bottom: 15px;">
                                <strong style="font-size: 13px; color: #4a5568;">Current Status:</strong><br>
                                <span class="status-badge status-{{ strtolower(str_replace(' ', '-', $data['student']->academic_status)) }}">
                                    {{ $data['student']->academic_status }}
                                </span>
                            </div>
                        @else
                            <div style="margin-bottom: 15px;">
                                <span class="status-badge status-not-set">
                                    <i class="fas fa-exclamation-circle"></i> Status Not Set
                                </span>
                            </div>
                        @endif

                        <a href="{{ route('admin.student-reports.edit', $data['student']->student_id) }}" class="edit-btn">
                            <i class="fas fa-edit"></i> Update Status
                        </a>
                    </div>
                @endforeach
            </div>
        @else
            <div class="no-students">
                <i class="fas fa-users-slash"></i>
                <h2>No Students Found</h2>
                <p>There are currently no students registered in the system.</p>
            </div>
        @endif
    </div>
</body>
</html>