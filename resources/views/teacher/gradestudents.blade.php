<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mark Students</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen">

<div class="max-w-7xl mx-auto px-4 py-8">

    <!-- Header with Title and Dashboard Button -->
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-3xl font-bold text-gray-800">
            📝 Mark Students
        </h1>
        <a href="{{ route('teacher.dashboard') }}" 
           class="bg-blue-600 text-white px-4 py-2 rounded-lg shadow hover:bg-blue-700 transition">
           Dashboard
        </a>
    </div>

    <!-- Success/Error Messages -->
    @if(session('success'))
        <div class="mb-6">
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                {{ session('success') }}
            </div>
        </div>
    @endif

    @if(session('error'))
        <div class="mb-6">
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                {{ session('error') }}
            </div>
        </div>
    @endif

    <!-- Select Class -->
    <div class="mb-6 bg-white rounded-xl shadow-lg p-6">
        <h2 class="text-xl font-semibold text-indigo-600 mb-4">Select Class</h2>
        <form method="GET" action="{{ route('teacher.gradestudents') }}" class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <select name="class" class="border rounded-lg px-3 py-2 focus:ring-2 focus:ring-indigo-400" required>
                <option value="">Select Class</option>
                @for($i = 1; $i <= 10; $i++)
                    <option value="Grade {{ $i }}" 
                        {{ (isset($selectedClass) && $selectedClass == "Grade $i") ? 'selected' : '' }}>
                        Grade {{ $i }}
                    </option>
                @endfor
            </select>
            <button type="submit" class="bg-indigo-600 text-white rounded-lg px-4 py-2 hover:bg-indigo-700">
                Show Students
            </button>
        </form>
    </div>

    <!-- Students List and Marks Form -->
    @if(isset($students) && $students->count() > 0)
        <form action="{{ route('teacher.storemarks') }}" method="POST" class="grid grid-cols-1 gap-4">
            @csrf
            <input type="hidden" name="class" value="{{ $selectedClass }}">

            <div class="bg-white rounded-xl shadow-lg p-6 mb-10">
                <h2 class="text-2xl font-semibold text-indigo-600 mb-4">
                    Students List - {{ $selectedClass }}
                </h2>

                <div class="overflow-x-auto">
                    <table class="min-w-full border border-gray-200 rounded-lg">
                        <thead class="bg-gray-100">
                        <tr>
                            <th class="px-4 py-2 text-left text-sm font-semibold">Admission No</th>
                            <th class="px-4 py-2 text-left text-sm font-semibold">Full Name</th>
                            <th class="px-4 py-2 text-left text-sm font-semibold">Math</th>
                            <th class="px-4 py-2 text-left text-sm font-semibold">English Language</th>
                            <th class="px-4 py-2 text-left text-sm font-semibold">Literature</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($students as $student)
                            <tr class="border-t hover:bg-gray-50">
                                <td class="px-4 py-2">{{ $student->admission_number }}</td>
                                <td class="px-4 py-2">{{ $student->full_name }}</td>

                                <!-- Math Marks -->
                                <td class="px-4 py-2">
                                    <div class="flex flex-col gap-2">
                                        <input type="number" name="math[{{ $student->student_id }}][quiz]" placeholder="Quiz" class="border rounded-lg px-3 py-2">
                                        <input type="number" name="math[{{ $student->student_id }}][assignment]" placeholder="Assignment" class="border rounded-lg px-3 py-2">
                                        <input type="number" name="math[{{ $student->student_id }}][mid_exam]" placeholder="Mid Exam" class="border rounded-lg px-3 py-2">
                                        <input type="number" name="math[{{ $student->student_id }}][final_exam]" placeholder="Final Exam" class="border rounded-lg px-3 py-2">
                                    </div>
                                </td>

                                <!-- English Marks -->
                                <td class="px-4 py-2">
                                    <div class="flex flex-col gap-2">
                                        <input type="number" name="english[{{ $student->student_id }}][quiz]" placeholder="Quiz" class="border rounded-lg px-3 py-2">
                                        <input type="number" name="english[{{ $student->student_id }}][assignment]" placeholder="Assignment" class="border rounded-lg px-3 py-2">
                                        <input type="number" name="english[{{ $student->student_id }}][mid_exam]" placeholder="Mid Exam" class="border rounded-lg px-3 py-2">
                                        <input type="number" name="english[{{ $student->student_id }}][final_exam]" placeholder="Final Exam" class="border rounded-lg px-3 py-2">
                                    </div>
                                </td>

                                <!-- Literature Marks -->
                                <td class="px-4 py-2">
                                    <div class="flex flex-col gap-2">
                                        <input type="number" name="literature[{{ $student->student_id }}][quiz]" placeholder="Quiz" class="border rounded-lg px-3 py-2">
                                        <input type="number" name="literature[{{ $student->student_id }}][assignment]" placeholder="Assignment" class="border rounded-lg px-3 py-2">
                                        <input type="number" name="literature[{{ $student->student_id }}][mid_exam]" placeholder="Mid Exam" class="border rounded-lg px-3 py-2">
                                        <input type="number" name="literature[{{ $student->student_id }}][final_exam]" placeholder="Final Exam" class="border rounded-lg px-3 py-2">
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Submit Button -->
            <div class="flex justify-end">
                <button type="submit" class="bg-indigo-600 text-white rounded-lg px-4 py-2 hover:bg-indigo-700 transition">
                    Save Marks
                </button>
            </div>
        </form>
    @elseif(isset($selectedClass))
        <p class="text-gray-500 italic">No students found for {{ $selectedClass }}.</p>
    @endif

</div>
</body>
</html>
