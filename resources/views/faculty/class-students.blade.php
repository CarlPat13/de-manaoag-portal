<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Class Students - De Manaoag University</title>
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
<body class="text-white">
    @include('layouts.nav')
    
    <div class="max-w-7xl mx-auto px-4 py-8">
        <a href="{{ route('faculty.dashboard') }}" class="text-blue-300 hover:text-white mb-6 inline-block">← Back to My Classes</a>
        
        <div class="bg-white/10 backdrop-blur-sm rounded-xl p-6 mb-6">
            <h1 class="text-2xl font-bold mb-2">
                {{ optional($class->subject)->code ?? 'N/A' }} — 
                {{ optional($class->subject)->name ?? 'Unknown Subject' }}
            </h1>
            <p class="text-blue-200">
                Schedule: {{ $class->schedule ?? 'Not set' }}
                @if($class->room) | Room: {{ $class->room }} @endif
            </p>
        </div>

        @if(session('success'))
            <div class="bg-green-500/20 border border-green-400/30 p-4 rounded-xl mb-6 text-green-200">
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-white/10 backdrop-blur-sm rounded-xl overflow-hidden">
            <div class="px-6 py-4 bg-white/10 border-b font-semibold">
                Enrolled Students — {{ $class->enrollments->count() }} student(s)
            </div>

            @if($class->enrollments->isEmpty())
                <div class="p-6 text-blue-200 text-center">
                    No students enrolled yet.
                </div>
            @else
                <form action="{{ route('faculty.assignGrades') }}" method="POST">
                    @csrf
                    <table class="w-full text-left">
                        <thead>
                            <tr class="bg-white/5 text-blue-200 text-sm">
                                <th class="px-6 py-3 font-semibold">Student ID</th>
                                <th class="px-6 py-3 font-semibold">Name</th>
                                <th class="px-6 py-3 font-semibold">Current Grade</th>
                                <th class="px-6 py-3 font-semibold w-48">Assign Grade</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($class->enrollments as $enroll)
                            <tr class="border-t border-white/10">
                                <td class="px-6 py-3 text-sm">
                                    {{ optional($enroll->student)->student_id ?? 'N/A' }}
                                </td>
                                <td class="px-6 py-3 font-medium">
                                    {{ optional($enroll->student)->first_name ?? '' }} 
                                    {{ optional($enroll->student)->last_name ?? '' }}
                                </td>
                                <td class="px-6 py-3 text-blue-200">
                                    {{ $enroll->grade ? $enroll->grade : '— Pending' }}
                                </td>
                                <td class="px-6 py-3">
                                    <input type="hidden" name="enrollment_ids[]" value="{{ $enroll->id }}">
                                    <select name="grades[]" class="w-full px-3 py-1.5 rounded-lg bg-white/10 border border-white/20 focus:outline-none focus:border-blue-400">
                                        <option value="" {{ !$enroll->grade ? 'selected' : '' }}>— Select Grade —</option>
                                        <option value="1.0" {{ $enroll->grade == '1.0' ? 'selected' : '' }}>1.0</option>
                                        <option value="1.25" {{ $enroll->grade == '1.25' ? 'selected' : '' }}>1.25</option>
                                        <option value="1.5" {{ $enroll->grade == '1.5' ? 'selected' : '' }}>1.5</option>
                                        <option value="1.75" {{ $enroll->grade == '1.75' ? 'selected' : '' }}>1.75</option>
                                        <option value="2.0" {{ $enroll->grade == '2.0' ? 'selected' : '' }}>2.0</option>
                                        <option value="2.25" {{ $enroll->grade == '2.25' ? 'selected' : '' }}>2.25</option>
                                        <option value="2.5" {{ $enroll->grade == '2.5' ? 'selected' : '' }}>2.5</option>
                                        <option value="2.75" {{ $enroll->grade == '2.75' ? 'selected' : '' }}>2.75</option>
                                        <option value="3.0" {{ $enroll->grade == '3.0' ? 'selected' : '' }}>3.0</option>
                                        <option value="4.0" {{ $enroll->grade == '4.0' ? 'selected' : '' }}>4.0</option>
                                        <option value="5.0" {{ $enroll->grade == '5.0' ? 'selected' : '' }}>5.0 — Failed</option>
                                    </select>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    
                    <div class="px-6 py-4 border-t border-white/10 flex justify-end">
                        <button type="submit" class="bg-blue-500 hover:bg-blue-600 px-6 py-2 rounded-lg transition">
                            Save All Grades
                        </button>
                    </div>
                </form>
            @endif
        </div>
    </div>
</body>
</html>