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

        <div class="flex items-center justify-between mb-6">
            <h1 class="text-2xl font-bold text-white">📢 Announcements</h1>
            <a href="{{ route('admin.announcements.create') }}" 
               class="bg-yellow-500 hover:bg-yellow-400 text-black px-4 py-2 rounded-lg font-medium transition">
                + New Announcement
            </a>
        </div>

        @if(session('success'))
            <div class="bg-green-100/90 text-green-700 p-4 rounded-lg mb-6 flex items-center gap-2 backdrop-blur-sm">
                ✅ {{ session('success') }}
            </div>
        @endif

        @if($announcements->count())
            <div class="space-y-4">
                @foreach($announcements as $a)
                <div class="bg-white/95 p-5 rounded-xl shadow-sm border backdrop-blur-sm">
                    <div class="flex items-start justify-between">
                        <div class="flex-1">
                            <h3 class="font-bold text-lg text-blue-900">{{ $a->title }}</h3>
                            <p class="text-sm text-gray-500 mt-1">
                                {{ $a->created_at->format('F d, Y h:i A') }}
                                @if($a->admin) · by {{ $a->admin->name }} @endif
                            </p>
                            <p class="text-gray-700 mt-3 leading-relaxed whitespace-pre-line">{{ $a->content }}</p>
                        </div>
                        {{-- Edit & Delete Buttons — Admin Only --}}
                        <div class="ml-4 flex flex-col gap-2 shrink-0">
                            <a href="{{ route('admin.announcements.edit', $a) }}" 
                               class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                                ✏️ Edit
                            </a>
                            <form method="POST" action="{{ route('admin.announcements.destroy', $a) }}" 
                                  onsubmit="return confirm('Delete this announcement?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-800 text-sm font-medium">
                                    🗑️ Delete
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        @else
            <div class="bg-white/95 p-8 rounded-xl shadow-sm border text-center text-gray-500 backdrop-blur-sm">
                <div class="text-4xl mb-3">📭</div>
                <h3 class="font-semibold text-gray-700">No announcements yet</h3>
                <p class="text-sm text-gray-400 mt-2">Click "New Announcement" to post one.</p>
            </div>
        @endif

    </div>
</body>
</html>