<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Assignments</title>

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen p-6">

    <div class="max-w-6xl mx-auto">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold text-gray-800">📚 Assignments</h1>

            <div class="space-x-2">
               <a href="{{ route('teacher.dashboard') }}"
                  class="bg-blue-700 text-white px-4 py-2 rounded-lg hover:bg-blue-800 transition">
                  Dashboard
               </a>

               <a href="{{ route('assignments.create') }}"
                  class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition">
                  + Add Assignment
               </a>
            </div>
        </div>

        @if (session('success'))
            <div class="bg-green-100 text-green-700 p-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <!-- Assignments by Class -->
        @for ($class = 1; $class <= 10; $class++)
            <div class="bg-white shadow rounded-lg mb-6 p-6">
                <h2 class="text-2xl font-semibold text-gray-700 mb-4">Class {{ $class }}</h2>

                @php
                    $classAssignments = $assignments->where('class', $class);
                @endphp

                @if ($classAssignments->count())
                    <div class="overflow-x-auto">
                        <table class="min-w-full text-sm">
                            <thead class="bg-gray-200 text-gray-700">
                                <tr>
                                    <th class="px-4 py-3 text-left">Title</th>
                                    <th class="px-4 py-3 text-left">Class</th>
                                    <th class="px-4 py-3 text-left">Due Date</th>
                                    <th class="px-4 py-3 text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($classAssignments as $assignment)
                                    <tr class="border-b hover:bg-gray-50">
                                        <td class="px-4 py-3 font-medium">{{ $assignment->title }}</td>
                                        <td class="px-4 py-3">Class {{ $assignment->class }}</td>
                                        <td class="px-4 py-3">{{ $assignment->due_date ?? '—' }}</td>
                                        <td class="px-4 py-3 text-center space-x-2">
                                            <a href="{{ route('assignments.download', $assignment->id) }}"
                                               class="inline-block bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600">
                                                Download
                                            </a>

                                            <form action="{{ route('assignments.destroy', $assignment->id) }}"
                                                  method="POST" class="inline-block"
                                                  onsubmit="return confirm('Delete this assignment?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                        class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600">
                                                    Delete
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="text-gray-500 italic">No assignments found for this class.</p>
                @endif
            </div>
        @endfor

    </div>

</body>
</html>
