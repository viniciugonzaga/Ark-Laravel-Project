<footer class="relative bg-gradient-to-b from-black to-gray-950 border-t border-cyan-500/40 py-8 mt-auto overflow-hidden">
    {{-- Linha scanner superior mais visível --}}
    <div class="absolute top-0 left-0 w-full h-[1px] bg-gradient-to-r from-transparent via-cyan-400 to-transparent opacity-80"></div>
    
    {{-- Efeito de grid sutil no fundo --}}
    <div class="absolute inset-0 bg-[url('data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSI0MCIgaGVpZ2h0PSI0MCIgdmlld0JveD0iMCAwIDQwIDQwIj48cGF0aCBkPSJNMCAwaDQwdjQwSDB6IiBmaWxsPSJub25lIi8+PHBhdGggZD0iTTAgMGg0MHY0MEgweiIgZmlsbD0ibm9uZSIgc3Ryb2tlPSIjMDBmMmZmIiBzdHJva2Utd2lkdGg9IjAuNSIgb3BhY2l0eT0iMC4wNSIvPjwvc3ZnPg==')] opacity-20 pointer-events-none"></div>

    <div class="max-w-7xl mx-auto px-4 text-center relative z-10">
        {{-- Linha de status com cores vibrantes --}}
        <div class="flex justify-center gap-8 mb-6">
            <div class="flex items-center gap-2 text-cyan-300 text-[11px] font-black uppercase tracking-[0.3em] drop-shadow-[0_0_5px_rgba(34,211,238,0.4)]">
                <span class="w-2 h-2 rounded-full bg-cyan-400 shadow-[0_0_10px_#00f2ff] animate-pulse"></span>
                <span>ARK SURVIVAL</span>
            </div>
            <div class="flex items-center gap-2 text-emerald-300 text-[11px] font-black uppercase tracking-[0.3em] drop-shadow-[0_0_5px_rgba(52,211,153,0.4)]">
                <span class="w-2 h-2 rounded-full bg-emerald-400 shadow-[0_0_10px_#4ade80]"></span>
                <span>STATUS: ATIVO</span>
            </div>
            <div class="flex items-center gap-2 text-cyan-200 text-[11px] font-black uppercase tracking-[0.3em]">
                <span class="w-2 h-2 rounded-full bg-cyan-300 shadow-[0_0_8px_rgba(165,243,252,0.5)]"></span>
                <span>VERSÃO: 2.6.7</span>
            </div>
        </div>

        {{-- Copyright com cores sólidas e legíveis --}}
        <p class="text-[10px] uppercase tracking-[0.4em] font-black">
            <span class="text-gray-200">&copy; {{ date('Y') }} ARK RPG</span>
            <span class="mx-3 text-cyan-500">//</span>
            <span class="text-transparent bg-clip-text bg-gradient-to-r from-cyan-300 via-blue-400 to-cyan-300 drop-shadow-[0_0_8px_rgba(0,242,255,0.3)]">
                TODOS OS DIREITOS RESERVADOS AOS SOBREVIVENTES
            </span>
        </p>
        
        {{-- Assinatura técnica --}}
        <div class="mt-4 text-[9px] text-gray-400 tracking-[0.5em] font-bold">
            <span class="hover:text-cyan-300 transition-colors duration-300 cursor-default border-x border-cyan-500/20 px-4 py-1 bg-cyan-950/20">
                SISTEMA NEURAL ARK v1.0
            </span>
        </div>
    </div>
</footer>