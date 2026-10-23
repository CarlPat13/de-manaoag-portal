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
<body class="min-h-screen">
    @include('layouts.nav')
    <main class="max-w-7xl mx-auto px-4 py-8">
        <div class="mb-6">
            <a href="{{ route('faculty.dashboard') }}" class="text-blue-600 hover:underline text-sm">← Back to My Classes</a>
        </div>

        <div class="bg-white rounded-xl shadow p-6 mb-6">
            <h1 class="text-2xl font-bold text-[#0A2342] mb-2">{{ $class->subject?->code ?? 'N/A' }} — {{ $class->subject?->name ?? 'N/A' }}</h1>
            <p class="text-gray-600">Schedule: {{ $class->schedule ?? '-' }} | Room: {{ $class->room ?? 'Not Assigned' }}</p>
        </div>

        @if(session('success'))
            <div class="bg-green-50 border border-green-200 text-green-800 p-4 rounded-lg mb-6">
                ✅ {{ session('success') }}
            </div>
        @endif

        <div class="bg-white rounded-xl shadow overflow-hidden">
            <div class="p-4 border-b bg-gray-50 font-semibold">
                Enrolled Students — {{ $class->students->count() }} student(s)
            </div>
            <table class="w-full text-sm">
                <thead class="bg-gray-50 text-gray-600">
                    <tr>
                        <th class="p-4 text-left">Student ID</th>
                        <th class="p-4 text-left">Name</th>
                        <th class="p-4 text-left">Current Grade</th>
                        <th class="p-4 text-left" width="220">Assign Grade</th>
                    </tr>
                </thead>
                <tbody class="divide-y">
                    @foreach($class->students as $student)
                        @php
                            $enrollment = \App\Models\Enrollment::where('class_id', $class->id)
                                ->where('student_id', $student->id)
                                ->first();
                        @endphp
                        <tr>
                            <td class="p-4 font-mono text-xs">{{ $student->student_id }}</td>
                            <td class="p-4">{{ $student->first_name }} {{ $student->last_name }}</td>
                            <td class="p-4">
                                @if($enrollment && $enrollment->grade)
                                    <span class="font-bold {{ $enrollment->grade <= 3.0 ? 'text-green-600' : 'text-red-600' }}">
                                        {{ number_format($enrollment->grade, 1) }}
                                    </span>
                                    <span class="text-xs text-gray-500 ml-1">({{ $enrollment->remarks }})</span>
                                @else
                                    <span class="text-gray-400">— Pending</span>
                                @endif
                            </td>
                            <td class="p-4">
                                @if($enrollment)
                                    <form method="POST" action="{{ route('faculty.storeGrade', $enrollment->id) }}" class="flex gap-2 items-center">
                                        @csrf
                                        <input 
                                            type="number" 
                                            name="grade" 
                                            step="0.1" 
                                            min="1.0" 
                                            max="5.0"
                                            value="{{ $enrollment->grade ?? '' }}"
                                            placeholder="1.0 — 5.0"
                                            class="w-24 px-2 py-1.5 border rounded-lg text-sm focus:ring-2 focus:ring-[#D4AF37] outline-none"
                                        >
                                        <button type="submit" class="bg-[#0A2342] text-white px-3 py-1.5 rounded-lg text-sm hover:opacity-90 transition">
                                            Save
                                        </button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </main>
</body>
</html>