<!DOCTYPE html>
<html>
<head>
    <title>New Announcement - De Manaoag University</title>
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
    <div class="max-w-2xl mx-auto px-4 py-8">

        <a href="{{ route('admin.announcements') }}" class="text-white hover:text-yellow-300 mb-4 inline-block transition">
            ← Back to Announcements
        </a>

        <h1 class="text-2xl font-bold text-white mb-6">📝 New Announcement</h1>

        <div class="bg-white/95 p-6 rounded-xl shadow-sm border backdrop-blur-sm">
            <form method="POST" action="{{ route('admin.announcements.store') }}">
                @csrf

                <div class="mb-5">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Title</label>
                    <input type="text" name="title" required
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-400"
                           placeholder="Enter announcement title...">
                </div>

                <div class="mb-5">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Content</label>
                    <textarea name="content" rows="6" required
                              class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-yellow-400"
                              placeholder="Write your announcement here..."></textarea>
                </div>

                <div class="flex gap-3 justify-end">
                    <a href="{{ route('admin.announcements') }}" 
                       class="px-5 py-2.5 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition">
                        Cancel
                    </a>
                    <button type="submit" 
                            class="bg-blue-900 text-white px-5 py-2.5 rounded-lg font-medium hover:bg-blue-800 transition">
                        Post Announcement
                    </button>
                </div>
            </form>
        </div>

    </div>
</body>
</html>