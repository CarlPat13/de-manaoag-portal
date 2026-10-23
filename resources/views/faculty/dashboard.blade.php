<!DOCTYPE html>
<html>
<head>
    <title>Faculty Dashboard - De Manaoag University</title>
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
        @if(session('success'))
            <div class="bg-green-50 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded-r-lg">
                ✅ {{ session('success') }}
            </div>
        @endif

        <div class="bg-white/95 rounded-xl shadow-lg p-6 mb-8">
            <h1 class="text-2xl font-bold text-blue-900">Welcome, {{ $faculty->first_name }}! 👋</h1>
            <p class="text-gray-600 mt-1">Faculty Portal — Manage your classes and students.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-white/95 rounded-xl shadow p-5">
                <p class="text-sm text-gray-500">Faculty ID</p>
                <p class="text-xl font-bold text-blue-900 mt-1">{{ $faculty->faculty_id }}</p>
            </div>
            <div class="bg-white/95 rounded-xl shadow p-5">
                <p class="text-sm text-gray-500">Department</p>
                <p class="text-xl font-bold text-blue-900 mt-1">{{ $faculty->department ?? 'Information Technology' }}</p>
            </div>
            <div class="bg-white/95 rounded-xl shadow p-5">
                <p class="text-sm text-gray-500">Total Classes</p>
                <p class="text-xl font-bold text-blue-900 mt-1">{{ $myClasses->count() }}</p>
            </div>
        </div>

        <div class="bg-white/95 rounded-xl shadow-lg p-6">
            <h2 class="text-xl font-bold text-blue-900 mb-4">📚 My Classes</h2>
            
            @if($myClasses->isNotEmpty())
                <div class="space-y-4">
                    @foreach($myClasses as $class)
                    <div class="border rounded-lg p-4 hover:shadow-md transition">
                        <div class="flex flex-col md:flex-row md:justify-between md:items-center gap-3">
                            <div>
                                <h3 class="font-bold text-lg text-blue-900">
                                    {{ $class->subject->code ?? 'N/A' }} — {{ $class->subject->name ?? 'Unknown Subject' }}
                                </h3>
                                <p class="text-gray-600 text-sm mt-1">
                                    📅 {{ $class->schedule ?? 'Schedule not set' }} • 
                                    🏢 Room {{ $class->room ?? 'Not assigned' }}
                                </p>
                                <p class="text-gray-500 text-sm mt-1">
                                    👥 {{ $class->enrollments->count() }} Student(s) Enrolled
                                </p>
                            </div>
                            <a href="{{ route('faculty.class-students', $class->id) }}" 
                               class="bg-blue-900 text-white px-4 py-2 rounded-lg text-center hover:bg-blue-800 transition whitespace-nowrap">
                                View Students →
                            </a>
                        </div>
                    </div>
                    @endforeach
                </div>
            @else
                <p class="text-gray-500 text-center py-8">No classes assigned yet.</p>
            @endif
        </div>
    </div>
</body>
</html>