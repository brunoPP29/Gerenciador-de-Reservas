@php
// Esta é uma view Blade aprimorada para o Laravel, totalmente funcional
// como HTML puro, exceto pelos placeholders Laravel como @csrf e {{ url(...) }}.
@endphp
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Reserva de Produto - {{ $productInfo->name ?? 'Detalhes' }}</title>
    
    <!-- Uso do Tailwind CDN para ser auto-contido e funcionar imediatamente -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Script anti-flash de Dark Mode -->
    <script>
        // Configurações do Tailwind para suportar classes personalizadas no script
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    },
                    colors: {
                        sky: { 50: '#f0f9ff', 100: '#e0f2fe', 200: '#bae6fd', 300: '#7dd3fc', 400: '#38bdf8', 500: '#0ea5e9', 600: '#0284c7', 700: '#0369a1', 800: '#075985', 900: '#0c4a6e', 950: '#082f49' },
                    }
                }
            }
        }
        
        if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
        </script>

<style>
    /* Animação de carregamento do botão */
    @keyframes spin {
        to { transform: rotate(360deg); }
    }
    .animate-spin-fast {
        animation: spin 0.7s linear infinite;
    }
    
    /* Estilo do foco para inputs de data/hora */
    input[type="date"], input[type="time"] {
        appearance: none;
        -webkit-appearance: none;
    }
    
    /* Estilização para o ícone do input de tempo */
    input[type="time"]::-webkit-calendar-picker-indicator {
        filter: invert(1); /* Inverte a cor do ícone no Dark Mode */
        cursor: pointer;
    }
    .dark input[type="time"]::-webkit-calendar-picker-indicator {
        filter: invert(0.9);
    }
    </style>
</head>

<body class="bg-gray-50 dark:bg-gray-900 min-h-screen flex items-center justify-center p-4 font-sans">
    
    @if($productInfo ?? null)
    <!-- Dashboard Principal -->
    <div class="w-full max-w-lg bg-white dark:bg-gray-800 rounded-2xl shadow-2xl p-6 md:p-8 space-y-6 border border-gray-200 dark:border-gray-700 transform transition duration-500 ease-in-out hover:shadow-sky-500/30">
        
        <!-- Cabeçalho e Botão Voltar -->
        <div class="flex justify-between items-center pb-4 border-b border-gray-100 dark:border-gray-700">
            <button onclick="history.back()" class="text-gray-500 dark:text-gray-400 hover:text-sky-600 dark:hover:text-sky-400 transition duration-200 p-2 rounded-full hover:bg-gray-100 dark:hover:bg-gray-700">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 inline-block" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
            </button>
            <h1 class="text-2xl md:text-3xl font-extrabold text-gray-900 dark:text-white tracking-tight text-center grow">
                Reservar: <span class="text-sky-600 dark:text-sky-400">{{ $productInfo->name }}</span>
            </h1>
            <!-- Botão placeholder (para alinhamento) -->
            <div class="w-10 h-6"></div> 
        </div>

        {{-- Mensagens (Mantidas e Aprimoradas) --}}
        @if(session('error'))
            <div class="bg-red-100 dark:bg-red-900/50 border border-red-400 dark:border-red-700 text-red-700 dark:text-red-300 p-3 rounded-xl text-sm font-medium transition duration-300">
                {{ session('error') }}
            </div>
        @endif
        @if(session('success'))
            <div class="bg-emerald-100 dark:bg-emerald-900/50 border border-emerald-400 dark:border-emerald-700 text-emerald-700 dark:text-emerald-300 p-4 rounded-xl text-base font-medium space-y-2 transition duration-300">
                <p class="font-bold">Reserva Confirmada!</p>
                <p>{{ session('success') }}</p>
            </div>
        @endif
        
        <form action="{{ route('bookcalendar', ['empresa' => $empresa, 'name' => $name]) }}" method="POST" class="space-y-6">
            @csrf

            {{-- Hidden Fields --}}
            <input type="hidden" name="where_to" value="{{ $tbReservation ?? '' }}">
            <input type="hidden" name="Products" value="{{ $tbProducts ?? '' }}">
            <input type="hidden" name="product_id" value="{{ $productInfo->id ?? '' }}">
            <input type="hidden" name="product" value="{{ $productInfo->name ?? '' }}">
            <input type="hidden" name="min_people" value="{{ $productInfo->min_people }}">
            <input type="hidden" name="status" value="confirmed">
            <input type="hidden" value="{{ session('userName') }}" name="client_name" id="client_name">
            
            {{-- CORRIGIDO: Usando 'price_per_hour' --}}
            <input type="hidden" value="{{ $productInfo->price_per_hour ?? 0 }}" id="product_price_per_hour">
            
            <input type="hidden" name="duration_minutes" id="duration_minutes_input">

            <!-- Detalhes do Produto (Card Informativo) -->
            <div class="p-4 bg-gray-100 dark:bg-gray-700 rounded-xl border border-gray-200 dark:border-gray-600 shadow-inner">
                <p class="text-lg font-bold text-sky-700 dark:text-sky-300 mb-1">Informações do Serviço</p>
                <p class="text-sm text-gray-600 dark:text-gray-300">
                    <span class="font-semibold">Preço/Hora:</span> R$ <span id="display-price-per-hour">{{ number_format($productInfo->price_per_hour ?? 0, 2, ',', '.') }}</span>
                </p>
                <p class="text-sm text-gray-600 dark:text-gray-300">
                    <span class="font-semibold">Horário de Funcionamento:</span> {{ $productInfo->opens_at ?? 'N/A' }} até {{ $productInfo->closes_at ?? 'N/A' }}
                </p>
                <p class="text-sm text-gray-600 dark:text-gray-300">
                    <span class="font-semibold">Pessoas mínimas:</span> {{ $productInfo->min_people ?? '0' }} 
                </p>
            </div>

            <!-- Campos de Reserva de Data/Hora (Grid Responsivo) -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                
                {{-- Data --}}
                @if ($productInfo->type === 'calendar')
                <div>
                    <label for="date" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Data:</label>
                    <input type="date" name="date" id="date" required
                    class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-4 focus:ring-sky-500/50 focus:border-sky-500 text-gray-900 dark:text-gray-100 transition duration-300 ease-in-out shadow-sm">
                </div>
            </div>
            @if ($productInfo->min_people > 0)
                            <div>
                                
                    <label for="peoples" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Pessoas:</label>
                    <input type="number" name="peoples" id="peoples" required
                    class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-4 focus:ring-sky-500/50 focus:border-sky-500 text-gray-900 dark:text-gray-100 transition duration-300 ease-in-out shadow-sm">
                </div>
            @endif
            
            <input value="Escolher Hora" type="submit"
       class="w-full py-3 bg-sky-600 hover:bg-sky-700 text-white font-semibold rounded-lg shadow-lg shadow-sky-500/30 transition duration-300 ease-in-out cursor-pointer transform hover:scale-[1.01]">

            @endif

        </form>
    </div>
