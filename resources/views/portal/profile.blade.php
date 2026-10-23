<!DOCTYPE html>
<html>
<head>
    <title>Profile - De Manaoag University</title>
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
    <div class="max-w-2xl mx-auto px-4 py-8">

        <h1 class="text-2xl font-bold text-white mb-6">👤 My Profile</h1>

        {{-- Success Message --}}
        @if(session('success'))
            <div class="bg-green-100/90 text-green-700 p-4 rounded-lg mb-6 flex items-center gap-2 backdrop-blur-sm">
                ✅ {{ session('success') }}
            </div>
        @endif

        {{-- Profile Info --}}
        <div class="bg-white/95 p-8 rounded-xl shadow-sm border backdrop-blur-sm space-y-6 mb-6">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <p class="text-gray-500 text-sm mb-1">Student ID</p>
                    <p class="font-bold font-mono text-blue-900">{{ $student->student_id ?? '—' }}</p>
                </div>
                <div>
                    <p class="text-gray-500 text-sm mb-1">Full Name</p>
                    <p class="font-bold text-gray-800">
                        {{ $student->last_name ?? '' }}, {{ $student->first_name ?? '' }} {{ $student->middle_name ?? '' }}
                    </p>
                </div>
                <div>
                    <p class="text-gray-500 text-sm mb-1">Course</p>
                    <p class="font-bold text-gray-800">{{ $student->course ?? '—' }}</p>
                </div>
                <div>
                    <p class="text-gray-500 text-sm mb-1">Year Level</p>
                    <p class="font-bold text-gray-800">
                        @if(isset($student->year_level))
                            @php
                                $suffix = ['st', 'nd', 'rd', 'th'][$student->year_level - 1] ?? 'th';
                            @endphp
                            {{ $student->year_level }}{{ $suffix }} Year
                        @else
                            —
                        @endif
                    </p>
                </div>
                <div>
                    <p class="text-gray-500 text-sm mb-1">Phone</p>
                    <p class="font-bold text-gray-800">{{ $student->phone ?? 'Not set' }}</p>
                </div>
                <div>
                    <p class="text-gray-500 text-sm mb-1">Address</p>
                    <p class="font-bold text-gray-800">{{ $student->address ?? 'Not set' }}</p>
                </div>
            </div>
        </div>

        {{-- Change Password --}}
        <div class="text-center">
            <a href="{{ route('password.change') }}" 
               class="inline-block bg-blue-900 text-white px-8 py-3 rounded-lg font-semibold hover:bg-blue-800 transition">
                🔐 CHANGE PASSWORD
            </a>
        </div>

    </div>
</body>
</html>