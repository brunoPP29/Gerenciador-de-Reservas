<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <title>Home - Celestial Dark</title>
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
    <div class="w-full max-w-2xl bg-gray-800 rounded-xl shadow-2xl p-8 space-y-8 border border-gray-700 text-center fade-in-up">
        <div class="flex justify-between items-center">
            <button onclick="history.back()" class="text-gray-400 hover:text-sky-400 transition duration-200">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 inline-block mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Back
            </button>
            <h1 class="text-4xl font-extrabold text-sky-400 tracking-tight">
                Welcome Home
            </h1>
            <a href="loggout"
               class="inline-flex items-center justify-center px-4 py-2 bg-red-600 hover:bg-red-700 text-white font-semibold rounded-lg shadow-lg shadow-red-500/30 transition duration-300 ease-in-out transform hover:scale-[1.05]">
                Logout
            </a>
        </div>
        
        <p class="text-lg text-gray-300">
            You are successfully logged in. This is your main dashboard.
        </p>

        <div class="pt-4">
            {{-- Additional content or links can go here --}}
        </div>
    </div>
</body>
</html>
