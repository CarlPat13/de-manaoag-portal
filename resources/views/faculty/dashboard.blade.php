<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Faculty Dashboard - De Manaoag University</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; background: linear-gradient(rgba(10, 35, 66, 0.92), rgba(10, 35, 66, 0.95)); min-height: 100vh; }
    </style>
</head>
<body class="text-white">
    @include('layouts.nav')
    
    <div class="max-w-7xl mx-auto px-4 py-8">
        @if(session('success'))
            <div class="bg-green-500/20 border border-green-400/30 p-4 rounded-xl mb-6 text-green-200">
                {{ session('success') }}
            </div>
        @endif

        <h1 class="text-3xl font-bold mb-2">
            Welcome, {{ optional($faculty)->first_name ?? 'Faculty' }}! 👋
        </h1>
        <p class="text-blue-200 mb-8">Faculty Portal — Manage your classes and students</p>

        @if(!$faculty)
            <div class="bg-yellow-500/20 border border-yellow-400/30 p-6 rounded-xl">
                <p class="text-yellow-200 font-medium">⚠️ Your faculty profile is not yet linked.</p>
                <p class="text-yellow-300/70 text-sm mt-1">Contact admin to connect your account.</p>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
                <div class="bg-white/10 backdrop-blur-sm p-6 rounded-xl">
                    <p class="text-blue-200 text-sm">Faculty ID</p>
                    <p class="text-xl font-semibold mt-1">{{ optional($faculty)->faculty_id ?? '—' }}</p>
                </div>
                <div class="bg-white/10 backdrop-blur-sm p-6 rounded-xl">
                    <p class="text-blue-200 text-sm">Department</p>
                    <p class="text-xl font-semibold mt-1">{{ optional($faculty)->department ?? 'Not Set' }}</p>
                </div>
                <div class="bg-white/10 backdrop-blur-sm p-6 rounded-xl">
                    <p class="text-blue-200 text-sm">Total Classes</p>
                    <p class="text-xl font-semibold mt-1">{{ $myClasses->count() }}</p>
                </div>
            </div>

            @if($myClasses->isEmpty())
                <div class="bg-white/10 backdrop-blur-sm p-8 rounded-xl text-center">
                    <p class="text-blue-200">No classes assigned yet.</p>
                    <p class="text-blue-300/60 text-sm mt-1">Contact admin to be assigned to classes.</p>
                </div>
            @else
                <h2 class="text-xl font-semibold mb-4">📋 My Classes</h2>
                <div class="space-y-4">
                    @foreach($myClasses as $class)
                    <div class="bg-white/10 backdrop-blur-sm p-5 rounded-xl">
                        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                            <div>
                                <h3 class="font-semibold text-lg">
                                    {{ optional($class->subject)->code ?? 'N/A' }} — {{ optional($class->subject)->name ?? 'Unknown Subject' }}
                                </h3>
                                <p class="text-blue-200 text-sm mt-1">
                                    {{ $class->schedule ?? 'Schedule not set' }}
                                    @if($class->room) • Room {{ $class->room }} @endif
                                </p>
                                <p class="text-green-300 text-sm mt-1">
                                    {{ $class->enrollments->count() }} student(s) enrolled
                                </p>
                            </div>
                            <a href="{{ route('faculty.classStudents', $class->id) }}" 
                               class="bg-blue-500 hover:bg-blue-600 px-5 py-2.5 rounded-lg text-center transition">
                                View Students →
                            </a>
                        </div>
                    </div>
                    @endforeach
                </div>
            @endif
        @endif
    </div>
</body>
</html>