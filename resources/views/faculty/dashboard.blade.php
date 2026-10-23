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
            <div class="bg-green-100/90 text-green-700 p-4 rounded-lg mb-6">
                ✅ {{ session('success') }}
            </div>
        @endif
        <h1 class="text-2xl font-bold text-white mb-2">Welcome, {{ $faculty->first_name ?? 'Faculty' }} {{ $faculty->last_name ?? '' }}! 👋</h1>
        <p class="text-blue-200 mb-8">Faculty Portal — Manage your classes and students.</p>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-white/95 p-5 rounded-xl shadow-sm">
                <p class="text-gray-500 text-sm">Faculty ID</p>
                <p class="font-bold text-blue-900 mt-1">{{ $faculty->faculty_id ?? '—' }}</p>
            </div>
            <div class="bg-white/95 p-5 rounded-xl shadow-sm">
                <p class="text-gray-500 text-sm">Department</p>
                <p class="font-bold text-blue-900 mt-1">{{ $faculty->department ?? 'Not set' }}</p>
            </div>
            <div class="bg-white/95 p-5 rounded-xl shadow-sm">
                <p class="text-gray-500 text-sm">Total Classes</p>
                <p class="font-bold text-blue-900 mt-1">{{ $myClasses->count() }}</p>
            </div>
        </div>
        <h2 class="text-lg font-bold text-white mb-4">📋 My Classes</h2>
        
        @if($myClasses->count())
            <div class="space-y-4">
                @foreach($myClasses as $c)
                <div class="bg-white/95 p-5 rounded-xl shadow-sm">
                    {{-- Ikuha ang code mula sa subject --}}
                    <h3 class="font-bold text-blue-900">
                        {{ $c->subject->code ?? 'N/A' }} - {{ $c->subject->name ?? 'No Subject Name' }}
                    </h3>
                    <p class="text-sm text-gray-500 mt-1">
                        {{ $c->schedule ?? '—' }} • Room {{ $c->room ?? '—' }}
                    </p>
                </div>
                @endforeach
            </div>
        @else
            <div class="bg-white/95 p-8 rounded-xl shadow-sm text-center text-gray-400">
                No classes assigned yet.
            </div>
        @endif
    </div>
</body>
</html>