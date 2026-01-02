<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My Assignments</title>

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen p-6">

<div class="max-w-5xl mx-auto">

    <!-- Header -->
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-bold text-gray-800">📚 My Assignments</h1>

        <a href="{{ route('student.dashboard') }}"
           class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
            Dashboard
        </a>
    </div>

    <!-- Assignments Card -->
    <div class="bg-white shadow rounded-lg p-6">

        @if ($assignments->count())
            <div class="overflow-x-auto">
                <table class="min-w-full text-sm">
                    <thead class="bg-gray-200 text-gray-700">
                        <tr>
                            <th class="px-4 py-3 text-left">Title</th>
                            <th class="px-4 py-3 text-left">Due Date</th>
                            <th class="px-4 py-3 text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($assignments as $assignment)
                            <tr class="border-b hover:bg-gray-50">
                                <td class="px-4 py-3 font-medium">
                                    {{ $assignment->title }}
                                </td>

                                <td class="px-4 py-3">
                                    {{ $assignment->due_date ?? '—' }}
                                </td>

                                <td class="px-4 py-3 text-center">
                                    <a href="{{ route('assignments.download', $assignment->id) }}"
                                       class="inline-block bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600">
                                        Download
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <p class="text-gray-500 italic text-center">
                No assignments available for your class.
            </p>
        @endif

    </div>

</div>

</body>
</html>
