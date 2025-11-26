<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>404 - Ops, Página Não Encontrada</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <!-- 
      MELHORIA (Botão Dark Mode): 
      Este script é executado ANTES de tudo.
      Ele verifica se o usuário JÁ escolheu um tema (light/dark) no localStorage
      e aplica imediatamente, evitando o "flash" de tema errado.
    -->
    <script>
        if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>

    <style>
        /* Animação original mantida */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .fade-in-up {
            animation: fadeIn 0.6s ease-out forwards;
        }

        /* MELHORIA (Fundo Animado): 
          Um gradiente sutil e animado no fundo para dar vida à página.
          Usa um pseudo-elemento `::before` para não afetar o conteúdo.
        */
        @keyframes gradientShift {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        body::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            z-index: -1; /* Coloca atrás de todo o conteúdo */
            
            /* Gradiente para Light Mode */
            background: linear-gradient(-45deg, #f0f9ff, #e0f2fe, #f0f9ff, #ecfdf5);
            
            /* Tamanho e animação */
            background-size: 400% 400%;
            animation: gradientShift 15s ease infinite;
            opacity: 1;
            transition: opacity 0.5s ease-in-out;
        }

        /* Gradiente para Dark Mode */
        .dark body::before {
            background: linear-gradient(-45deg, #0c1424, #0c1424, #020617, #111827);
        }

        /* MELHORIA (Animação Flutuante): 
          Uma leve animação de "flutuação" para o número 404, 
          dando uma sensação de "perdido no espaço".
        */
        @keyframes float {
            0% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
            100% { transform: translateY(0px); }
        }
        
        /* MELHORIA (Efeito Parallax no 404): 
          A transição suave é crucial para o efeito de parallax 
          controlado pelo mouse não ser "duro".
        */
        #parallax-404 {
            animation: float 6s ease-in-out infinite;
            transition: transform 0.2s cubic-bezier(0.25, 0.46, 0.45, 0.94);
        }
    </style>
</head>

<!-- 
  O corpo agora tem um `relative` para o pseudo-elemento `::before` funcionar
  e `overflow-hidden` para o gradiente não vazar.
-->
<body class="relative min-h-screen flex items-center justify-center p-4 overflow-hidden">
    
    <!-- 
      MELHORIA (Botão Light/Dark Mode): 
      Um botão funcional e acessível para alternar o tema.
      Ele fica fixo no canto superior direito.
    -->
    <button
        id="theme-toggle"
        aria-label="Alternar entre modo claro e escuro"
        class="fade-in-up fixed top-6 right-6 z-10 p-3 rounded-full text-gray-500 dark:text-gray-400 bg-white/50 dark:bg-gray-800/50 backdrop-blur-sm border border-gray-200 dark:border-gray-700 hover:bg-gray-100 dark:hover:bg-gray-700 transition-all duration-300 transform hover:scale-110"
        style="animation-delay: 0.3s;"
    >
        <!-- Ícone de Sol (visível no modo escuro) -->
        <svg id="theme-icon-sun" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M12 12a5 5 0 100-10 5 5 0 000 10z" />
        </svg>
        <!-- Ícone de Lua (visível no modo claro) -->
        <svg id="theme-icon-moon" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
        </svg>
    </button>

    <!-- 
      O `z-10` garante que o conteúdo fique acima do fundo `::before`.
      Adicionei um `max-w-md` para manter o conteúdo legível em telas grandes.
    -->
    <div class="text-center space-y-6 fade-in-up z-10 max-w-md w-full">
        <!-- 
          MELHORIA (Efeito Parallax):
          Este `<h1>` agora tem o ID `parallax-404` para o JS 
          criar o efeito de profundidade com o mouse.
        -->
        <h1 id="parallax-404" class="text-9xl font-extrabold text-sky-600 dark:text-sky-400 tracking-widest">
            404
        </h1>
        
        <!-- 
          O card de "Página não encontrada" agora tem um leve `backdrop-blur`
          para um efeito "glassmorphism" sobre o fundo animado.
        -->
        <div class="bg-white/70 dark:bg-gray-800/70 backdrop-blur-md text-gray-700 dark:text-gray-200 px-6 py-3 text-lg rounded-full border border-gray-200 dark:border-gray-700 shadow-xl shadow-gray-200/30 dark:shadow-black/30">
            Página Não Encontrada
        </div>

        <p class="text-lg text-gray-600 dark:text-gray-400">
            Parece que você se perdeu. Não se preocupe, acontece com os melhores.
        </p>
        
        <!-- 
          MELHORIA (Botões):
          - Adicionado `active:scale-95` para feedback tátil ao clicar.
          - Sombra mais pronunciada e específica da cor no botão primário.
          - Efeito de transição mais suave (`duration-300`).
        -->
        <div class="flex flex-col sm:flex-row justify-center gap-4 pt-4">
            <button 
                onclick="history.back()" 
                class="inline-flex items-center justify-center px-6 py-3 bg-gray-600 hover:bg-gray-700 text-white font-semibold rounded-lg shadow-md hover:shadow-lg transition duration-300 ease-in-out transform hover:scale-[1.03] active:scale-95"
            >
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Voltar
            </button>
            <a 
                href="{{ url('/') }}" 
                class="inline-flex items-center justify-center px-6 py-3 bg-sky-600 hover:bg-sky-700 text-white font-semibold rounded-lg shadow-lg shadow-sky-500/50 hover:shadow-xl hover:shadow-sky-500/60 transition duration-300 ease-in-out transform hover:scale-[1.03] active:scale-95"
            >
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                </svg>
                Ir para Home
            </a>
        </div>
    </div>

    <!-- 
      MELHORIA (JavaScript Funcional):
      Todo o JS para as novas interações está aqui.
    -->
    <script>
        // --- LÓGICA DO BOTÃO DE DARK MODE ---
        const themeToggle = document.getElementById('theme-toggle');
        const sunIcon = document.getElementById('theme-icon-sun');
        const moonIcon = document.getElementById('theme-icon-moon');
        const htmlEl = document.documentElement;

        // Função para atualizar o ícone visível
        function updateIcon() {
            if (htmlEl.classList.contains('dark')) {
                sunIcon.classList.remove('hidden');
                moonIcon.classList.add('hidden');
            } else {
                sunIcon.classList.add('hidden');
                moonIcon.classList.remove('hidden');
            }
        }

        // Função para alternar o tema
        function toggleTheme() {
            if (htmlEl.classList.contains('dark')) {
                htmlEl.classList.remove('dark');
                localStorage.theme = 'light';
            } else {
                htmlEl.classList.add('dark');
                localStorage.theme = 'dark';
            }
            updateIcon(); // Atualiza o ícone após a troca
        }

        // Adiciona o clique ao botão
        themeToggle.addEventListener('click', toggleTheme);
        
        // Define o ícone correto na primeira vez que a página carrega
        updateIcon();


        // --- LÓGICA DO EFEITO PARALLAX NO 404 ---
        const text404 = document.getElementById('parallax-404');
        const strength = 25; // Quão forte é o efeito?

        document.addEventListener('mousemove', (e) => {
            // Pega a posição do mouse (de 0 a 1)
            const x = e.clientX / window.innerWidth;
            const y = e.clientY / window.innerHeight;

            // Calcula o quanto o texto deve se mover (de -0.5 a +0.5)
            // Multiplica pela "força" para definir o total de pixels
            const moveX = (x - 0.5) * strength;
            const moveY = (y - 0.5) * strength;
            
            // Aplica a transformação. O texto se move na direção OPOSTA
            // do mouse para criar o efeito de profundidade.
            text404.style.transform = `translateX(${-moveX}px) translateY(${-moveY}px)`;
            
            // Nota: A animação 'float' no CSS é sobrescrita por este style.
            // Para combinar os dois, precisaríamos de uma lógica mais complexa.
            // Por enquanto, o parallax é mais interativo e "legal".
            // Para re-adicionar a flutuação, podemos adicionar
            // a animação 'float' ao 'transform' aqui, mas vamos manter simples.
        });

    </script>
</body>
</html>