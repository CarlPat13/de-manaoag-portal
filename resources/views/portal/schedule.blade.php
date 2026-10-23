<!DOCTYPE html>
<html>
<head>
    <title>Schedule - De Manaoag University</title>
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
<body class="bg-gray-50 min-h-screen">
    @include('layouts.nav')
    <div class="max-w-5xl mx-auto px-4 py-8">
        <h1 class="text-2xl font-bold text-white mb-6">📅 My Schedule</h1>

        @if(!isset($schedules) || count($schedules) === 0)
            <div class="bg-white/90 p-8 rounded-xl text-center backdrop-blur-sm">
                <div class="text-5xl mb-4">📭</div>
                <h3 class="text-lg font-semibold text-gray-700">No Schedule Yet</h3>
                <p class="text-gray-500 mt-2">
                    Your schedule will appear here once you are enrolled in classes.
                </p>
            </div>
        @else
            <div class="bg-white/95 rounded-xl shadow-sm border overflow-hidden backdrop-blur-sm">
                <table class="w-full text-left">
                    <thead class="bg-blue-900 text-white">
                        <tr>
                            <th class="p-4 font-semibold">Subject Code</th>
                            <th class="p-4 font-semibold">Subject Name</th>
                            <th class="p-4 font-semibold">Day / Time</th>
                            <th class="p-4 font-semibold">Room</th>
                            <th class="p-4 font-semibold">Faculty</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($schedules as $enroll)
                            @php
                                $class = $enroll->class;
                                if (!$class) continue;
                                $subject = $class->subject;
                                $faculty = $class->faculty;
                            @endphp
                            <tr class="border-t hover:bg-blue-50">
                                <td class="p-4 font-mono font-bold text-blue-900">
                                    {{ $subject?->code ?? 'N/A' }}
                                </td>
                                <td class="p-4">
                                    {{ $subject?->name ?? 'N/A' }}
                                </td>
                                <td class="p-4 text-sm">
                                    @if($class->schedule)
                                        {{ $class->schedule }}
                                    @else
                                        <span class="text-gray-400">Not Set</span>
                                    @endif
                                </td>
                               <td class="p-4 text-sm">
    {{ $class->room ?? '-' }}
</td>
                                <td class="p-4 text-sm">
                                    @if($faculty)
                                        {{ $faculty->first_name }} {{ $faculty->last_name }}
                                    @else
                                        <span class="text-gray-400">Not Assigned</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</body>
</html>