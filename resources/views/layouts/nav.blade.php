<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>body{font-family:'Inter',sans-serif;}</style>
</head>
<body class="bg-gray-100 min-h-screen">

<nav class="bg-blue-900 text-white shadow-md">
    <div class="max-w-7xl mx-auto px-4 py-3 flex items-center justify-between">
        <div class="flex items-center gap-3 min-w-0">
            {{-- UNIVERSITY LOGO --}}
            <div class="w-10 h-10 bg-yellow-400 rounded-full flex items-center justify-center shrink-0 overflow-hidden">
                <img
                    src="{{ asset('images/logo.png') }}"
                    alt="De Manaoag University Logo"
                    class="w-full h-full object-cover rounded-full"
                    onerror="this.style.display='none'"
                >
            </div>
            <div class="min-w-0">
                <h1 class="font-bold text-lg leading-tight">DE MANAOAG UNIVERSITY</h1>
                <p class="text-xs text-blue-200">
                    @if(Auth::user()?->role === 'student')
                        Student Portal
                    @elseif(Auth::user()?->role === 'faculty')
                        Faculty Portal
                    @elseif(Auth::user()?->role === 'admin')
                        Admin Portal
                    @endif
                </p>
            </div>
        </div>

        {{-- NAVIGATION LINKS --}}
        <div class="hidden md:flex items-center gap-5">
            @if(Auth::user()?->role === 'student')
                <a href="{{ route('dashboard') }}" 
                   class="hover:text-yellow-300 transition font-medium {{ request()->routeIs('dashboard') ? 'text-yellow-300 border-b-2 border-yellow-300 pb-1' : '' }}">
                    Dashboard
                </a>
                <a href="{{ route('profile') }}" 
                   class="hover:text-yellow-300 transition font-medium {{ request()->routeIs('profile') ? 'text-yellow-300 border-b-2 border-yellow-300 pb-1' : '' }}">
                    Profile
                </a>
                <a href="{{ route('grades') }}" 
                   class="hover:text-yellow-300 transition font-medium {{ request()->routeIs('grades') ? 'text-yellow-300 border-b-2 border-yellow-300 pb-1' : '' }}">
                    Grades
                </a>
                <a href="{{ route('subjects') }}" 
                   class="hover:text-yellow-300 transition font-medium {{ request()->routeIs('subjects') ? 'text-yellow-300 border-b-2 border-yellow-300 pb-1' : '' }}">
                    Subjects
                </a>
                <a href="{{ route('announcements') }}" 
                   class="hover:text-yellow-300 transition font-medium {{ request()->routeIs('announcements') ? 'text-yellow-300 border-b-2 border-yellow-300 pb-1' : '' }}">
                    Announcements
                </a>
            @elseif(Auth::user()?->role === 'faculty')
                <a href="{{ route('faculty.dashboard') }}" 
                   class="hover:text-yellow-300 transition font-medium {{ request()->routeIs('faculty.dashboard') ? 'text-yellow-300 border-b-2 border-yellow-300 pb-1' : '' }}">
                    Dashboard
                </a>
                <a href="{{ route('faculty.schedule') }}" 
                   class="hover:text-yellow-300 transition font-medium {{ request()->routeIs('faculty.schedule') ? 'text-yellow-300 border-b-2 border-yellow-300 pb-1' : '' }}">
                    My Schedule
                </a>
                <a href="{{ route('faculty.announcements') }}" 
                   class="hover:text-yellow-300 transition font-medium {{ request()->routeIs('faculty.announcements') ? 'text-yellow-300 border-b-2 border-yellow-300 pb-1' : '' }}">
                    Announcements
                </a>
            @elseif(Auth::user()?->role === 'admin')
                <a href="{{ route('admin.dashboard') }}" 
                   class="hover:text-yellow-300 transition font-medium {{ request()->routeIs('admin.dashboard') ? 'text-yellow-300 border-b-2 border-yellow-300 pb-1' : '' }}">
                    Dashboard
                </a>
                <a href="{{ route('admin.users') }}" 
                   class="hover:text-yellow-300 transition font-medium {{ request()->routeIs('admin.users') ? 'text-yellow-300 border-b-2 border-yellow-300 pb-1' : '' }}">
                    Manage Users
                </a>
                <a href="{{ route('admin.subjects') }}" 
                   class="hover:text-yellow-300 transition font-medium {{ request()->routeIs('admin.subjects') ? 'text-yellow-300 border-b-2 border-yellow-300 pb-1' : '' }}">
                    Manage Subjects
                </a>
                <a href="{{ route('admin.classes') }}" 
                   class="hover:text-yellow-300 transition font-medium {{ request()->routeIs('admin.classes') ? 'text-yellow-300 border-b-2 border-yellow-300 pb-1' : '' }}">
                    Manage Classes
                </a>
                <a href="{{ route('admin.enrollments') }}" 
                   class="hover:text-yellow-300 transition font-medium {{ request()->routeIs('admin.enrollments') ? 'text-yellow-300 border-b-2 border-yellow-300 pb-1' : '' }}">
                    Enroll Students
                </a>
                <a href="{{ route('admin.announcements') }}" 
                   class="hover:text-yellow-300 transition font-medium {{ request()->routeIs('admin.announcements') ? 'text-yellow-300 border-b-2 border-yellow-300 pb-1' : '' }}">
                    Announcements
                </a>
            @endif
        </div>

        {{-- USER INFO & LOGOUT --}}
        <div class="flex items-center gap-4 shrink-0">
            <div class="text-right hidden sm:block">
                <p class="font-semibold text-sm">{{ Auth::user()?->name ?? 'Guest' }}</p>
                <p class="text-xs text-blue-200">
                    @if(Auth::user()?->role === 'student')
                        Student
                    @elseif(Auth::user()?->role === 'faculty')
                        Faculty
                    @elseif(Auth::user()?->role === 'admin')
                        Administrator
                    @endif
                </p>
            </div>
            
            <form action="{{ route('logout') }}" method="POST" class="inline">
                @csrf
                <button type="submit" class="bg-red-600 hover:bg-red-700 px-4 py-2 rounded text-sm font-medium transition">
                    Logout
                </button>
            </form>
        </div>
    </div>
</nav>

{{-- PAGE CONTENT --}}
<main>
    @yield('content')
</main>

</body>
</html>