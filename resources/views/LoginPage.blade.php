@php
// Esta é uma view Blade aprimorada para o Laravel, mas é totalmente funcional
// como HTML puro, exceto pelos placeholders Laravel como @csrf e {{ url(...) }}.
@endphp
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Acesso de Cliente - Gerenciador de Reservas</title>

    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- 
      MELHORIA: Script para aplicar Dark Mode imediatamente (anti-flash) 
      se a preferência do usuário for escura.
    -->
    <script>
        if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>
</head>

<body class="bg-gray-50 dark:bg-gray-900 min-h-screen flex items-center justify-center p-4">
    
    <!-- Container Principal do Formulário -->
    <div class="w-full max-w-md bg-white dark:bg-gray-800 rounded-2xl shadow-2xl p-8 space-y-8 border border-gray-200 dark:border-gray-700 transform transition duration-500 ease-in-out hover:shadow-sky-500/30">
        
        <div class="text-center">
            <h1 class="text-4xl font-extrabold text-gray-900 dark:text-white tracking-tight mb-2">
                Bem-vindo(a) de Volta!
            </h1>
            <p class="text-gray-500 dark:text-gray-400">
                Acesse sua conta com segurança.
            </p>
        </div>

        {{-- Message Display --}}
        @if($message ?? '')
            <div class="bg-blue-100 dark:bg-blue-900/50 border border-blue-400 dark:border-blue-700 text-blue-700 dark:text-blue-300 p-3 rounded-xl text-sm font-medium text-center transition duration-300">
                {{ $message }}
            </div>
        @endif

        {{-- Error Session Message --}}
        @if(session('error'))
            <div class="bg-red-100 dark:bg-red-900/50 border border-red-400 dark:border-red-700 text-red-700 dark:text-red-300 p-3 rounded-xl text-sm font-medium transition duration-300">
                {{ session('error') }}
            </div>
        @endif

        <form method="post" class="space-y-6">
            @csrf 
            
            {{-- Campo Nome de Usuário --}}
            <div>
                <label for="user" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Nome de Usuário</label>
                <input name="user" id="user" type="text" placeholder="Seu nome de usuário" required
                       class="w-full px-4 py-3 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-4 focus:ring-sky-500/50 focus:border-sky-500 placeholder-gray-500 dark:placeholder-gray-400 text-gray-900 dark:text-gray-100 transition duration-300 ease-in-out shadow-inner dark:shadow-none"
                       value="{{ old('user') }}">
                @error('user')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Campo Senha (COM TOGGLE DE VISIBILIDADE - GRANDE MELHORIA DE UX) --}}
            <div>
                <label for="password" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Senha</label>
                <div class="relative">
                    <input name="password" id="password" type="password" placeholder="Sua senha secreta" required
                           class="w-full px-4 py-3 pr-12 bg-gray-50 dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-lg focus:ring-4 focus:ring-sky-500/50 focus:border-sky-500 placeholder-gray-500 dark:placeholder-gray-400 text-gray-900 dark:text-gray-100 transition duration-300 ease-in-out shadow-inner dark:shadow-none">
                    
                    <!-- Botão de Toggle de Senha -->
                    <button type="button" id="togglePassword" aria-label="Mostrar/Ocultar Senha"
                            class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-400 dark:text-gray-500 hover:text-sky-600 dark:hover:text-sky-400 transition duration-200 focus:outline-none">
                        
                        <!-- Ícone do Olho (Visível por padrão) -->
                        <svg id="icon-eye-closed" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13.875 18.825A10.026 10.026 0 0112 19c-4.97 0-9.28-2.812-11.291-6.878 2.01-4.067 6.32-6.879 11.291-6.879 1.487 0 2.941.353 4.254 1.011m-4.254-1.011l-.398.397M17 12h.01M21 12c-1.972 3.968-6.198 6.878-11.291 6.878-1.54 0-3.044-.39-4.385-1.121m8.68-.001l-.398-.398M21 12h.01M1 12C3.01 7.933 7.32 5.121 12 5.121c4.68 0 8.99 2.812 11.291 6.879M3 12h.01" />
                        </svg>
                        
                        <!-- Ícone do Olho Aberto (Escondido por padrão) -->
                        <svg id="icon-eye-open" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                    </button>
                </div>
                @error('password')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Botão de Envio (MELHORIA SIGNIFICATIVA DE UI/UX) --}}
            <button type="submit"
                   class="w-full py-3 bg-sky-600 hover:bg-sky-700 text-white font-extrabold rounded-xl shadow-lg shadow-sky-500/50 
                          transition-all duration-300 ease-in-out transform hover:scale-[1.01] active:scale-[0.98] 
                          focus:outline-none focus:ring-4 focus:ring-sky-500/50 dark:focus:ring-offset-gray-800 tracking-wide">
                ENTRAR
            </button>
        </form>

        {{-- Links Adicionais --}}
        <div class="text-center pt-4 border-t border-gray-200 dark:border-gray-700 space-y-3">
            <p class="text-sm text-gray-600 dark:text-gray-400">
                Não tem uma conta? 
                <a href="{{ url('register') }}" class="font-semibold text-sky-600 hover:text-sky-500 dark:text-sky-400 dark:hover:text-sky-300 transition duration-200 hover:underline">
                    Cadastre-se aqui
                </a>
            </p>
            <p class="text-sm text-gray-600 dark:text-gray-400">
                Acesso para Empresas? 
                <a href="{{ url('enterprise') }}" class="font-semibold text-indigo-600 hover:text-indigo-500 dark:text-indigo-400 dark:hover:text-indigo-300 transition duration-200 hover:underline">
                    Login Empresarial
                </a>
            </p>
        </div>
    </div>

    <!-- Script para funcionalidade da Senha -->
    <script>
        const passwordInput = document.getElementById('password');
        const toggleButton = document.getElementById('togglePassword');
        const eyeOpen = document.getElementById('icon-eye-open');
        const eyeClosed = document.getElementById('icon-eye-closed');

        if (toggleButton && passwordInput) {
            toggleButton.addEventListener('click', function() {
                const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordInput.setAttribute('type', type);
                
                // Troca dos ícones SVG
                if (type === 'text') {
                    eyeOpen.classList.remove('hidden');
                    eyeClosed.classList.add('hidden');
                } else {
                    eyeOpen.classList.add('hidden');
                    eyeClosed.classList.remove('hidden');
                }
            });
        }
    </script>
</body>
</html>