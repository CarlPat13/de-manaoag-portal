<!DOCTYPE html>
<html>
<head>
    <title>Manage Subjects - De Manaoag University</title>
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
        <h1 class="text-2xl font-bold text-white mb-6">📚 Manage Subjects</h1>

        @if(session('success'))
            <div class="bg-green-100/90 text-green-700 p-4 rounded-lg mb-6 backdrop-blur-sm">
                ✅ {{ session('success') }}
            </div>
        @endif

        {{-- ADD NEW SUBJECT FORM --}}
        <div class="bg-white/95 p-6 rounded-xl shadow-sm border mb-8 backdrop-blur-sm">
            <h2 class="font-bold text-lg text-blue-900 mb-4">➕ Add New Subject</h2>
            <form method="POST" action="{{ route('admin.subjects.store') }}">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Subject Code</label>
                        <input type="text" name="code" required placeholder="e.g. IT 101"
                            class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-400">
                        @error('code') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Subject Name</label>
                        <input type="text" name="name" required placeholder="e.g. Introduction to Computing"
                            class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-400">
                        @error('name') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Units</label>
                        <input type="number" name="units" required min="1" max="6" value="3"
                            class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-400">
                        @error('units') <span class="text-red-500 text-sm mt-1">{{ $message }}</span> @enderror
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                        <input type="text" name="description" placeholder="Brief description (optional)"
                            class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-400">
                    </div>
                </div>
                <button type="submit"
                    class="mt-4 bg-blue-900 text-white px-6 py-2.5 rounded-lg font-medium hover:bg-blue-800 transition">
                    ➕ Add Subject
                </button>
            </form>
        </div>

        {{-- LIST OF SUBJECTS --}}
        <div class="bg-white/95 rounded-xl shadow-sm border overflow-hidden backdrop-blur-sm">
            <table class="w-full text-left">
                <thead class="bg-blue-900 text-white">
                    <tr>
                        <th class="p-4 font-semibold">Code</th>
                        <th class="p-4 font-semibold">Subject Name</th>
                        <th class="p-4 font-semibold text-center">Units</th>
                        <th class="p-4 font-semibold text-center">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($subjects as $subj)
                    <tr class="border-t hover:bg-blue-50">
                        <td class="p-4 font-mono font-bold text-blue-900">{{ $subj->code }}</td>
                        <td class="p-4">
                            {{ $subj->name }}
                            @if($subj->description)
                                <p class="text-xs text-gray-500 mt-1">{{ $subj->description }}</p>
                            @endif
                        </td>
                        <td class="p-4 text-center font-medium">{{ $subj->units }}</td>
                        <td class="p-4 text-center">
                            <div class="flex justify-center gap-2">
                                {{-- EDIT BUTTON --}}
                                <button type="button" 
                                    onclick="toggleEdit({{ $subj->id }}, '{{ $subj->code }}', '{{ $subj->name }}', '{{ $subj->units }}', '{{ $subj->description ?? '' }}')"
                                    class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                                    ✏️ Edit
                                </button>
                                {{-- DELETE BUTTON --}}
                                <form method="POST" action="{{ route('admin.subjects.destroy', $subj) }}" 
                                    onsubmit="return confirm('Delete this subject? Cannot undo.')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-800 text-sm font-medium">
                                        🗑️ Delete
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    {{-- EDIT MODAL --}}
    <div id="editModal" class="fixed inset-0 bg-black/50 hidden items-center justify-center z-50">
        <div class="bg-white rounded-xl p-6 max-w-md w-full mx-4">
            <h3 class="font-bold text-lg text-blue-900 mb-4">✏️ Edit Subject</h3>
            <form method="POST" id="editForm" action="" class="space-y-4">
                @csrf @method('PUT')
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Subject Code</label>
                    <input type="text" name="code" id="edit_code" required
                        class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-yellow-400">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Subject Name</label>
                    <input type="text" name="name" id="edit_name" required
                        class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-yellow-400">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Units</label>
                    <input type="number" name="units" id="edit_units" required min="1" max="6"
                        class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-yellow-400">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                    <input type="text" name="description" id="edit_description"
                        class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-yellow-400">
                </div>
                <div class="flex gap-3 justify-end">
                    <button type="button" onclick="closeEdit()"
                        class="px-4 py-2 border rounded-lg hover:bg-gray-50">Cancel</button>
                    <button type="submit"
                        class="bg-blue-900 text-white px-5 py-2 rounded-lg hover:bg-blue-800">Save Changes</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function toggleEdit(id, code, name, units, description) {
            document.getElementById('editForm').action = '/admin/subjects/' + id;
            document.getElementById('edit_code').value = code;
            document.getElementById('edit_name').value = name;
            document.getElementById('edit_units').value = units;
            document.getElementById('edit_description').value = description;
            document.getElementById('editModal').classList.remove('hidden');
            document.getElementById('editModal').classList.add('flex');
        }
        function closeEdit() {
            document.getElementById('editModal').classList.add('hidden');
            document.getElementById('editModal').classList.remove('flex');
        }
        document.getElementById('editModal').addEventListener('click', function(e) {
            if (e.target === this) closeEdit();
        });
    </script>
</body>
</html>