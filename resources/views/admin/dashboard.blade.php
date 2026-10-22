<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard - De Manaoag University</title>
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
    <div class="max-w-7xl mx-auto px-4 py-8">
        
        @if(session('success'))
            <div class="bg-green-100/90 text-green-700 p-4 rounded-lg mb-6 flex items-center gap-4 backdrop-blur-sm">
                ✅ {{ session('success') }}
            </div>
        @endif

        <h1 class="text-2xl font-bold text-white mb-2">Welcome, Administrator! 🔐</h1>
        <p class="text-blue-200 mb-8">System Overview — De Manaoag University</p>

        {{-- Stats Cards --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
            <div class="bg-white/95 p-6 rounded-xl shadow-sm border border-blue-100 hover:shadow-md transition backdrop-blur-sm">
                <p class="text-gray-500 text-sm mb-2">👥 Total Students</p>
                <p class="text-3xl font-bold text-blue-900">{{ $stats['students'] ?? 0 }}</p>
            </div>
            <div class="bg-white/95 p-6 rounded-xl shadow-sm border border-green-100 hover:shadow-md transition backdrop-blur-sm">
                <p class="text-gray-500 text-sm mb-2">🎓 Total Faculty</p>
                <p class="text-3xl font-bold text-green-700">{{ $stats['faculty'] ?? 0 }}</p>
            </div>
            <div class="bg-white/95 p-6 rounded-xl shadow-sm border border-yellow-100 hover:shadow-md transition backdrop-blur-sm">
                <p class="text-gray-500 text-sm mb-2">🔑 Total Admins</p>
                <p class="text-3xl font-bold text-yellow-600">{{ $stats['admins'] ?? 0 }}</p>
            </div>
        </div>

        {{-- Quick Access --}}
        <h2 class="text-lg font-bold text-white mb-4">Quick Access</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <a href="{{ route('admin.users') }}" class="bg-white/95 p-6 rounded-xl shadow-sm border hover:shadow-md transition group backdrop-blur-sm">
                <h3 class="font-bold text-lg text-blue-900 group-hover:text-blue-700">👥 Manage Users</h3>
                <p class="text-sm text-gray-500 mt-2">View and manage all student, faculty, and admin accounts</p>
            </a>
            <a href="{{ route('admin.subjects') }}" class="bg-white/95 p-6 rounded-xl shadow-sm border hover:shadow-md transition group backdrop-blur-sm">
                <h3 class="font-bold text-lg text-blue-900 group-hover:text-blue-700">📚 Manage Subjects</h3>
                <p class="text-sm text-gray-500 mt-2">Add, edit, and maintain course subjects</p>
            </a>
            <a href="{{ route('admin.classes') }}" class="bg-white/95 p-6 rounded-xl shadow-sm border hover:shadow-md transition group backdrop-blur-sm">
                <h3 class="font-bold text-lg text-blue-900 group-hover:text-blue-700">🏫 Manage Classes</h3>
                <p class="text-sm text-gray-500 mt-2">Assign subjects, faculty, schedules, and rooms</p>
            </a>
            <a href="{{ route('admin.announcements') }}" class="bg-white/95 p-6 rounded-xl shadow-sm border hover:shadow-md transition group backdrop-blur-sm">
                <h3 class="font-bold text-lg text-blue-900 group-hover:text-blue-700">📢 Announcements</h3>
                <p class="text-sm text-gray-500 mt-2">Post and manage university-wide announcements</p>
            </a>
        </div>
    </div>
</body>
</html>