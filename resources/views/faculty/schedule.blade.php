<!DOCTYPE html>
<html>
<head>
    <title>My Schedule - De Manaoag University</title>
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
        <h1 class="text-2xl font-bold text-white mb-6">📅 My Schedule</h1>
        
        @if($myClasses->isNotEmpty())
            <div class="bg-white rounded-xl shadow-sm overflow-hidden">
                <table class="w-full text-left">
                    <thead class="bg-blue-900 text-white">
                        <tr>
                            <th class="p-4">Subject Code</th>
                            <th class="p-4">Subject Name</th>
                            <th class="p-4">Schedule</th>
                            <th class="p-4">Room</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($myClasses as $c)
                        <tr class="border-t hover:bg-gray-50">
                            <td class="p-4 font-mono font-bold">{{ $c->subject->code ?? '—' }}</td>
                            <td class="p-4">{{ $c->subject->name ?? 'Unknown' }}</td>
                            <td class="p-4">{{ $c->schedule ?? '—' }}</td>
                            <td class="p-4">{{ $c->room ?? '—' }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="bg-white p-8 rounded-xl text-center text-gray-400">
                No classes assigned yet.
            </div>
        @endif
    </div>
</body>
</html>