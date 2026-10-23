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
        @if(session('success'))
            <div class="bg-green-100/90 text-green-700 p-4 rounded-lg mb-6 backdrop-blur-sm">
                ✅ {{ session('success') }}
            </div>
        @endif

        <h1 class="text-2xl font-bold text-white mb-2">
            Welcome, {{ optional($faculty)->first_name ?? 'Faculty' }}! 👋
        </h1>
        <p class="text-blue-200 mb-8">Faculty Portal — Manage your classes and students.</p>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-white/95 p-5 rounded-xl shadow-sm border backdrop-blur-sm">
                <p class="text-gray-500 text-sm">Faculty ID</p>
                <p class="font-bold text-blue-900 mt-1">{{ optional($faculty)->faculty_id ?? '—' }}</p>
            </div>
            <div class="bg-white/95 p-5 rounded-xl shadow-sm border backdrop-blur-sm">
                <p class="text-gray-500 text-sm">Department</p>
                <p class="font-bold text-blue-900 mt-1">{{ optional($faculty)->department ?? 'Not set' }}</p>
            </div>
            <div class="bg-white/95 p-5 rounded-xl shadow-sm border backdrop-blur-sm">
                <p class="text-gray-500 text-sm">Total Classes</p>
                <p class="font-bold text-blue-900 mt-1">{{ $myClasses->count() }}</p>
            </div>
        </div>

        @if(!$faculty)
            <div class="bg-yellow-50 p-6 rounded-xl text-center">
                <p class="text-yellow-700 font-medium">⚠️ Your faculty profile is not yet linked.</p>
                <p class="text-yellow-600 text-sm mt-1">Contact admin to connect your account.</p>
            </div>
        @elseif($myClasses->isEmpty())
            <div class="bg-white/95 p-8 rounded-xl shadow-sm border text-center text-gray-400 backdrop-blur-sm">
                No classes assigned yet.
            </div>
        @else
            <h2 class="text-lg font-bold text-white mb-4">📋 My Classes</h2>
            <div class="space-y-4">
                @foreach($myClasses as $c)
                <div class="bg-white/95 p-5 rounded-xl shadow-sm border flex justify-between items-start backdrop-blur-sm">
                    <div>
                        <h3 class="font-bold text-blue-900">
                            {{ optional($c->subject)->code ?? 'N/A' }} — {{ optional($c->subject)->name ?? 'Unknown Subject' }}
                        </h3>
                        <p class="text-sm text-gray-500 mt-1">
                            {{ $c->schedule ?? '—' }} • Room {{ $c->room ?? '—' }}
                        </p>
                        <p class="text-sm text-green-600 mt-1">
                            {{ method_exists($c, 'students') ? $c->students()->count() : $c->enrollments->count() }} Student(s) Enrolled
                        </p>
                    </div>
                    <a href="{{ route('faculty.classStudents', $c->id) }}"
                       class="bg-blue-900 text-white px-4 py-2 rounded-lg text-sm hover:bg-blue-800 transition shrink-0 ml-4">
                        View Students →
                    </a>
                </div>
                @endforeach
            </div>
        @endif
    </div>
</body>
</html>