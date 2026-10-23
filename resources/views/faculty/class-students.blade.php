<html>
<body>
    <div class="max-w-7xl mx-auto px-4 py-8">
        <div class="bg-white/95 rounded-xl shadow-lg overflow-hidden">
            <div class="p-6 border-b">
                <h2 class="text-xl font-bold">Students in Class</h2>
            </div>

            <div class="p-6">
                @if(isset($class) && $class->enrollments->isNotEmpty())
                    <table class="w-full">
                        <thead>
                            <tr class="bg-gray-50">
                                <th class="text-left p-3">Student ID</th>
                                <th class="text-left p-3">Name</th>
                                <th class="text-left p-3">Grade</th>
                                <th class="text-left p-3">Remarks</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($class->enrollments as $enrollment)
                            <tr>
                                <td class="p-3">{{ $enrollment->student->student_id ?? '-' }}</td>
                                <td class="p-3">{{ $enrollment->student->first_name ?? '' }} {{ $enrollment->student->last_name ?? '' }}</td>
                                <td class="p-3">
                                    <form action="{{ route('faculty.store-grade', $enrollment->id) }}" method="POST">
                                        @csrf
                                        <input type="number" name="grade" step="0.1" min="1.0" max="5.0" 
                                               value="{{ $enrollment->grade }}" class="w-20 p-1 border rounded">
                                        <button type="submit" class="bg-blue-600 text-white px-3 py-1 rounded ml-2">Save</button>
                                    </form>
                                </td>
                                <td class="p-3">{{ $enrollment->remarks ?? '-' }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <div class="p-8 text-center text-gray-400">
                        No students enrolled in this class yet.
                    </div>
                @endif
            </div>
        </div>
    </div>
</body>
</html>