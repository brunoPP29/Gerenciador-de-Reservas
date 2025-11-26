@php
// Código Laravel Blade aprimorado para rodar com Tailwind CDN.
// O @vite original foi removido e substituído pelo CDN.
@endphp
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Enterprise Login - Celestial Dark</title>
    
    <!-- Tailwind CSS CDN para garantir o estilo no ambiente de visualização -->
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        /* Animação de entrada (mantida) */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .fade-in-up {
            animation: fadeIn 0.6s ease-out forwards;
        }
    </style>
</head>
<body class="bg-gray-900 text-gray-100 min-h-screen flex items-center justify-center p-4">
    <div class="w-full max-w-md bg-gray-800 rounded-xl shadow-2xl p-8 space-y-6 border border-gray-700 fade-in-up">
        <h1 class="text-3xl font-extrabold text-center text-sky-400 tracking-tight">
            Login da Empresa
        </h1>
        
        {{-- Mensagem de Erro da Sessão --}}
        @if(session('error'))
            <div class="bg-red-900/50 border border-red-700 text-red-300 p-3 rounded-lg text-sm font-medium">
                {{ session('error') }}
            </div>
        @endif

        <form method="post" class="space-y-4">
            @csrf 
            
            {{-- Email Input --}}
            <div>
                <label for="email" class="sr-only">Email</label>
                <input placeholder="E-mail da Empresa..." id="email" type="text" name="email" required
                       class="w-full px-4 py-3 bg-gray-700 border border-gray-600 rounded-lg focus:ring-sky-500 focus:border-sky-500 placeholder-gray-400 text-gray-100 transition duration-200 ease-in-out">
            </div>

            {{-- Password Input (Aprimorado com Toggle) --}}
            <div class="relative">
                <label for="password" class="sr-only">Password</label>
                <input type="password" id="password" placeholder="Senha..." name="password" required
                       class="w-full px-4 py-3 bg-gray-700 border border-gray-600 rounded-lg focus:ring-sky-500 focus:border-sky-500 placeholder-gray-400 text-gray-100 pr-12 transition duration-200 ease-in-out">
                
                <button type="button" id="togglePassword" class="absolute inset-y-0 right-0 flex items-center px-4 text-gray-400 hover:text-sky-400 transition duration-200">
                    <!-- Ícone do olho fechado (inicial) -->
                    <svg id="eye-off-icon" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.696-2.54A6.992 6.992 0 0012 3c-4.478 0-8.268 2.943-9.543 7a10.025 10.025 0 004.155 4.888L14.47 11.23a6.994 6.994 0 00-3.518-1.581l2.576-2.577z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21L3 3" />
                    </svg>
                    <!-- Ícone do olho aberto (será manipulado pelo JS) -->
                    <svg id="eye-icon" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.478 0-8.268-2.943-9.542-7z" />
                    </svg>
                </button>
            </div>

            {{-- Submit Button --}}
            <input type="submit" value="Fazer Login"
                   class="w-full py-3 bg-sky-600 hover:bg-sky-700 text-white font-semibold rounded-lg shadow-lg shadow-sky-500/30 transition duration-300 ease-in-out cursor-pointer transform hover:scale-[1.01]">
        </form>

        {{-- Links --}}
        <div class="text-center pt-2 text-sm space-y-1">
            <p>
                <a href="registerEnterprise" class="font-medium text-sky-400 hover:text-sky-300 transition duration-200">
                    Registrar nova empresa
                </a>
            </p>
            <p class="text-gray-500">ou</p>
            <p>
                <a href="." class="font-medium text-sky-400 hover:text-sky-300 transition duration-200">
                    Fazer login como Cliente
                </a>
            </p>
        </div>
    </div>

    <script>
        // Lógica para alternar a visibilidade da senha
        const passwordInput = document.getElementById('password');
        const toggleButton = document.getElementById('togglePassword');
        const eyeOn = document.getElementById('eye-icon');
        const eyeOff = document.getElementById('eye-off-icon');

        toggleButton.addEventListener('click', function () {
            // Alterna o tipo de input
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);

            // Alterna os ícones
            if (type === 'text') {
                eyeOff.classList.add('hidden');
                eyeOn.classList.remove('hidden');
            } else {
                eyeOff.classList.remove('hidden');
                eyeOn.classList.add('hidden');
            }
        });
    </script>
</body>
</html>