<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - DesignerHub</title>
    {{-- ✅ Include Vite styles and scripts --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        /* Custom styles for smoother transitions and modern look */
        input[type="email"],
        input[type="password"] {
            transition: all 0.3s ease-in-out;
            border-color: #e2e8f0; /* default border color */
        }
        input[type="email"]:focus,
        input[type="password"]:focus {
            border-color: #818cf8; /* indigo-400 equivalent */
            box-shadow: 0 0 0 3px rgba(129, 140, 248, 0.4); /* focus ring */
        }
    </style>
</head>
<body class="bg-gradient-to-br from-blue-100 to-purple-200 min-h-screen flex items-center justify-center p-4 sm:p-6 lg:p-8">

    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-6xl flex flex-col md:flex-row overflow-hidden transform transition-all duration-300 scale-95 md:scale-100">
        {{-- LEFT SIDE: Login Form --}}
        <div class="w-full md:w-1/2 p-6 sm:p-10 lg:p-12 flex flex-col justify-center">
            <h2 class="text-3xl sm:text-4xl font-extrabold text-center text-gray-800 mb-8">Welcome Back <span class="text-indigo-600">🎨</span></h2>

            @if (session('status'))
                <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-6 rounded-md" role="alert">
                    {{ session('status') }}
                </div>
            @endif

            @if($errors->any())
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded-md" role="alert">
                    <strong class="font-bold">Whoops!</strong>
                    <span class="block sm:inline">There were some issues with your login:</span>
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
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email Address</label>
                    <input type="email" name="email" id="email" required autofocus value="{{ old('email') }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500">
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                    <input type="password" name="password" id="password" required
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500">
                </div>

                <button type="submit"
                    class="w-full bg-gradient-to-r from-indigo-600 to-purple-600 text-white py-3 rounded-lg font-semibold hover:from-indigo-700 hover:to-purple-700 transition-all duration-300 ease-in-out transform hover:-translate-y-1 hover:shadow-lg">
                    Login
                </button>
            </form>

            <p class="text-sm text-center text-gray-600 mt-8">Don’t have an account?
                <a href="{{ route('register') }}" class="text-indigo-600 hover:underline font-medium">Sign up here</a>
            </p>
            <p class="text-sm text-center text-gray-600 mt-8">
                <a href="{{ route('forgot-password') }}" class="text-indigo-600 hover:underline font-medium">Forgot Password ?</a>
            </p>
        </div>

        {{-- RIGHT SIDE: Vector Illustration --}}
        <div class="hidden md:flex w-1/2 bg-gradient-to-br from-indigo-500 to-purple-700 items-center justify-center p-8 lg:p-12">
            <div class="text-center text-white">
                <img src="{{asset('assets/img/obeth.webp')}}" alt="Creative Design Illustration" class="max-w-full h-auto mx-auto mb-6 drop-shadow-lg p-3 rounded bg-white">
                <h3 class="text-2xl font-bold mb-3">Unleash Your Creativity</h3>
                <p class="text-indigo-100 text-lg leading-relaxed">Join our community of designers and bring your ideas to life.</p>
            </div>
        </div>
    </div>

</body>
</html>