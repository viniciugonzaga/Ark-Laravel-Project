<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', config('app.name', 'ARK RPG'))</title>
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}?v=2">
    
    {{-- Fontes já importadas no app.css via @import --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    {{-- Stack para estilos adicionais de páginas específicas --}}
    @stack('styles')
</head>
<body class="font-sans antialiased">

    {{-- Tela de Carregamento (componente) --}}
    <x-loading-screen />

    <div class="min-h-screen flex flex-col">
        
        {{-- Navegação --}}
        @include('layouts.navigation')

        {{-- Cabeçalho da Página (se existir $header) --}}
        @isset($header)
            <header class="ark-header shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    <h2 class="font-semibold text-xl leading-tight">
                        {{ $header }}
                    </h2>
                </div>
            </header>
        @endisset

        {{-- Conteúdo Principal --}}
        <main class="flex-grow flex flex-col">
            {{ $slot }}
        </main>

        {{-- Rodapé Padrão --}}
        <footer class="ark-footer">
            <div class="max-w-7xl mx-auto px-4 text-center">
                <div class="flex justify-center gap-6 mb-4 opacity-50">
                    <span class="text-[9px] tracking-[0.3em] uppercase text-cyan-400">Terminal: Ativo</span>
                    <span class="text-[9px] tracking-[0.3em] uppercase text-gray-500">
                        Local: {{ request()->path() == '/' ? 'Início' : ucfirst(str_replace('-', ' ', request()->path())) }}
                    </span>
                </div>
                <p class="text-gray-500 text-[10px] uppercase tracking-widest">
                    &copy; {{ date('Y') }} ARK RPG - Projeto Fan-Made. Sistema Neural v1.0
                </p>
            </div>
        </footer>
    </div>

    {{-- Overlay de Animação de Dado (já existente) --}}
    <div id="animacaoDado" class="ark-panel" style="display: none; position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%); z-index: 9999; padding: 2rem 3rem; text-align: center;">
        <div class="text-4xl mb-2 text-cyan-300" id="dadoResultado"></div>
        <div class="tracking-[0.2em] uppercase text-cyan-200">Sincronizando Dados...</div>
    </div>
    
    <audio id="somDado" src="/sons/dado.mp3" preload="auto"></audio>

    {{-- Scripts adicionais --}}
    @stack('scripts')
</body>
</html>