<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Dashboard Cliente - Celestial Dark</title>
    
    <!-- Tailwind CSS CDN para garantir o estilo no ambiente de visualização -->
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .fade-in-up {
            animation: fadeIn 0.6s ease-out forwards;
        }
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
    
    <!-- Container Principal do Dashboard do Cliente -->
    <div class="w-full max-w-4xl mx-auto space-y-10 fade-in-up">
        
        <!-- HEADER: Título e Logout -->
        <header class="flex flex-col sm:flex-row justify-between items-center py-4 border-b border-gray-700">
            <h1 class="text-4xl font-extrabold text-sky-400 tracking-wider mb-2 sm:mb-0">
                Minha Área
            </h1>

            <div class="flex items-center space-x-4">
                <p class="text-lg font-medium text-gray-300 bg-gray-700/50 px-4 py-2 rounded-full hidden sm:block">
                    Olá, <strong><i>{{ session('userName') }}</i></strong>!
                </p>
                
                <!-- Botão de Logout -->
                <a href="loggout"
                   class="flex items-center justify-center px-4 py-2 bg-red-600 hover:bg-red-700 text-white font-semibold rounded-xl shadow-lg shadow-red-500/30 transition duration-300 ease-in-out transform hover:scale-[1.05]">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3v-4a3 3 0 013-3h4a3 3 0 013 3v1" />
                    </svg>
                    Sair
                </a>
            </div>
        </header>

        <!-- SEÇÃO PRINCIPAL: BOTÕES DE AÇÃO -->
        <section class="grid grid-cols-1 md:grid-cols-2 gap-6">
            
            
            <!-- Ação 2: Meus Próximos Agendamentos -->
            <a href="client/my_appointments"
               class="p-8 bg-gray-800 rounded-xl shadow-xl border border-gray-700 hover:border-sky-500 card-hover space-y-3 flex flex-col justify-center items-center text-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-sky-400 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <span class="text-xl font-bold text-gray-100">Meus Horários</span>
                <span class="text-sm text-gray-400">Verifique os próximos serviços.</span>
            </a>

            <!-- Ação 3: Meu Perfil e Configurações -->
            <a href="client/profile"
               class="p-8 bg-gray-800 rounded-xl shadow-xl border border-gray-700 hover:border-sky-500 card-hover space-y-3 flex flex-col justify-center items-center text-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-sky-400 mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                </svg>
                <span class="text-xl font-bold text-gray-100">Dados Pessoais</span>
                <span class="text-sm text-gray-400">Atualizar informações de contato.</span>
            </a>
        </section>

        <!-- SEÇÃO DE INFORMAÇÕES DE STATUS (OPCIONAL/VISUAL) -->
        <section class="pt-6">
            <h2 class="text-2xl font-bold text-gray-300 mb-4 border-b border-gray-700/50 pb-2">Status Rápido</h2>
            <div class="bg-gray-800 p-6 rounded-xl border border-gray-700 space-y-4 mb-4">
                <p class="text-lg text-gray-300 flex justify-between items-center">
                    <span class="font-semibold">Reservas:</span>
                    <span class="text-green-400 font-bold">{{ $statusReservations[0] }}</span>
                </p>
            </div>
            <div class="bg-gray-800 p-6 rounded-xl border border-gray-700 space-y-4 mb-4">
                <p class="text-lg text-gray-300 flex justify-between items-center">
                    <span class="font-semibold">Reservas confirmadas:</span>
                    <span class="text-green-400 font-bold">{{ $statusReservations[1] }}</span>
                </p>
            </div>
            <div class="bg-gray-800 p-6 rounded-xl border border-gray-700 space-y-4 mb-4">
                <p class="text-lg text-gray-300 flex justify-between items-center">
                    <span class="font-semibold">Reservas Canceladas:</span>
                    <span class="text-green-400 font-bold">{{ $statusReservations[2] }}</span>
                </p>
            </div>
        </section>
        
    </div>
</body>
</html>