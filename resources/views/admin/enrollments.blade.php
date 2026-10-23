<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enrollments - De Manaoag University</title>
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
        <h1 class="text-3xl font-bold text-white mb-8">📋 Student Enrollments</h1>

        @if(session('success'))
            <div class="bg-green-50 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded-r-lg">
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="bg-red-50 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded-r-lg">
                @foreach($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif

        <!-- Enrollment Form -->
        <div class="bg-white/95 p-6 rounded-xl shadow-sm mb-8">
            <h2 class="text-xl font-semibold text-blue-900 mb-4">Enroll New Student</h2>
            <form action="{{ route('admin.enrollments.store') }}" method="POST" class="grid grid-cols-1 md:grid-cols-2 gap-4">
                @csrf

                <!-- Student -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Student</label>
                    <select name="student_id" required class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500">
                        <option value="">-- Choose Student --</option>
                        @foreach($students as $s)
                            <option value="{{ $s->id }}">
                                {{ $s->student_id }} — {{ $s->first_name }} {{ $s->last_name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Class / Subject -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Class & Subject</label>
                    <select name="class_id" required id="classSelect" class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500">
                        <option value="">-- Choose Class --</option>
                        @foreach($classes as $c)
                            <option value="{{ $c->id }}" data-faculty-id="{{ $c->faculty_id }}" data-faculty-name="{{ $c->faculty ? $c->faculty->first_name.' '.$c->faculty->last_name : '' }}">
                                {{ $c->code }} — {{ optional($c->subject)->name ?? 'Unknown Subject' }}
                                @if($c->faculty)
                                    ({{ $c->faculty->first_name }} {{ $c->faculty->last_name }})
                                @else
                                    — No Instructor Yet
                                @endif
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Faculty / Instructor (Optional) -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">
                        Assign Instructor 
                        <span class="text-xs text-gray-400">(optional — auto if class has one)</span>
                    </label>
                    <select name="faculty_id" id="facultySelect" class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500">
                        <option value="">-- Use Class Default --</option>
                        @foreach($faculties as $f)
                            <option value="{{ $f->id }}">
                                {{ $f->first_name }} {{ $f->last_name }}
                            </option>
                        @endforeach
                    </select>
                    <p id="currentFacultyNote" class="text-sm text-gray-500 mt-1 hidden">
                        Current class instructor: <span id="facultyName"></span>
                    </p>
                </div>

                <div class="md:col-span-2">
                    <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition">
                        ✅ Enroll Student
                    </button>
                </div>
            </form>
        </div>

        <!-- Enrollment List -->
        <div class="bg-white/95 p-6 rounded-xl shadow-sm">
            <h2 class="text-xl font-semibold text-blue-900 mb-4">All Enrollments ({{ $enrollments->count() }})</h2>
            
            @if($enrollments->isEmpty())
                <p class="text-gray-500">No enrollments yet.</p>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead>
                            <tr class="border-b-2 border-gray-200">
                                <th class="py-3 px-2">Student</th>
                                <th class="py-3 px-2">Class / Subject</th>
                                <th class="py-3 px-2">Instructor</th>
                                <th class="py-3 px-2">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($enrollments as $e)
                            <tr class="border-b border-gray-100 hover:bg-gray-50">
                                <td class="py-3 px-2">
                                    <div class="font-medium">{{ optional($e->student)->first_name }} {{ optional($e->student)->last_name }}</div>
                                    <div class="text-sm text-gray-500">{{ optional($e->student)->student_id }}</div>
                                </td>
                                <td class="py-3 px-2">
                                    {{ optional($e->class)->code }} — {{ optional(optional($e->class)->subject)->name ?? 'Unknown' }}
                                </td>
                                <td class="py-3 px-2">
                                    @if(optional($e->class)->faculty)
                                        {{ optional($e->class)->faculty->first_name }} {{ optional($e->class)->faculty->last_name }}
                                    @else
                                        <span class="text-orange-500">Not Assigned</span>
                                    @endif
                                </td>
                                <td class="py-3 px-2">
                                    <form action="{{ route('admin.enrollments.destroy', $e->id) }}" method="POST" onsubmit="return confirm('Remove this enrollment?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-800 text-sm">Remove</button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>

    <script>
        // Auto-fill/update instructor info when class is selected
        const classSelect = document.getElementById('classSelect');
        const facultySelect = document.getElementById('facultySelect');
        const facultyNote = document.getElementById('currentFacultyNote');
        const facultyNameSpan = document.getElementById('facultyName');

        classSelect.addEventListener('change', function () {
            const selectedOption = this.options[this.selectedIndex];
            const facultyId = selectedOption.dataset.facultyId;
            const facultyName = selectedOption.dataset.facultyName;

            if (facultyId && facultyName) {
                facultyNameSpan.textContent = facultyName;
                facultyNote.classList.remove('hidden');
            } else {
                facultyNote.classList.add('hidden');
            }
        });
    </script>
</body>
</html>