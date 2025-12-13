<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Admin Registration Form</title>

        <style>
            /* --- Base Styles (Kept the same for consistent look) --- */
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
                max-width: 500px; /* Reduced width slightly for fewer fields */
                background: #fff;
                padding: 25px; 
                margin: 10px auto; 
                border-radius: 12px;
                box-shadow: 0 4px 20px rgba(0,0,0,0.1);
                width: 95%; 
                max-height: 90vh; 
                overflow-y: auto; 
            }

            h2 {
                text-align: center;
                margin-bottom: 20px; 
                font-size: 22px; 
                color: #dc3545; /* Changed color to Admin theme color (Red/Danger) */
            }

            h3 {
                margin-top: 20px; 
                margin-bottom: 8px; 
                color: #dc3545; /* Changed color to Admin theme color */
                border-bottom: 1px solid #eef1f5;
                padding-bottom: 4px;
                font-size: 16px; 
            }

            .grid {
                display: grid;
                grid-template-columns: 1fr; /* Single column layout is fine for a few fields */
                gap: 15px; /* Increased gap for better spacing */
                margin-bottom: 15px; 
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
                font-size: 13px; 
                margin-top: 15px; 
            }

            .checkbox-label input[type="checkbox"] {
                width: auto; 
                margin-right: 8px; 
            }

            input, select, textarea {
                width: 100%;
                padding: 8px; 
                border: 1px solid #bbb;
                border-radius: 4px; 
                box-sizing: border-box; 
                font-size: 13px; 
            }

            input:focus, select:focus, textarea:focus {
                border-color: #dc3545; /* Admin focus color */
                box-shadow: 0 0 3px rgba(220,53,69,0.4); 
                outline: none; 
            }

            button {
                width: 100%;
                padding: 10px; 
                background: #dc3545; /* Admin button color (Red/Danger) */
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
                background: #c82333; /* Darker red on hover */
            }

            .login-link {
                margin-top: 10px; 
                text-align: center;
                font-size: 13px; 
            }

            .login-link a {
                color: #dc3545; /* Admin link color */
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
            <h2>Admin Registration Form</h2>

            <form action="{{ route('admin.register.store') }}" method="POST"> 
                @csrf
                <h3>Administrator Details</h3>

                <div class="grid">
                    <div class="input-box">
                        <label for="fullName">Full Name</label>
                        <input type="text" id="fullName" name="fullName" required value="{{ old('fullName') }}">
                        @error('fullName')<span class="error-message">{{ $message }}</span>@enderror
                    </div>

                    <div class="input-box">
                        <label for="adminId">Employee/Admin ID</label>
                        <input type="text" id="adminId" name="adminId" required value="{{ old('adminId') }}">
                        @error('adminId')<span class="error-message">{{ $message }}</span>@enderror
                    </div>
                </div>

                <div class="grid">
                    <div class="input-box">
                        <label for="email">Work Email</label>
                        <input type="email" id="email" name="email" required value="{{ old('email') }}">
                        @error('email')<span class="error-message">{{ $message }}</span>@enderror
                    </div>
                </div>

                <div class="grid">
                    <div class="input-box">
                        <label for="phone">Phone Number</label>
                        <input type="tel" id="phone" name="phone" value="{{ old('phone') }}">
                        @error('phone')<span class="error-message">{{ $message }}</span>@enderror
                    </div>
                    
                    <div class="input-box">
                        <label for="role">Role / Department</label>
                        <select id="role" name="role" required>
                            <option value="">-- Select Role --</option>
                            <option value="administrator" {{ old('role') == 'administrator' ? 'selected' : '' }}>Administrator</option>
                            <option value="registrar" {{ old('role') == 'registrar' ? 'selected' : '' }}>Registrar</option>
                            <option value="finance" {{ old('role') == 'finance' ? 'selected' : '' }}>Finance</option>
                            <option value="it_support" {{ old('role') == 'it_support' ? 'selected' : '' }}>IT Support</option>
                        </select>
                        @error('role')<span class="error-message">{{ $message }}</span>@enderror
                    </div>
                </div>
                
                <div class="grid">
                    <div class="input-box">
                        <label for="password">Password</label>
                        <input type="password" id="password" name="password" required>
                        @error('password')<span class="error-message">{{ $message }}</span>@enderror
                    </div>

                    <div class="input-box">
                        <label for="password_confirmation">Confirm Password</label>
                        <input type="password" id="password_confirmation" name="password_confirmation" required>
                    </div>
                </div>
                
                <div class="grid">
                    <div class="input-box" style="grid-column: 1 / 3;">
                        <label for="address">Office Address (Optional)</label>
                        <textarea id="address" name="address">{{ old('address') }}</textarea>
                        @error('address')<span class="error-message">{{ $message }}</span>@enderror
                    </div>
                </div>


                <div class="input-box">
                    <label class="checkbox-label">
                        <input type="checkbox" name="terms" value="1" required {{ old('terms') ? 'checked' : '' }}>
                        I confirm this information is correct and I accept the terms of use.
                    </label>
                    @error('terms')<span class="error-message">{{ $message }}</span>@enderror
                </div>


                <button type="submit">Register Admin Account</button>
                
                <div class="login-link">
                    Already have an account? <a href="{{ route('admin.login') }}">Log In here</a>
                </div>

            </form>
        </div>

    </body>
</html>