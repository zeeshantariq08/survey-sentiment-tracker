<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Member Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center h-screen">

<div class="bg-white shadow-lg rounded-lg p-8 max-w-md w-full">
    <h2 class="text-2xl font-semibold text-center mb-6 text-gray-700">Member Login</h2>

    @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-2 rounded relative mb-4">
            {{ session('error') }}
        </div>
    @endif

    <form action="{{ route('member.login') }}" method="POST" class="space-y-4">
        @csrf

        <div>
            <label class="block text-sm font-medium text-gray-700">Email</label>
            <input type="email" name="email" required
                   class="mt-1 px-4 py-2 w-full border rounded-lg focus:ring focus:ring-blue-300 focus:border-blue-500 transition">
            @error('email')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">Password</label>
            <input type="password" name="password" required
                   class="mt-1 px-4 py-2 w-full border rounded-lg focus:ring focus:ring-blue-300 focus:border-blue-500 transition">
            @error('password')
            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <button type="submit"
                class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-lg transition">
            Login
        </button>
    </form>

    <div class="mt-4 text-center">
        <a href="#" class="text-blue-600 hover:underline">Forgot Password?</a>
    </div>
</div>

</body>
</html>
