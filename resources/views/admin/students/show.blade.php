<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Details</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 20px;
        }
        .container-custom {
            background: white;
            border-radius: 15px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.1);
            padding: 40px;
            margin: 20px auto;
            max-width: 1000px;
        }
        .section-title {
            color: #dc3545;
            border-bottom: 2px solid #dc3545;
            padding-bottom: 10px;
            margin-bottom: 20px;
            margin-top: 30px;
            font-size: 18px;
            font-weight: 600;
        }
        .info-row {
            display: flex;
            padding: 12px 0;
            border-bottom: 1px solid #e9ecef;
        }
        .info-label {
            font-weight: 600;
            color: #495057;
            width: 200px;
            flex-shrink: 0;
        }
        .info-value {
            color: #212529;
        }
        .profile-header {
            background: linear-gradient(135deg, #dc3545, #c82333);
            color: white;
            padding: 30px;
            border-radius: 10px;
            margin-bottom: 30px;
            text-align: center;
        }
        .profile-icon {
            font-size: 80px;
            margin-bottom: 15px;
        }
        .badge-active {
            background-color: #28a745;
        }
        .badge-inactive {
            background-color: #6c757d;
        }
        .badge-suspended {
            background-color: #dc3545;
        }
        .badge-graduated {
            background-color: #17a2b8;
        }
    </style>
</head>
<body>
    <div class="container-custom">
        <!-- Header with Actions -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2><i class="fas fa-user-circle text-danger"></i> Student Details</h2>
            <div>
                <a href="{{ route('admin.students.edit', $student->student_id) }}" class="btn btn-warning me-2">
                    <i class="fas fa-edit"></i> Edit
                </a>
                <a href="{{ route('admin.students.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i> Back to List
                </a>
            </div>
        </div>

        <!-- Profile Header -->
        <div class="profile-header">
            <i class="fas fa-user-circle profile-icon"></i>
            <h3>{{ $student->full_name }}</h3>
            <p class="mb-2"><strong>Admission No:</strong> {{ $student->admission_number }}</p>
            <p class="mb-0">
                @if($student->academic_status == 'Active')
                    <span class="badge badge-active fs-6">Active</span>
                @elseif($student->academic_status == 'Inactive')
                    <span class="badge badge-inactive fs-6">Inactive</span>
                @elseif($student->academic_status == 'Suspended')
                    <span class="badge badge-suspended fs-6">Suspended</span>
                @elseif($student->academic_status == 'Graduated')
                    <span class="badge badge-graduated fs-6">Graduated</span>
                @else
                    <span class="badge bg-secondary fs-6">Status Not Set</span>
                @endif
            </p>
        </div>

        <!-- Personal Information -->
        <div class="section-title">
            <i class="fas fa-user"></i> Personal Information
        </div>
        <div class="info-row">
            <div class="info-label">Full Name:</div>
            <div class="info-value">{{ $student->full_name }}</div>
        </div>
        <div class="info-row">
            <div class="info-label">Date of Birth:</div>
            <div class="info-value">{{ $student->date_of_birth->format('F d, Y') }} ({{ $student->date_of_birth->age }} years old)</div>
        </div>
        <div class="info-row">
            <div class="info-label">Gender:</div>
            <div class="info-value">{{ $student->gender }}</div>
        </div>
        <div class="info-row">
            <div class="info-label">Blood Group:</div>
            <div class="info-value">{{ $student->blood_group ?? 'Not specified' }}</div>
        </div>

        <!-- Academic Information -->
        <div class="section-title">
            <i class="fas fa-graduation-cap"></i> Academic Information
        </div>
        <div class="info-row">
            <div class="info-label">Admission Number:</div>
            <div class="info-value"><strong>{{ $student->admission_number }}</strong></div>
        </div>
        <div class="info-row">
            <div class="info-label">Class:</div>
            <div class="info-value"><span class="badge bg-info fs-6">{{ $student->student_class }}</span></div>
        </div>
        <div class="info-row">
            <div class="info-label">Academic Status:</div>
            <div class="info-value">
                @if($student->academic_status == 'Active')
                    <span class="badge badge-active">Active</span>
                @elseif($student->academic_status == 'Inactive')
                    <span class="badge badge-inactive">Inactive</span>
                @elseif($student->academic_status == 'Suspended')
                    <span class="badge badge-suspended">Suspended</span>
                @elseif($student->academic_status == 'Graduated')
                    <span class="badge badge-graduated">Graduated</span>
                @else
                    <span class="badge bg-secondary">Not Set</span>
                @endif
            </div>
        </div>
        @if($student->status_remarks)
        <div class="info-row">
            <div class="info-label">Status Remarks:</div>
            <div class="info-value">{{ $student->status_remarks }}</div>
        </div>
        @endif

        <!-- Contact Information -->
        <div class="section-title">
            <i class="fas fa-envelope"></i> Contact Information
        </div>
        <div class="info-row">
            <div class="info-label">Student Email:</div>
            <div class="info-value">
                <a href="mailto:{{ $student->student_email }}">{{ $student->student_email }}</a>
            </div>
        </div>
        <div class="info-row">
            <div class="info-label">Address:</div>
            <div class="info-value">{{ $student->address ?? 'Not specified' }}</div>
        </div>

        <!-- Parent/Guardian Information -->
        <div class="section-title">
            <i class="fas fa-users"></i> Parent/Guardian Information
        </div>
        <div class="info-row">
            <div class="info-label">Parent 1 Name:</div>
            <div class="info-value">{{ $student->parent1_name }}</div>
        </div>
        <div class="info-row">
            <div class="info-label">Parent 1 Phone:</div>
            <div class="info-value">
                <a href="tel:{{ $student->parent1_phone }}">{{ $student->parent1_phone }}</a>
            </div>
        </div>
        @if($student->parent1_email)
        <div class="info-row">
            <div class="info-label">Parent 1 Email:</div>
            <div class="info-value">
                <a href="mailto:{{ $student->parent1_email }}">{{ $student->parent1_email }}</a>
            </div>
        </div>
        @endif

        @if($student->parent2_name)
        <div class="info-row">
            <div class="info-label">Parent 2 Name:</div>
            <div class="info-value">{{ $student->parent2_name }}</div>
        </div>
        @endif
        @if($student->parent2_phone)
        <div class="info-row">
            <div class="info-label">Parent 2 Phone:</div>
            <div class="info-value">
                <a href="tel:{{ $student->parent2_phone }}">{{ $student->parent2_phone }}</a>
            </div>
        </div>
        @endif

        <!-- Emergency Contact -->
        @if($student->emergency_contact_name || $student->emergency_contact_phone)
        <div class="section-title">
            <i class="fas fa-phone-alt"></i> Emergency Contact
        </div>
        @if($student->emergency_contact_name)
        <div class="info-row">
            <div class="info-label">Emergency Contact Name:</div>
            <div class="info-value">{{ $student->emergency_contact_name }}</div>
        </div>
        @endif
        @if($student->emergency_contact_phone)
        <div class="info-row">
            <div class="info-label">Emergency Contact Phone:</div>
            <div class="info-value">
                <a href="tel:{{ $student->emergency_contact_phone }}">{{ $student->emergency_contact_phone }}</a>
            </div>
        </div>
        @endif
        @endif

        <!-- Medical Information -->
        @if($student->medical_notes)
        <div class="section-title">
            <i class="fas fa-notes-medical"></i> Medical Information
        </div>
        <div class="info-row">
            <div class="info-label">Medical Notes:</div>
            <div class="info-value">{{ $student->medical_notes }}</div>
        </div>
        @endif

        <!-- System Information -->
        <div class="section-title">
            <i class="fas fa-info-circle"></i> System Information
        </div>
        <div class="info-row">
            <div class="info-label">Student ID:</div>
            <div class="info-value">{{ $student->student_id }}</div>
        </div>
        <div class="info-row">
            <div class="info-label">Registered On:</div>
            <div class="info-value">{{ $student->created_at->format('F d, Y h:i A') }}</div>
        </div>
        <div class="info-row">
            <div class="info-label">Last Updated:</div>
            <div class="info-value">{{ $student->updated_at->format('F d, Y h:i A') }}</div>
        </div>

        <!-- Action Buttons -->
        <div class="d-flex justify-content-between mt-4 pt-3 border-top">
            <form action="{{ route('admin.students.destroy', $student->student_id) }}" method="POST" 
                  onsubmit="return confirm('Are you sure you want to delete this student? This action cannot be undone.');">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">
                    <i class="fas fa-trash"></i> Delete Student
                </button>
            </form>
            <div>
                <a href="{{ route('admin.students.edit', $student->student_id) }}" class="btn btn-warning">
                    <i class="fas fa-edit"></i> Edit Student
                </a>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>