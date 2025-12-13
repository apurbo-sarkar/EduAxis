<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Admin Login Page</title>
        <style>
            /* --- General Styles --- */
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
                max-width: 380px; /* Slightly wider container for more fields if needed */
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
                font-size: 26px; /* Slightly larger heading */
                color: #dc3545; /* Changed color to red/danger for admin theme */
            }

            /* --- Input Styles --- */
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
                border-color: #dc3545; /* Admin focus color */
                box-shadow: 0 0 4px rgba(220,53,69,0.4);
                outline: none;
            }

            /* --- Links --- */
            .forgot-password {
                text-align: right;
                margin-bottom: 20px;
                font-size: 12px;
            }

            .forgot-password a {
                color: #dc3545; /* Admin link color */
                text-decoration: none;
            }
            
            .forgot-password a:hover {
                text-decoration: underline;
            }

            /* --- Button Styles --- */
            button {
                width: 100%;
                padding: 12px; 
                background: #dc3545; /* Admin button color (Red/Danger) */
                color: white;
                border: none;
                border-radius: 6px;
                font-size: 16px; 
                cursor: pointer;
                margin-top: 10px; 
                transition: 0.2s ease-in-out;
            }

            button:hover {
                background: #c82333; /* Darker red on hover */
            }

            /* --- Register Link --- */
            .register-link {
                margin-top: 25px;
                font-size: 14px;
            }

            .register-link a {
                color: #dc3545; /* Admin link color */
                text-decoration: none;
                font-weight: 600;
            }

            .register-link a:hover {
                text-decoration: underline;
            }

            /* --- Alert Styles --- */
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
            <h2>Admin Login</h2>
            
            @if(session('success'))
                <div class="alert-success">
                    {{ session('success') }}
                </div>
            @endif
            
            {{-- Error Handling for Admin: Using generic 'email' error for login --}}
            @error('email') 
                <div class="alert-error">
                    {{ $message }}
                </div>
            @enderror
            
            {{-- Form action updated for Admin login route --}}
            <form action="{{ route('admin.login.attempt') }}" method="POST"> 
                @csrf 

                {{-- Admin Name Field (Optional for strict login, but included per request) --}}
                <div class="input-box">
                    <label for="name">Name</label>
                    <input type="text" id="name" name="name" required value="{{ old('name') }}">
                </div>
                
                {{-- Email Field (Common login identifier for Admin) --}}
                <div class="input-box">
                    <label for="email">Email Address</label>
                    <input type="email" id="email" name="email" required value="{{ old('email') }}">
                </div>
                
                {{-- Phone Field (Optional for strict login, but included per request) --}}
                <div class="input-box">
                    <label for="phone">Phone Number</label>
                    <input type="text" id="phone" name="phone" value="{{ old('phone') }}">
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
                Don't have an admin account? <a href="{{ route('admin.register') }}">Register here</a>
            </div>
        </div>

    </body>
</html>