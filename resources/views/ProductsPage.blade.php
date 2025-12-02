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
    </style>
</head>
<body class="bg-gray-900 text-gray-100 min-h-screen p-4 md:p-8 font-sans">
    
    <div class="max-w-6xl mx-auto fade-in-up">
        
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

        <!-- FILTROS -->
        <div class="bg-gray-800 rounded-xl shadow-2xl p-6 mb-8 border border-gray-700">
            <h2 class="text-xl font-semibold mb-4 text-white">Filtrar Produtos</h2>
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4" id="filter-controls">
                
                <!-- Filtro por Nome/Descrição -->
                <div class="col-span-full md:col-span-1">
                    <label for="search-term" class="block text-sm font-medium text-gray-400 mb-1">Buscar por Nome/Descrição</label>
                    <input type="text" id="search-term" placeholder="Ex: Sala, Estúdio, 10 pessoas" class="w-full p-2 bg-gray-700 border border-gray-600 rounded-lg focus:ring-sky-500 focus:border-sky-500 text-white" oninput="filterProducts()">
                </div>

                <!-- Filtro por Tipo -->
                <div>
                    <label for="filter-type" class="block text-sm font-medium text-gray-400 mb-1">Tipo de Produto</label>
                    <select id="filter-type" class="w-full p-2 bg-gray-700 border border-gray-600 rounded-lg focus:ring-sky-500 focus:border-sky-500 text-white" onchange="filterProducts()">
                        <option value="">Todos os Tipos</option>
                        <!-- Opções preenchidas via JS -->
                    </select>
                </div>

                <!-- Filtro por Mínimo de Pessoas -->
                <div>
                    <label for="filter-min-people" class="block text-sm font-medium text-gray-400 mb-1">Mínimo de Pessoas: <span id="min-people-value">1</span></label>
                    <input type="range" id="filter-min-people" min="0" max="20" value="0" class="w-full h-2 bg-gray-700 rounded-lg appearance-none cursor-pointer range-lg" oninput="document.getElementById('min-people-value').innerText = this.value; filterProducts()">
                </div>

                <!-- Filtro por Preço Máximo -->
                <div>
                    <label for="filter-max-price" class="block text-sm font-medium text-gray-400 mb-1">Preço Máximo/Hora: R$ <span id="max-price-value">500,00</span></label>
                    <input type="range" id="filter-max-price" min="50" max="500" step="10" value="500" class="w-full h-2 bg-gray-700 rounded-lg appearance-none cursor-pointer range-lg" oninput="document.getElementById('max-price-value').innerText = parseFloat(this.value).toFixed(2).replace('.', ','); filterProducts()">
                </div>

                <!-- Filtro por Horário de Uso -->
                <div class="col-span-full md:col-span-1">
                    <label for="filter-time" class="block text-sm font-medium text-gray-400 mb-1">Disponível no Horário</label>
                    <input type="time" id="filter-time" value="" class="w-full p-2 bg-gray-700 border border-gray-600 rounded-lg focus:ring-sky-500 focus:border-sky-500 text-white" onchange="filterProducts()">
                </div>

            </div>
        </div>

        <!-- LISTA DE PRODUTOS -->
        <div class="space-y-6" id="products-list">
            <!-- Produtos serão renderizados aqui pelo JavaScript -->
        </div>

        <!-- Mensagem de Nenhum Produto Encontrado -->
        <div id="no-products-message" class="hidden bg-gray-800 rounded-xl shadow-2xl p-8 text-center border border-gray-700">
            <p class="text-xl text-gray-300">Nenhum produto encontrado com os filtros aplicados.</p>
        </div>

    </div>

    <script>
        // 1. INJEÇÃO DE DADOS DO BACKEND (BLADE)
        // O array de produtos é injetado diretamente do PHP/Laravel para o JavaScript
        const PRODUCTS = @json($produtos);
        // A slug da empresa é injetada para a construção correta do link de agendamento
        const EMPRESA_SLUG = '{{ $empresa }}';

        // 2. FUNÇÕES DE UTILIDADE
        // Função para formatar o preço para BRL
        const formatPrice = (price) => {
            // Garante que o valor é um número e formata
            return parseFloat(price).toLocaleString('pt-BR', { style: 'currency', currency: 'BRL' });
        };

        // Função para preencher o select de Tipos de Produto
        const populateTypeFilter = () => {
            const typeSelect = document.getElementById('filter-type');
            // Cria um Set de tipos únicos e os ordena
            const types = [...new Set(PRODUCTS.map(p => p.type))].sort();
            
            types.forEach(type => {
                const option = document.createElement('option');
                option.value = type;
                option.textContent = type;
                typeSelect.appendChild(option);
            });
        };

        // 3. FUNÇÃO PRINCIPAL DE FILTRAGEM E RENDERIZAÇÃO
        const filterProducts = () => {
            // Coleta os valores dos filtros
            const searchTerm = document.getElementById('search-term').value.toLowerCase();
            const filterType = document.getElementById('filter-type').value;
            const minPeople = parseInt(document.getElementById('filter-min-people').value);
            const maxPrice = parseFloat(document.getElementById('filter-max-price').value);
            const filterTime = document.getElementById('filter-time').value;
            
            const productsList = document.getElementById('products-list');
            productsList.innerHTML = ''; // Limpa a lista atual
            
            const filteredProducts = PRODUCTS.filter(product => {
                // 1. Filtro por Nome/Descrição
                const matchesSearch = product.name.toLowerCase().includes(searchTerm) || 
                                      (product.description && product.description.toLowerCase().includes(searchTerm));

                // 2. Filtro por Tipo
                const matchesType = !filterType || product.type === filterType;

                // 3. Filtro por Mínimo de Pessoas
                const matchesMinPeople = product.min_people >= minPeople;

                // 4. Filtro por Preço Máximo
                const matchesMaxPrice = product.price_per_hour <= maxPrice;

                // 5. Filtro por Horário de Uso
                let matchesTime = true;
                if (filterTime) {
                    // Converte os horários para um formato comparável (ex: 14:30 -> 1430)
                    const selectedTime = parseInt(filterTime.replace(':', ''));
                    const openTime = parseInt(product.opens_at.replace(':', ''));
                    const closeTime = parseInt(product.closes_at.replace(':', ''));
                    
                    // Lógica de comparação de horário: selectedTime deve estar entre openTime e closeTime
                    matchesTime = selectedTime >= openTime && selectedTime <= closeTime;
                }

                return matchesSearch && matchesType && matchesMinPeople && matchesMaxPrice && matchesTime;
            });

            // Renderiza os produtos filtrados
            if (filteredProducts.length > 0) {
                document.getElementById('no-products-message').classList.add('hidden');
                filteredProducts.forEach(product => {
                    const productCard = document.createElement('div');
                    productCard.className = 'bg-gray-800 rounded-xl shadow-lg p-6 border border-gray-700 flex flex-col lg:flex-row justify-between items-start lg:items-center space-y-4 lg:space-y-0 transition duration-300 ease-in-out card-hover';
                    
                    // Cria o slug do produto para o link

                    // Informações Adicionais (Badges)
                    const badges = `
                        <div class="flex flex-wrap gap-2 mt-2">
                            <span class="px-3 py-1 text-xs font-medium text-sky-200 bg-sky-900 rounded-full">${product.type}</span>
                            <span class="px-3 py-1 text-xs font-medium text-green-200 bg-green-900 rounded-full">Mín. ${product.min_people} Pessoas</span>
                            <span class="px-3 py-1 text-xs font-medium text-indigo-200 bg-indigo-900 rounded-full">${product.duration_minutes} min de Duração</span>
                            <span class="px-3 py-1 text-xs font-medium text-yellow-200 bg-yellow-900 rounded-full">${product.opens_at} - ${product.closes_at}</span>
                        </div>
                    `;

                    productCard.innerHTML = `
                        <div class="space-y-1 flex-grow">
                            <h2 class="text-2xl font-bold text-white">${product.name}</h2>
                            <p class="text-lg font-medium text-sky-300">${formatPrice(product.price_per_hour)} / hora</p>
                            ${product.description ? `<p class="text-sm text-gray-400 mt-2 max-w-xl">${product.description}</p>` : ''}
                            ${badges}
                        </div>
                        
                        <a href="/reservas/public/loja/${EMPRESA_SLUG}/${product.name}"
                           class="inline-flex items-center justify-center px-6 py-3 bg-sky-600 hover:bg-sky-700 text-white font-semibold rounded-lg shadow-lg shadow-sky-500/30 transition duration-300 ease-in-out transform hover:scale-[1.03] shrink-0 text-base">
                            Agendar Agora
                        </a>
                    `;
                    productsList.appendChild(productCard);
                });
            } else {
                document.getElementById('no-products-message').classList.remove('hidden');
            }
        };

        // 4. INICIALIZAÇÃO
        document.addEventListener('DOMContentLoaded', () => {
            // Define os valores iniciais dos range sliders com base nos dados reais, se houver
            if (PRODUCTS.length > 0) {
                const maxPrice = Math.ceil(Math.max(...PRODUCTS.map(p => p.price_per_hour)) / 10) * 10;
                const maxPeople = Math.max(...PRODUCTS.map(p => p.min_people));

                const priceRange = document.getElementById('filter-max-price');
                priceRange.max = maxPrice > 500 ? maxPrice : 500; // Garante um max razoável
                priceRange.value = priceRange.max;
                document.getElementById('max-price-value').innerText = parseFloat(priceRange.value).toFixed(2).replace('.', ',');

                const peopleRange = document.getElementById('filter-min-people');
                peopleRange.max = maxPeople > 20 ? maxPeople : 20; // Garante um max razoável
                peopleRange.value = peopleRange.min;
                document.getElementById('min-people-value').innerText = peopleRange.value;
            }

            populateTypeFilter();
            filterProducts(); // Renderiza a lista inicial
        });
    </script>
</body>
</html>
