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
        @if(session('warning'))
            <div class="bg-yellow-50 border-l-4 border-yellow-500 text-yellow-700 p-4 mb-6 rounded-r-lg">
                {{ session('warning') }}
            </div>
        @endif

        <div class="mb-8">
            <h1 class="text-3xl font-bold text-white">
                Welcome, {{ optional($faculty)->first_name ?? Auth::user()->name ?? 'Faculty Member' }}! 👋
            </h1>
            <p class="text-blue-200 mt-2">Faculty Portal — Manage your classes and students.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-white/95 p-5 rounded-xl shadow-sm">
                <p class="text-sm text-gray-500">Faculty ID</p>
                <p class="text-xl font-bold text-blue-900 mt-1">
                    {{ optional($faculty)->faculty_id ?? 'Not Assigned' }}
                </p>
            </div>
            <div class="bg-white/95 p-5 rounded-xl shadow-sm">
                <p class="text-sm text-gray-500">Department</p>
                <p class="text-xl font-bold text-blue-900 mt-1">
                    {{ optional($faculty)->department ?? 'Not Set' }}
                </p>
            </div>
            <div class="bg-white/95 p-5 rounded-xl shadow-sm">
                <p class="text-sm text-gray-500">Total Classes</p>
                <p class="text-xl font-bold text-blue-900 mt-1">
                    {{ $myClasses->count() }}
                </p>
            </div>
        </div>

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
                            {{ optional($class->subject)->code ?? 'N/A' }} - {{ optional($class->subject)->name ?? 'Unknown Subject' }}
                        </h3>
                        <p class="text-gray-600 mt-1">
                            {{ $class->schedule ?? 'Schedule not set' }} • Room {{ $class->room ?? 'Not set' }}
                        </p>
                    </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</body>
</html>