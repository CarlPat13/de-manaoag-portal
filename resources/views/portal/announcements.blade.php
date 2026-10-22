<!DOCTYPE html>
<html>
<head>
    <title>Announcements - De Manaoag University</title>
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
    <div class="max-w-4xl mx-auto px-4 py-8">
        <h1 class="text-2xl font-bold text-white mb-6">📢 Announcements</h1>
        @if(count($announcements))
            <div class="space-y-4">
                @foreach($announcements as $a)
                <div class="bg-white p-6 rounded-xl shadow-sm border">
                    <h2 class="font-bold text-lg text-blue-900">{{ $a->title }}</h2>
                    <p class="text-xs text-gray-400 mb-2">{{ $a->created_at->format('F j, Y g:i A') }}</p>
                    <p class="text-gray-700">{{ $a->content }}</p>
                </div>
                @endforeach
            </div>
        @else
            <div class="bg-white p-8 rounded-xl shadow-sm border text-center text-gray-400">No announcements yet.</div>
        @endif
    </div>
</body>
</html>