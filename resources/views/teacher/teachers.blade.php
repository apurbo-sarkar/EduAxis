<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Teacher Registration</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100">

    <div class="max-w-3xl mx-auto mt-10 bg-white shadow-lg rounded-xl p-8">
        
        <h2 class="text-3xl font-bold text-center text-blue-600 mb-6">
            Teacher Registration
        </h2>

        @if (session('success'))
            <div class="mb-4 p-4 bg-green-100 text-green-800 border border-green-300 rounded-lg">
                {{ session('success') }}
            </div>
        @endif

        <form action="/teacher/register" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <!-- Row 1 -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block font-semibold mb-1">First Name</label>
                    <input type="text" name="first_name" required
                        class="w-full border rounded-lg p-3 focus:ring focus:ring-blue-300" />
                </div>

                <div>
                    <label class="block font-semibold mb-1">Last Name</label>
                    <input type="text" name="last_name" required
                        class="w-full border rounded-lg p-3 focus:ring focus:ring-blue-300" />
                </div>
            </div>

            <!-- Row 2 -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block font-semibold mb-1">Date of Birth</label>
                    <input type="date" name="dob" required
                        class="w-full border rounded-lg p-3 focus:ring focus:ring-blue-300" />
                </div>

                <div>
                    <label class="block font-semibold mb-1">Gender</label>
                    <select name="gender" required
                        class="w-full border rounded-lg p-3 focus:ring focus:ring-blue-300">
                        <option value="">Select Gender</option>
                        <option>Male</option>
                        <option>Female</option>
                        <option>Other</option>
                    </select>
                </div>
            </div>

            <!-- Row 3 -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block font-semibold mb-1">Phone Number</label>
                    <input type="text" name="phone" required
                        class="w-full border rounded-lg p-3 focus:ring focus:ring-blue-300" />
                </div>

                <div>
                    <label class="block font-semibold mb-1">Email</label>
                    <input type="email" name="email" required
                        class="w-full border rounded-lg p-3 focus:ring focus:ring-blue-300" />
                </div>
            </div>

            <!-- Row 4 - Username and Password -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block font-semibold mb-1">Username</label>
                    <input type="text" name="username" required
                        class="w-full border rounded-lg p-3 focus:ring focus:ring-blue-300" />
                </div>

                <div>
                    <label class="block font-semibold mb-1">Password</label>
                    <input type="password" name="password" required
                        class="w-full border rounded-lg p-3 focus:ring focus:ring-blue-300" />
                    <p class="text-sm text-gray-500 mt-1">Minimum 8 characters</p>
                </div>
            </div>

            <!-- Row 5 - Confirm Password -->
            <div>
                <label class="block font-semibold mb-1">Confirm Password</label>
                <input type="password" name="password_confirmation" required
                    class="w-full border rounded-lg p-3 focus:ring focus:ring-blue-300" />
            </div>

            <!-- Addresses -->
            <div>
                <label class="block font-semibold mb-1">Present Address</label>
                <input type="text" name="present_address" required
                    class="w-full border rounded-lg p-3 focus:ring focus:ring-blue-300" />
            </div>

            <div>
                <label class="block font-semibold mb-1">Permanent Address</label>
                <input type="text" name="permanent_address" required
                    class="w-full border rounded-lg p-3 focus:ring focus:ring-blue-300" />
            </div>

            <!-- National ID -->
            <div>
                <label class="block font-semibold mb-1">National ID (optional)</label>
                <input type="text" name="national_id"
                    class="w-full border rounded-lg p-3 focus:ring focus:ring-blue-300" />
            </div>

            <!-- Photo -->
            <div>
                <label class="block font-semibold mb-2">Upload Photo</label>
                <input type="file" name="photo"
                    class="w-full border p-3 rounded-lg bg-gray-50" />
            </div>

            <!-- Submit Button -->
            <div class="text-center">
                <button type="submit"
                    class="bg-blue-600 text-white px-6 py-3 rounded-lg hover:bg-blue-700 transition">
                    Register Teacher
                </button>
            </div>

        </form>
    </div>

</body>
</html>