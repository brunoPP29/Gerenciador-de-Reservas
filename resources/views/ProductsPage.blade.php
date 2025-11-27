<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Produtos da Empresa - Celestial Dark</title>
    
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
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(8, 126, 164, 0.2);
        }
        .card-hover {
            transition: all 0.3s ease-in-out;
        }
    </style>
</head>
<body class="bg-gray-900 text-gray-100 min-h-screen p-4 md:p-8 font-sans">
    
    <div class="max-w-4xl mx-auto fade-in-up">
        
        <!-- HEADER: Título e Botão Voltar -->
        <div class="flex justify-between items-center mb-8 border-b border-gray-700 pb-4">
            <button onclick="history.back()" class="text-gray-400 hover:text-sky-400 transition duration-200 flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 inline-block mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Voltar
            </button>
            <h1 class="text-4xl font-extrabold text-center text-sky-400 tracking-tight grow">
                Produtos de {{ $dadosEmpresa->name ?? 'Empresa' }}
            </h1>
            <div></div> {{-- Spacer --}}
        </div>

        {{-- Lista de Produtos --}}
        @if($produtos->isEmpty())
            <div class="bg-gray-800 rounded-xl shadow-2xl p-8 text-center border border-gray-700">
                <p class="text-xl text-gray-300">Nenhum produto encontrado para esta empresa.</p>
            </div>
        @else
            <div class="space-y-6">
                @foreach($produtos as $produto)
                    <div class="bg-gray-800 rounded-xl shadow-lg p-6 border border-gray-700 flex flex-col sm:flex-row justify-between items-start sm:items-center space-y-4 sm:space-y-0 transition duration-300 ease-in-out card-hover">
                        <div class="space-y-1">
                            <h2 class="text-2xl font-bold text-white">{{ $produto->name }}</h2>
                            <p class="text-lg font-medium text-sky-300">R$ {{ number_format($produto->price_per_hour, 2, ',', '.') }} / hora</p>
                            @if(isset($produto->description))
                                <p class="text-sm text-gray-400 mt-2 max-w-lg">{{ $produto->description }}</p>
                            @endif
                        </div>
                        
                        <a href="/reservas/public/loja/{{ $empresa }}/{{ $produto->name }}"
                           class="inline-flex items-center justify-center px-6 py-3 bg-sky-600 hover:bg-sky-700 text-white font-semibold rounded-lg shadow-lg shadow-sky-500/30 transition duration-300 ease-in-out transform hover:scale-[1.03] shrink-0 text-base">
                            Agendar Agora
                        </a>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</body>
</html>