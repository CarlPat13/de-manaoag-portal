<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - De Manaoag University</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            margin: 0;
            padding: 0;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(rgba(15, 23, 42, 0.75), rgba(15, 23, 42, 0.85)), 
                        url('{{ asset('images/bg-campus.jpg') }}') center/cover no-repeat fixed;
        }
    </style>
</head>
<body>
    <div class="w-full max-w-md px-6">
        <div class="bg-white rounded-2xl shadow-2xl p-8">
            
            <div class="text-center mb-5">
                <div class="w-36 h-36 mx-auto mb-3 rounded-full bg-white shadow-lg flex items-center justify-center overflow-hidden border-4 border-blue-900">
                    <img src="{{ asset('images/logo.png') }}" alt="De Manaoag University" 
                         class="w-full h-full object-cover scale-110">
                </div>
                <h1 class="text-xl font-bold text-blue-900">DE MANAOAG UNIVERSITY</h1>
                <p class="text-gray-500 text-sm mt-1">Student Portal</p>
            </div>

            <h2 class="text-lg font-semibold mb-4 text-center">Sign In</h2>

            @if(session('success'))
                <div class="bg-green-100 text-green-700 p-3 rounded-lg mb-4 text-sm">
                    ✅ {{ session('success') }}
                </div>
            @endif

            @if($errors->any())
                <div class="bg-red-100 text-red-700 p-3 rounded-lg mb-4 text-sm">
                    @foreach($errors->all() as $error)
                        <p>⚠️ {{ $error }}</p>
                    @endforeach
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="space-y-3">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Email or ID Number</label>
                        <input type="text" name="login" required value="{{ old('login') }}"
                               class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 text-sm">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                        <input type="password" name="password" required
                               class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 text-sm">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Login As</label>
                        <select name="role" required
                                class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 text-sm">
                            <option value="student" {{ old('role') === 'student' ? 'selected' : '' }}>Student</option>
                            <option value="faculty" {{ old('role') === 'faculty' ? 'selected' : '' }}>Faculty</option>
                            <option value="admin" {{ old('role') === 'admin' ? 'selected' : '' }}>Admin</option>
                        </select>
                    </div>
                    <div class="g-recaptcha" data-sitekey="6Lcbl_wtAAAAAKQkrZu8ZUUhWCZYT06UrkLL59NQ"></div>
                    <button type="submit"
                            class="w-full bg-blue-900 text-white py-2 rounded-lg font-semibold hover:bg-blue-800 transition text-sm">
                        LOGIN
                    </button>
                </div>
            </form>

            <p class="text-center mt-4 text-sm text-gray-600">
                Don't have an account? 
                <a href="{{ route('register') }}" class="text-blue-900 font-semibold hover:underline">Register here</a>
            </p>
        </div>
    </div>
</body>
</html>