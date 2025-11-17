<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <title>Register - Celestial Dark</title>
</head>
<body class="bg-gray-900 text-gray-100 min-h-screen flex items-center justify-center p-4">
    <div class="w-full max-w-md bg-gray-800 rounded-xl shadow-2xl p-8 space-y-6 border border-gray-700">
        <h1 class="text-3xl font-extrabold text-center text-sky-400 tracking-tight">
            <a class="w-10 block" href="."><x-heroicon-s-chevron-left class="h-[30px] w-[30px]" /></a>
            Register
        </h1>

        {{-- Success Message Block --}}
        @if(session('success'))
            <div class="bg-emerald-900/50 border border-emerald-700 text-emerald-300 p-4 rounded-lg text-base font-medium space-y-3">
                <p>{{ session('success') }}</p>
                <a href="." class="inline-block px-4 py-2 bg-sky-600 hover:bg-sky-700 text-white font-semibold rounded-lg transition duration-300 ease-in-out">
                    Login
                </a>
            </div>
        @endif

        <form method="POST" class="space-y-4">
            @csrf

            {{-- User Input --}}
            <div>
                <label for="user" class="sr-only">User</label>
                <input placeholder="User..." id="user" type="text" name="user" value="{{ old('user', '') }}" required
                       class="w-full px-4 py-3 bg-gray-700 border border-gray-600 rounded-lg focus:ring-sky-500 focus:border-sky-500 placeholder-gray-400 text-gray-100 transition duration-200 ease-in-out">
                @error('user')
                    <p class="mt-1 text-sm text-red-400">{{ $message }}</p> 
                @enderror
            </div>

            {{-- Email Input --}}
            <div>
                <label for="email" class="sr-only">Email</label>
                <input placeholder="E-mail..." id="email" type="email" name="email" value="{{ old('email', '') }}" required
                       class="w-full px-4 py-3 bg-gray-700 border border-gray-600 rounded-lg focus:ring-sky-500 focus:border-sky-500 placeholder-gray-400 text-gray-100 transition duration-200 ease-in-out">
                @error('email')
                    <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                @enderror
            </div>

            {{-- Password Input --}}
            <div>
                <label for="password" class="sr-only">Password</label>
                <input placeholder="Password..." id="password" type="password" name="password" required
                       class="w-full px-4 py-3 bg-gray-700 border border-gray-600 rounded-lg focus:ring-sky-500 focus:border-sky-500 placeholder-gray-400 text-gray-100 transition duration-200 ease-in-out">
                @error('password')
                    <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                @enderror
            </div>

            {{-- Submit Button --}}
            <button type="submit"
                    class="w-full py-3 bg-sky-600 hover:bg-sky-700 text-white font-semibold rounded-lg shadow-lg shadow-sky-500/30 transition duration-300 ease-in-out cursor-pointer transform hover:scale-[1.01]">
                Cadastrar
            </button>
        </form>
    </div>
</body>
</html>
