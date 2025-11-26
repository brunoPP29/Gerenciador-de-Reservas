<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Registro de Usuário - Celestial Dark</title>

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
    </style>
</head>
<body class="bg-gray-900 text-gray-100 min-h-screen flex items-center justify-center p-4">
    <div class="w-full max-w-md bg-gray-800 rounded-xl shadow-2xl p-8 space-y-6 border border-gray-700 fade-in-up">
        
        <header class="flex items-center justify-center relative">
            <!-- Botão Voltar (adaptado para um link) -->
            <a href="." class="absolute left-0 text-gray-400 hover:text-sky-400 transition duration-200">
                 <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
            </a>
            <h1 class="text-3xl font-extrabold text-center text-sky-400 tracking-tight">
                Cadastrar-se
            </h1>
        </header>

        {{-- Success Message Block --}}
        @if(session('success'))
            <div class="bg-emerald-900/50 border border-emerald-700 text-emerald-300 p-4 rounded-lg text-base font-medium space-y-3">
                <p>{{ session('success') }}</p>
                <a href="." class="inline-block px-4 py-2 bg-sky-600 hover:bg-sky-700 text-white font-semibold rounded-lg transition duration-300 ease-in-out">
                    Fazer Login
                </a>
            </div>
        @endif

        <form method="POST" class="space-y-4">
            @csrf

            {{-- User Input (Nome/Apelido) --}}
            <div>
                <label for="user" class="sr-only">Nome de Usuário</label>
                <input placeholder="Nome de Usuário..." id="user" type="text" name="user" value="{{ old('user', '') }}" required
                       class="w-full px-4 py-3 bg-gray-700 border border-gray-600 rounded-lg focus:ring-sky-500 focus:border-sky-500 placeholder-gray-400 text-gray-100 transition duration-200 ease-in-out">
                @error('user')
                    <p class="mt-1 text-sm text-red-400">{{ $message }}</p> 
                @enderror
            </div>

            {{-- Email Input --}}
            <div>
                <label for="email" class="sr-only">Email</label>
                <input placeholder="E-mail..." id="email" type="email" name="email" value="{{ old('email', '') }}" required
                       class="w-full px-4 py-3 bg-gray-700 border border-gray-600 rounded-lg focus:ring-sky-500 focus:border-sky-500 placeholder-gray-400 text-gray-100 transition duration-200 ease-in-out">
                @error('email')
                    <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
                @enderror
            </div>

            {{-- Password Input with Toggle --}}
            <div class="relative">
                <label for="password" class="sr-only">Senha</label>
                <input placeholder="Senha..." id="password" type="password" name="password" required
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
            @error('password')
                <p class="mt-1 text-sm text-red-400">{{ $message }}</p>
            @enderror

            {{-- Submit Button --}}
            <button type="submit"
                    class="w-full py-3 bg-sky-600 hover:bg-sky-700 text-white font-semibold rounded-lg shadow-lg shadow-sky-500/30 transition duration-300 ease-in-out cursor-pointer transform hover:scale-[1.01]">
                Cadastrar
            </button>
        </form>
    </div>

    <script>
        // Lógica para alternar a visibilidade da senha
        const passwordInput = document.getElementById('password');
        const toggleButton = document.getElementById('togglePassword');
        const eyeOn = document.getElementById('eye-icon');
        const eyeOff = document.getElementById('eye-off-icon');

        if (toggleButton && passwordInput) {
            toggleButton.addEventListener('click', function (e) {
                e.preventDefault(); // Previne o envio do formulário, pois é um botão dentro do form
                
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
        }
    </script>
</body>
</html>