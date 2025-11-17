<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="/reservas/resources/css/app.css">
    <title>Login - Celestial Dark</title>
</head>
<body class="bg-gray-900 text-gray-100 min-h-screen flex items-center justify-center p-4">
    <div class="w-full max-w-md bg-gray-800 rounded-xl shadow-2xl p-8 space-y-6 border border-gray-700">
        <h1 class="text-3xl font-extrabold text-center text-sky-400 tracking-tight">
            Login Page
        </h1>
        
        {{-- Message Display --}}
        @if($message ?? '')
            <p class="text-center text-sm font-medium text-sky-300">{{ $message }}</p>
        @endif

        {{-- Error Session Message --}}
        @if(session('error'))
            <div class="bg-red-900/50 border border-red-700 text-red-300 p-3 rounded-lg text-sm font-medium">
                {{ session('error') }}
            </div>
        @endif

        <form method="post" class="space-y-4">
            @csrf 
            
            {{-- User Input --}}
            <div>
                <label for="user" class="sr-only">User</label>
                <input name="user" id="user" type="text" placeholder="Seu usuário..." required
                       class="w-full px-4 py-3 bg-gray-700 border border-gray-600 rounded-lg focus:ring-sky-500 focus:border-sky-500 placeholder-gray-400 text-gray-100 transition duration-200 ease-in-out">
            </div>

            {{-- Password Input --}}
            <div>
                <label for="password" class="sr-only">Password</label>
                <input name="password" id="password" type="password" placeholder="Sua senha..." required
                       class="w-full px-4 py-3 bg-gray-700 border border-gray-600 rounded-lg focus:ring-sky-500 focus:border-sky-500 placeholder-gray-400 text-gray-100 transition duration-200 ease-in-out">
            </div>

            {{-- Submit Button --}}
            <input type="submit" value="Logar"
                   class="w-full py-3 bg-sky-600 hover:bg-sky-700 text-white font-semibold rounded-lg shadow-lg shadow-sky-500/30 transition duration-300 ease-in-out cursor-pointer transform hover:scale-[1.01]">
        </form>

        {{-- Links --}}
        <div class="text-center pt-2 space-y-2">
            <a href="register" class="text-sm font-medium text-sky-400 hover:text-sky-300 transition duration-200">
                Cadastrar-se
            </a>
            <span class="text-gray-500"> | </span>
            <a href="enterprise" class="text-sm font-medium text-sky-400 hover:text-sky-300 transition duration-200">
                Sou empresa
            </a>
        </div>
    </div>
</body>
</html>