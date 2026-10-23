<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Faculty Dashboard - De Manaoag University</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(rgba(10, 35, 66, 0.85), rgba(10, 35, 66, 0.90)), 
                        url('{{ asset('images/bg-campus.jpg') }}') center/cover no-repeat fixed;
            min-height: 100vh;
        }
    </style>
</head>
<body>
    @include('layouts.nav')

    <div class="max-w-6xl mx-auto px-4 py-8">
        {{-- WELCOME HEADER --}}
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-white mb-2">Welcome, {{ Auth::user()->name }}! 👋</h1>
            <p class="text-blue-200">Faculty Portal — Manage your classes and students.</p>
        </div>

        {{-- STATS --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
            <div class="bg-white/95 p-5 rounded-xl shadow-sm backdrop-blur-sm">
                <p class="text-sm text-gray-500 mb-1">Faculty ID</p>
                <p class="text-xl font-bold text-blue-900">{{ $faculty->employee_id ?? 'FAC-00001' }}</p>
            </div>
            <div class="bg-white/95 p-5 rounded-xl shadow-sm backdrop-blur-sm">
                <p class="text-sm text-gray-500 mb-1">Department</p>
                <p class="text-xl font-bold text-blue-900">Information Technology</p>
            </div>
            <div class="bg-white/95 p-5 rounded-xl shadow-sm backdrop-blur-sm">
                <p class="text-sm text-gray-500 mb-1">Total Classes</p>
                <p class="text-xl font-bold text-blue-900">{{ $classes->count() }}</p>
            </div>
        </div>

        {{-- MY CLASSES WITH STUDENTS & GRADE ASSIGNMENT --}}
        <h2 class="text-xl font-bold text-white mb-4">📋 My Classes</h2>

        @if($classes->isEmpty())
            <div class="bg-white/90 p-6 rounded-xl text-gray-500 text-center backdrop-blur-sm">
                No classes assigned yet.
            </div>
        @else
            <div class="space-y-6">
                @foreach($classes as $class)
                    <div class="bg-white/95 rounded-xl shadow-sm overflow-hidden backdrop-blur-sm">
                        {{-- CLASS HEADER --}}
                        <div class="bg-blue-50 px-5 py-4 border-b">
                            <h3 class="font-bold text-lg text-blue-900">
                                {{ $class->code }} — {{ $class->subject->name ?? 'Unknown Subject' }}
                            </h3>
                            <p class="text-sm text-gray-600 mt-1">
                                {{ $class->schedule ?? 'Schedule not set' }}
                                @if($class->room) • {{ $class->room }} @endif
                            </p>
                        </div>

                        {{-- STUDENTS LIST WITH GRADE --}}
                        <div class="p-5">
                            <h4 class="font-semibold text-gray-700 mb-3">
                                Enrolled Students — {{ $class->enrollments->count() }} student(s)
                            </h4>

                            @if($class->enrollments->isEmpty())
                                <p class="text-sm text-gray-400 italic">No students enrolled yet.</p>
                            @else
                                <form method="POST" action="{{ route('faculty.assignGrades') }}">
                                    @csrf
                                    <div class="overflow-x-auto">
                                        <table class="w-full text-sm">
                                            <thead>
                                                <tr class="text-left text-gray-500 border-b">
                                                    <th class="pb-3 font-medium">Student ID</th>
                                                    <th class="pb-3 font-medium">Name</th>
                                                    <th class="pb-3 font-medium">Current Grade</th>
                                                    <th class="pb-3 font-medium">Assign Grade</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($class->enrollments as $enrollment)
                                                    <tr class="border-b last:border-0">
                                                        <td class="py-3 font-mono">
                                                            {{ $enrollment->student->student_id ?? 'N/A' }}
                                                        </td>
                                                        <td class="py-3">
                                                            {{ $enrollment->student->last_name ?? '' }}, {{ $enrollment->student->first_name ?? '' }}
                                                        </td>
                                                        <td class="py-3 text-gray-500">
                                                            {{ $enrollment->grade ?? '— Pending' }}
                                                        </td>
                                                        <td class="py-3">
                                                            <input type="hidden" name="enrollment_ids[]" value="{{ $enrollment->id }}">
                                                            <input 
                                                                type="text" 
                                                                name="grades[]" 
                                                                value="{{ old('grades.'.$loop->index, $enrollment->grade) }}"
                                                                class="w-20 px-2 py-1 border border-gray-300 rounded focus:ring-2 focus:ring-yellow-400 text-center"
                                                                placeholder="2">
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    <button type="submit" class="mt-4 bg-blue-900 text-white px-5 py-2 rounded-lg font-medium hover:bg-blue-800 transition">
                                        💾 Save Grades
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</body>
</html>