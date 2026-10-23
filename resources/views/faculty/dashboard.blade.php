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
            min-height: 100vh;
        }
    </style>
</head>
<body>
    @include('layouts.nav')
    
    <div class="max-w-7xl mx-auto px-4 py-8">
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-white">Welcome, {{ $faculty->first_name }} {{ $faculty->last_name }}! 👋</h1>
            <p class="text-blue-200 mt-2">Faculty Portal — Manage your classes and students.</p>
        </div>

        <!-- Stats Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-white/95 p-5 rounded-xl shadow-sm">
                <p class="text-sm text-gray-500">Faculty ID</p>
                <p class="text-xl font-bold text-blue-900 mt-1">{{ $faculty->faculty_id }}</p>
            </div>
            <div class="bg-white/95 p-5 rounded-xl shadow-sm">
                <p class="text-sm text-gray-500">Department</p>
                <p class="text-xl font-bold text-blue-900 mt-1">{{ $faculty->department ?? 'Not Set' }}</p>
            </div>
            <div class="bg-white/95 p-5 rounded-xl shadow-sm">
                <p class="text-sm text-gray-500">Total Classes</p>
                <p class="text-xl font-bold text-blue-900 mt-1">{{ $myClasses->count() }}</p>
            </div>
        </div>

        <!-- My Classes — Ibalik ang View Students ✅ -->
        <div>
            <h2 class="text-xl font-semibold text-white mb-4">📋 My Classes</h2>
            
            @if($myClasses->isEmpty())
                <div class="bg-white/95 p-6 rounded-xl text-gray-500">
                    No classes assigned yet.
                </div>
            @else
                <div class="space-y-4">
                    @foreach($myClasses as $class)
                    <div class="bg-white/95 p-5 rounded-xl shadow-sm">
                        <h3 class="font-bold text-lg text-blue-900">
                            {{ $class->subject->code ?? 'N/A' }} - {{ $class->subject->name ?? 'Unknown Subject' }}
                        </h3>
                        <p class="text-gray-600 mt-1">
                            {{ $class->schedule ?? 'Schedule not set' }} • Room {{ $class->room ?? 'Not set' }}
                        </p>
                        <div class="mt-3">
                            <a href="{{ route('faculty.classStudents', ['classId' => $class->id]) }}" 
                               class="inline-block bg-blue-900 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-blue-800 transition">
                                👥 View Students
                            </a>
                        </div>
                    </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</body>
</html>