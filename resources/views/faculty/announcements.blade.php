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
<body>
    @include('layouts.nav')
    <div class="max-w-3xl mx-auto px-4 py-8">
        
        <h1 class="text-2xl font-bold text-white mb-6">📢 Announcements</h1>

        @if($announcements->count())
            <div class="space-y-4">
                @foreach($announcements as $a)
                <div class="bg-white/95 p-5 rounded-xl shadow-sm border backdrop-blur-sm">
                    <h3 class="font-bold text-lg text-blue-900">{{ $a->title }}</h3>
                    <p class="text-sm text-gray-500 mt-1">{{ $a->created_at->format('F d, Y h:i A') }}</p>
                    <p class="text-gray-700 mt-3 leading-relaxed whitespace-pre-line">{{ $a->content }}</p>
                </div>
                @endforeach
            </div>
        @else
            <div class="bg-white/95 p-8 rounded-xl shadow-sm border text-center text-gray-500 backdrop-blur-sm">
                <div class="text-4xl mb-3">📭</div>
                <h3 class="font-semibold text-gray-700">No announcements yet</h3>
                <p class="text-sm text-gray-400 mt-2">Check back later for updates.</p>
            </div>
        @endif

    </div>
</body>
</html>