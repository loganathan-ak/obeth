<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login - DesignerHub</title>
     {{-- ✅ Include Vite styles and scripts --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gradient-to-br from-blue-100 to-purple-200 min-h-screen flex items-center justify-center">

    <div class="bg-white rounded-2xl shadow-xl w-full max-w-md p-10">
        <h2 class="text-3xl font-bold text-center text-gray-800 mb-6">Welcome Back 🎨</h2>

        @if (session('status'))
            <div class="mb-4 text-sm text-green-600">
                {{ session('status') }}
            </div>
        @endif

        @if($errors->any())
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-4">
                <strong class="font-semibold">Whoops! Something went wrong:</strong>
                <ul class="mt-2 list-disc pl-6">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}" class="space-y-6">
            @csrf

            <div>
                <label for="email" class="block text-sm font-medium text-gray-700">Email Address</label>
                <input type="email" name="email" id="email" required autofocus
                    class="mt-1 w-full px-4 py-2 border rounded-md focus:ring-2 focus:ring-indigo-400 focus:outline-none">
            </div>

            <div>
                <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                <input type="password" name="password" id="password" required
                    class="mt-1 w-full px-4 py-2 border rounded-md focus:ring-2 focus:ring-indigo-400 focus:outline-none">
            </div>

            {{-- <div class="flex justify-between items-center">
                <label class="flex items-center text-sm">
                    <input type="checkbox" name="remember" class="mr-2">
                    Remember me
                </label>

                <a href="{{ route('password.request') }}" class="text-sm text-indigo-600 hover:underline">Forgot password?</a>
            </div> --}}

            <button type="submit"
                class="w-full bg-indigo-600 text-white py-2 rounded-md font-semibold hover:bg-indigo-700 transition">
                Login
            </button>
        </form>

        <p class="text-sm text-center text-gray-600 mt-6">Don’t have an account?
            <a href="{{ route('register') }}" class="text-indigo-600 hover:underline">Sign up</a>
        </p>
    </div>

</body>
</html>
