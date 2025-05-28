<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register - DesignerHub</title>
     {{-- ✅ Include Vite styles and scripts --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gradient-to-br from-purple-100 to-blue-200 min-h-screen flex items-center justify-center">

    <div class="bg-white rounded-2xl shadow-xl w-full max-w-md p-10">
        <h2 class="text-3xl font-bold text-center text-gray-800 mb-6">Create Your Account 🎨</h2>

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


        <form method="POST" action="{{ route('register') }}" class="space-y-6">
            @csrf

            <div>
                <label for="name" class="block text-sm font-medium text-gray-700">Full Name</label>
                <input type="text" name="name" id="name" required autofocus
                    class="mt-1 w-full px-4 py-2 border rounded-md focus:ring-2 focus:ring-purple-400 focus:outline-none">
            </div>

            <div>
                <label for="email" class="block text-sm font-medium text-gray-700">Email Address</label>
                <input type="email" name="email" id="email" required
                    class="mt-1 w-full px-4 py-2 border rounded-md focus:ring-2 focus:ring-purple-400 focus:outline-none">
            </div>

            <div>
                <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                <input type="password" name="password" id="password" required
                    class="mt-1 w-full px-4 py-2 border rounded-md focus:ring-2 focus:ring-purple-400 focus:outline-none">
            </div>

            <div>
                <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirm Password</label>
                <input type="password" name="password_confirmation" id="password_confirmation" required
                    class="mt-1 w-full px-4 py-2 border rounded-md focus:ring-2 focus:ring-purple-400 focus:outline-none">
            </div>

            <button type="submit"
                class="w-full bg-purple-600 text-white py-2 rounded-md font-semibold hover:bg-purple-700 transition">
                Register
            </button>
        </form>

        <p class="text-sm text-center text-gray-600 mt-6">Already have an account?
            <a href="{{ route('login') }}" class="text-purple-600 hover:underline">Log in</a>
        </p>
    </div>

</body>
</html>
