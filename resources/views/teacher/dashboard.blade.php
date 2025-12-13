<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Teacher Profile</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-50">

    <!-- Top Navigation Bar -->
    <nav class="bg-gradient-to-r from-blue-600 to-purple-600 shadow-lg">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex justify-between items-center h-16">
                <h1 class="text-2xl font-bold text-white">Teacher Portal</h1>

                <div class="flex items-center space-x-4">
                    <span class="text-white font-semibold">
                        {{ $teacher->first_name }} {{ $teacher->last_name }}
                    </span>

                    <form action="/teacher/logout" method="POST">
                        @csrf
                        <button 
                            class="bg-white text-blue-600 px-4 py-2 rounded-lg font-semibold hover:bg-gray-100">
                            Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <!-- Action Buttons Bar -->
    <div class="bg-white shadow-md">
        <div class="max-w-7xl mx-auto px-4 py-4 flex flex-wrap justify-center gap-4">
            <button class="bg-blue-600 text-white px-4 py-2 rounded-lg shadow hover:bg-blue-700">
                Create Assignment
            </button>
            <button class="bg-purple-600 text-white px-4 py-2 rounded-lg shadow hover:bg-purple-700">
                Take Attendance
            </button>
            <button class="bg-green-600 text-white px-4 py-2 rounded-lg shadow hover:bg-green-700">
                Upload Materials
            </button>
            <button class="bg-orange-600 text-white px-4 py-2 rounded-lg shadow hover:bg-orange-700">
                Grade Submissions
            </button>
        </div>
    </div>

    <!-- Profile Section -->
    <div class="max-w-7xl mx-auto px-4 py-10">

        <div class="bg-white shadow-lg rounded-xl p-8">

            <div class="flex justify-between items-center">
                <h2 class="text-3xl font-bold text-gray-800 mb-6">Teacher Profile</h2>

                <!-- EDIT BUTTON -->
                <button onclick="openEditModal()" 
                    class="bg-gray-700 text-white px-4 py-2 rounded-lg shadow hover:bg-gray-800">
                    Edit Profile
                </button>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                <!-- Full Name -->
                <div class="flex items-start space-x-3">
                    <div class="text-blue-600 text-2xl">👤</div>
                    <div>
                        <p class="text-gray-500 text-sm">Full Name</p>
                        <p class="font-medium">{{ $teacher->first_name }} {{ $teacher->last_name }}</p>
                    </div>
                </div>

                <!-- Email -->
                <div class="flex items-start space-x-3">
                    <div class="text-purple-600 text-2xl">📧</div>
                    <div>
                        <p class="text-gray-500 text-sm">Email Address</p>
                        <p class="font-medium">{{ $teacher->email }}</p>
                    </div>
                </div>

                <!-- Phone -->
                <div class="flex items-start space-x-3">
                    <div class="text-green-600 text-2xl">📞</div>
                    <div>
                        <p class="text-gray-500 text-sm">Phone Number</p>
                        <p class="font-medium">{{ $teacher->phone }}</p>
                    </div>
                </div>

                <!-- Date of Birth -->
                <div class="flex items-start space-x-3">
                    <div class="text-orange-600 text-2xl">📅</div>
                    <div>
                        <p class="text-gray-500 text-sm">Date of Birth</p>
                        <p class="font-medium">{{ $teacher->dob }}</p>
                    </div>
                </div>

                <!-- Gender -->
                <div class="flex items-start space-x-3">
                    <div class="text-pink-600 text-2xl">⚧</div>
                    <div>
                        <p class="text-gray-500 text-sm">Gender</p>
                        <p class="font-medium">{{ $teacher->gender }}</p>
                    </div>
                </div>

                <!-- National ID -->
                <div class="flex items-start space-x-3">
                    <div class="text-indigo-600 text-2xl">🆔</div>
                    <div>
                        <p class="text-gray-500 text-sm">National ID</p>
                        <p class="font-medium">{{ $teacher->national_id ?? 'Not provided' }}</p>
                    </div>
                </div>

                <!-- Present Address -->
                <div class="md:col-span-2 flex items-start space-x-3">
                    <div class="text-red-600 text-2xl">📍</div>
                    <div>
                        <p class="text-gray-500 text-sm">Present Address</p>
                        <p class="font-medium">{{ $teacher->present_address }}</p>
                    </div>
                </div>

                <!-- Permanent Address -->
                <div class="md:col-span-2 flex items-start space-x-3">
                    <div class="text-yellow-600 text-2xl">🏠</div>
                    <div>
                        <p class="text-gray-500 text-sm">Permanent Address</p>
                        <p class="font-medium">{{ $teacher->permanent_address }}</p>
                    </div>
                </div>

            </div>
        </div>

    </div>

    <!-- EDIT PROFILE MODAL -->
    <div id="editModal" class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center z-50">
        <div class="bg-white w-full max-w-2xl mx-4 rounded-lg shadow-lg p-6 relative">

            <h2 class="text-2xl font-bold text-gray-800 mb-4">Edit Profile</h2>

            <!-- Close Button -->
            <button onclick="closeEditModal()" class="absolute top-3 right-3 text-gray-500 hover:text-black">✕</button>

            <!-- Edit Profile Form -->
            <form action="{{ route('teacher.update', $teacher->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                    <div>
                        <label class="text-gray-600 text-sm font-semibold">First Name</label>
                        <input type="text" name="first_name" value="{{ $teacher->first_name }}"
                            class="w-full border rounded-lg px-3 py-2 mt-1">
                    </div>

                    <div>
                        <label class="text-gray-600 text-sm font-semibold">Last Name</label>
                        <input type="text" name="last_name" value="{{ $teacher->last_name }}"
                            class="w-full border rounded-lg px-3 py-2 mt-1">
                    </div>

                    <div>
                        <label class="text-gray-600 text-sm font-semibold">Email</label>
                        <input type="email" name="email" value="{{ $teacher->email }}"
                            class="w-full border rounded-lg px-3 py-2 mt-1">
                    </div>

                    <div>
                        <label class="text-gray-600 text-sm font-semibold">Phone</label>
                        <input type="text" name="phone" value="{{ $teacher->phone }}"
                            class="w-full border rounded-lg px-3 py-2 mt-1">
                    </div>

                    <div>
                        <label class="text-gray-600 text-sm font-semibold">Date of Birth</label>
                        <input type="date" name="dob" value="{{ $teacher->dob }}"
                            class="w-full border rounded-lg px-3 py-2 mt-1">
                    </div>

                    <div>
                        <label class="text-gray-600 text-sm font-semibold">Gender</label>
                        <select name="gender" class="w-full border rounded-lg px-3 py-2 mt-1">
                            <option value="Male" {{ $teacher->gender == 'Male' ? 'selected' : '' }}>Male</option>
                            <option value="Female" {{ $teacher->gender == 'Female' ? 'selected' : '' }}>Female</option>
                            <option value="Other" {{ $teacher->gender == 'Other' ? 'selected' : '' }}>Other</option>
                        </select>
                    </div>

                    <div class="md:col-span-2">
                        <label class="text-gray-600 text-sm font-semibold">National ID</label>
                        <input type="text" name="national_id" value="{{ $teacher->national_id }}"
                            class="w-full border rounded-lg px-3 py-2 mt-1">
                    </div>

                    <div class="md:col-span-2">
                        <label class="text-gray-600 text-sm font-semibold">Present Address</label>
                        <textarea name="present_address" rows="2"
                            class="w-full border rounded-lg px-3 py-2 mt-1">{{ $teacher->present_address }}</textarea>
                    </div>

                    <div class="md:col-span-2">
                        <label class="text-gray-600 text-sm font-semibold">Permanent Address</label>
                        <textarea name="permanent_address" rows="2"
                            class="w-full border rounded-lg px-3 py-2 mt-1">{{ $teacher->permanent_address }}</textarea>
                    </div>

                </div>

                <div class="mt-5 flex justify-end space-x-3">
                     <!-- New Close Button -->
                     <button type="button" onclick="closeEditModal()"
                           class="bg-gray-300 text-gray-800 px-5 py-2 rounded-lg shadow hover:bg-gray-400">
                           Close
                     </button>

                <!-- Save Changes Button -->
                     <button type="submit"
                           class="bg-blue-600 text-white px-5 py-2 rounded-lg shadow hover:bg-blue-700">
                           Save Changes
                     </button>
                </div>

            </form>

        </div>
    </div>

    <!-- MODAL SCRIPT -->
    <script>
        function openEditModal() {
            document.getElementById('editModal').classList.remove('hidden');
        }

        function closeEditModal() {
            document.getElementById('editModal').classList.add('hidden');
        }
    </script>

</body>
</html>
