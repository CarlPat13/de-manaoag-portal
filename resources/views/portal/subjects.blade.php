<!DOCTYPE html>
<html>
<head>
    <title>My Subjects - De Manaoag University</title>
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
    <div class="max-w-5xl mx-auto px-4 py-8">
        <h1 class="text-2xl font-bold text-white mb-6">📚 My Subjects</h1>

        {{-- Check kung may laman ang $mySubjects --}}
        @if(empty($mySubjects) || count($mySubjects) === 0)
            <div class="bg-white/90 p-8 rounded-xl text-center backdrop-blur-sm">
                <div class="text-5xl mb-4">📭</div>
                <h3 class="text-lg font-semibold text-gray-700">No Subjects Enrolled Yet</h3>
                <p class="text-gray-500 mt-2">
                    Your subjects will appear here once the administrator enrolls you in classes.
                </p>
            </div>
        @else
            <div class="bg-white/95 rounded-xl shadow-sm border overflow-hidden backdrop-blur-sm">
                <table class="w-full text-left">
                    <thead class="bg-blue-900 text-white">
                        <tr>
                            <th class="p-4 font-semibold">Code</th>
                            <th class="p-4 font-semibold">Subject Name</th>
                            <th class="p-4 font-semibold text-center">Units</th>
                            <th class="p-4 font-semibold text-center">Schedule / Room</th>
                            <th class="p-4 font-semibold text-center">Grade</th>
                            <th class="p-4 font-semibold text-center">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($mySubjects as $subj)
                        <tr class="border-t hover:bg-blue-50">
                            {{-- Code --}}
                            <td class="p-4 font-mono font-bold text-blue-900">
                                {{ $subj['code'] ?? 'N/A' }}
                            </td>
                            
                            {{-- Subject Name + Faculty --}}
                            <td class="p-4">
                                {{ $subj['name'] ?? 'N/A' }}
                                @if(!empty($subj['faculty']))
                                    <p class="text-xs text-gray-500 mt-1">{{ $subj['faculty'] }}</p>
                                @endif
                            </td>
                            
                            {{-- Units --}}
                            <td class="p-4 text-center">
                                {{ $subj['units'] ?? 3 }}
                            </td>
                            
                            {{-- Schedule + Room --}}
                            <td class="p-4 text-center text-sm">
                                {{ $subj['schedule'] ?? '-' }}
                                @if(!empty($subj['room']))
                                    <br><span class="text-gray-500">{{ $subj['room'] }}</span>
                                @endif
                            </td>
                            
                            {{-- Grade --}}
                            <td class="p-4 text-center font-bold">
                                {{ $subj['grade'] ?? '—' }}
                            </td>
                            
                            {{-- Status --}}
                            <td class="p-4 text-center">
                                @if(($subj['status'] ?? 'Ongoing') === 'Completed')
                                    <span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-sm font-medium">
                                        Completed
                                    </span>
                                @else
                                    <span class="px-3 py-1 bg-blue-100 text-blue-700 rounded-full text-sm font-medium">
                                        Ongoing
                                    </span>
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