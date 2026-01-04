<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Student</title>
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
            max-width: 900px;
        }
        .section-title {
            color: #dc3545;
            border-bottom: 2px solid #dc3545;
            padding-bottom: 10px;
            margin-bottom: 20px;
            font-size: 18px;
            font-weight: 600;
        }
        .btn-primary {
            background: linear-gradient(135deg, #dc3545, #c82333);
            border: none;
        }
        .btn-primary:hover {
            background: linear-gradient(135deg, #c82333, #bd2130);
        }
        .form-label {
            font-weight: 500;
            color: #2d3748;
        }
        .required-field::after {
            content: " *";
            color: #dc3545;
        }
    </style>
</head>
<body>
    <div class="container-custom">
        <!-- Header -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2><i class="fas fa-user-plus text-danger"></i> Add New Student</h2>
                <p class="text-muted mb-0">Fill in the student information below</p>
            </div>
            <a href="{{ route('admin.students.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Back to List
            </a>
        </div>

        <!-- Error Display -->
        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <h5><i class="fas fa-exclamation-triangle"></i> Please fix the following errors:</h5>
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <form action="{{ route('admin.students.store') }}" method="POST">
            @csrf

            <!-- Personal Information -->
            <div class="section-title">
                <i class="fas fa-user"></i> Personal Information
            </div>
            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label required-field">Full Name</label>
                    <input type="text" name="full_name" class="form-control @error('full_name') is-invalid @enderror" 
                           value="{{ old('full_name') }}" required>
                    @error('full_name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label required-field">Admission Number</label>
                    <input type="text" name="admission_number" class="form-control @error('admission_number') is-invalid @enderror" 
                           value="{{ old('admission_number') }}" required>
                    @error('admission_number')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-4">
                    <label class="form-label required-field">Date of Birth</label>
                    <input type="date" name="date_of_birth" class="form-control @error('date_of_birth') is-invalid @enderror" 
                           value="{{ old('date_of_birth') }}" required>
                    @error('date_of_birth')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-4">
                    <label class="form-label required-field">Gender</label>
                    <select name="gender" class="form-select @error('gender') is-invalid @enderror" required>
                        <option value="">Select Gender</option>
                        <option value="Male" {{ old('gender') == 'Male' ? 'selected' : '' }}>Male</option>
                        <option value="Female" {{ old('gender') == 'Female' ? 'selected' : '' }}>Female</option>
                        <option value="Other" {{ old('gender') == 'Other' ? 'selected' : '' }}>Other</option>
                    </select>
                    @error('gender')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-4">
                    <label class="form-label">Blood Group</label>
                    <input type="text" name="blood_group" class="form-control @error('blood_group') is-invalid @enderror" 
                           value="{{ old('blood_group') }}" placeholder="e.g., A+, O-">
                    @error('blood_group')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <!-- Academic Information -->
            <div class="section-title mt-4">
                <i class="fas fa-graduation-cap"></i> Academic Information
            </div>
            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label required-field">Class</label>
                    <input type="text" name="student_class" class="form-control @error('student_class') is-invalid @enderror" 
                           value="{{ old('student_class') }}" placeholder="e.g., Grade 1, Grade 5" required>
                    @error('student_class')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label">Academic Status</label>
                    <select name="academic_status" class="form-select @error('academic_status') is-invalid @enderror">
                        <option value="Active" {{ old('academic_status') == 'Active' ? 'selected' : '' }}>Active</option>
                        <option value="Inactive" {{ old('academic_status') == 'Inactive' ? 'selected' : '' }}>Inactive</option>
                        <option value="Suspended" {{ old('academic_status') == 'Suspended' ? 'selected' : '' }}>Suspended</option>
                        <option value="Graduated" {{ old('academic_status') == 'Graduated' ? 'selected' : '' }}>Graduated</option>
                    </select>
                    @error('academic_status')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="mb-3">
                <label class="form-label">Status Remarks</label>
                <textarea name="status_remarks" class="form-control @error('status_remarks') is-invalid @enderror" 
                          rows="2">{{ old('status_remarks') }}</textarea>
                @error('status_remarks')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Contact Information -->
            <div class="section-title mt-4">
                <i class="fas fa-envelope"></i> Contact Information
            </div>
            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label required-field">Student Email</label>
                    <input type="email" name="student_email" class="form-control @error('student_email') is-invalid @enderror" 
                           value="{{ old('student_email') }}" required>
                    @error('student_email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label">Address</label>
                    <input type="text" name="address" class="form-control @error('address') is-invalid @enderror" 
                           value="{{ old('address') }}">
                    @error('address')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <!-- Login Credentials -->
            <div class="section-title mt-4">
                <i class="fas fa-key"></i> Login Credentials
            </div>
            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label required-field">Password</label>
                    <input type="password" name="password" class="form-control @error('password') is-invalid @enderror" required>
                    @error('password')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <small class="text-muted">Minimum 8 characters</small>
                </div>
                <div class="col-md-6">
                    <label class="form-label required-field">Confirm Password</label>
                    <input type="password" name="password_confirmation" class="form-control" required>
                </div>
            </div>

            <!-- Parent/Guardian Information -->
            <div class="section-title mt-4">
                <i class="fas fa-users"></i> Parent/Guardian Information
            </div>
            <div class="row mb-3">
                <div class="col-md-4">
                    <label class="form-label required-field">Parent 1 Name</label>
                    <input type="text" name="parent1_name" class="form-control @error('parent1_name') is-invalid @enderror" 
                           value="{{ old('parent1_name') }}" required>
                    @error('parent1_name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-4">
                    <label class="form-label required-field">Parent 1 Phone</label>
                    <input type="text" name="parent1_phone" class="form-control @error('parent1_phone') is-invalid @enderror" 
                           value="{{ old('parent1_phone') }}" required>
                    @error('parent1_phone')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-4">
                    <label class="form-label">Parent 1 Email</label>
                    <input type="email" name="parent1_email" class="form-control @error('parent1_email') is-invalid @enderror" 
                           value="{{ old('parent1_email') }}">
                    @error('parent1_email')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label">Parent 2 Name</label>
                    <input type="text" name="parent2_name" class="form-control @error('parent2_name') is-invalid @enderror" 
                           value="{{ old('parent2_name') }}">
                    @error('parent2_name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label">Parent 2 Phone</label>
                    <input type="text" name="parent2_phone" class="form-control @error('parent2_phone') is-invalid @enderror" 
                           value="{{ old('parent2_phone') }}">
                    @error('parent2_phone')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <!-- Emergency Contact -->
            <div class="section-title mt-4">
                <i class="fas fa-phone-alt"></i> Emergency Contact
            </div>
            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label">Emergency Contact Name</label>
                    <input type="text" name="emergency_contact_name" class="form-control @error('emergency_contact_name') is-invalid @enderror" 
                           value="{{ old('emergency_contact_name') }}">
                    @error('emergency_contact_name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
                <div class="col-md-6">
                    <label class="form-label">Emergency Contact Phone</label>
                    <input type="text" name="emergency_contact_phone" class="form-control @error('emergency_contact_phone') is-invalid @enderror" 
                           value="{{ old('emergency_contact_phone') }}">
                    @error('emergency_contact_phone')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <!-- Medical Information -->
            <div class="section-title mt-4">
                <i class="fas fa-notes-medical"></i> Medical Information
            </div>
            <div class="mb-3">
                <label class="form-label">Medical Notes</label>
                <textarea name="medical_notes" class="form-control @error('medical_notes') is-invalid @enderror" 
                          rows="3" placeholder="Allergies, medications, special needs, etc.">{{ old('medical_notes') }}</textarea>
                @error('medical_notes')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <!-- Submit Buttons -->
            <div class="d-flex justify-content-between mt-4">
                <a href="{{ route('admin.students.index') }}" class="btn btn-secondary">
                    <i class="fas fa-times"></i> Cancel
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Create Student
                </button>
            </div>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>