@else
    <!-- Conteúdo de Erro se o produto não for encontrado (Mantido, mas estilizado) -->
    <div class="bg-white dark:bg-gray-800 w-full max-w-md rounded-2xl shadow-2xl p-8 space-y-4 border border-gray-200 dark:border-gray-700 text-center">
        <h2 class="text-3xl font-bold text-red-600 dark:text-red-400">Produto Não Encontrado</h2>
        <p class="text-lg text-gray-600 dark:text-gray-300">Não foi possível prosseguir com a reserva. A informação do produto está faltando.</p>
        <a href="{{ url('/') }}" class="inline-block px-6 py-3 bg-sky-600 hover:bg-sky-700 text-white font-semibold rounded-lg shadow-lg shadow-sky-500/30 transition duration-300 ease-in-out transform hover:scale-[1.05]">
            Ir para Home
        </a>
    </div>
@endif

<script>

    // --- 2. LÓGICA DA MÁSCARA DE TELEFONE (DDD + 9 dígitos) ---
    const phoneInput = document.getElementById('client_phone');
    
    function phoneMask(event) {
        let input = event.target
        input.value = phoneCleanup(input.value)
    }

    function phoneCleanup(v) {
        v = v.replace(/\D/g,"") // Remove tudo que não é dígito
        v = v.replace(/^(\d{2})(\d)/g,"($1) $2") // Adiciona parênteses no DDD
        v = v.replace(/(\d)(\d{4})$/,"$1-$2") // Adiciona o hífen antes dos últimos 4 dígitos
        return v
    }

    if (phoneInput) {
        phoneInput.addEventListener('keyup', phoneMask);
    }

    form.addEventListener('submit', function(e) {
        // e.preventDefault(); // Descomente para testes de UI sem envio real

        // Mudar estado para Loading
        submitButton.disabled = true;
        buttonText.textContent = 'Reservando...';
        buttonIcon.innerHTML = `
            <svg class="animate-spin-fast h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
        `;
    });
</script>



</body>
</html>