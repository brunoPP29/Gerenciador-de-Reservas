<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <title>Enterprise Dashboard - Celestial Dark</title>
</head>
<body class="bg-gray-900 text-gray-100 min-h-screen flex items-center justify-center p-4">
    <div class="w-full max-w-2xl bg-gray-800 rounded-xl shadow-2xl p-8 space-y-8 border border-gray-700">
        <div class="flex justify-between items-center">
            <button onclick="history.back()" class="text-gray-400 hover:text-sky-400 transition duration-200">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 inline-block mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Back
            </button>
            <h1 class="text-3xl font-extrabold text-center text-sky-400 tracking-tight">
                Enterprise Dashboard
            </h1>
            <a href="loggout"
               class="flex items-center justify-center px-4 py-2 bg-red-600 hover:bg-red-700 text-white font-semibold rounded-lg shadow-lg shadow-red-500/30 transition duration-300 ease-in-out transform hover:scale-[1.05]">
                Logout
            </a>
        </div>

        <div class="text-center text-lg text-gray-300">
            We are logged in as an enterprise.
        </div>

        <div class="flex flex-col sm:flex-row justify-center space-y-4 sm:space-y-0 sm:space-x-6">
            <a href="enterprise/registerProduct"
               class="flex items-center justify-center px-6 py-3 bg-sky-600 hover:bg-sky-700 text-white font-semibold rounded-lg shadow-lg shadow-sky-500/30 transition duration-300 ease-in-out transform hover:scale-[1.05]">
                Register Product
            </a>
        </div>
    </div>
</body>
</html>
