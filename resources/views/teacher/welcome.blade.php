<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Teacher Portal</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gradient-to-br from-blue-500 to-purple-600 min-h-screen flex items-center justify-center">

    <div class="max-w-4xl mx-auto px-4">
        
        <!-- Welcome Header -->
        <div class="text-center mb-12">
            <h1 class="text-5xl font-bold text-white mb-4">
                Welcome to Teacher Portal
            </h1>
            <p class="text-xl text-white opacity-90">
                Manage your teaching profile and access your dashboard
            </p>
        </div>

        @if (session('success'))
            <div class="mb-6 p-4 bg-green-100 text-green-800 border border-green-300 rounded-lg text-center">
                {{ session('success') }}
            </div>
        @endif

        <!-- Login and Register Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            
            <!-- Login Card -->
            <div class="bg-white rounded-2xl shadow-2xl p-8 transform hover:scale-105 transition duration-300">
                <div class="text-center mb-6">
                    <div class="bg-blue-100 w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-10 h-10 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
                        </svg>
                    </div>
                    <h2 class="text-3xl font-bold text-gray-800 mb-2">Sign In</h2>
                    <p class="text-gray-600">Already have an account?</p>
                </div>

                <a href="/teacher/login" 
                    class="block w-full bg-blue-600 text-white text-center py-4 rounded-lg hover:bg-blue-700 transition font-semibold text-lg">
                    Login to Your Account
                </a>

                <p class="text-center text-gray-500 text-sm mt-4">
                    Access your dashboard and manage your profile
                </p>
            </div>

            <!-- Register Card -->
            <div class="bg-white rounded-2xl shadow-2xl p-8 transform hover:scale-105 transition duration-300">
                <div class="text-center mb-6">
                    <div class="bg-purple-100 w-20 h-20 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-10 h-10 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path>
                        </svg>
                    </div>
                    <h2 class="text-3xl font-bold text-gray-800 mb-2">Register</h2>
                    <p class="text-gray-600">New to our platform?</p>
                </div>

                <a href="/teacher/register" 
                    class="block w-full bg-purple-600 text-white text-center py-4 rounded-lg hover:bg-purple-700 transition font-semibold text-lg">
                    Create New Account
                </a>

                <p class="text-center text-gray-500 text-sm mt-4">
                    Join us and start your teaching journey
                </p>
            </div>

        </div>

        <!-- Footer -->
        <div class="text-center mt-12">
            <p class="text-white opacity-75">
                © 2024 Teacher Portal. All rights reserved.
            </p>
        </div>

    </div>

</body>
</html>