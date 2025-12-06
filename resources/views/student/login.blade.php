<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Student Login Page</title>
        <style>
            body {
                font-family: Arial, sans-serif;
                background: #eef1f5;
                margin: 0;
                padding: 0;
                display: flex;
                justify-content: center;
                align-items: center;
                min-height: 100vh; 
                overflow: hidden; 
            }

            .login-container {
                max-width: 350px; 
                background: #fff;
                padding: 40px 30px; 
                border-radius: 12px;
                box-shadow: 0 4px 20px rgba(0,0,0,0.1);
                width: 90%; 
                text-align: center;
            }

            h2 {
                text-align: center;
                margin-bottom: 25px; 
                font-size: 24px;
                color: #4285f4; 
            }

            .input-box {
                display: flex;
                flex-direction: column;
                margin-bottom: 20px;
                text-align: left;
            }

            label {
                font-weight: 600;
                margin-bottom: 6px;
                color: #555;
                font-size: 14px;
            }

            input {
                width: 100%;
                padding: 10px; 
                border: 1px solid #bbb;
                border-radius: 6px;
                box-sizing: border-box; 
                font-size: 14px; 
                transition: 0.2s ease-in-out;
            }

            input:focus {
                border-color: #4285f4;
                box-shadow: 0 0 4px rgba(66,133,244,0.4);
                outline: none;
            }

            .forgot-password {
                text-align: right;
                margin-bottom: 20px;
                font-size: 12px;
            }

            .forgot-password a {
                color: #4285f4;
                text-decoration: none;
            }
            
            .forgot-password a:hover {
                text-decoration: underline;
            }

            button {
                width: 100%;
                padding: 12px; 
                background: #4285f4;
                color: white;
                border: none;
                border-radius: 6px;
                font-size: 16px; 
                cursor: pointer;
                margin-top: 10px; 
                transition: 0.2s ease-in-out;
            }

            button:hover {
                background: #3274d6;
            }

            .register-link {
                margin-top: 25px;
                font-size: 14px;
            }

            .register-link a {
                color: #4285f4;
                text-decoration: none;
                font-weight: 600;
            }

            .register-link a:hover {
                text-decoration: underline;
            }

            .alert-error {
                color: #d9534f;
                background-color: #f2dede;
                border: 1px solid #ebccd1;
                padding: 10px;
                border-radius: 4px;
                margin-bottom: 15px;
            }
            
            .alert-success {
                color: #3c763d;
                background-color: #dff0d8;
                border: 1px solid #d6e9c6;
                padding: 10px;
                border-radius: 4px;
                margin-bottom: 15px;
            }
        </style>
    </head>
    <body>

        <div class="login-container">
            <h2>Student Login</h2>
            @if(session('success'))
                <div class="alert-success">
                    {{ session('success') }}
                </div>
            @endif
            @error('admissionNumber')
                <div class="alert-error">
                    {{ $message }}
                </div>
            @enderror
            <form action="{{ route('student.login.attempt') }}" method="POST"> 
                @csrf 

                <div class="input-box">
                    <label for="admissionNumber">Admission Number</label>
                    <input type="text" id="admissionNumber" name="admissionNumber" required value="{{ old('admissionNumber') }}">
                </div>

                <div class="input-box">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" required>
                </div>
                
                <div class="forgot-password">
                    <a href="#">Forgot Password?</a>
                </div>

                <button type="submit">Log In</button>

            </form>

            <div class="register-link">
                Don't have an account? <a href="{{ route('student.register') }}">Register here</a>
            </div>
        </div>

    </body>
</html>
