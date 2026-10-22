<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Dashboard - De Manaoag University</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        * {
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(rgba(10, 35, 66, 0.85), rgba(10, 35, 66, 0.90)), 
                        url('{{ asset('images/bg-campus.jpg') }}') center/cover no-repeat fixed;
            min-height: 100vh;
            color: #1e293b;
        }
        :root {
            --navy: #0A2342;
            --navy-light: #134074;
            --gold: #D4AF37;
            --gold-light: #fbf5df;
        }
        .text-navy { color: var(--navy); }
        .bg-navy { background-color: var(--navy); }
        .bg-gold { background-color: var(--gold); }
        .text-gold { color: var(--gold); }
        
        .dashboard-card {
            background: rgba(255, 255, 255, 0.94);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(212, 175, 55, 0.15);
            border-radius: 16px;
            box-shadow: 0 2px 12px rgba(10, 35, 66, 0.08);
            transition: all 0.3s ease;
        }
        .dashboard-card:hover {
            border-color: rgba(212, 175, 55, 0.4);
            box-shadow: 0 12px 32px rgba(10, 35, 66, 0.15);
            transform: translateY(-2px);
        }
        .stat-icon {
            width: 46px;
            height: 46px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            border-radius: 12px;
            font-size: 22px;
        }
        .section-title {
            font-size: 17px;
            font-weight: 700;
            color: var(--navy);
        }
        .table-row:hover {
            background: #f8fafc;
        }
        a:focus-visible,
        button:focus-visible {
            outline: 3px solid #D4AF37;
            outline-offset: 3px;
        }
        @media (prefers-reduced-motion: reduce) {
            *, *::before, *::after {
                transition: none !important;
                scroll-behavior: auto !important;
            }
        }
    </style>
