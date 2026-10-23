<!DOCTYPE html>
<html>
<head>
    <title>Manage Users - De Manaoag University</title>
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
    <div class="max-w-7xl mx-auto px-4 py-8">
        <h1 class="text-2xl font-bold text-white mb-6">👥 Manage Users</h1>

        {{-- Students Section --}}
        <div class="bg-white rounded-xl shadow-sm border mb-8">
            <div class="p-4 bg-blue-50 border-b flex justify-between items-center">
                <h2 class="font-bold text-blue-900">Students ({{ $students->count() }})</h2>
            </div>
            @if($students->count() > 0)
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="p-3 font-semibold text-gray-600">Student ID</th>
                                <th class="p-3 font-semibold text-gray-600">Full Name</th>
                                <th class="p-3 font-semibold text-gray-600">Email</th>
                                <th class="p-3 font-semibold text-gray-600">Course / Year</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($students as $s)
                            <tr class="border-t hover:bg-gray-50">
                                <td class="p-3 font-mono text-sm">{{ $s->student_id }}</td>
                                <td class="p-3">{{ $s->last_name }}, {{ $s->first_name }} {{ $s->middle_name ?? '' }}</td>
                                <td class="p-3 text-sm text-gray-500">{{ $s->user->email ?? '—' }}</td>
                                <td class="p-3 text-sm">{{ $s->course }} — {{ $s->year_level }} Year</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="p-8 text-center text-gray-400">No student accounts registered yet.</div>
            @endif
        </div>

        {{-- Faculty Section --}}
        <div class="bg-white rounded-xl shadow-sm border mb-8">
            <div class="p-4 bg-green-50 border-b flex justify-between items-center">
                <h2 class="font-bold text-green-900">Faculty ({{ $faculties->count() }})</h2>
            </div>
            @if($faculties->count() > 0)
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="p-3 font-semibold text-gray-600">Faculty ID</th>
                                <th class="p-3 font-semibold text-gray-600">Full Name</th>
                                <th class="p-3 font-semibold text-gray-600">Email</th>
                                <th class="p-3 font-semibold text-gray-600">Department</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($faculties as $f)
                            <tr class="border-t hover:bg-gray-50">
                                <td class="p-3 font-mono text-sm">{{ $f->faculty_id }}</td>
                                <td class="p-3">{{ $f->last_name }}, {{ $f->first_name }}</td>
                                <td class="p-3 text-sm text-gray-500">{{ $f->user->email ?? '—' }}</td>
                                <td class="p-3 text-sm">{{ $f->department ?? 'Not set' }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="p-8 text-center text-gray-400">No faculty accounts created yet.</div>
            @endif
        </div>

        {{-- Admins Section --}}
        <div class="bg-white rounded-xl shadow-sm border">
            <div class="p-4 bg-yellow-50 border-b flex justify-between items-center">
                <h2 class="font-bold text-yellow-900">Administrators ({{ $admins->count() }})</h2>
            </div>
            @if($admins->count() > 0)
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="p-3 font-semibold text-gray-600">Admin ID</th>
                                <th class="p-3 font-semibold text-gray-600">Full Name</th>
                                <th class="p-3 font-semibold text-gray-600">Email</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($admins as $a)
                            <tr class="border-t hover:bg-gray-50">
                                <td class="p-3 font-mono text-sm">{{ $a->admin_id }}</td>
                                <td class="p-3">{{ $a->last_name }}, {{ $a->first_name }}</td>
                                <td class="p-3 text-sm text-gray-500">{{ $a->user->email ?? '—' }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="p-8 text-center text-gray-400">No additional admin accounts yet.</div>
            @endif
        </div>
    </div>
</body>
</html>