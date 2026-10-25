<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enroll Students - De Manaoag University</title>
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
        <h1 class="text-2xl font-bold text-white mb-6">📋 Enroll Students</h1>
        
        @if(session('success'))
            <div class="bg-green-100/90 text-green-700 p-4 rounded-lg mb-6 backdrop-blur-sm">
                ✅ {{ session('success') }}
            </div>
        @endif

        {{-- DATA PROCESSING --}}
        @php
            $allClassesData = $classes->map(function($c) {
                return [
                    'subject_id' => $c->subject_id,
                    'faculty_id' => $c->faculty_id,
                    'faculty_name' => $c->faculty ? $c->faculty->first_name.' '.$c->faculty->last_name : null,
                ];
            })->values();

            // Ihanda ang lahat ng enrollment nang isang beses lang
            $allEnrollments = \App\Models\Enrollment::with('student', 'class')->get()->groupBy('class_id');
        @endphp

        {{-- ENROLLMENT FORM --}}
        <div class="bg-white/95 p-6 rounded-xl shadow-sm border mb-8 backdrop-blur-sm">
            <h2 class="font-bold text-lg text-blue-900 mb-4">➕ Enroll New Student</h2>
            <form method="POST" action="{{ route('admin.enrollments.store') }}">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                    {{-- STUDENT --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Select Student</label>
                        <select name="student_id" required class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-400">
                            <option value="">-- Choose Student --</option>
                            @foreach($students as $s)
                                <option value="{{ $s->id }}">
                                    {{ $s->student_id }} — {{ $s->first_name }} {{ $s->last_name }} | {{ $s->course }} | 
                                    @if($s->year_level == 1)
                                        1st Year
                                    @elseif($s->year_level == 2)
                                        2nd Year
                                    @elseif($s->year_level == 3)
                                        3rd Year
                                    @elseif($s->year_level == 4)
                                        4th Year
                                    @endif
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- CLASS / SUBJECT --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Select Class / Subject</label>
                        <select name="class_id" id="classSelect" required class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-400">
                            <option value="">-- Choose Class --</option>
                            @foreach($classes as $c)
                                <option value="{{ $c->id }}" 
                                    data-subject-id="{{ $c->subject_id }}"
                                    data-faculty-id="{{ $c->faculty_id ?? '' }}" 
                                    data-faculty-name="{{ $c->faculty ? $c->faculty->first_name.' '.$c->faculty->last_name : '' }}">
                                    {{ $c->subject->code ?? '' }} — {{ $c->subject->name ?? '' }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- INSTRUCTOR --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Assign Instructor</label>
                        <select name="faculty_id" id="facultySelect" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-400">
                            <option value="">-- Select Subject First --</option>
                        </select>
                    </div>
                </div>
                <button type="submit" class="bg-blue-900 text-white px-6 py-2.5 rounded-lg font-medium hover:bg-blue-800 transition">
                    ✅ Enroll Student
                </button>
            </form>
        </div>

        {{-- CURRENT ENROLLMENTS — GROUPED BY YEAR LEVEL --}}
        <h2 class="text-lg font-bold text-white mb-4">📝 Enrolled Students — By Year Level</h2>

        @foreach([1 => '1st Year', 2 => '2nd Year', 3 => '3rd Year', 4 => '4th Year'] as $yearNum => $yearLabel)
            @php
                $hasContent = false;
                $output = [];

                foreach ($classes as $c) {
                    $enrolled = isset($allEnrollments[$c->id]) 
                        ? $allEnrollments[$c->id]->where('student.year_level', $yearNum) 
                        : collect();
                    
                    if ($enrolled->count()) {
                        $hasContent = true;
                        $output[] = ['class' => $c, 'students' => $enrolled];
                    }
                }
            @endphp

            @if($hasContent)
                <div class="mb-8">
                    <h3 class="text-xl font-bold text-yellow-300 mb-3 border-b-2 border-yellow-400/50 pb-2">
                        📚 {{ $yearLabel }}
                    </h3>
                    @foreach($output as $item)
                        @php $c = $item['class']; $enrolled = $item['students']; @endphp
                        <div class="bg-white/95 rounded-xl shadow-sm border mb-4 overflow-hidden backdrop-blur-sm">
                            <div class="bg-blue-50 px-5 py-3 border-b">
                                <h4 class="font-bold text-blue-900">
                                    {{ $c->subject->code ?? '' }} — {{ $c->subject->name ?? 'Unknown' }}
                                    <span class="text-sm font-normal text-gray-500 ml-2">
                                        {{ $enrolled->count() }} student(s)
                                    </span>
                                    @if($c->faculty)
                                        <span class="text-sm font-normal text-blue-600 ml-3">
                                            Instructor: {{ $c->faculty->first_name }} {{ $c->faculty->last_name }}
                                        </span>
                                    @endif
                                </h4>
                            </div>
                            <div class="p-4">
                                <table class="w-full text-left">
                                    <thead>
                                        <tr class="text-sm text-gray-500">
                                            <th class="pb-2">Student ID</th>
                                            <th class="pb-2">Full Name</th>
                                            <th class="pb-2">Course</th>
                                            <th class="pb-2 text-right">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($enrolled as $e)
                                            <tr class="border-t">
                                                <td class="p-3 font-mono text-sm">{{ optional($e->student)->student_id ?? '—' }}</td>
                                                <td class="p-3">
                                                    {{ optional($e->student)->first_name ?? '' }} 
                                                    {{ optional($e->student)->last_name ?? '' }}
                                                </td>
                                                <td class="p-3">{{ optional($e->student)->course ?? '—' }}</td>
                                                <td class="p-3 text-right">
                                                    <form method="POST" action="{{ route('admin.enrollments.destroy', $e->id) }}" 
                                                        onsubmit="return confirm('Remove this student?')">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="text-red-600 hover:text-red-800 text-sm font-medium">
                                                            🗑️ Remove
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        @endforeach
    </div>

    <script>
        const classSelect = document.getElementById('classSelect');
        const facultySelect = document.getElementById('facultySelect');
        const allClasses = @json($allClassesData);

        classSelect.addEventListener('change', function () {
            const selectedOption = this.options[this.selectedIndex];
            
            if (!selectedOption.value) {
                facultySelect.innerHTML = '<option value="">-- Select Subject First --</option>';
                facultySelect.disabled = true;
                return;
            }

            const subjectId = selectedOption.dataset.subjectId;
            const assignedFacultyId = selectedOption.dataset.facultyId;
            const subjectInstructors = [];
            const seen = new Set();
            
            allClasses.forEach(c => {
                if (c.subject_id == subjectId && c.faculty_id && !seen.has(c.faculty_id)) {
                    seen.add(c.faculty_id);
                    subjectInstructors.push({
                        id: c.faculty_id,
                        name: c.faculty_name
                    });
                }
            });

            facultySelect.innerHTML = '';
            facultySelect.disabled = false;

            if (subjectInstructors.length === 0) {
                facultySelect.innerHTML = '<option value="">-- No instructor assigned --</option>';
            }
            else if (subjectInstructors.length === 1) {
                const inst = subjectInstructors[0];
                facultySelect.innerHTML = '<option value="' + inst.id + '" selected>' + inst.name + '</option>';
                facultySelect.disabled = true;
            }
            else {
                facultySelect.innerHTML = '<option value="">-- Choose Instructor --</option>';
                subjectInstructors.forEach(inst => {
                    const selected = inst.id == assignedFacultyId ? 'selected' : '';
                    facultySelect.innerHTML += '<option value="' + inst.id + '" ' + selected + '>' + inst.name + '</option>';
                });
            }
        });
    </script>
</body>
</html>