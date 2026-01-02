<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Study Materials</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen">

<div class="max-w-7xl mx-auto px-4 py-8">

    <!-- Header with Title and Dashboard Button -->
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-3xl font-bold text-gray-800">
            📚 Study Materials
        </h1>
        <a href="{{ route('teacher.dashboard') }}" 
           class="bg-blue-600 text-white px-4 py-2 rounded-lg shadow hover:bg-blue-700 transition">
           Dashboard
        </a>
    </div>

    <!-- Success message -->
    @if(session('success'))
        <div class="mb-6 max-w-7xl mx-auto px-4">
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        </div>
    @endif

    <!-- Upload Card -->
    <div class="bg-white rounded-xl shadow-lg p-6 mb-10">
        <h2 class="text-xl font-semibold text-indigo-600 mb-4">
            Upload Study Material
        </h2>

        <form action="{{ url('/studymaterials') }}"
              method="POST"
              enctype="multipart/form-data"
              class="grid grid-cols-1 md:grid-cols-5 gap-4">
            @csrf

            <!-- Class Dropdown -->
            <select name="class"
                    class="border rounded-lg px-3 py-2 focus:ring-2 focus:ring-indigo-400"
                    required>
                <option value="">Select Class</option>
                @for($i = 1; $i <= 10; $i++)
                    <option value="{{ $i }}">Class {{ $i }}</option>
                @endfor
            </select>

            <input type="text" name="title" placeholder="Title"
                   class="border rounded-lg px-3 py-2 focus:ring-2 focus:ring-indigo-400"
                   required>

            <input type="text" name="subject" placeholder="Subject"
                   class="border rounded-lg px-3 py-2 focus:ring-2 focus:ring-indigo-400"
                   required>

            <input type="file" name="file"
                   class="border rounded-lg px-3 py-2"
                   required>

            <button type="submit"
                    class="bg-indigo-600 text-white rounded-lg px-4 py-2 hover:bg-indigo-700 transition">
                Upload
            </button>
        </form>
    </div>

    <!-- Materials List -->
    @for ($class = 1; $class <= 10; $class++)
        <div class="bg-white rounded-xl shadow-md mb-8 p-6">
            <h2 class="text-2xl font-semibold text-gray-700 mb-4">
                Class {{ $class }}
            </h2>

            @if(isset($materials[$class]) && $materials[$class]->count())
                <div class="overflow-x-auto">
                    <table class="min-w-full border border-gray-200 rounded-lg">
                        <thead class="bg-gray-100">
                        <tr>
                            <th class="px-4 py-2 text-left text-sm font-semibold">Title</th>
                            <th class="px-4 py-2 text-left text-sm font-semibold">Subject</th>
                            <th class="px-4 py-2 text-left text-sm font-semibold">Type</th>
                            <th class="px-4 py-2 text-center text-sm font-semibold">Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($materials[$class] as $material)
                            <tr class="border-t hover:bg-gray-50">
                                <td class="px-4 py-2">{{ $material->title }}</td>
                                <td class="px-4 py-2">{{ $material->subject }}</td>
                                <td class="px-4 py-2 uppercase">{{ $material->file_type }}</td>
                                <td class="px-4 py-2 text-center space-x-2">
                                    <a href="{{ asset('storage/'.$material->file_path) }}"
                                       target="_blank"
                                       class="bg-green-500 text-white px-3 py-1 rounded-md text-sm hover:bg-green-600">
                                        Download
                                    </a>

                                    <form action="{{ url('/studymaterials/'.$material->id) }}"
                                          method="POST"
                                          class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button onclick="return confirm('Delete this material?')"
                                                class="bg-red-500 text-white px-3 py-1 rounded-md text-sm hover:bg-red-600">
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
                <p class="text-gray-500 italic">No materials uploaded.</p>
            @endif
        </div>
    @endfor

</div>

</body>
</html>
