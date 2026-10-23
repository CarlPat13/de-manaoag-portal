<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Grades - De Manaoag University</title>
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
    <main class="max-w-4xl mx-auto px-4 py-8">
        <h1 class="text-2xl font-bold text-white mb-6">📝 My Grades</h1>
        
        @if($enrollments->isNotEmpty())
            <div class="bg-white/95 backdrop-blur rounded-xl shadow-lg overflow-hidden">
                <table class="w-full text-left text-sm">
                    <thead class="bg-[#0A2342] text-white">
                        <tr>
                            <th class="p-4 font-semibold">Subject Code</th>
                            <th class="p-4 font-semibold">Subject Name</th>
                            <th class="p-4 font-semibold">Units</th>
                            <th class="p-4 font-semibold">Faculty</th>
                            <th class="p-4 font-semibold">Grade</th>
                            <th class="p-4 font-semibold">Remarks</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($enrollments as $e)
                            @php $class = $e->class; @endphp
                            @if(!$class)
                                <tr>
                                    <td colspan="6" class="p-4 text-gray-400 italic">Class data not available</td>
                                </tr>
                                @continue
                            @endif
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="p-4 font-mono font-bold text-navy">
                                    {{ $class->subject?->code ?? 'N/A' }}
                                </td>
                                <td class="p-4">
                                    {{ $class->subject?->name ?? 'N/A' }}
                                </td>
                                <td class="p-4">
                                    {{ $class->subject?->units ?? 3 }}
                                </td>
                                <td class="p-4">
                                    {{ $class->faculty?->first_name ?? '' }} {{ $class->faculty?->last_name ?? 'Not Assigned' }}
                                </td>
                                <td class="p-4">
                                    @if($e->grade)
                                        <span class="font-bold text-lg {{ $e->grade <= 3.0 ? 'text-green-600' : 'text-red-600' }}">
                                            {{ number_format($e->grade, 1) }}
                                        </span>
                                    @else
                                        <span class="text-gray-400">— Pending</span>
                                    @endif
                                </td>
                                <td class="p-4">
                                    @if($e->remarks)
                                        <span class="px-2 py-1 rounded-full text-xs font-medium {{ $e->grade <= 3.0 ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                            {{ $e->remarks }}
                                        </span>
                                    @else
                                        <span class="text-gray-400 text-xs">—</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="bg-white/95 backdrop-blur p-10 rounded-xl shadow-sm border text-center">
                <div class="text-4xl mb-3" aria-hidden="true">📭</div>
                <p class="text-gray-500 font-medium">No grades available yet.</p>
                <p class="text-sm text-gray-400 mt-1">Your grades will appear here once posted by your instructor.</p>
            </div>
        @endif
    </main>
</body>
</html>