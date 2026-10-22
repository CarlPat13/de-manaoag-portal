@extends('layouts.nav')
@section('content')
 <style>
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(rgba(10, 35, 66, 0.85), rgba(10, 35, 66, 0.90)), 
                        url('{{ asset('images/bg-campus.jpg') }}') center/cover no-repeat fixed;
            min-height: 100vh;
        }
    </style>
<div class="max-w-7xl mx-auto px-4 py-8">
    <h1 class="text-2xl font-bold text-white mb-6">Manage Classes</h1>

    <!-- Add New Class Form -->
    <div class="bg-white p-6 rounded-lg shadow mb-8">
        <h2 class="text-xl font-semibold mb-4">Add New Class</h2>
        @if(session('success'))
            <div class="bg-green-100 text-green-700 p-3 rounded mb-4">{{ session('success') }}</div>
        @endif
        <form method="POST" action="{{ route('admin.classes.store') }}">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block font-medium mb-1">Class Code</label>
                    <input type="text" name="code" required
                        class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500">
                    @error('code') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label class="block font-medium mb-1">Subject</label>
                    <select name="subject_id" required
                        class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500">
                        <option value="">-- Select Subject --</option>
                        @foreach(\App\Models\Subject::latest()->get() as $subj)
                            <option value="{{ $subj->id }}">{{ $subj->code }} - {{ $subj->name }}</option>
                        @endforeach
                    </select>
                    @error('subject_id') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
                <div>
                    <label class="block font-medium mb-1">Assign Faculty</label>
                    <select name="faculty_id" required
                        class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500">
                        <option value="">-- Select Faculty --</option>
                        @foreach(\App\Models\Faculty::with('user')->latest()->get() as $fac)
                            <option value="{{ $fac->id }}">
                                {{ $fac->faculty_id }} - {{ $fac->first_name }} {{ $fac->last_name }}
                            </option>
                        @endforeach
                    </select>
                    @error('faculty_id') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
                <!-- ✅ BAGONG FIELD: Room / Classroom -->
                <div>
                    <label class="block font-medium mb-1">Room / Classroom</label>
                    <input type="text" name="room" placeholder="e.g. Bldg A - Room 101"
                        class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label class="block font-medium mb-1">Schedule</label>
                    <input type="text" name="schedule" placeholder="e.g. Mon/Wed 9:00-10:30 AM"
                        class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label class="block font-medium mb-1">Year Level</label>
                    <select name="year_level" required
                        class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500">
                        <option value="">-- Select Year --</option>
                        <option value="1">1st Year</option>
                        <option value="2">2nd Year</option>
                        <option value="3">3rd Year</option>
                        <option value="4">4th Year</option>
                    </select>
                    @error('year_level') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>
                <div class="md:col-span-2">
                    <label class="block font-medium mb-1">Description</label>
                    <textarea name="description" rows="2"
                        class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500"></textarea>
                </div>
            </div>
            <button type="submit"
                class="mt-4 bg-blue-900 text-white px-6 py-2 rounded-lg hover:bg-blue-800 transition">
                Create Class
            </button>
        </form>
    </div>

    <!-- List of Classes -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <table class="w-full">
            <thead class="bg-blue-900 text-white">
                <tr>
                    <th class="px-4 py-3 text-left">Class Code</th>
                    <th class="px-4 py-3 text-left">Subject</th>
                    <th class="px-4 py-3 text-left">Faculty Assigned</th>
                    <th class="px-4 py-3 text-left">Room</th> <!-- ✅ BAGONG COLUMN -->
                    <th class="px-4 py-3 text-left">Schedule</th>
                    <th class="px-4 py-3 text-left">Year Level</th>
                    <th class="px-4 py-3 text-left">Enrolled</th>
                </tr>
            </thead>
            <tbody>
                @foreach($classes as $class)
                <tr class="border-b">
                    <td class="px-4 py-3 font-medium">{{ $class->code }}</td>
                    <td class="px-4 py-3">{{ $class->subject?->name ?? 'N/A' }}</td>
                    <td class="px-4 py-3">
                        @if($class->faculty)
                            {{ $class->faculty->first_name }} {{ $class->faculty->last_name }}
                        @else
                            <span class="text-orange-500">Unassigned</span>
                        @endif
                    </td>
                    <!-- ✅ Room Display -->
                    <td class="px-4 py-3 font-mono text-sm">
                        {{ $class->room ?? '-' }}
                    </td>
                    <td class="px-4 py-3">{{ $class->schedule ?? '-' }}</td>
                    <td class="px-4 py-3">{{ $class->year_level }} Year</td>
                    <td class="px-4 py-3">{{ $class->students->count() }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection