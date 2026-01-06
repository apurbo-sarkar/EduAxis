<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Take Attendance</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen">

<div class="max-w-7xl mx-auto px-4 py-8">

    <!-- Header -->
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-3xl font-bold text-gray-800">📝 Take Attendance</h1>
        <a href="{{ route('teacher.dashboard') }}" 
           class="bg-blue-600 text-white px-4 py-2 rounded-lg shadow hover:bg-blue-700 transition">
           Dashboard
        </a>
    </div>

    <!-- Success message -->
    @if(session('success'))
        <div class="mb-6">
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                {{ session('success') }}
            </div>
        </div>
    @endif

    <!-- Select Class -->
    <div class="bg-white rounded-xl shadow-lg p-6 mb-10">
        <h2 class="text-xl font-semibold text-indigo-600 mb-4">Select Class</h2>
        <form method="GET" action="{{ route('teacher.attendance') }}" class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <select name="class" class="border rounded-lg px-3 py-2 focus:ring-2 focus:ring-indigo-400" required>
            <option value="">Select Class</option>
                @for($i = 1; $i <= 10; $i++)
            <option value="{{ $i }}" {{ request('class') == $i ? 'selected' : '' }}>Grade {{ $i }}</option> <!-- Updated to Grade -->
                @endfor
            </select>
        <button type="submit" class="bg-indigo-600 text-white rounded-lg px-4 py-2 hover:bg-indigo-700">
            Show Students
         </button>
        </form>

    </div>

    <!-- Attendance List -->
    @if($students && $students->count() > 0)
        <div class="bg-white rounded-xl shadow-md p-6">
            <h2 class="text-2xl font-semibold text-gray-700 mb-4">Class {{ request('class') }}</h2>

            <form method="POST" action="{{ route('teacher.attendance.store') }}">
    @csrf
    <input type="hidden" name="class" value="{{ request('class') }}">

    <div class="overflow-x-auto">
        <table class="min-w-full border border-gray-200 rounded-lg">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-4 py-2 text-left text-sm font-semibold">Roll No</th>
                    <th class="px-4 py-2 text-left text-sm font-semibold">Student Name</th>
                    <th class="px-4 py-2 text-left text-sm font-semibold">Attendance</th>
                </tr>
            </thead>
            <tbody>
                @foreach($students as $student)
                    <tr class="border-t hover:bg-gray-50">
                        <td class="px-4 py-2">{{ $student->admission_number }}</td>
                        <td class="px-4 py-2">{{ $student->full_name }}</td>
                        <td class="px-4 py-2">
                            <select name="attendance[{{ $student->student_id }}]" 
                                class="border rounded-lg px-2 py-1 focus:ring-2 focus:ring-indigo-400" required>
                                <option value="P" {{ old("attendance.$student->student_id") == 'P' ? 'selected' : '' }}>Present</option>
                                <option value="A" {{ old("attendance.$student->student_id") == 'A' ? 'selected' : '' }}>Absent</option>
                                <option value="L" {{ old("attendance.$student->student_id") == 'L' ? 'selected' : '' }}>Late</option>
                                <option value="E" {{ old("attendance.$student->student_id") == 'E' ? 'selected' : '' }}>Excused</option>
                            </select>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <button type="submit" class="mt-4 bg-green-600 text-white rounded-lg px-4 py-2 hover:bg-green-700">
        Save Attendance
    </button>
</form>

        </div>
    @elseif(request('class'))
        <p class="text-gray-500 italic">No students found for this class.</p>
    @endif

</div>
</body>
</html>
