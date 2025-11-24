    @vite(['resources/css/app.css', 'resources/js/app.js'])

<div class="bg-gray-900 text-gray-100 min-h-screen p-8">
    <div class="max-w-4xl mx-auto">
        <div class="flex justify-between items-center mb-8">
            <button onclick="history.back()" class="text-gray-400 hover:text-sky-400 transition duration-200">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 inline-block mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Back
            </button>
            <h1 class="text-4xl font-extrabold text-center text-sky-400 tracking-tight flex-grow">
                Products from {{ $dadosEmpresa->name ?? 'Enterprise' }}
            </h1>
            <div></div> {{-- Spacer --}}
        </div>

        @if($databaseOrigin->isEmpty())
            <div class="bg-gray-800 rounded-xl shadow-2xl p-8 text-center border border-gray-700">
                <p class="text-xl text-gray-300">No products found for this enterprise.</p>
            </div>
        @else
            <div class="space-y-6">
                @foreach($databaseOrigin as $produto)
                    <div class="bg-gray-800 rounded-xl shadow-lg p-6 border border-gray-700 flex flex-col sm:flex-row justify-between items-start sm:items-center space-y-4 sm:space-y-0 transition duration-300 ease-in-out transform hover:scale-[1.01] hover:shadow-sky-500/30">
                        <div class="space-y-1">
                            <h2 class="text-xl font-bold text-white">{{ $produto->name }}</h2>
                            <p class="text-lg font-medium text-sky-300">R$ {{ $produto->price_per_hour }} / hour</p>
                            {{-- Assuming a description field exists, adding it for better presentation --}}
                            @if(isset($produto->description))
                                <p class="text-sm text-gray-400 mt-2">{{ $produto->description }}</p>
                            @endif
                        </div>
                        
                        <a href="/reservas/public/loja/{{ $empresa }}/{{ $produto->name }}"
                           class="inline-flex items-center justify-center px-6 py-2 bg-sky-600 hover:bg-sky-700 text-white font-semibold rounded-lg shadow-lg shadow-sky-500/30 transition duration-300 ease-in-out transform hover:scale-[1.05] flex-shrink-0">
                            Book Now
                        </a>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>
