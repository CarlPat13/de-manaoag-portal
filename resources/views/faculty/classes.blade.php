<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Classes - De Manaoag University</title>
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
        <h1 class="text-2xl font-bold text-white mb-6">📚 Manage Classes</h1>

        @if(session('success'))
            <div class="bg-green-100/90 text-green-700 p-4 rounded-lg mb-6 backdrop-blur-sm">
                ✅ {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="bg-red-100/90 text-red-700 p-4 rounded-lg mb-6 backdrop-blur-sm">
                @foreach($errors->all() as $error)
                    <p>❌ {{ $error }}</p>
                @endforeach
            </div>
        @endif

        <!-- Create Class Form -->
        <div class="bg-white/95 p-6 rounded-xl shadow-sm border backdrop-blur-sm">
            <h2 class="font-bold text-lg text-blue-900 mb-4">➕ Add New Class</h2>
            <form method="POST" action="{{ route('admin.classes.store') }}">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <!-- Class Code -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Class Code</label>
                        <input type="text" name="code" required 
                               class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-400"
                               placeholder="NET-102">
                    </div>

                    <!-- Subject -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Subject</label>
                        <select name="subject_id" required 
                                class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-400">
                            <option value="">-- Select Subject --</option>
                            @foreach($subjects as $s)
                                <option value="{{ $s->id }}">{{ $s->code }} — {{ $s->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Assign Faculty -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Assign Faculty</label>
                        <select name="faculty_id" required 
                                class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-400">
                            <option value="">-- Select Faculty --</option>
                            @foreach($faculties as $f)
                                <option value="{{ $f->id }}">
                                    {{ $f->employee_id ?? 'FAC-000' }} — {{ $f->first_name }} {{ $f->last_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Room / Classroom -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Room / Classroom</label>
                        <input type="text" name="room" 
                               class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-400"
                               placeholder="Room 15">
                    </div>

                    <!-- Schedule -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Schedule</label>
                        <input type="text" name="schedule" 
                               class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-400"
                               placeholder="Mon/Tue 9:30-10:30 AM">
                    </div>

                    <!-- Year Level -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Year Level</label>
                        <select name="year_level" required 
                                class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-400">
                            <option value="">-- Select Year --</option>
                            <option value="1">1st Year</option>
                            <option value="2">2nd Year</option>
                            <option value="3">3rd Year</option>
                            <option value="4">4th Year</option>
                        </select>
                    </div>

                    <!-- Description -->
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                        <textarea name="description" rows="3"
                                  class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-400"
                                  placeholder="Brief description of this class..."></textarea>
                    </div>
                </div>

                <button type="submit" class="mt-4 bg-blue-900 text-white px-6 py-2.5 rounded-lg font-medium hover:bg-blue-800 transition">
                    Create Class
                </button>
            </form>
        </div>
    </div>
</body>
</html>