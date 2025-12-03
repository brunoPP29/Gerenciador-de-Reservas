<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Registrar Produto - Celestial Dark (Melhorado)</title>
    
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Configuração do Tailwind para cores personalizadas e sombra -->
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'dark-bg': '#0f172a', // slate-900
                        'dark-card': '#1e293b', // slate-800
                        'dark-input': '#334155', // slate-700
                        'accent': '#38bdf8', // sky-400
                    },
                    boxShadow: {
                        'glow': '0 0 15px rgba(56, 189, 248, 0.4)', // Sombra para o botão
                    }
                }
            }
        }
    </script>

    <style>
        /* Animação de entrada mais suave */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .fade-in-up {
            animation: fadeIn 0.8s ease-out forwards;
        }

        /* Estilo para o input em foco */
        .input-focus:focus {
            box-shadow: 0 0 0 3px rgba(56, 189, 248, 0.5);
        }

        /* Estilo para o botão de submit com efeito de clique */
        .submit-button:active {
            transform: scale(0.98);
            box-shadow: none;
        }
    </style>
</head>
<body class="bg-dark-bg text-gray-100 min-h-screen flex items-center justify-center p-4">
    <div class="w-full max-w-lg bg-dark-card rounded-2xl shadow-2xl p-8 space-y-8 border border-slate-700/50 fade-in-up">
        
        <!-- Header com Botão Voltar e Título -->
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center border-b border-slate-700/50 pb-4">
            <!-- Botão Voltar Aprimorado -->
            <a href="http://localhost/reservas/public/enterprise/" 
               class="text-slate-400 hover:text-accent transition duration-300 flex items-center p-2 rounded-lg hover:bg-slate-700/50 -ml-2 mb-4 sm:mb-0">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 inline-block mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                <span class="font-medium">Voltar</span>
            </a>
            
            <h1 class="text-3xl font-extrabold text-accent tracking-tight text-right w-full sm:w-auto">
                Registrar Novo Produto
            </h1>
        </div>

        {{-- Error Session Message (Aprimorado) --}}
        @if(session('error'))
            <div class="bg-red-900/30 border border-red-700 text-red-300 p-4 rounded-xl text-sm font-medium transition duration-500 ease-in-out transform hover:scale-[1.01] shadow-lg shadow-red-900/20">
                <p class="flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                    </svg>
                    {{ session('error') }}
                </p>
            </div>
        @endif
        
        {{-- Success Session Message (Aprimorado) --}}
        @if(session('success'))
            <div class="bg-emerald-900/30 border border-emerald-700 text-emerald-300 p-5 rounded-xl text-base font-medium space-y-4 transition duration-500 ease-in-out transform hover:scale-[1.01] shadow-lg shadow-emerald-900/20">
                <p class="flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                    </svg>
                    {{ session('success') }}
                </p>
                <a href="." class="inline-block px-6 py-2 bg-accent hover:bg-sky-500 text-white font-semibold rounded-lg transition duration-300 ease-in-out shadow-md shadow-accent/30">
                    Ir para o Dashboard
                </a>
            </div>
        @endif

        <form method="POST" class="space-y-6">
            @csrf
            
            <!-- Seção 1: Informações Básicas -->
            <div class="space-y-4 border-b border-slate-700/50 pb-6">
                <h2 class="text-xl font-semibold text-accent">Detalhes do Produto</h2>

                {{-- Name Input --}}
                <div>
                    <label for="name" class="block text-sm font-medium text-slate-300 mb-1">Nome do Produto</label>
                    <input type="text" id="name" placeholder="Nome do Produto ou Serviço..." name="name" required
                    class="input-focus w-full px-4 py-3 bg-dark-input border border-slate-600 rounded-lg placeholder-slate-400 text-gray-100 transition duration-200 ease-in-out">
                </div>
                
                {{-- Type Select --}}
                <div>
                    <label for="type" class="block text-sm font-medium text-slate-300 mb-1">Tipo de Produto</label>
                    <select id="type" name="type"
                            class="input-focus w-full px-4 py-3 bg-dark-input border border-slate-600 rounded-lg placeholder-slate-400 text-gray-100 transition duration-200 ease-in-out appearance-none cursor-pointer">
                        <option value="" disabled selected>Selecione o Tipo...</option>
                        @foreach($getTypes as $type)
                            <option value="{{ $type->type }}">{{ $type->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <!-- Seção 2: Preço e Duração -->
            <div class="space-y-4 border-b border-slate-700/50 pb-6">
                <h2 class="text-xl font-semibold text-accent">Configuração de Reserva</h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    {{-- Price Input --}}
                    <div>
                        <label for="price_per_hour" class="block text-sm font-medium text-slate-300 mb-1">Preço por Hora (R$/HR)</label>
                        <input type="number" id="price_per_hour" placeholder="0.00" name="price_per_hour" step="0.01" required
                               class="input-focus w-full px-4 py-3 bg-dark-input border border-slate-600 rounded-lg placeholder-slate-400 text-gray-100 transition duration-200 ease-in-out">
                    </div>

                    {{-- Duration Input --}}
                    <div>
                        <label for="duration_minutes" class="block text-sm font-medium text-slate-300 mb-1">Duração Padrão (minutos)</label>
                        <input type="number" id="duration_minutes" placeholder="Ex: 60" name="duration_minutes" required
                               class="input-focus w-full px-4 py-3 bg-dark-input border border-slate-600 rounded-lg placeholder-slate-400 text-gray-100 transition duration-200 ease-in-out">
                    </div>
                </div>

                {{-- Min People Input --}}
                <div>
                    <label for="min_people" class="block text-sm font-medium text-slate-300 mb-1">Mínimo de Pessoas</label>
                    <input type="number" id="min_people" placeholder="Ex: 1" name="min_people" required
                           class="input-focus w-full px-4 py-3 bg-dark-input border border-slate-600 rounded-lg placeholder-slate-400 text-gray-100 transition duration-200 ease-in-out">
                </div>
                <div>
                    <label for="cancel_time" class="block text-sm font-medium text-slate-300 mb-1">Tempo mínimo antes de cancelamento (horas)</label>
                    <input type="number" id="cancel_time" placeholder="Ex: 24" name="cancel_time" required
                               class="input-focus w-full px-4 py-3 bg-dark-input border border-slate-600 rounded-lg placeholder-slate-400 text-gray-100 transition duration-200 ease-in-out">
                </div>
            </div>

            <!-- Seção 3: Horários de Operação -->
            <div class="space-y-4 border-b border-slate-700/50 pb-6">
                <h2 class="text-xl font-semibold text-accent">Horários de Operação</h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    {{-- Opens At Input --}}
                    <div>
                        <label for="opens_at" class="block text-sm font-medium text-slate-300 mb-1">Início das Operações</label>
                        <input type="time" id="opens_at" name="opens_at" required
                               class="input-focus w-full px-4 py-3 bg-dark-input border border-slate-600 rounded-lg placeholder-slate-400 text-gray-100 transition duration-200 ease-in-out text-center">
                    </div>

                    {{-- Closes At Input --}}
                    <div>
                        <label for="closes_at" class="block text-sm font-medium text-slate-300 mb-1">Fim das Operações</label>
                        <input type="time" id="closes_at" name="closes_at" required
                               class="input-focus w-full px-4 py-3 bg-dark-input border border-slate-600 rounded-lg placeholder-slate-400 text-gray-100 transition duration-200 ease-in-out text-center">
                    </div>
                </div>
            </div>

            <!-- Seção 4: Descrição -->
            <div class="space-y-4">
                <h2 class="text-xl font-semibold text-accent">Descrição Detalhada</h2>

                {{-- Description Input --}}
                <div>
                    <label for="description" class="sr-only">Descrição</label>
                    <textarea id="description" placeholder="Descrição detalhada do Produto/Serviço, incluindo regras e informações importantes..." name="description" rows="4"
                           class="input-focus w-full px-4 py-3 bg-dark-input border border-slate-600 rounded-lg placeholder-slate-400 text-gray-100 transition duration-200 ease-in-out"></textarea>
                </div>
            </div>

            {{-- Submit Button --}}
            <input type="submit" value="Registrar Produto"
                   class="submit-button w-full py-4 bg-accent hover:bg-sky-500 text-white text-lg font-bold rounded-xl shadow-lg shadow-accent/40 transition duration-300 ease-in-out cursor-pointer transform hover:scale-[1.01] focus:outline-none focus:ring-4 focus:ring-accent/50">
        </form>
    </div>
</body>
</html>
