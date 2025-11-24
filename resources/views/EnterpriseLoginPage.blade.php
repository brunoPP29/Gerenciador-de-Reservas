<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <title>Enterprise Login - Celestial Dark</title>
    <style>
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .fade-in-up {
            animation: fadeIn 0.6s ease-out forwards;
        }
    </style>
</head>
<body class="bg-gray-900 text-gray-100 min-h-screen flex items-center justify-center p-4">
    <div class="w-full max-w-md bg-gray-800 rounded-xl shadow-2xl p-8 space-y-6 border border-gray-700 fade-in-up">
        <h1 class="text-3xl font-extrabold text-center text-sky-400 tracking-tight">
            Enterprise Login
        </h1>
        
        {{-- Error Session Message --}}
        @if(session('error'))
            <div class="bg-red-900/50 border border-red-700 text-red-300 p-3 rounded-lg text-sm font-medium">
                {{ session('error') }}
            </div>
        @endif

        <form method="post" class="space-y-4">
            @csrf 
            
            {{-- Email Input --}}
            <div>
                <label for="email" class="sr-only">Email</label>
                <input placeholder="E-mail..." id="email" type="text" name="email" required
                       class="w-full px-4 py-3 bg-gray-700 border border-gray-600 rounded-lg focus:ring-sky-500 focus:border-sky-500 placeholder-gray-400 text-gray-100 transition duration-200 ease-in-out">
            </div>

            {{-- Password Input --}}
            <div>
                <label for="password" class="sr-only">Password</label>
                <input type="password" id="password" placeholder="Password..." name="password" required
                       class="w-full px-4 py-3 bg-gray-700 border border-gray-600 rounded-lg focus:ring-sky-500 focus:border-sky-500 placeholder-gray-400 text-gray-100 transition duration-200 ease-in-out">
            </div>

            {{-- Submit Button --}}
            <input type="submit" value="Logar!"
                   class="w-full py-3 bg-sky-600 hover:bg-sky-700 text-white font-semibold rounded-lg shadow-lg shadow-sky-500/30 transition duration-300 ease-in-out cursor-pointer transform hover:scale-[1.01]">
        </form>

        {{-- Links --}}
        <div class="text-center pt-2">
            <a href="registerEnterprise" class="text-sm font-medium text-sky-400 hover:text-sky-300 transition duration-200">
                Register enterprise
            </a>
            <span class="text-gray-500"> | </span>
            <a href="." class="text-sm font-medium text-sky-400 hover:text-sky-300 transition duration-200">
                Customer
            </a>
        </div>
    </div>
</body>
</html>
