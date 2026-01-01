<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Teacher</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f5f7fa;
            padding: 30px;
        }
        .container {
            max-width: 1000px;
            margin: 0 auto;
        }
        .header {
            background: white;
            padding: 25px 30px;
            border-radius: 15px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            margin-bottom: 30px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .header h1 {
            color: #2d3748;
            font-size: 26px;
        }
        .btn {
            padding: 10px 20px;
            border: none;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }
        .btn-secondary {
            background: #6c757d;
            color: white;
        }
        .btn-secondary:hover {
            background: #5a6268;
        }
        .btn-primary {
            background: #dc3545;
            color: white;
            font-size: 16px;
        }
        .btn-primary:hover {
            background: #c82333;
        }
        .form-container {
            background: white;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .form-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 20px;
        }
        .form-group {
            margin-bottom: 20px;
        }
        .form-group.full-width {
            grid-column: 1 / -1;
        }
        .form-group label {
            display: block;
            margin-bottom: 8px;
            color: #2d3748;
            font-weight: 600;
            font-size: 14px;
        }
        .form-group label .required {
            color: #dc3545;
        }
        .form-group input,
        .form-group select,
        .form-group textarea {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 14px;
            transition: border-color 0.3s;
        }
        .form-group input:focus,
        .form-group select:focus,
        .form-group textarea:focus {
            outline: none;
            border-color: #dc3545;
        }
        .form-group textarea {
            resize: vertical;
            min-height: 100px;
        }
        .error {
            color: #dc3545;
            font-size: 12px;
            margin-top: 5px;
        }
        .section-title {
            color: #2d3748;
            font-size: 18px;
            font-weight: 600;
            margin: 30px 0 20px 0;
            padding-bottom: 10px;
            border-bottom: 2px solid #e2e8f0;
            grid-column: 1 / -1;
        }
        .section-title:first-child {
            margin-top: 0;
        }
        .form-actions {
            margin-top: 30px;
            display: flex;
            gap: 15px;
            justify-content: flex-end;
        }
        .info-note {
            background: #e7f3ff;
            border-left: 4px solid #2196F3;
            padding: 12px;
            margin-bottom: 20px;
            border-radius: 4px;
            font-size: 14px;
            color: #1976D2;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1><i class="fas fa-user-edit"></i> Edit Teacher</h1>
            <a href="{{ route('admin.users.teachers') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Back
            </a>
        </div>

        <div class="form-container">
            <div class="info-note">
                <i class="fas fa-info-circle"></i> Leave password fields empty to keep the current password.
            </div>

            <form method="POST" action="{{ route('admin.users.teachers.update', $teacher->id) }}">
                @csrf
                @method('PUT')

                <div class="form-grid">
                    <div class="section-title">Basic Information</div>

                    <div class="form-group">
                        <label>Full Name <span class="required">*</span></label>
                        <input type="text" name="full_name" value="{{ old('full_name', $teacher->full_name) }}" required>
                        @error('full_name')
                            <div class="error">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label>Teacher ID <span class="required">*</span></label>
                        <input type="text" name="teacher_id" value="{{ old('teacher_id', $teacher->teacher_id) }}" required>
                        @error('teacher_id')
                            <div class="error">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label>Email <span class="required">*</span></label>
                        <input type="email" name="email" value="{{ old('email', $teacher->email) }}" required>
                        @error('email')
                            <div class="error">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label>Phone</label>
                        <input type="text" name="phone" value="{{ old('phone', $teacher->phone) }}">
                        @error('phone')
                            <div class="error">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label>Date of Birth</label>
                        <input type="date" name="date_of_birth" value="{{ old('date_of_birth', $teacher->date_of_birth?->format('Y-m-d')) }}">
                        @error('date_of_birth')
                            <div class="error">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label>Gender</label>
                        <select name="gender">
                            <option value="">Select Gender</option>
                            <option value="male" {{ old('gender', $teacher->gender) == 'male' ? 'selected' : '' }}>Male</option>
                            <option value="female" {{ old('gender', $teacher->gender) == 'female' ? 'selected' : '' }}>Female</option>
                            <option value="other" {{ old('gender', $teacher->gender) == 'other' ? 'selected' : '' }}>Other</option>
                        </select>
                        @error('gender')
                            <div class="error">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group full-width">
                        <label>Address</label>
                        <textarea name="address">{{ old('address', $teacher->address) }}</textarea>
                        @error('address')
                            <div class="error">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="section-title">Professional Information</div>

                    <div class="form-group">
                        <label>Department</label>
                        <input type="text" name="department" value="{{ old('department', $teacher->department) }}">
                        @error('department')
                            <div class="error">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label>Designation</label>
                        <input type="text" name="designation" value="{{ old('designation', $teacher->designation) }}">
                        @error('designation')
                            <div class="error">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label>Qualification</label>
                        <input type="text" name="qualification" value="{{ old('qualification', $teacher->qualification) }}">
                        @error('qualification')
                            <div class="error">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label>Joining Date</label>
                        <input type="date" name="joining_date" value="{{ old('joining_date', $teacher->joining_date?->format('Y-m-d')) }}">
                        @error('joining_date')
                            <div class="error">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label>Salary</label>
                        <input type="number" name="salary" value="{{ old('salary', $teacher->salary) }}" step="0.01" min="0">
                        @error('salary')
                            <div class="error">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label>Status <span class="required">*</span></label>
                        <select name="status" required>
                            <option value="active" {{ old('status', $teacher->status) == 'active' ? 'selected' : '' }}>Active</option>
                            <option value="inactive" {{ old('status', $teacher->status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
                            <option value="on_leave" {{ old('status', $teacher->status) == 'on_leave' ? 'selected' : '' }}>On Leave</option>
                        </select>
                        @error('status')
                            <div class="error">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="section-title">Change Password (Optional)</div>

                    <div class="form-group">
                        <label>New Password</label>
                        <input type="password" name="password">
                        @error('password')
                            <div class="error">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label>Confirm New Password</label>
                        <input type="password" name="password_confirmation">
                    </div>
                </div>

                <div class="form-actions">
                    <a href="{{ route('admin.users.teachers') }}" class="btn btn-secondary">Cancel</a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Update Teacher
                    </button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>