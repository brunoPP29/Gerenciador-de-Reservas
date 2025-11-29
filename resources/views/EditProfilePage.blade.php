<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <title>Edit Profile - Celestial Dark</title>
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
        <div class="flex justify-between items-center">
            <button onclick="history.back()" class="text-gray-400 hover:text-sky-400 transition duration-200">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 inline-block mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Back
            </button>
            <h1 class="text-3xl font-extrabold text-center text-sky-400 tracking-tight">
                Edit Profile
            </h1>
            <div></div> {{-- Spacer --}}
        </div>
{{-- Error Session Message --}}
@if(session('error'))
    <div class="bg-red-900/50 border border-red-700 text-red-300 p-3 rounded-lg text-sm font-medium">
        {{ session('error') }}
    </div>
@endif

{{-- Success Session Message --}}
@if(session('success'))
    <div class="bg-emerald-900/50 border border-emerald-700 text-emerald-300 p-4 rounded-lg text-base font-medium space-y-3">
        <p>{{ session('success') }}</p>
        {{-- Optional: Add a link if needed, e.g., to go back to the dashboard --}}
    </div>
@endif

        <form method="post" class="space-y-4">
            @csrf

            {{-- Username Input --}}
            <div>
                <label for="username" class="sr-only">Username</label>
                <input type="text" id="username" name="username" placeholder="Username" value="{{ session('userName') }}" required
                       class="w-full px-4 py-3 bg-gray-700 border border-gray-600 rounded-lg focus:ring-sky-500 focus:border-sky-500 placeholder-gray-400 text-gray-100 transition duration-200 ease-in-out">
            </div>

            {{-- Password Input --}}
            <div>
                <label for="password" class="sr-only">Password</label>
                <input type="password" id="password" name="password" placeholder="New Password (*******)"
                       class="w-full px-4 py-3 mb-5 bg-gray-700 border border-gray-600 rounded-lg focus:ring-sky-500 focus:border-sky-500 placeholder-gray-400 text-gray-100 transition duration-200 ease-in-out">
                <input type="password" id="password" name="confpassword" placeholder="Your actual password"
                       class="w-full px-4 py-3 bg-gray-700 border border-gray-600 rounded-lg focus:ring-sky-500 focus:border-sky-500 placeholder-gray-400 text-gray-100 transition duration-200 ease-in-out">
                    </div>

            {{-- Submit Button --}}
            <input type="submit" value="Editar!"
                   class="w-full py-3 bg-sky-600 hover:bg-sky-700 text-white font-semibold rounded-lg shadow-lg shadow-sky-500/30 transition duration-300 ease-in-out cursor-pointer transform hover:scale-[1.01]">
        </form>
    </div>
</body>
</html>
