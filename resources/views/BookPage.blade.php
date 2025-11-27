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
        
        <form method="POST" id="reservation-form" class="space-y-6">
            @csrf

            {{-- Hidden Fields --}}
            <input type="hidden" name="where_to" value="{{ $tbReservation ?? '' }}">
            <input type="hidden" name="Products" value="{{ $tbProducts ?? '' }}">
            <input type="hidden" name="product_id" value="{{ $productInfo->id ?? '' }}">
            <input type="hidden" name="product" value="{{ $productInfo->name ?? '' }}">
            <input type="hidden" name="status" value="confirmed">
            <input type="hidden" value="{{ $clientName }}" name="client_name" id="client_name">
            
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
            </div>

            <!-- Campos de Reserva de Data/Hora (Grid Responsivo) -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                
                {{-- Data --}}
                <div>
                    <label for="date" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Data:</label>
                    <input type="date" name="date" id="date" required
                           class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-4 focus:ring-sky-500/50 focus:border-sky-500 text-gray-900 dark:text-gray-100 transition duration-300 ease-in-out shadow-sm">
                </div>

                {{-- Hora Início --}}
                <div>
                    <label for="start_time" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Hora de Início:</label>
                    <input type="time" name="start_time" id="start_time" 
                           min="{{ $productInfo->opens_at ?? '' }}" 
                           max="{{ $productInfo->closes_at ?? '' }}" 
                           required
                           class="time-input w-full px-4 py-3 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-4 focus:ring-sky-500/50 focus:border-sky-500 text-gray-900 dark:text-gray-100 transition duration-300 ease-in-out shadow-sm">
                </div>

                {{-- Hora Fim --}}
                <div>
                    <label for="end_time" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Hora de Término:</label>
                    <input type="time" name="end_time" id="end_time" 
                           min="{{ $productInfo->opens_at ?? '' }}" 
                           max="{{ $productInfo->closes_at ?? '' }}" 
                           required
                           class="time-input w-full px-4 py-3 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-4 focus:ring-sky-500/50 focus:border-sky-500 text-gray-900 dark:text-gray-100 transition duration-300 ease-in-out shadow-sm">
                </div>
                
                {{-- Telefone do Cliente (COM MÁSCARA JS) --}}
                <div>
                    <label for="client_phone" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Telefone (DDD + Número):</label>
                    <input type="text" name="client_phone" id="client_phone" placeholder="(99) 99999-9999" maxlength="15"
                           class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-4 focus:ring-sky-500/50 focus:border-sky-500 placeholder-gray-500 dark:placeholder-gray-400 text-gray-900 dark:text-gray-100 transition duration-300 ease-in-out shadow-sm">
                </div>
            </div>

            <!-- Card de Resumo do Custo (Dinâmico) -->
            <div id="summary-card" class="p-4 bg-sky-50 dark:bg-sky-950 rounded-xl border border-sky-200 dark:border-sky-800 text-center shadow-md">
                <p class="text-sm font-semibold text-sky-700 dark:text-sky-300 mb-1">Resumo da Reserva</p>
                <p class="text-base text-gray-700 dark:text-gray-200">
                    Duração: <span id="duration-display" class="font-bold text-sky-600 dark:text-sky-400">0 min</span>
                </p>
                <p class="text-xl font-extrabold text-sky-800 dark:text-sky-200">
                    Total: R$ <span id="total-cost-display">0,00</span>
                </p>
            </div>
            
            {{-- Botão de Envio (COM ESTADOS INTERATIVOS) --}}
            <button type="submit" id="submit-button"
                    class="w-full py-4 bg-sky-600 hover:bg-sky-700 text-white font-extrabold rounded-xl shadow-lg shadow-sky-500/50 
                           transition-all duration-300 ease-in-out transform hover:scale-[1.01] active:scale-[0.98] disabled:opacity-50 disabled:cursor-not-allowed
                           focus:outline-none focus:ring-4 focus:ring-sky-500/50 tracking-wide flex items-center justify-center space-x-2">
                <span id="button-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                    </svg>
                </span>
                <span id="button-text">Fazer Reserva Agora</span>
            </button>
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
    // --- 1. LÓGICA DE CÁLCULO DINÂMICO DE CUSTO/DURAÇÃO (CORRIGIDA) ---
    const startTimeInput = document.getElementById('start_time');
    const endTimeInput = document.getElementById('end_time');
    const durationDisplay = document.getElementById('duration-display');
    const totalCostDisplay = document.getElementById('total-cost-display');
    const durationMinutesInput = document.getElementById('duration_minutes_input');
    
    // CORRIGIDO: Variável agora lida corretamente o ID 'product_price_per_hour'
    const productPriceEl = document.getElementById('product_price_per_hour');
    
    // Preço por hora (R$)
    // Importante: Assume-se que o valor no input hidden está em formato float (ex: 150.00)
    const pricePerHour = parseFloat(productPriceEl ? productPriceEl.value : 0) || 0;

    function calculateReservation() {
        const startTime = startTimeInput.value;
        const endTime = endTimeInput.value;
        const dateInput = document.getElementById('date');

        if (!startTime || !endTime || !dateInput.value) {
            durationDisplay.textContent = '0 min';
            totalCostDisplay.textContent = pricePerHour === 0 ? '0,00' : '...';
            durationMinutesInput.value = 0;
            return;
        }

        const date = dateInput.value;
        
        // Cria objetos Date para cálculo
        let startDateTime = new Date(`${date}T${startTime}:00`);
        let endDateTime = new Date(`${date}T${endTime}:00`);

        // Lida com reserva que termina no dia seguinte (Se a hora final for menor que a inicial)
        if (endDateTime.getTime() <= startDateTime.getTime()) {
             // Só adiciona um dia se as horas não forem iguais (duração mínima de 1 minuto)
             if (endDateTime.getTime() !== startDateTime.getTime()) {
                endDateTime = new Date(endDateTime.getTime() + 24 * 60 * 60 * 1000); // Adiciona 24h
            } else {
                 // Duração zero, sai.
                 durationDisplay.textContent = '0 min';
                 totalCostDisplay.textContent = '0,00';
                 durationMinutesInput.value = 0;
                 return;
            }
        }

        const durationMs = endDateTime - startDateTime;
        const durationMins = Math.round(durationMs / (1000 * 60)); // Duração em minutos

        let totalCost = 0;
        if (pricePerHour > 0) {
            // CORRIGIDO: Cálculo de custo
            // Custo = Preço por hora * (Duração em minutos / 60)
            totalCost = pricePerHour * (durationMins / 60);
        } else {
            // Se o preço for 0, é uma reserva gratuita.
            totalCost = 0;
        }

        // Atualiza a UI com formatação BR
        durationDisplay.textContent = `${durationMins} min`;
        totalCostDisplay.textContent = totalCost.toLocaleString('pt-BR', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
        durationMinutesInput.value = durationMins; // Salva a duração no campo hidden
    }

    // Adiciona listeners para cálculo em tempo real
    startTimeInput.addEventListener('change', calculateReservation);
    endTimeInput.addEventListener('change', calculateReservation);
    document.getElementById('date').addEventListener('change', calculateReservation);
    
    // Executa o cálculo inicial se houver valores pré-definidos
    calculateReservation();


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

    // --- 3. LÓGICA DO ESTADO DO BOTÃO (LOADING/SUCCESS) ---
    const submitButton = document.getElementById('submit-button');
    const buttonText = document.getElementById('button-text');
    const buttonIcon = document.getElementById('button-icon');
    const form = document.getElementById('reservation-form');

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