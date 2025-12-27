<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Student Status - Admin</title>
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
            max-width: 1200px;
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
            background: #6c757d;
            color: white;
            padding: 10px 25px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s;
        }

        .back-btn:hover {
            background: #5a6268;
            transform: translateY(-2px);
        }

        .content-wrapper {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 25px;
        }

        .card {
            background: white;
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }

        .card h2 {
            color: #2d3748;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 2px solid #e2e8f0;
            font-size: 22px;
        }

        .student-info-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 15px;
            margin-bottom: 25px;
        }

        .info-item {
            padding: 12px;
            background: #f8f9fa;
            border-radius: 8px;
        }

        .info-label {
            color: #718096;
            font-size: 13px;
            margin-bottom: 5px;
        }

        .info-value {
            color: #2d3748;
            font-weight: 600;
            font-size: 15px;
        }

        .report-section {
            margin-bottom: 25px;
        }

        .overall-stats {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            padding: 20px;
            border-radius: 10px;
            text-align: center;
            margin-bottom: 20px;
        }

        .overall-stats h3 {
            font-size: 18px;
            margin-bottom: 10px;
        }

        .overall-stats .score {
            font-size: 36px;
            font-weight: bold;
        }

        .subject-list {
            list-style: none;
        }

        .subject-item {
            display: flex;
            justify-content: space-between;
            padding: 12px;
            background: #f8f9fa;
            border-radius: 8px;
            margin-bottom: 10px;
        }

        .subject-name {
            font-weight: 600;
            color: #2d3748;
        }

        .subject-score {
            font-weight: bold;
            color: #28a745;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            color: #2d3748;
            font-weight: 600;
            margin-bottom: 8px;
        }

        .form-group select,
        .form-group textarea {
            width: 100%;
            padding: 12px;
            border: 2px solid #e2e8f0;
            border-radius: 8px;
            font-size: 15px;
            font-family: inherit;
            transition: border-color 0.3s;
        }

        .form-group select:focus,
        .form-group textarea:focus {
            outline: none;
            border-color: #dc3545;
        }

        .form-group textarea {
            resize: vertical;
            min-height: 100px;
        }

        .status-info {
            background: #fff3cd;
            border-left: 4px solid #ffc107;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        .status-info p {
            color: #856404;
            font-size: 14px;
            margin: 0;
        }

        .current-status {
            background: #e7f3ff;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        .current-status strong {
            color: #2d3748;
            display: block;
            margin-bottom: 8px;
        }

        .status-badge {
            display: inline-block;
            padding: 8px 16px;
            border-radius: 20px;
            font-weight: 600;
            font-size: 14px;
        }

        .status-excellent { background: #d4edda; color: #155724; }
        .status-good { background: #d1ecf1; color: #0c5460; }
        .status-satisfactory { background: #fff3cd; color: #856404; }
        .status-needs-improvement { background: #ffe5d0; color: #974c00; }
        .status-poor { background: #f8d7da; color: #842029; }
        .status-not-set { background: #e9ecef; color: #495057; }

        .submit-btn {
            width: 100%;
            background: linear-gradient(135deg, #dc3545, #c82333);
            color: white;
            padding: 15px;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
        }

        .submit-btn:hover {
            background: linear-gradient(135deg, #c82333, #bd2130);
            transform: translateY(-2px);
        }

        @media (max-width: 968px) {
            .content-wrapper {
                grid-template-columns: 1fr;
            }

            .student-info-grid {
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
            <h1><i class="fas fa-user-edit"></i>Update Student Status</h1>
            <a href="{{ route('admin.student-reports.index') }}" class="back-btn">
                <i class="fas fa-arrow-left"></i> Back to Reports
            </a>
        </div>

        <div class="content-wrapper">
            <div class="card">
                <h2><i class="fas fa-user-graduate"></i> Student Information</h2>
                
                <div class="student-info-grid">
                    <div class="info-item">
                        <div class="info-label">Full Name</div>
                        <div class="info-value">{{ $student->full_name }}</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Admission Number</div>
                        <div class="info-value">{{ $student->admission_number }}</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Class</div>
                        <div class="info-value">{{ $student->student_class }}</div>
                    </div>
                    <div class="info-item">
                        <div class="info-label">Email</div>
                        <div class="info-value">{{ $student->student_email ?? 'N/A' }}</div>
                    </div>
                </div>

                <h2><i class="fas fa-chart-line"></i> Academic Performance</h2>

                <div class="overall-stats">
                    <h3>Overall Average</h3>
                    <div class="score">{{ $overallAverage }}% (Grade {{ $overallGrade }})</div>
                </div>

                <ul class="subject-list">
                    @foreach($subjects as $subjectName => $subject)
                        @if($subject)
                            <li class="subject-item">
                                <span class="subject-name">{{ $subjectName }}</span>
                                <span class="subject-score">{{ $subject->marks_obtained }}%</span>
                            </li>
                        @endif
                    @endforeach
                </ul>
            </div>

            <div class="card">
                <h2><i class="fas fa-tasks"></i> Set Academic Status</h2>

                @if($student->academic_status)
                    <div class="current-status">
                        <strong>Current Status:</strong>
                        <span class="status-badge status-{{ strtolower(str_replace(' ', '-', $student->academic_status)) }}">
                            {{ $student->academic_status }}
                        </span>
                        @if($student->status_remarks)
                            <p style="margin-top: 10px; color: #4a5568; font-size: 14px;">
                                <strong>Remarks:</strong> {{ $student->status_remarks }}
                            </p>
                        @endif
                    </div>
                @endif

                <div class="status-info">
                    <p><i class="fas fa-info-circle"></i> This status will be visible to the student in their portal.</p>
                </div>

                <form action="{{ route('admin.student-reports.update', $student->student_id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="form-group">
                        <label for="academic_status">
                            <i class="fas fa-star"></i> Academic Status *
                        </label>
                        <select name="academic_status" id="academic_status" required>
                            <option value="">-- Select Status --</option>
                            <option value="Excellent" {{ old('academic_status', $student->academic_status) == 'Excellent' ? 'selected' : '' }}>
                                Excellent
                            </option>
                            <option value="Good" {{ old('academic_status', $student->academic_status) == 'Good' ? 'selected' : '' }}>
                                Good
                            </option>
                            <option value="Satisfactory" {{ old('academic_status', $student->academic_status) == 'Satisfactory' ? 'selected' : '' }}>
                                Satisfactory
                            </option>
                            <option value="Needs Improvement" {{ old('academic_status', $student->academic_status) == 'Needs Improvement' ? 'selected' : '' }}>
                                Needs Improvement
                            </option>
                            <option value="Poor" {{ old('academic_status', $student->academic_status) == 'Poor' ? 'selected' : '' }}>
                                Poor
                            </option>
                        </select>
                        @error('academic_status')
                            <span style="color: #dc3545; font-size: 13px;">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="status_remarks">
                            <i class="fas fa-comment"></i> Remarks (Optional)
                        </label>
                        <textarea 
                            name="status_remarks" 
                            id="status_remarks" 
                            placeholder="Add any remarks or comments about the student's performance..."
                        >{{ old('status_remarks', $student->status_remarks) }}</textarea>
                        @error('status_remarks')
                            <span style="color: #dc3545; font-size: 13px;">{{ $message }}</span>
                        @enderror
                    </div>

                    <button type="submit" class="submit-btn">
                        <i class="fas fa-save"></i> Update Status
                    </button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>