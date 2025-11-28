<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <title>Select Time Slot - Celestial Dark</title>
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
                Confirm Reservation
            </h1>
            <div></div> {{-- Spacer --}}
        </div>

        <form method="post" class="space-y-4">
            @csrf
            
            {{-- Hidden Fields (Preserved Functionality) --}}
            <input type="hidden" name="where_to" value="{{ $req->where_to ?? '' }}">
            <input type="hidden" name="Products" value="{{ $req->Products ?? '' }}">
            <input type="hidden" name="product_id" value="{{ $req->product_id ?? '' }}">
            <input type="hidden" name="product" value="{{ $req->product ?? '' }}">
            <input type="hidden" name="date" value="{{ $req->date ?? '' }}">
            <input type="hidden" name="status" value="confirmed">
            <input type="hidden" value="{{ session('userName') }}" name="client_name" id="client_name">

            {{-- Time Slot Selection --}}
            <div>
                <label for="hora" class="block text-sm font-medium text-gray-300 mb-1">Choose Time Slot:</label>
                <select name="hora" id="hora" required
                        class="w-full px-4 py-3 bg-gray-700 border border-gray-600 rounded-lg focus:ring-sky-500 focus:border-sky-500 text-gray-100 transition duration-200 ease-in-out appearance-none">
                    @if(count($horariosDisponiveis) > 0)
                        @foreach($horariosDisponiveis as $time)
                            <option value="{{ $time['start'] }}">
                                {{ $time['start'] }} - {{ $time['end'] }}
                            </option>
                        @endforeach
                    @else
                        <option disabled>No available time slots</option>
                    @endif
                </select>
            </div>

            {{-- Client Phone Input --}}
            <div>
                <label for="client_phone" class="sr-only">Client Phone</label>
                <input type="number" name="client_phone" id="client_phone" placeholder="Client Phone (Required)" required
                       class="w-full px-4 py-3 bg-gray-700 border border-gray-600 rounded-lg focus:ring-sky-500 focus:border-sky-500 placeholder-gray-400 text-gray-100 transition duration-200 ease-in-out">
            </div>

            {{-- Submit Button --}}
            <input type="submit" value="Reservar!"
                   class="w-full py-3 bg-sky-600 hover:bg-sky-700 text-white font-semibold rounded-lg shadow-lg shadow-sky-500/30 transition duration-300 ease-in-out cursor-pointer transform hover:scale-[1.01]">
        </form>
    </div>
</body>
</html>
