<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Class Students - De Manaoag University</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; background-color: #f0f4f8; }
    </style>
</head>
<body class="bg-gray-50 text-gray-800">
    @include('layouts.nav')
    
    <div class="max-w-7xl mx-auto px-4 py-8">
        <a href="{{ route('faculty.dashboard') }}" class="text-blue-600 hover:text-blue-800 mb-6 inline-block">← Back to My Classes</a>
        
        <div class="bg-white rounded-xl shadow-md p-6 mb-6">
            <h1 class="text-2xl font-bold text-gray-800 mb-2">
                {{ optional($class->subject)->code ?? 'N/A' }} — 
                {{ optional($class->subject)->name ?? 'Unknown Subject' }}
            </h1>
            <p class="text-gray-600">
                Schedule: {{ $class->schedule ?? 'Not set' }}
                @if($class->room) | Room: {{ $class->room }} @endif
            </p>
        </div>

        @if(session('success'))
            <div class="bg-green-100 border border-green-300 text-green-700 p-4 rounded-xl mb-6">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-white rounded-xl shadow-md overflow-hidden">
            <div class="px-6 py-4 bg-gray-50 border-b font-semibold">
                Enrolled Students — {{ $class->enrollments->count() }} student(s)
            </div>

            @if($class->enrollments->isEmpty())
                <div class="p-6 text-gray-500 text-center">
                    No students enrolled yet.
                </div>
            @else
                <form action="{{ route('faculty.assignGrades') }}" method="POST">
                    @csrf
                    <table class="w-full text-left">
                        <thead>
                            <tr class="bg-gray-50 text-gray-600 text-sm">
                                <th class="px-6 py-3 font-semibold">Student ID</th>
                                <th class="px-6 py-3 font-semibold">Name</th>
                                <th class="px-6 py-3 font-semibold">Current Grade</th>
                                <th class="px-6 py-3 font-semibold w-40">Assign Grade</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($class->enrollments as $enroll)
                            <tr class="border-t border-gray-100">
                                <td class="px-6 py-3 text-sm">
                                    {{ optional($enroll->student)->student_id ?? 'N/A' }}
                                </td>
                                <td class="px-6 py-3 font-medium">
                                    {{ optional($enroll->student)->first_name ?? '' }} 
                                    {{ optional($enroll->student)->last_name ?? '' }}
                                </td>
                                <td class="px-6 py-3 text-gray-500">
                                    {{ $enroll->grade ?? '— Pending' }}
                                </td>
                                <td class="px-6 py-3">
                                    <input type="hidden" name="enrollment_ids[]" value="{{ $enroll->id }}">
                                    <div class="flex gap-2">
                                        <input type="text" name="grades[]" value="{{ $enroll->grade }}" 
                                               class="flex-1 px-3 py-1.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                                        <button type="submit" name="save_single" value="{{ $enroll->id }}"
                                                class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-1.5 rounded-lg text-sm transition">
                                            Save
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    
                    <div class="px-6 py-4 border-t bg-gray-50 flex justify-end">
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg transition">
                            Save All Grades
                        </button>
                    </div>
                </form>
            @endif
        </div>
    </div>
</body>
</html>