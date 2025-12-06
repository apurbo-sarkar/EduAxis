<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Student Registration Form</title>

        <style>
            body {
                font-family: Arial, sans-serif;
                background: #eef1f5;
                margin: 0;
                padding: 10px; 
                display: flex; 
                justify-content: center;
                align-items: center;
                min-height: 100vh; 
            }

            .container {
                max-width: 650px; 
                background: #fff;
                padding: 20px; 
                margin: 10px auto; 
                border-radius: 12px;
                box-shadow: 0 4px 20px rgba(0,0,0,0.1);
                width: 95%; 
                max-height: 90vh; 
                overflow-y: auto; 
            }

            h2 {
                text-align: center;
                margin-bottom: 15px; 
                font-size: 20px; 
                color: #333;
            }

            h3 {
                margin-top: 20px; 
                margin-bottom: 8px; 
                color: #4285f4;
                border-bottom: 1px solid #eef1f5;
                padding-bottom: 4px;
                font-size: 16px; 
            }

            .grid {
                display: grid;
                grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); 
                gap: 10px; 
                margin-bottom: 10px; 
            }

            .input-box {
                display: flex;
                flex-direction: column;
            }

            label {
                font-weight: 600;
                margin-bottom: 3px; 
                color: #555;
                font-size: 13px; 
            }

            .checkbox-label {
                display: flex;
                align-items: center;
                font-weight: normal; 
                color: #333;
                margin-bottom: 0;
                font-size: 13px; 
                margin-top: 15px; 
            }

            .checkbox-label input[type="checkbox"] {
                width: auto; 
                margin-right: 8px; 
            }

            input, select, textarea {
                width: 100%;
                padding: 7px; 
                border: 1px solid #bbb;
                border-radius: 4px; 
                box-sizing: border-box; 
                font-size: 13px; 
            }

            textarea {
                resize: none;
                height: 50px; 
            }

            input:focus, select:focus, textarea:focus {
                border-color: #4285f4;
                box-shadow: 0 0 3px rgba(66,133,244,0.4); 
                outline: none; 
            }

            button {
                width: 100%;
                padding: 10px; 
                background: #4285f4;
                color: white;
                border: none;
                border-radius: 4px; 
                font-size: 14px; 
                cursor: pointer;
                margin-top: 15px; 
                letter-spacing: 0.3px;
                transition: 0.2s ease-in-out;
            }

            button:hover {
                background: #3274d6;
            }

            .login-link {
                margin-top: 10px; 
                text-align: center;
                font-size: 13px; 
            }

            .login-link a {
                color: #4285f4;
                text-decoration: none;
                font-weight: 600;
            }

            .login-link a:hover {
                text-decoration: underline;
            }
            .error-message {
                color: #d9534f;
                font-size: 11px;
                margin-top: 3px;
                display: block;
            }
        </style>
    </head>
    <body>

        <div class="container">
            <h2>Student Registration Form</h2>

            <form action="{{ route('student.register.store') }}" method="POST" id="registrationForm"> 
                @csrf
                <h3>Student Details</h3>

                <div class="grid">
                    <div class="input-box">
                        <label for="fullName">Full Name</label>
                        <input type="text" id="fullName" name="fullName" required value="{{ old('fullName') }}">
                        @error('fullName')<span class="error-message">{{ $message }}</span>@enderror
                    </div>

                    <div class="input-box">
                        <label for="admissionNumber">Admission Number</label>
                        <input type="text" id="admissionNumber" name="admissionNumber" value="{{ old('admissionNumber') }}">
                        @error('admissionNumber')<span class="error-message">{{ $message }}</span>@enderror
                    </div>
                </div>

                <div class="grid">
                    <div class="input-box">
                        <label for="dob">Date of Birth</label>
                        <input type="date" id="dob" name="dob" required value="{{ old('dob') }}">
                        @error('dob')<span class="error-message">{{ $message }}</span>@enderror
                    </div>

                    <div class="input-box">
                        <label for="gender">Gender</label>
                        <select id="gender" name="gender" required>
                            <option value="">-- Select Gender --</option>
                            <option value="Male" {{ old('gender') == 'Male' ? 'selected' : '' }}>Male</option>
                            <option value="Female" {{ old('gender') == 'Female' ? 'selected' : '' }}>Female</option>
                            <option value="Other" {{ old('gender') == 'Other' ? 'selected' : '' }}>Other</option>
                        </select>
                        @error('gender')<span class="error-message">{{ $message }}</span>@enderror
                    </div>
                </div>

                <div class="grid">
                    <div class="input-box">
                        <label for="studentClass">Class/Grade</label>
                        <select id="studentClass" name="studentClass" required>
                            <option value="">Select Grade</option>
                            @for ($i = 1; $i <= 12; $i++)
                                <option value="{{ $i }}" {{ old('studentClass') == $i ? 'selected' : '' }}>Grade {{ $i }}</option>
                            @endfor
                        </select>
                        @error('studentClass')<span class="error-message">{{ $message }}</span>@enderror
                    </div>
                    <div class="input-box">
                        <label for="password">Password</label>
                        <input type="password" id="password" name="password" required>
                        @error('password')<span class="error-message">{{ $message }}</span>@enderror
                    </div>
                </div>
                <div class="grid">
                    <div class="input-box" style="grid-column: 1 / 3;">
                        <label for="password_confirmation">Confirm Password</label>
                        <input type="password" id="password_confirmation" name="password_confirmation" required>
                    </div>
                </div>

                <div class="grid">
                    <div class="input-box">
                        <label for="bloodGroup">Blood Group (e.g., A+)</label>
                        <input type="text" id="bloodGroup" name="bloodGroup" value="{{ old('bloodGroup') }}">
                        @error('bloodGroup')<span class="error-message">{{ $message }}</span>@enderror
                    </div>

                    <div class="input-box">
                        <label for="email">Student Email (Optional)</label>
                        <input type="email" id="email" name="email" value="{{ old('email') }}">
                        @error('email')<span class="error-message">{{ $message }}</span>@enderror
                    </div>
                </div>
                
                <h3>Parent/Guardian 1 (Primary)</h3>

                <div class="grid">
                    <div class="input-box">
                        <label for="parent1Name">Full Name</label>
                        <input type="text" id="parent1Name" name="parent1Name" required value="{{ old('parent1Name') }}">
                        @error('parent1Name')<span class="error-message">{{ $message }}</span>@enderror
                    </div>
                    <div class="input-box">
                        <label for="parent1Phone">Phone Number</label>
                        <input type="tel" id="parent1Phone" name="parent1Phone" required value="{{ old('parent1Phone') }}">
                        @error('parent1Phone')<span class="error-message">{{ $message }}</span>@enderror
                    </div>
                    <div class="input-box" style="grid-column: 1 / 3;">
                        <label for="parent1Email">Email</label>
                        <input type="email" id="parent1Email" name="parent1Email" required value="{{ old('parent1Email') }}">
                        @error('parent1Email')<span class="error-message">{{ $message }}</span>@enderror
                    </div>
                </div>
                
                <h3>Parent/Guardian 2 (Secondary)</h3>
                
                <div class="grid">
                    <div class="input-box">
                        <label for="parent2Name">Full Name (Optional)</label>
                        <input type="text" id="parent2Name" name="parent2Name" value="{{ old('parent2Name') }}">
                        @error('parent2Name')<span class="error-message">{{ $message }}</span>@enderror
                    </div>
                    <div class="input-box">
                        <label for="parent2Phone">Phone Number (Optional)</label>
                        <input type="tel" id="parent2Phone" name="parent2Phone" value="{{ old('parent2Phone') }}">
                        @error('parent2Phone')<span class="error-message">{{ $message }}</span>@enderror
                    </div>
                </div>
                
                <h3>Address & Medical Information</h3>

                <div class="grid">
                    <div class="input-box" style="grid-column: 1 / 3;">
                        <label for="address">Address</label>
                        <textarea id="address" name="address" required>{{ old('address') }}</textarea>
                        @error('address')<span class="error-message">{{ $message }}</span>@enderror
                    </div>
                </div>

                <div class="grid">
                    <div class="input-box">
                        <label for="emergencyName">Emergency Contact Name</label>
                        <input type="text" id="emergencyName" name="emergencyName" required value="{{ old('emergencyName') }}">
                        @error('emergencyName')<span class="error-message">{{ $message }}</span>@enderror
                    </div>
                    <div class="input-box">
                        <label for="emergencyPhone">Emergency Contact Phone</label>
                        <input type="tel" id="emergencyPhone" name="emergencyPhone" required value="{{ old('emergencyPhone') }}">
                        @error('emergencyPhone')<span class="error-message">{{ $message }}</span>@enderror
                    </div>
                </div>
                
                <div class="grid">
                    <div class="input-box" style="grid-column: 1 / 3;">
                        <label for="medicalNotes">Medical Notes/Allergies (Optional)</label>
                        <textarea id="medicalNotes" name="medicalNotes">{{ old('medicalNotes') }}</textarea>
                        @error('medicalNotes')<span class="error-message">{{ $message }}</span>@enderror
                    </div>
                </div>

                <div class="input-box">
                    <label class="checkbox-label">
                        <input type="checkbox" name="terms" value="1" required {{ old('terms') ? 'checked' : '' }}>
                        I agree to the terms and conditions.
                    </label>
                    @error('terms')<span class="error-message">{{ $message }}</span>@enderror
                </div>


                <button type="submit">Register Student</button>
                
                <div class="login-link">
                    Already registered? <a href="{{ route('student.login') }}">Log In here</a>
                </div>

            </form>
        </div>

    </body>
</html>
