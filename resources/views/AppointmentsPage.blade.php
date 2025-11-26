<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Reservas - Celestial Dark</title>

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
        /* Estilos específicos para o tema Dark e Status */
        .status-Pendente { background-color: #f59e0b; color: #1f2937; } 
        .status-Confirmado { background-color: #10b981; color: #1f2937; } 
        .status-Cancelado { background-color: #ef4444; color: #1f2937; } 
        .status-Concluido { background-color: #3b82f6; color: #1f2937; } 
        
        /* Estilo para a mensagem de feedback */
        #feedback-message {
            transition: opacity 0.5s, transform 0.5s;
        }
    </style>
</head>
<body class="bg-gray-900 text-gray-100 min-h-screen p-4 md:p-8 font-sans">
    
    <div class="max-w-5xl mx-auto fade-in-up">
        
        <!-- HEADER: Título e Botão Voltar -->
        <header class="flex justify-between items-center mb-8 border-b border-gray-700 pb-4">
            <button onclick="history.back()" class="text-gray-400 hover:text-sky-400 transition duration-200 flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 inline-block mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Voltar
            </button>
            <h1 class="text-4xl font-extrabold text-center text-sky-400 tracking-tight flex-grow">
                Agenda de Reservas
            </h1>
            <div></div> {{-- Spacer --}}
        </header>

        {{-- Campo oculto para o token CSRF (necessário para requisições POST seguras) --}}
        <input type="hidden" id="csrf-token" value="{{ csrf_token() }}">

        {{-- Lista de Reservas --}}
        <div class="space-y-6">
            @if(empty($reservations))
                <div class="bg-gray-800 rounded-xl shadow-2xl p-8 text-center border border-gray-700">
                    <p class="text-xl text-gray-300">Nenhuma reserva encontrada.</p>
                </div>
            @else
                @foreach($reservations as $reservation)
                    <?php 
                        // Lógica para extrair o nome da empresa (source_table - "_reservations")
                        $sourceTableName = $reservation->source_table ?? 'default_reservations';
                        $companyName = str_replace('_reservations', '', $sourceTableName);
                        $companyNameDisplay = str_replace('_', ' ', $companyName);
                        
                        // Formatação da Data (usando $reservation->date)
                        // Assume que $reservation->date é uma string de data válida (ex: YYYY-MM-DD)
                        $dateFormatted = date('d/m/Y', strtotime($reservation->date));
                        
                        // Determinar a classe do botão de cancelamento (usando $reservation->status)
                        $isCancelled = $reservation->status === 'Cancelado';
                        $cancelClass = $isCancelled 
                            ? 'bg-gray-600 text-gray-400 cursor-not-allowed' 
                            : 'bg-red-600 hover:bg-red-700 text-white shadow-lg shadow-red-500/30 transform hover:scale-[1.03]';
                        
                        // O ID da reserva deve ser o ID real no banco de dados. Estou assumindo que ele é $reservation->id.
                        // Se a sua variável não for 'id', ajuste aqui:
                        $reservationId = $reservation->id ?? $reservation->date . '_' . $reservation->start_time; // Fallback se 'id' não existir
                    ?>
                    <div class="bg-gray-800 rounded-xl shadow-xl p-6 border border-gray-700 flex flex-col md:flex-row justify-between items-start md:items-center space-y-4 md:space-y-0 transition duration-300 ease-in-out hover:scale-[1.01] hover:shadow-sky-500/30" data-reservation-id="{{ $reservationId }}" id="reservation-card-{{ $reservationId }}">
                        
                        <!-- Coluna 1: Dados da Reserva (Horários e Empresa) -->
                        <div class="space-y-1 md:w-1/3">
                            <p class="text-lg font-semibold text-sky-400">
                                <span class="font-normal text-gray-300">Empresa:</span> {{ $companyNameDisplay }}
                            </p>
                            <p class="text-3xl font-extrabold text-white">
                                {{ $reservation->start_time }} - {{ $reservation->end_time }}
                            </p>
                            <p class="text-md font-medium text-gray-400">
                                Data: {{ $dateFormatted }}
                            </p>
                        </div>
                        
                        <!-- Coluna 2: Dados do Cliente e Status -->
                        <div class="space-y-2 md:w-1/3">
                            <div class="flex items-center space-x-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-sky-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                                <!-- Nome do Cliente (usando $reservation->client_name) -->
                                <p class="text-base text-gray-200">{{ $reservation->client_name }}</p>
                            </div>
                            <div class="flex items-center space-x-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-sky-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 00.948-.684l1.498-4.493a1 1 0 011.859 0l1.498 4.493A1 1 0 0017.72 3H21a2 2 0 012 2v10a2 2 0 01-2 2h-3.28a1 1 0 00-.948.684l-1.498 4.493a1 1 0 01-1.859 0l-1.498-4.493A1 1 0 008.28 17H5a2 2 0 01-2-2V5z" />
                                </svg>
                                <!-- Telefone do Cliente (usando $reservation->client_phone) -->
                                <p class="text-sm text-gray-400">{{ $reservation->client_phone }}</p>
                            </div>
                            
                            <!-- Status Label (usando $reservation->status) -->
                            <span id="status-label-{{ $reservationId }}" class="inline-block mt-2 px-3 py-1 text-xs font-bold uppercase rounded-full {{ 'status-' . str_replace(' ', '', $reservation->status) }}">
                                {{ $reservation->status }}
                            </span>
                        </div>

                        <!-- Coluna 3: Ações -->
                        <div class="md:w-1/3 flex justify-end">
                            <a
                            href="delete/{{ $reservation->id }}/{{ $reservation->source_table }}"
                                class="cancel-button inline-flex items-center justify-center px-6 py-2 font-semibold rounded-lg transition duration-300 ease-in-out {{ $cancelClass }}"
                                {{ $isCancelled ? 'disabled' : '' }}
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                {{ $isCancelled ? 'Cancelada' : 'Cancelar Reserva' }}
                            </a>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
        
    </div>
    

</body>
</html>