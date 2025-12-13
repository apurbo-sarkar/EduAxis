<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Teacher Sign In</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100">

    <div class="max-w-md mx-auto mt-20 bg-white shadow-lg rounded-xl p-8">
        
        <h2 class="text-3xl font-bold text-center text-blue-600 mb-6">
            Teacher Sign In
        </h2>

        @if (session('success'))
            <div class="mb-4 p-4 bg-green-100 text-green-800 border border-green-300 rounded-lg">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="mb-4 p-4 bg-red-100 text-red-800 border border-red-300 rounded-lg">
                {{ session('error') }}
            </div>
        @endif

        <form action="{{ route('teacher.login') }}" method="POST" class="space-y-6">
            @csrf

            <!-- Username -->
            <div>
                <label class="block font-semibold mb-2">Username</label>
                <input type="text" name="username" required
                    class="w-full border rounded-lg p-3 focus:ring focus:ring-blue-300" />
            </div>

            <!-- Password -->
            <div>
                <label class="block font-semibold mb-2">Password</label>
                <input type="password" name="password" required
                    class="w-full border rounded-lg p-3 focus:ring focus:ring-blue-300" />
            </div>

            <!-- Submit Button -->
            <div>
                <button type="submit"
                    class="w-full bg-blue-600 text-white py-3 rounded-lg hover:bg-blue-700 transition">
                    Sign In
                </button>
            </div>

            <!-- Register Link -->
            <div class="text-center">
                <p class="text-gray-600">Don't have an account? 
                    <a href="/teacher/register" class="text-blue-600 hover:underline">Register here</a>
                </p>
            </div>

        </form>
    </div>

</body>
</html>