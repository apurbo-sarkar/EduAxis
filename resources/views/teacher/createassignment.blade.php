<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Create Assignment</title>

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center">

    <div class="w-full max-w-lg bg-white rounded-xl shadow-lg p-8">
        <h2 class="text-2xl font-bold text-center text-gray-800 mb-6">
            📘 Create Assignment
        </h2>

        @if ($errors->any())
            <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
                <ul class="list-disc list-inside text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('assignments.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
            @csrf

            <!-- Title -->
            <div>
                <label class="block text-sm font-medium text-gray-700">Title</label>
                <input type="text" name="title"
                       class="w-full mt-1 px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none"
                       placeholder="Assignment title" required>
            </div>

            <!-- Description -->
            <div>
                <label class="block text-sm font-medium text-gray-700">Description</label>
                <textarea name="description" rows="3"
                          class="w-full mt-1 px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none"
                          placeholder="Optional description"></textarea>
            </div>

            <!-- Class -->
            <div>
                <label class="block text-sm font-medium text-gray-700">Class</label>
                <select name="class"
                        class="w-full mt-1 px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none"
                        required>
                    <option value="">Select Class</option>
                    @for ($i = 1; $i <= 10; $i++)
                        <option value="{{ $i }}">Class {{ $i }}</option>
                    @endfor
                </select>
            </div>

            <!-- File -->
            <div>
                <label class="block text-sm font-medium text-gray-700">Assignment File</label>
                <input type="file" name="file"
                       class="w-full mt-1 border rounded-lg p-2"
                       required>
                <p class="text-xs text-gray-500 mt-1">PDF, DOC, PPT (Max 5MB)</p>
            </div>

            <!-- Due Date -->
            <div>
                <label class="block text-sm font-medium text-gray-700">Due Date</label>
                <input type="date" name="due_date"
                       class="w-full mt-1 px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none">
            </div>

            <!-- Submit -->
            <button type="submit"
                    class="w-full bg-blue-600 text-white py-2 rounded-lg font-semibold hover:bg-blue-700 transition">
                Upload Assignment
            </button>
        </form>

        <div class="text-center mt-4">
            <a href="{{ route('teacher.assignmentindex') }}"
               class="text-blue-600 hover:underline text-sm">
                ← Back to Assignments
            </a>
        </div>
    </div>

</body>
</html>
