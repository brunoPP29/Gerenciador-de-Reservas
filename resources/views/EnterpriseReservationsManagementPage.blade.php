<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard de Reservas - Gerenciamento</title>
    
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        /* Estilos para o tema escuro e transições */
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
        /* Estilos para o range slider */
        input[type=range]::-webkit-slider-thumb {
            -webkit-appearance: none;
            appearance: none;
            width: 16px;
            height: 16px;
            background: #0ea5e9; /* sky-500 */
            cursor: pointer;
            border-radius: 50%;
            margin-top: -6px; /* Centraliza o thumb */
        }
        input[type=range]::-moz-range-thumb {
            width: 16px;
            height: 16px;
            background: #0ea5e9; /* sky-500 */
            cursor: pointer;
            border-radius: 50%;
        }
        /* Estilo para a tabela responsiva */
        @media (max-width: 1024px) {
            .reservation-table-row {
                display: block;
                margin-bottom: 1rem;
                border-radius: 0.5rem;
                padding: 1rem;
                border: 1px solid #374151; /* gray-700 */
            }
            .reservation-table-row > div {
                display: flex;
                justify-content: space-between;
                padding: 0.25rem 0;
                border-bottom: 1px dotted #4b5563; /* gray-600 */
            }
            .reservation-table-row > div:last-child {
                border-bottom: none;
            }
            .reservation-table-row .header-label {
                font-weight: 600;
                color: #9ca3af; /* gray-400 */
                margin-right: 1rem;
            }
            .reservation-table-header {
                display: none; /* Esconde o cabeçalho da tabela em telas pequenas */
            }
        }
    </style>
