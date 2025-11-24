<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <title>404 - Page Not Found</title>
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
    <div class="text-center space-y-6 fade-in-up">
        <h1 class="text-9xl font-extrabold text-sky-400 tracking-widest">
            404
        </h1>
        <div class="bg-gray-800 text-gray-300 px-4 py-2 text-sm rounded-full border border-gray-700">
            Page Not Found
        </div>
        <div class="flex justify-center space-x-4 pt-4">
            <button onclick="history.back()" class="inline-block px-6 py-3 bg-gray-600 hover:bg-gray-700 text-white font-semibold rounded-lg shadow-lg shadow-gray-500/30 transition duration-300 ease-in-out transform hover:scale-[1.05]">
                ← Go Back
            </button>
            <a href="/reservas/public/" class="inline-block px-6 py-3 bg-sky-600 hover:bg-sky-700 text-white font-semibold rounded-lg shadow-lg shadow-sky-500/30 transition duration-300 ease-in-out transform hover:scale-[1.05]">
                Go Home
            </a>
        </div>
    </div>
</body>
</html>
