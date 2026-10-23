<!DOCTYPE html>
<html>
<head>
    <title>Class Students - De Manaoag University</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(rgba(10, 35, 66, 0.85), rgba(10, 35, 66, 0.90));
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            min-height: 100vh;
        }
    </style>
</head>
<body>
    @include('layouts.nav')
    
    <div class="max-w-7xl mx-auto px-4 py-8">
        {{-- Back Button --}}
        <a href="{{ route('faculty.dashboard') }}" 
           class="inline-flex items-center text-white mb-6 hover:text-yellow-300 transition">
            ← Back to Dashboard
        </a>

        {{-- Class Info --}}
        <div class="bg-white/95 rounded-xl shadow-lg p-6 mb-6">
            <h1 class="text-2xl font-bold text-blue-900">
                {{ $class->subject->code ?? 'N/A' }} — {{ $class->subject->name ?? 'Unknown Subject' }}
            </h1>
            <p class="text-gray-600 mt-2">
                📅 {{ $class->schedule ?? 'Schedule not set' }} • 
                🏢 Room {{ $class->room ?? 'Not assigned' }}
            </p>
            <p class="text-gray-500 mt-1">
                👥 {{ $class->enrollments->count() }} Student(s) Enrolled
            </p>
        </div>

        {{-- Success Message --}}
        @if(session('success'))
            <div class="bg-green-50 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded-r-lg">
                ✅ {{ session('success') }}
            </div>
        @endif

        {{-- Students Table --}}
        <div class="bg-white/95 rounded-xl shadow-lg overflow-hidden">
            <div class="p-6 border-b border-gray-100">
                <h2 class="text-lg font-bold text-blue-900">Enrolled Students</h2>
            </div>
            
            @if($class->enrollments->isNotEmpty())
                <table class="w-full text-left">
                    <thead class="bg-blue-900 text-white">
                        <tr>
                            <th class="p-4">Student ID</th>
                            <th class="p-4">Name</th>
                            <th class="p-4">Current Grade</th>
                            <th class="p-4">Assign Grade</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($class->enrollments as $enroll)
                        <tr class="border-t hover:bg-gray-50">
                            <td class="p-4 font-mono font-bold text-blue-900">
                                {{ $enroll->student->student_id ?? 'N/A' }}
                            </td>
                            <td class="p-4">
                                {{ $enroll->student->first_name ?? '' }} {{ $enroll->student->last_name ?? '' }}
                            </td>
                            <td class="p-4">
                                @if($enroll->grade)
                                    <span class="font-bold {{ $enroll->grade <= 3.0 ? 'text-green-600' : 'text-red-600' }}">
                                        {{ $enroll->grade }}
                                    </span>
                                    <span class="text-sm text-gray-400 ml-1">
                                        ({{ $enroll->remarks }})
                                    </span>
                                @else
                                    <span class="text-gray-400 italic">— Pending —</span>
                                @endif
                            </td>
                            <td class="p-4">
                                <form action="{{ route('faculty.store-grade', $enroll->id) }}" method="POST" class="flex gap-2 items-center">
                                    @csrf
                                    <input type="number" 
                                           name="grade" 
                                           step="0.1" 
                                           min="1.0" 
                                           max="5.0" 
                                           value="{{ $enroll->grade ?? '' }}"
                                           placeholder="e.g. 1.0, 2.5, 3.0"
                                           class="w-32 px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    <button type="submit" 
                                            class="bg-blue-900 text-white px-4 py-2 rounded-lg hover:bg-blue-800 transition">
                                        Save
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <div class="p-8 text-center text-gray-400">
                    No students enrolled in this class yet.
                </div>
            @endif
        </div>
    </div>
</body>
</html>