</head>
<body class="bg-gray-900 text-gray-100 min-h-screen p-4 md:p-8 font-sans">
    
    <div class="max-w-7xl mx-auto fade-in-up">
        
        <!-- HEADER: Título e Botões de Ação -->
        <div class="flex justify-between items-center mb-8 border-b border-gray-700 pb-4">
            <h1 class="text-4xl font-extrabold text-sky-400 tracking-tight">
                Gerenciamento de Reservas
            </h1>
            <div class="flex space-x-4">
                <button onclick="filterReservations()" 
                   class="inline-flex items-center px-4 py-2 bg-sky-600 hover:bg-sky-700 text-white font-semibold rounded-lg shadow-lg shadow-sky-500/30 transition duration-300 ease-in-out transform hover:scale-[1.03]">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M3 3a1 1 0 011-1h12a1 1 0 011 1v3a1 1 0 01-.293.707L12 11.414V15a1 1 0 01-.293.707l-2 2A1 1 0 018 17v-5.586L3.293 6.707A1 1 0 013 6V3z" clip-rule="evenodd" />
                    </svg>
                    Aplicar Filtros
                </button>
            </div>
        </div>

        <!-- FILTROS -->
        <div class="bg-gray-800 rounded-xl shadow-2xl p-6 mb-8 border border-gray-700">
            <h2 class="text-xl font-semibold mb-4 text-white">Filtros Avançados</h2>
            <div class="grid grid-cols-1 md:grid-cols-5 gap-4" id="filter-controls">
                
                <!-- Filtro por Nome/Telefone do Cliente -->
                <div class="col-span-full md:col-span-1">
                    <label for="search-term" class="block text-sm font-medium text-gray-400 mb-1">Buscar (Cliente/Telefone)</label>
                    <input type="text" id="search-term" placeholder="Ex: Bruno, 5199..." class="w-full p-2 bg-gray-700 border border-gray-600 rounded-lg focus:ring-sky-500 focus:border-sky-500 text-white" oninput="filterReservations()">
                </div>

                <!-- Filtro por Status -->
                <div>
                    <label for="filter-status" class="block text-sm font-medium text-gray-400 mb-1">Status</label>
                    <select id="filter-status" class="w-full p-2 bg-gray-700 border border-gray-600 rounded-lg focus:ring-sky-500 focus:border-sky-500 text-white" onchange="filterReservations()">
                        <option value="">Todos</option>
                        <!-- Opções preenchidas via JS -->
                    </select>
                </div>

                <!-- Filtro por Data -->
                <div>
                    <label for="filter-date" class="block text-sm font-medium text-gray-400 mb-1">Data Específica</label>
                    <input type="date" id="filter-date" class="w-full p-2 bg-gray-700 border border-gray-600 rounded-lg focus:ring-sky-500 focus:border-sky-500 text-white" onchange="filterReservations()">
                </div>

                <!-- Filtro por Mínimo de Pessoas -->
                <div>
                    <label for="filter-min-people" class="block text-sm font-medium text-gray-400 mb-1">Mín. Pessoas: <span id="min-people-value">1</span></label>
                    <input type="range" id="filter-min-people" min="0" max="10" value="0" class="w-full h-2 bg-gray-700 rounded-lg appearance-none cursor-pointer range-lg" oninput="document.getElementById('min-people-value').innerText = this.value; filterReservations()">
                </div>

                <!-- Filtro por Período (Data de Criação) -->
                <div>
                    <label for="filter-created-at" class="block text-sm font-medium text-gray-400 mb-1">Criado Após</label>
                    <input type="date" id="filter-created-at" class="w-full p-2 bg-gray-700 border border-gray-600 rounded-lg focus:ring-sky-500 focus:border-sky-500 text-white" onchange="filterReservations()">
                </div>

            </div>
        </div>

        <!-- LISTA DE RESERVAS (Tabela/Cards) -->
        <div class="bg-gray-800 rounded-xl shadow-2xl border border-gray-700 overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-700">
                <thead class="bg-gray-700 reservation-table-header">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">ID</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Cliente</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Data</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Horário</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Pessoas</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Status</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Criado Em</th>
                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-300 uppercase tracking-wider">Ações</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-700" id="reservations-list">
                    <!-- Linhas de reservas serão renderizadas aqui pelo JavaScript -->
                </tbody>
            </table>
        </div>

        <!-- Mensagem de Nenhum Produto Encontrado -->
        <div id="no-reservations-message" class="hidden mt-4 bg-gray-800 rounded-xl shadow-2xl p-8 text-center border border-gray-700">
            <p class="text-xl text-gray-300">Nenhuma reserva encontrada com os filtros aplicados.</p>
        </div>

    </div>

    <script>
        // 1. INJEÇÃO DE DADOS DO BACKEND (BLADE)
        // Injeta a coleção de reservas do Laravel/PHP para o JavaScript
        const RESERVATIONS = @json($reservations ?? []);

        // 2. FUNÇÕES DE UTILIDADE
        // Função para formatar a data (YYYY-MM-DD para DD/MM/YYYY)
        const formatDate = (dateString) => {
            if (!dateString) return '';
            const [year, month, day] = dateString.split('-');
            return `${day}/${month}/${year}`;
        };

        // Função para formatar o status com cores
        const formatStatus = (status) => {
            let colorClass = 'bg-gray-600';
            let text = status.charAt(0).toUpperCase() + status.slice(1);

            switch (status.toLowerCase()) {
                case 'confirmed':
                    colorClass = 'bg-green-600';
                    text = 'Confirmada';
                    break;
                case 'pending':
                    colorClass = 'bg-yellow-600';
                    text = 'Pendente';
                    break;
                case 'canceled':
                    colorClass = 'bg-red-600';
                    text = 'Cancelada';
                    break;
                case 'completed':
                    colorClass = 'bg-sky-600';
                    text = 'Concluída';
                    break;
            }

            return `<span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full ${colorClass} text-white">${text}</span>`;
        };

        // Função para preencher o select de Status
        const populateStatusFilter = () => {
            const statusSelect = document.getElementById('filter-status');
            // Cria um Set de status únicos e os ordena
            const statuses = [...new Set(RESERVATIONS.map(r => r.status))].sort();
            
            statuses.forEach(status => {
                const option = document.createElement('option');
                option.value = status;
                option.textContent = status.charAt(0).toUpperCase() + status.slice(1); // Capitaliza o status
                statusSelect.appendChild(option);
            });
        };

        // 3. FUNÇÃO PRINCIPAL DE FILTRAGEM E RENDERIZAÇÃO
        const filterReservations = () => {
            // Coleta os valores dos filtros
            const searchTerm = document.getElementById('search-term').value.toLowerCase();
            const filterStatus = document.getElementById('filter-status').value;
            const filterDate = document.getElementById('filter-date').value; // YYYY-MM-DD
            const minPeople = parseInt(document.getElementById('filter-min-people').value);
            const filterCreatedAt = document.getElementById('filter-created-at').value; // YYYY-MM-DD
            
            const reservationsList = document.getElementById('reservations-list');
            reservationsList.innerHTML = ''; // Limpa a lista atual
            
            const filteredReservations = RESERVATIONS.filter(reservation => {
                // 1. Filtro por Nome/Telefone do Cliente
                const matchesSearch = reservation.client_name.toLowerCase().includes(searchTerm) || 
                                      (reservation.client_phone && reservation.client_phone.includes(searchTerm));

                // 2. Filtro por Status
                const matchesStatus = !filterStatus || reservation.status === filterStatus;

                // 3. Filtro por Data Específica
                const matchesDate = !filterDate || reservation.date === filterDate;

                // 4. Filtro por Mínimo de Pessoas
                const matchesMinPeople = reservation.peoples >= minPeople;

                // 5. Filtro por Data de Criação (Criado Após)
                const matchesCreatedAt = !filterCreatedAt || reservation.created_at.substring(0, 10) >= filterCreatedAt;

                return matchesSearch && matchesStatus && matchesDate && matchesMinPeople && matchesCreatedAt;
            });

            // Renderiza as reservas filtradas
            if (filteredReservations.length > 0) {
                document.getElementById('no-reservations-message').classList.add('hidden');
                filteredReservations.forEach(reservation => {
                    const row = document.createElement('tr');
                    row.className = 'reservation-table-row bg-gray-800 hover:bg-gray-700 transition duration-150 ease-in-out';
                    
                    // Lógica dos Links de Ação Condicionais
                    let actionLinks = '';
                    
                    // Link de Confirmar (se o status for 'canceled' ou 'pending')
                    if (reservation.status === 'canceled' || reservation.status === 'pending') {
                        // ATENÇÃO: Substitua o '#' pela sua rota real de confirmação
                        actionLinks += `
                            <a href="reservations/status/${reservation.id}" data-action="confirm" data-id="${reservation.id}"
                               class="text-green-500 hover:text-green-700 transition duration-150 ease-in-out transform hover:scale-105">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline-block" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                </svg>
                                <span class="lg:hidden ml-1">Confirmar</span>
                            </a>
                        `;
                    }

                    // Link de Cancelar (se o status for 'confirmed' ou 'pending')
                    if (reservation.status === 'confirmed') {
                        // ATENÇÃO: Substitua o '#' pela sua rota real de cancelamento
                        actionLinks += `
                            <a href="reservations/status/${reservation.id}" data-action="cancel" data-id="${reservation.id}"
                               class="text-yellow-500 hover:text-yellow-700 transition duration-150 ease-in-out transform hover:scale-105">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline-block" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                                </svg>
                                <span class="lg:hidden ml-1">Cancelar</span>
                            </a>
                        `;
                    }

                    // Link de Deletar (sempre visível)
                    // ATENÇÃO: Substitua o '#' pela sua rota real de deleção
                    actionLinks += `
                        <a href="reservations/delete/${reservation.id}" data-action="delete" data-id="${reservation.id}"
                                class="text-red-500 hover:text-red-700 transition duration-150 ease-in-out transform hover:scale-105">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline-block" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 100 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                            </svg>
                            <span class="lg:hidden ml-1">Deletar</span>
                        </a>
                    `;
                    
                    // Para telas grandes (tabela)
                    row.innerHTML = `
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-400 hidden lg:table-cell">${reservation.id}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-white">
                            <span class="header-label lg:hidden">Cliente:</span> ${reservation.client_name}
                            <p class="text-xs text-gray-400">${reservation.client_phone}</p>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-sky-300">
                            <span class="header-label lg:hidden">Data:</span> ${formatDate(reservation.date)}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">
                            <span class="header-label lg:hidden">Horário:</span> ${reservation.start_time.substring(0, 5)} - ${reservation.end_time.substring(0, 5)}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">
                            <span class="header-label lg:hidden">Pessoas:</span> ${reservation.peoples}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            <span class="header-label lg:hidden">Status:</span> ${formatStatus(reservation.status)}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-400">
                            <span class="header-label lg:hidden">Criado Em:</span> ${formatDate(reservation.created_at.substring(0, 10))}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium space-x-2">
                            ${actionLinks}
                        </td>
                    `;
                    reservationsList.appendChild(row);
                });
            } else {
                document.getElementById('no-reservations-message').classList.remove('hidden');
            }
        };


        // 5. INICIALIZAÇÃO
        document.addEventListener('DOMContentLoaded', () => {
            // 5.1. Ajusta os valores máximos dos ranges com base nos dados reais
            if (RESERVATIONS.length > 0) {
                const people = RESERVATIONS.map(r => r.peoples);
                const maxPeople = Math.max(...people);

                // Pessoas
                const peopleRange = document.getElementById('filter-min-people');
                peopleRange.max = maxPeople > 10 ? maxPeople : 10;
                peopleRange.value = peopleRange.min;
                document.getElementById('min-people-value').innerText = peopleRange.value;
            }

            // 5.2. Preenche o filtro de Status
            populateStatusFilter();
            
            // 5.3. Renderiza a lista inicial
            filterReservations(); 
        });
    </script>
</body>
</html>
