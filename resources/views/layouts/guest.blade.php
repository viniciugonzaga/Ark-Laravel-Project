<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'ARK RPG') }} - @yield('title', 'Acesso')</title>
    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>
<body class="font-sans antialiased bg-black text-gray-200" style="background-image: radial-gradient(circle at 20% 30%, #0a1a1a 0%, #030808 100%);">
    <div class="min-h-screen flex flex-col">
        {{-- Header simplificado para visitantes --}}
        <header class="py-6 px-4 border-b border-cyan-500/20 bg-black/40 backdrop-blur-sm">
            <div class="max-w-7xl mx-auto flex justify-between items-center">
                <a href="{{ route('home') }}" class="flex items-center gap-2 group">
                    <div class="w-10 h-10 relative">
                        <x-application-logo class="w-full h-full filter brightness-0 invert" />
                    </div>
                    <span class="text-xl font-display font-bold tracking-wider text-transparent bg-clip-text bg-gradient-to-r from-cyan-300 to-blue-300">ARK</span>
                </a>
                <div class="text-xs text-gray-500 uppercase tracking-widest">
                    <span class="text-cyan-400/70">SISTEMA DE ACESSO</span>
                </div>
            </div>
        </header>

        {{-- Conteúdo principal --}}
        <main class="flex-grow flex items-center justify-center p-6">
            <div class="w-full max-w-md">
                {{ $slot }}
            </div>
        </main>

        {{-- Footer simplificado --}}
        <footer class="py-4 text-center border-t border-cyan-500/10 bg-black/30">
            <p class="text-[10px] text-gray-500 tracking-widest">
                &copy; {{ date('Y') }} ARK RPG - Terminal de Acesso
            </p>
        </footer>
    </div>
    @stack('scripts')
</body>
</html>