<x-app-layout>
    <div class="min-h-[80vh] flex flex-col items-center justify-center text-center p-6">
        {{-- Container com efeito glitch sutil --}}
        <div class="relative">
            <div class="absolute -inset-1 bg-gradient-to-r from-cyan-500/20 to-blue-500/20 rounded-lg blur-xl"></div>
            <div class="relative ark-panel !p-12 !border-red-500/30">
                {{-- Código 404 com efeito --}}
                <h1 class="text-9xl font-black font-display text-transparent bg-clip-text bg-gradient-to-b from-red-400 to-red-600 mb-4 drop-shadow-[0_0_20px_rgba(239,68,68,0.5)]">
                    404
                </h1>
                
                {{-- Ícone de sinal perdido --}}
                <div class="flex justify-center mb-4">
                    <svg class="w-12 h-12 text-red-400/70" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8.111 16.404a5.5 5.5 0 017.778 0M12 20h.01M6.5 12.5a9 9 0 0111 0M3 8a13 13 0 0118 0" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 6L6 18" class="text-red-500" />
                    </svg>
                </div>
                
                <h2 class="text-2xl font-display text-white uppercase tracking-widest mb-3">Sinal Interrompido</h2>
                <p class="text-gray-400 max-w-md mb-8 text-sm">
                    A coordenada que você tentou acessar não existe no mapa ou foi removida pelo administrador do sistema.
                </p>
                
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="{{ route('home') }}" class="ark-btn !bg-red-950/30 !border-red-500/50 hover:!bg-red-900/40 !text-red-300">
                        <span class="flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                            Ponto de Extração
                        </span>
                    </a>
                    <button onclick="history.back()" class="ark-btn !bg-gray-900/50 !border-gray-600/50 hover:!bg-gray-800 !text-gray-300">
                        <span class="flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                            Voltar
                        </span>
                    </button>
                </div>
            </div>
        </div>
        
        {{-- Código de erro pequeno --}}
        <p class="mt-6 text-[10px] text-gray-600 tracking-widest">ERRO: 0x00000404 // NEXUS_DESCONECTADO</p>
    </div>
</x-app-layout>