<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard de Produtos - Gerenciamento</title>
    
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
            .product-table-row {
                display: block;
                margin-bottom: 1rem;
                border-radius: 0.5rem;
                padding: 1rem;
                border: 1px solid #374151; /* gray-700 */
            }
            .product-table-row > div {
                display: flex;
                justify-content: space-between;
                padding: 0.25rem 0;
                border-bottom: 1px dotted #4b5563; /* gray-600 */
            }
            .product-table-row > div:last-child {
                border-bottom: none;
            }
            .product-table-row .header-label {
                font-weight: 600;
                color: #9ca3af; /* gray-400 */
                margin-right: 1rem;
            }
            .product-table-header {
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
                Gerenciamento de Produtos
            </h1>
            <div class="flex space-x-4">
                <a href="registerProduct" 
                   class="inline-flex items-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white font-semibold rounded-lg shadow-lg shadow-green-500/30 transition duration-300 ease-in-out transform hover:scale-[1.03]">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z" clip-rule="evenodd" />
                    </svg>
                    Novo Produto
                </a>
            </div>
        </div>

        <!-- FILTROS -->
        <div class="bg-gray-800 rounded-xl shadow-2xl p-6 mb-8 border border-gray-700">
            <h2 class="text-xl font-semibold mb-4 text-white">Filtros Avançados</h2>
            <div class="grid grid-cols-1 md:grid-cols-5 gap-4" id="filter-controls">
                
                <!-- Filtro por Nome/Descrição -->
                <div class="col-span-full md:col-span-1">
                    <label for="search-term" class="block text-sm font-medium text-gray-400 mb-1">Buscar (Nome/Desc.)</label>
                    <input type="text" id="search-term" placeholder="Ex: Sala, Estúdio" class="w-full p-2 bg-gray-700 border border-gray-600 rounded-lg focus:ring-sky-500 focus:border-sky-500 text-white" oninput="filterProducts()">
                </div>

                <!-- Filtro por Tipo -->
                <div>
                    <label for="filter-type" class="block text-sm font-medium text-gray-400 mb-1">Tipo</label>
                    <select id="filter-type" class="w-full p-2 bg-gray-700 border border-gray-600 rounded-lg focus:ring-sky-500 focus:border-sky-500 text-white" onchange="filterProducts()">
                        <option value="">Todos</option>
                        <!-- Opções preenchidas via JS -->
                    </select>
                </div>

                <!-- Filtro por Mínimo de Pessoas -->
                <div>
                    <label for="filter-min-people" class="block text-sm font-medium text-gray-400 mb-1">Mín. Pessoas: <span id="min-people-value">1</span></label>
                    <input type="range" id="filter-min-people" min="0" max="20" value="0" class="w-full h-2 bg-gray-700 rounded-lg appearance-none cursor-pointer range-lg" oninput="document.getElementById('min-people-value').innerText = this.value; filterProducts()">
                </div>

                <!-- Filtro por Preço Máximo -->
                <div>
                    <label for="filter-max-price" class="block text-sm font-medium text-gray-400 mb-1">Preço Máximo/Hora: R$ <span id="max-price-value">500,00</span></label>
                    <input type="range" id="filter-max-price" min="0" max="500" step="10" value="500" class="w-full h-2 bg-gray-700 rounded-lg appearance-none cursor-pointer range-lg" oninput="document.getElementById('max-price-value').innerText = parseFloat(this.value).toFixed(2).replace('.', ','); filterProducts()">
                </div>

                <!-- Filtro por Duração Mínima -->
                <div>
                    <label for="filter-min-duration" class="block text-sm font-medium text-gray-400 mb-1">Duração Mínima (min): <span id="min-duration-value">0</span></label>
                    <input type="range" id="filter-min-duration" min="0" max="360" step="15" value="0" class="w-full h-2 bg-gray-700 rounded-lg appearance-none cursor-pointer range-lg" oninput="document.getElementById('min-duration-value').innerText = this.value; filterProducts()">
                </div>

            </div>
        </div>

        <!-- LISTA DE PRODUTOS (Tabela/Cards) -->
        <div class="bg-gray-800 rounded-xl shadow-2xl border border-gray-700 overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-700">
                <thead class="bg-gray-700 product-table-header">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">ID</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Nome</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Preço/Hora</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Duração (min)</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Horário</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Tipo</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Mín. Pessoas</th>
                        <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-300 uppercase tracking-wider">Ações</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-700" id="products-list">
                    <!-- Linhas de produtos serão renderizadas aqui pelo JavaScript -->
                </tbody>
            </table>
        </div>

        <!-- Mensagem de Nenhum Produto Encontrado -->
        <div id="no-products-message" class="hidden mt-4 bg-gray-800 rounded-xl shadow-2xl p-8 text-center border border-gray-700">
            <p class="text-xl text-gray-300">Nenhum produto encontrado com os filtros aplicados.</p>
        </div>

    </div>

    <script>
        // 1. INJEÇÃO DE DADOS DO BACKEND (BLADE)
        // Injeta a coleção de produtos do Laravel/PHP para o JavaScript
        const PRODUCTS = @json($products ?? []);

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
                option.textContent = type.charAt(0).toUpperCase() + type.slice(1); // Capitaliza o tipo
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
            const minDuration = parseInt(document.getElementById('filter-min-duration').value);
            
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

                // 5. Filtro por Duração Mínima
                const matchesMinDuration = product.duration_minutes >= minDuration;

                return matchesSearch && matchesType && matchesMinPeople && matchesMaxPrice && matchesMinDuration;
            });

            // Renderiza os produtos filtrados
            if (filteredProducts.length > 0) {
                document.getElementById('no-products-message').classList.add('hidden');
                filteredProducts.forEach(product => {
                    const row = document.createElement('tr');
                    row.className = 'product-table-row bg-gray-800 hover:bg-gray-700 transition duration-150 ease-in-out';
                    
                    // Para telas grandes (tabela)
                    row.innerHTML = `
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-400 hidden lg:table-cell">${product.id}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-white">
                            <span class="header-label lg:hidden">Nome:</span> ${product.name}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-sky-300">
                            <span class="header-label lg:hidden">Preço/Hora:</span> ${formatPrice(product.price_per_hour)}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">
                            <span class="header-label lg:hidden">Duração:</span> ${product.duration_minutes} min
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">
                            <span class="header-label lg:hidden">Horário:</span> ${product.opens_at.substring(0, 5)} - ${product.closes_at.substring(0, 5)}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">
                            <span class="header-label lg:hidden">Tipo:</span> ${product.type}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-300">
                            <span class="header-label lg:hidden">Mín. Pessoas:</span> ${product.min_people}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <button onclick="handleDelete(${product.id}, '${product.name}')" 
                                    class="text-red-500 hover:text-red-700 transition duration-150 ease-in-out transform hover:scale-105">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 inline-block" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                                </svg>
                                <span class="lg:hidden ml-1">Deletar</span>
                            </button>
                        </td>
                    `;
                    productsList.appendChild(row);
                });
            } else {
                document.getElementById('no-products-message').classList.remove('hidden');
            }
        };

        // 4. FUNÇÃO DE AÇÃO (DELETAR)
        const handleDelete = (productId, productName) => {
            if (confirm(`Tem certeza que deseja deletar o produto "${productName}" (ID: ${productId})?`)) {
                // Aqui você faria a chamada AJAX/Fetch para o seu backend Laravel
                // Exemplo:
                // fetch(`/products/${productId}`, {
                //     method: 'DELETE',
                //     headers: {
                //         'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                //     }
                // })
                // .then(response => {
                //     if (response.ok) {
                //         alert('Produto deletado com sucesso!');
                //         // Recarrega a página ou remove o item da lista (para este exemplo, apenas alertamos)
                //         window.location.reload(); 
                //     } else {
                //         alert('Erro ao deletar o produto.');
                //     }
                // });

                // Para fins de demonstração, apenas um alerta:
                alert(`Ação de DELETAR para o produto ${productName} (ID: ${productId}) seria executada aqui.`);
                
                // Em um ambiente real, após o sucesso, você removeria o item da lista sem recarregar a página
                // const index = PRODUCTS.findIndex(p => p.id === productId);
                // if (index > -1) {
                //     PRODUCTS.splice(index, 1);
                //     filterProducts(); // Re-renderiza a lista
                // }
            }
        };

        // 5. INICIALIZAÇÃO
        document.addEventListener('DOMContentLoaded', () => {
            // 5.1. Ajusta os valores máximos dos ranges com base nos dados reais
            if (PRODUCTS.length > 0) {
                const prices = PRODUCTS.map(p => parseFloat(p.price_per_hour));
                const people = PRODUCTS.map(p => p.min_people);
                const durations = PRODUCTS.map(p => p.duration_minutes);

                const maxPrice = Math.ceil(Math.max(...prices) / 10) * 10;
                const maxPeople = Math.max(...people);
                const maxDuration = Math.max(...durations);

                // Preço
                const priceRange = document.getElementById('filter-max-price');
                priceRange.max = maxPrice > 500 ? maxPrice : 500;
                priceRange.value = priceRange.max;
                document.getElementById('max-price-value').innerText = parseFloat(priceRange.value).toFixed(2).replace('.', ',');

                // Pessoas
                const peopleRange = document.getElementById('filter-min-people');
                peopleRange.max = maxPeople > 20 ? maxPeople : 20;
                peopleRange.value = peopleRange.min;
                document.getElementById('min-people-value').innerText = peopleRange.value;

                // Duração
                const durationRange = document.getElementById('filter-min-duration');
                durationRange.max = maxDuration > 360 ? maxDuration : 360;
                durationRange.value = durationRange.min;
                document.getElementById('min-duration-value').innerText = durationRange.value;
            }

            // 5.2. Preenche o filtro de Tipo
            populateTypeFilter();
            
            // 5.3. Renderiza a lista inicial
            filterProducts(); 
        });
    </script>
</body>
</html>
