<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password - De Manaoag University</title>
    <script src="https://cdn.tailwindcss.com"></script>
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
            <h2 class="text-lg font-semibold mb-4 text-center">Reset Password</h2>
            @if(session('success'))
                <div class="bg-green-100 text-green-700 p-3 rounded-lg mb-4 text-sm">✅ {{ session('success') }}</div>
            @endif
            @if($errors->any())
                <div class="bg-red-100 text-red-700 p-3 rounded-lg mb-4 text-sm">
                    @foreach($errors->all() as $error)<p>⚠️ {{ $error }}</p>@endforeach
                </div>
            @endif
            <form method="POST" action="{{ route('password.store') }}">
                @csrf
                <input type="hidden" name="token" value="{{ $token }}">
                <div class="space-y-3">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                        <input type="email" name="email" required value="{{ old('email', $email) }}" class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 text-sm">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">New Password</label>
                        <input type="password" name="password" required minlength="8" class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 text-sm">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Confirm Password</label>
                        <input type="password" name="password_confirmation" required class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-blue-500 text-sm">
                    </div>
                    <button type="submit" class="w-full bg-blue-900 text-white py-2 rounded-lg font-semibold hover:bg-blue-800 transition text-sm">RESET PASSWORD</button>
                </div>
            </form>
            <p class="text-center mt-4 text-sm text-gray-600">
                <a href="{{ route('login') }}" class="text-blue-900 font-semibold hover:underline">Back to login</a>
            </p>
        </div>
    </div>
</body>
</html>