</head>
<body>
    @include('layouts.nav')
    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 lg:py-9">
        {{-- SUCCESS MESSAGE --}}
        @if(session('success'))
            <div role="status"
                 class="flex items-start gap-3 bg-green-50 border border-green-200
                        text-green-800 rounded-xl p-4 mb-6">
                <span class="text-xl" aria-hidden="true">✓</span>
                <div>
                    <p class="font-semibold text-sm">Success</p>
                    <p class="text-sm mt-1">{{ session('success') }}</p>
                </div>
            </div>
        @endif

        {{-- WELCOME HEADER --}}
        <section class="relative overflow-hidden bg-navy rounded-2xl
                        p-6 sm:p-8 mb-7 shadow-lg">
            <div class="absolute -right-12 -top-20 w-64 h-64 rounded-full
                        border border-white/10 pointer-events-none"></div>
            <div class="absolute -right-4 -top-12 w-44 h-44 rounded-full
                        border border-yellow-400/20 pointer-events-none"></div>
            <div class="relative flex flex-col sm:flex-row sm:items-center
                        sm:justify-between gap-5">
                <div>
                    <div class="flex items-center gap-2 mb-3">
                        <span class="w-2 h-2 rounded-full bg-yellow-400"></span>
                        <p class="text-blue-100 text-xs font-semibold uppercase
                                   tracking-widest">
                            Student Portal
                        </p>
                    </div>
                    <h1 class="text-2xl sm:text-3xl font-bold text-white">
                        Welcome back, {{ $student->first_name }}!
                    </h1>
                    <p class="text-blue-100 text-sm mt-2 leading-6">
                        Here's an overview of your academic information.
                    </p>
                    <div class="flex flex-wrap items-center gap-x-5 gap-y-2 mt-5">
                        <p class="text-sm text-blue-100">
                            Student ID:
                            <span class="text-yellow-300 font-bold font-mono ml-1">
                                {{ $student->student_id ?: 'Not assigned' }}
                            </span>
                        </p>
                        <span class="hidden sm:block text-white/30">|</span>
                        <p class="text-sm text-blue-100">
                            {{ $student->course }}
                        </p>
                    </div>
                </div>
                <div class="sm:text-right shrink-0">
                    <div class="inline-flex items-center gap-2 bg-white/10
                                border border-white/10 rounded-xl px-4 py-3">
                        <span class="text-xl" aria-hidden="true">🎓</span>
                        <div class="text-left">
                            <p class="text-xs text-blue-100">Academic Level</p>
                            <p class="font-semibold text-white text-sm">
                                @php
                                    $yearLabels = [
                                        '1' => '1st Year',
                                        '2' => '2nd Year',
                                        '3' => '3rd Year',
                                        '4' => '4th Year',
                                    ];
                                @endphp
                                {{ $yearLabels[(string) $student->year_level] ?? $student->year_level }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        {{-- STUDENT OVERVIEW --}}
        <section class="mb-8" aria-label="Student information">
            <div class="flex items-center justify-between mb-4">
                <h2 class="section-title text-white">My Overview</h2>
                <span class="text-xs text-gray-300">Student information</span>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 gap-4">
                {{-- COURSE --}}
                <article class="dashboard-card p-5">
                    <div class="flex items-center gap-4">
                        <div class="stat-icon bg-blue-50 text-blue-800" aria-hidden="true">📚</div>
                        <div class="min-w-0">
                            <p class="text-sm text-gray-500">Enrolled Course</p>
                            <p class="text-lg font-bold text-navy mt-1 break-words">
                                {{ $student->course ?: 'Not specified' }}
                            </p>
                            <p class="text-xs text-gray-400 mt-1">Your academic program</p>
                        </div>
                    </div>
                </article>
                {{-- YEAR LEVEL --}}
                <article class="dashboard-card p-5">
                    <div class="flex items-center gap-4">
                        <div class="stat-icon bg-amber-50 text-amber-700" aria-hidden="true">🎓</div>
                        <div class="min-w-0">
                            <p class="text-sm text-gray-500">Year Level</p>
                            <p class="text-lg font-bold text-navy mt-1">
                                {{ $yearLabels[(string) $student->year_level] ?? $student->year_level }}
                            </p>
                            <p class="text-xs text-gray-400 mt-1">Current academic level</p>
                        </div>
                    </div>
                </article>
                {{-- EMAIL --}}
                <article class="dashboard-card p-5 sm:col-span-2 xl:col-span-1">
                    <div class="flex items-center gap-4">
                        <div class="stat-icon bg-emerald-50 text-emerald-700" aria-hidden="true">✉</div>
                        <div class="min-w-0">
                            <p class="text-sm text-gray-500">Email Address</p>
                            <p class="text-sm font-bold text-navy mt-2 break-all">
                                {{ $user->email }}
                            </p>
                            <p class="text-xs text-gray-400 mt-1">Your registered email</p>
                        </div>
                    </div>
                </article>
            </div>
        </section>

        {{-- CLASS SCHEDULE — ✅ TUNAY NA DATA NA --}}
        <section class="dashboard-card mb-8 overflow-hidden">
            <div class="p-5 sm:p-6 border-b border-gray-100
                        flex flex-col sm:flex-row sm:items-center
                        sm:justify-between gap-3">
                <div class="flex items-center gap-3">
                    <div class="stat-icon bg-blue-50 text-blue-800" aria-hidden="true">📅</div>
                    <div>
                        <h2 class="section-title">My Class Schedule</h2>
                        <p class="text-sm text-gray-500 mt-1">
                            Check your class times and assigned rooms.
                        </p>
                    </div>
                </div>
                <span class="text-xs font-medium text-gray-500 bg-gray-100
                             rounded-lg px-3 py-2 self-start sm:self-auto">
                    Class timetable
                </span>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <caption class="sr-only">
                        Student class schedule, including subject, time, room and faculty
                    </caption>
                    <thead class="bg-gray-50 text-gray-500 text-xs uppercase tracking-wide">
                        <tr>
                            <th scope="col" class="px-5 py-4 font-semibold">Subject Code</th>
                            <th scope="col" class="px-5 py-4 font-semibold">Subject Name</th>
                            <th scope="col" class="px-5 py-4 font-semibold">Schedule</th>
                            <th scope="col" class="px-5 py-4 font-semibold">Room</th>
                            <th scope="col" class="px-5 py-4 font-semibold">Faculty</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @if(!isset($enrollments) || count($enrollments) === 0)
                            <tr>
                                <td colspan="5" class="px-5 py-10 text-center text-gray-500">
                                    <div class="text-3xl mb-2" aria-hidden="true">📭</div>
                                    <p>No classes enrolled yet.</p>
                                    <p class="text-xs mt-1">Your schedule will appear here once enrolled.</p>
                                </td>
                            </tr>
                        @else
                            @foreach($enrollments as $enroll)
                                @php $class = $enroll->class; @endphp
                                @if($class)
                                    <tr>
                                        <td class="px-5 py-3 font-mono font-bold text-navy">
                                            {{ $class->subject?->code ?? 'N/A' }}
                                        </td>
                                        <td class="px-5 py-3">
                                            {{ $class->subject?->name ?? 'N/A' }}
                                        </td>
                                        <td class="px-5 py-3 text-sm">
                                            {{ $class->schedule ?? 'Not Set' }}
                                        </td>
                                        {{-- ✅ ROOM NUMBER — LALABAS NA! --}}
                                        <td class="px-5 py-3 text-sm font-medium">
                                            {{ $class->room ?? 'Not Assigned' }}
                                        </td>
                                        <td class="px-5 py-3 text-sm">
                                            @if($class->faculty)
                                                {{ $class->faculty->first_name }} {{ $class->faculty->last_name }}
                                            @else
                                                <span class="text-gray-400">Not Assigned</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endif
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
        </section>

        {{-- SUBJECTS AND ANNOUNCEMENTS --}}
        <div class="grid grid-cols-1 xl:grid-cols-2 gap-6 items-start">
            {{-- MY SUBJECTS --}}
            <section class="dashboard-card overflow-hidden">
                <div class="p-5 sm:p-6 border-b border-gray-100 flex items-center gap-3">
                    <div class="stat-icon bg-amber-50 text-amber-700" aria-hidden="true">📖</div>
                    <div>
                        <h2 class="section-title">My Subjects</h2>
                        <p class="text-sm text-gray-500 mt-1">
                            Your subjects and academic progress.
                        </p>
                    </div>
                </div>
                <div class="p-5 space-y-3">
                    @if(!isset($enrollments) || count($enrollments) === 0)
                        <div class="text-center py-8 text-gray-500">
                            <div class="text-2xl mb-2" aria-hidden="true">📭</div>
                            <p class="text-sm">No subjects enrolled yet.</p>
                        </div>
                    @else
                        @foreach($enrollments as $enroll)
                            @php 
                                $class = $enroll->class;
                                if (!$class) continue;
                                $subject = $class->subject;
                            @endphp
                            <article class="border border-gray-100 rounded-xl p-4 hover:border-amber-200 transition-colors">
                                <div class="flex items-start justify-between gap-3">
                                    <div class="min-w-0">
                                        <p class="font-bold text-navy text-sm">
                                            {{ $subject?->code ?? 'N/A' }}
                                        </p>
                                        <h3 class="text-sm text-gray-600 mt-1 leading-5">
                                            {{ $subject?->name ?? 'N/A' }}
                                        </h3>
                                        <p class="text-xs text-gray-400 mt-2">
                                            {{ $subject?->units ?? 3 }} {{ ($subject?->units ?? 3) == 1 ? 'unit' : 'units' }}
                                        </p>
                                    </div>
                                    <div class="text-right shrink-0">
                                        @if($enroll->grade)
                                            <span class="inline-flex items-center rounded-full
                                                        bg-green-50 text-green-700 px-2.5 py-1 text-xs font-semibold">
                                                Completed
                                            </span>
                                            <p class="text-xs text-gray-500 mt-3">Final grade</p>
                                            <p class="font-bold text-navy mt-1">{{ $enroll->grade }}</p>
                                        @else
                                            <span class="inline-flex items-center rounded-full
                                                        bg-blue-50 text-blue-700 px-2.5 py-1 text-xs font-semibold">
                                                Ongoing
                                            </span>
                                            <p class="text-xs text-gray-400 mt-3">Grade pending</p>
                                        @endif
                                    </div>
                                </div>
                            </article>
                        @endforeach
                    @endif
                </div>
            </section>

            {{-- ANNOUNCEMENTS --}}
            <section class="dashboard-card overflow-hidden">
                <div class="p-5 sm:p-6 border-b border-gray-100 flex items-center gap-3">
                    <div class="stat-icon bg-blue-50 text-blue-800" aria-hidden="true">📢</div>
                    <div>
                        <h2 class="section-title">Announcements</h2>
                        <p class="text-sm text-gray-500 mt-1">
                            Latest university updates and notices.
                        </p>
                    </div>
                </div>
                <div class="p-5">
                    @if(isset($announcements) && $announcements->count() > 0)
                        <div class="space-y-5">
                            @foreach($announcements as $a)
                                <article class="relative pl-5 border-l-2 border-amber-300 pb-1">
                                    <div class="absolute w-2 h-2 rounded-full bg-amber-400 -left-[5px] top-1"></div>
                                    <h3 class="font-bold text-navy text-sm leading-5">{{ $a->title }}</h3>
                                    <p class="text-xs text-gray-400 mt-2 mb-3">
                                        {{ $a->created_at ? $a->created_at->format('F j, Y') : 'Date unavailable' }}
                                    </p>
                                    <p class="text-sm text-gray-600 leading-6 whitespace-pre-line break-words">
                                        {{ $a->content }}
                                    </p>
                                </article>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-10">
                            <div class="text-4xl mb-3" aria-hidden="true">📭</div>
                            <h3 class="font-semibold text-gray-700 text-sm">No announcements yet</h3>
                            <p class="text-sm text-gray-400 mt-2">
                                University announcements will appear here.
                            </p>
                        </div>
                    @endif
                </div>
            </section>
        </div>

        {{-- FOOTER --}}
        <footer class="text-center py-8">
            <p class="text-xs text-gray-300">De Manaoag University</p>
            <p class="text-xs text-gray-400 mt-1">Student Portal · Academic Information</p>
        </footer>
    </main>
</body>
</html>