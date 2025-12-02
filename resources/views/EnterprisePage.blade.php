@php
// Código Laravel Blade aprimorado para um dashboard moderno e estruturado.
// O @vite foi substituído pelo CDN do Tailwind para visualização imediata.
@endphp
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Enterprise Dashboard - Celestial Dark</title>
    
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Configuração do Tailwind para fontes e cores -->
    <script>
        tailwind.config = {
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
    </script>

    <style>
        /* Animação para cards */
        .card-hover:hover {
            transform: translateY(-4px) scale(1.01);
            box-shadow: 0 10px 20px rgba(8, 126, 164, 0.4);
        }
        .card-hover {
            transition: all 0.3s ease-in-out;
        }
    </style>
</head>
<body class="bg-gray-900 text-gray-100 min-h-screen p-4 md:p-8 font-sans">
    
    <!-- Container Principal do Dashboard -->
    <div class="w-full max-w-6xl mx-auto space-y-10">
        
        <!-- HEADER: Título, Status e Logout -->
        <header class="flex flex-col sm:flex-row justify-between items-center py-4 border-b border-gray-700">
            <h1 class="text-4xl font-extrabold text-sky-400 tracking-wider mb-2 sm:mb-0">
                Painel da Empresa
            </h1>

            <div class="flex items-center space-x-4">
                <!-- Status/Nome da Empresa (Placeholder) -->
                <p class="text-lg font-medium text-gray-300 bg-gray-700/50 px-4 py-2 rounded-full hidden sm:block">
                    Bem-vindo, <strong><i>{{ session('userEnterprise') }}</i></strong>!
                </p>
                
                <!-- Botão de Logout -->
                <a href="loggout"
                   class="flex items-center justify-center px-4 py-2 bg-red-600 hover:bg-red-700 text-white font-semibold rounded-xl shadow-lg shadow-red-500/30 transition duration-300 ease-in-out transform hover:scale-[1.05]">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3v-4a3 3 0 013-3h4a3 3 0 013 3v1" />
                    </svg>
                    Logout
                </a>
            </div>
        </header>

        <!-- SEÇÃO 1: INFORMAÇÕES GERAIS (Data e Hora Dinâmicas) -->
        <section class="grid grid-cols-1 md:grid-cols-3 gap-6">
            
            <!-- Card 1: Data Atual -->
            <div class="p-6 bg-gray-800 rounded-xl shadow-xl border-t-4 border-sky-500 hover:border-sky-400 card-hover space-y-2">
                <h3 class="text-sm font-semibold text-gray-400 uppercase tracking-wider">DATA ATUAL</h3>
                <p id="current-date" class="text-3xl font-bold text-gray-100">-</p>
            </div>
            
            <!-- Card 2: Hora Atual -->
            <div class="p-6 bg-gray-800 rounded-xl shadow-xl border-t-4 border-sky-500 hover:border-sky-400 card-hover space-y-2">
                <h3 class="text-sm font-semibold text-gray-400 uppercase tracking-wider">HORA LOCAL</h3>
                <p id="current-time" class="text-3xl font-bold text-gray-100">-</p>
            </div>

            <!-- Card 3: Link Rápido de Ação -->
            <a href="enterprise/registerProduct"
               class="p-6 bg-sky-700 rounded-xl shadow-xl border-t-4 border-sky-500 hover:bg-sky-600 card-hover space-y-2 flex flex-col justify-center items-center text-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-white mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                </svg>
                <span class="text-lg font-bold text-white">Registrar Produto</span>
                <span class="text-xs text-sky-100">Crie um novo serviço ou produto agora.</span>
            </a>
        </section>

        <!-- SEÇÃO 2: Cartões de Métricas (Preparação para Futuro) -->
        <section class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            
            <!-- Métrica 1: Total de Produtos -->
            <div class="p-6 bg-gray-800 rounded-xl shadow-xl border-l-4 border-green-500 card-hover space-y-1">
                <h3 class="text-sm font-semibold text-gray-400">PRODUTOS ATIVOS</h3>
                <p class="text-2xl font-bold text-gray-100">12</p>
                <p class="text-xs text-green-400">+5% este mês</p>
            </div>

            <!-- Métrica 2: Novas Reservas -->
            <div class="p-6 bg-gray-800 rounded-xl shadow-xl border-l-4 border-yellow-500 card-hover space-y-1">
                <h3 class="text-sm font-semibold text-gray-400">NOVAS RESERVAS</h3>
                <p class="text-2xl font-bold text-gray-100">45</p>
                <p class="text-xs text-yellow-400">Desde ontem</p>
            </div>

            <!-- Métrica 3: Clientes Totais -->
            <div class="p-6 bg-gray-800 rounded-xl shadow-xl border-l-4 border-blue-500 card-hover space-y-1">
                <h3 class="text-sm font-semibold text-gray-400">CLIENTES (Base)</h3>
                <p class="text-2xl font-bold text-gray-100">1.250</p>
                <p class="text-xs text-blue-400">Crescimento constante</p>
            </div>

            <!-- Métrica 4: Faturamento (Placeholder) -->
            <div class="p-6 bg-gray-800 rounded-xl shadow-xl border-l-4 border-purple-500 card-hover space-y-1">
                <h3 class="text-sm font-semibold text-gray-400">FATURAMENTO (Mês)</h3>
                <p class="text-2xl font-bold text-gray-100">R$ 15.400,00</p>
                <p class="text-xs text-purple-400">Meta: R$ 20k</p>
            </div>
        </section>

        <!-- SEÇÃO 3: Links de Navegação Principal (Botões Grandes) -->
        <section class="pt-4 grid grid-cols-1 sm:grid-cols-2 gap-6">
            
            <!-- Gerenciar Produtos/Serviços -->
            <a href="enterprise/manageProducts"
               class="p-6 flex items-center justify-center bg-gray-800 rounded-xl border border-gray-700 shadow-xl card-hover hover:border-sky-500">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-sky-400 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2m-7 5.75L12 17l-3-4.25" />
                </svg>
                <span class="text-xl font-bold text-gray-100">Gerenciar Serviços</span>
            </a>

            <!-- Ver Reservas/Agendamentos -->
            <a href="enterprise/reservations"
               class="p-6 flex items-center justify-center bg-gray-800 rounded-xl border border-gray-700 shadow-xl card-hover hover:border-sky-500">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-sky-400 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-4 4h.01M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
                <span class="text-xl font-bold text-gray-100">Ver Agendamentos</span>
            </a>

        </section>
        
    </div>

    <script>
        // Função para atualizar a data e hora em tempo real
        function updateDateTime() {
            const now = new Date();
            
            // Opções de formatação para data (ex: Terça-feira, 25 de Novembro)
            const dateOptions = { 
                weekday: 'long', 
                year: 'numeric', 
                month: 'long', 
                day: 'numeric' 
            };
            const formattedDate = now.toLocaleDateString('pt-BR', dateOptions);
            
            // Opções de formatação para hora (ex: 14:30:45)
            const timeOptions = { 
                hour: '2-digit', 
                minute: '2-digit', 
                second: '2-digit' 
            };
            const formattedTime = now.toLocaleTimeString('pt-BR', timeOptions);

            document.getElementById('current-date').textContent = formattedDate;
            document.getElementById('current-time').textContent = formattedTime;
        }

        // Chama a função imediatamente e depois a cada segundo
        updateDateTime();
        setInterval(updateDateTime, 1000);
    </script>
</body>
</html>