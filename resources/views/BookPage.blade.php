@vite(['resources/css/app.css', 'resources/js/app.js'])
@if($productInfo)
    <div class="bg-gray-900 text-gray-100 min-h-screen flex items-center justify-center p-4">
        <div class="w-full max-w-lg bg-gray-800 rounded-xl shadow-2xl p-8 space-y-6 border border-gray-700">
            <div class="flex justify-between items-center">
                <button onclick="history.back()" class="text-gray-400 hover:text-sky-400 transition duration-200">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 inline-block mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Back
                </button>
                <h1 class="text-3xl font-extrabold text-center text-sky-400 tracking-tight">
                    Book: {{ $productInfo->name }}
                </h1>
                <div></div> {{-- Spacer --}}
            </div>

            {{-- Success/Error Messages --}}
            @if(session('error'))
                <div class="bg-red-900/50 border border-red-700 text-red-300 p-3 rounded-lg text-sm font-medium">
                    {{ session('error') }}
                </div>
            @endif
            @if(session('success'))
                <div class="bg-emerald-900/50 border border-emerald-700 text-emerald-300 p-4 rounded-lg text-base font-medium space-y-3">
                    <p>{{ session('success') }}</p>
                </div>
            @endif
            

            <form method="POST" class="space-y-4">
                @csrf

                {{-- Hidden Fields for Dynamic Tables and Product Info --}}
                <input type="hidden" name="where_to" value="{{ $tbReservation }}">
                <input type="hidden" name="Products" value="{{ $tbProducts }}">
                <input type="hidden" name="product_id" value="{{ $productInfo->id }}">
                <input type="hidden" name="product" value="{{ $productInfo->name }}">
                <input type="hidden" name="status" value="confirmed">
                
                {{-- Client Name (Assuming this is set by a session or hidden logic) --}}
                <input type="hidden" value="" name="client_name" id="client_name">

                {{-- Product Details (Read-only) --}}
                <div class="space-y-2 p-4 bg-gray-700/50 rounded-lg border border-gray-600">
                    <p class="text-lg font-semibold text-sky-300">Product Details</p>
                    <p class="text-sm text-gray-300"><strong>Name:</strong> {{ $productInfo->name }}</p>
                    @if(isset($productInfo->price))
                        <p class="text-sm text-gray-300"><strong>Price per hour:</strong> R$ {{ $productInfo->price }}</p>
                    @endif
                    @if(isset($productInfo->opens_at))
                        <p class="text-sm text-gray-300"><strong>Opens at:</strong> {{ $productInfo->opens_at }}</p>
                    @endif
                    @if(isset($productInfo->closes_at))
                        <p class="text-sm text-gray-300"><strong>Closes at:</strong> {{ $productInfo->closes_at }}</p>
                    @endif
                    @if(isset($productInfo->price))
                        <p class="text-sm text-gray-300"><strong>Minimum duration:</strong> R$ {{ $productInfo->duration_minutes }}</p>
                    @endif
                </div>

                {{-- Booking Inputs --}}
                <div>
                    <label for="date" class="block text-sm font-medium text-gray-300 mb-1">Date:</label>
                    <input type="date" name="date" id="date" required
                           class="w-full px-4 py-3 bg-gray-700 border border-gray-600 rounded-lg focus:ring-sky-500 focus:border-sky-500 placeholder-gray-400 text-gray-100 transition duration-200 ease-in-out">
                </div>

                <div>
                    <label for="start_time" class="block text-sm font-medium text-gray-300 mb-1">Start Time:</label>
                    <input type="time" name="start_time" id="start_time" 
                           min="{{ $productInfo->opens_at ?? '' }}" 
                           max="{{ $productInfo->closes_at ?? '' }}" 
                           required
                           class="w-full px-4 py-3 bg-gray-700 border border-gray-600 rounded-lg focus:ring-sky-500 focus:border-sky-500 placeholder-gray-400 text-gray-100 transition duration-200 ease-in-out">
                </div>

                <div>
                    <label for="end_time" class="block text-sm font-medium text-gray-300 mb-1">End Time:</label>
                    <input type="time" name="end_time" id="end_time" 
                           min="{{ $productInfo->opens_at ?? '' }}" 
                           max="{{ $productInfo->closes_at ?? '' }}" 
                           required
                           class="w-full px-4 py-3 bg-gray-700 border border-gray-600 rounded-lg focus:ring-sky-500 focus:border-sky-500 placeholder-gray-400 text-gray-100 transition duration-200 ease-in-out">
                </div>

                {{-- Client Phone --}}
                <div>
                    <label for="client_phone" class="block text-sm font-medium text-gray-300 mb-1">Client Phone:</label>
                    <input type="text" name="client_phone" id="client_phone" placeholder="Client Phone..."
                           class="w-full px-4 py-3 bg-gray-700 border border-gray-600 rounded-lg focus:ring-sky-500 focus:border-sky-500 placeholder-gray-400 text-gray-100 transition duration-200 ease-in-out">
                </div>

                {{-- Submit Button --}}
                <button type="submit"
                        class="w-full py-3 bg-sky-600 hover:bg-sky-700 text-white font-semibold rounded-lg shadow-lg shadow-sky-500/30 transition duration-300 ease-in-out cursor-pointer transform hover:scale-[1.01]">
                    Save Reservation
                </button>
            </form>
        </div>
    </div>
@else
    <div class="bg-gray-900 text-gray-100 min-h-screen flex items-center justify-center p-4">
        <div class="w-full max-w-md bg-gray-800 rounded-xl shadow-2xl p-8 space-y-4 border border-gray-700 text-center">
            <h2 class="text-2xl font-bold text-red-400">Product Not Found</h2>
            <p class="text-gray-300">Cannot proceed with the reservation as the product information is missing.</p>
            <a href="/" class="inline-block px-6 py-3 bg-sky-600 hover:bg-sky-700 text-white font-semibold rounded-lg shadow-lg shadow-sky-500/30 transition duration-300 ease-in-out transform hover:scale-[1.05]">
                Go to Home
            </a>
        </div>
    </div>
@endif
