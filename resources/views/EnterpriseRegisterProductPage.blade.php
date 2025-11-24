<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <title>Register Product - Celestial Dark</title>
</head>
<body class="bg-gray-900 text-gray-100 min-h-screen flex items-center justify-center p-4">
    <div class="w-full max-w-md bg-gray-800 rounded-xl shadow-2xl p-8 space-y-6 border border-gray-700">
        <div class="flex justify-between items-center">
            <button onclick="history.back()" class="text-gray-400 hover:text-sky-400 transition duration-200">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 inline-block mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Back
            </button>
            <h1 class="text-3xl font-extrabold text-center text-sky-400 tracking-tight">
                Register New Product
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
                <a href="." class="inline-block px-4 py-2 bg-sky-600 hover:bg-sky-700 text-white font-semibold rounded-lg transition duration-300 ease-in-out">
                    Go to Dashboard
                </a>
            </div>
        @endif

        <form method="POST" class="space-y-4">
            @csrf
            
            {{-- Name Input --}}
            <div>
                <label for="name" class="sr-only">Product Name</label>
                <input type="text" id="name" placeholder="Product Name" name="name" required
                       class="w-full px-4 py-3 bg-gray-700 border border-gray-600 rounded-lg focus:ring-sky-500 focus:border-sky-500 placeholder-gray-400 text-gray-100 transition duration-200 ease-in-out">
            </div>

            {{-- Price Input --}}
            <div>
                <label for="price_per_hour" class="sr-only">Price per Hour (R$/HR)</label>
                <input type="number" id="price_per_hour" placeholder="Price per Hour (R$/HR)" name="price_per_hour" step="0.01" required
                       class="w-full px-4 py-3 bg-gray-700 border border-gray-600 rounded-lg focus:ring-sky-500 focus:border-sky-500 placeholder-gray-400 text-gray-100 transition duration-200 ease-in-out">
            </div>

            {{-- Duration Input --}}
            <div>
                <label for="duration_minutes" class="sr-only">Duration (minutes)</label>
                <input type="number" id="duration_minutes" placeholder="Duration (minutes)" name="duration_minutes" required
                       class="w-full px-4 py-3 bg-gray-700 border border-gray-600 rounded-lg focus:ring-sky-500 focus:border-sky-500 placeholder-gray-400 text-gray-100 transition duration-200 ease-in-out">
            </div>

            {{-- Opens At Input --}}
            <div>
                <label for="opens_at" class="block text-sm font-medium text-gray-300 mb-1">Opens At:</label>
                <input type="time" id="opens_at" name="opens_at" required
                       class="w-full px-4 py-3 bg-gray-700 border border-gray-600 rounded-lg focus:ring-sky-500 focus:border-sky-500 placeholder-gray-400 text-gray-100 text-center transition duration-200 ease-in-out">
            </div>

            {{-- Closes At Input --}}
            <div>
                <label for="closes_at" class="block text-sm font-medium text-gray-300 mb-1">Closes At:</label>
                <input type="time" id="closes_at" name="closes_at" required
                       class="w-full px-4 py-3 bg-gray-700 border border-gray-600 rounded-lg focus:ring-sky-500 focus:border-sky-500 placeholder-gray-400 text-gray-100 text-center transition duration-200 ease-in-out">
            </div>

            {{-- Description Input --}}
            <div>
                <label for="description" class="sr-only">Description</label>
                <textarea id="description" placeholder="Description" name="description" rows="3"
                       class="w-full px-4 py-3 bg-gray-700 border border-gray-600 rounded-lg focus:ring-sky-500 focus:border-sky-500 placeholder-gray-400 text-gray-100 transition duration-200 ease-in-out"></textarea>
            </div>

            {{-- Submit Button --}}
            <input type="submit" value="Register Product"
                   class="w-full py-3 bg-sky-600 hover:bg-sky-700 text-white font-semibold rounded-lg shadow-lg shadow-sky-500/30 transition duration-300 ease-in-out cursor-pointer transform hover:scale-[1.01]">
        </form>
    </div>
</body>
</html>
