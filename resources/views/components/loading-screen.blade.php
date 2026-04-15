{{-- resources/views/components/loading-screen.blade.php --}}
<div id="global-loader" class="fixed inset-0 z-[10000] bg-black flex flex-col items-center justify-center transition-opacity duration-700" style="background-image: radial-gradient(circle at center, #0a1a1a 0%, #000000 100%);">
    <div class="relative">
        {{-- Logo do Ark (substitua pelo seu componente ou SVG) --}}
        <div class="w-32 h-32 relative">
            <x-application-logo class="w-full h-full text-cyan-400 filter drop-shadow-[0_0_15px_rgba(0,242,255,0.5)]" style="filter: brightness(0) invert(1);" />
            
            {{-- Efeito scanner sobre o logo --}}
            <div class="absolute inset-0 overflow-hidden rounded-md pointer-events-none">
                <div class="absolute inset-0 bg-gradient-to-t from-transparent via-cyan-300/30 to-transparent animate-scanner-wave"></div>
            </div>
        </div>
        
        {{-- Anel giratório externo --}}
        <div class="absolute -inset-4 border border-cyan-500/20 rounded-full"></div>
        <div class="absolute -inset-8 border border-cyan-500/10 rounded-full animate-pulse"></div>
    </div>
    
    {{-- Texto de status --}}
    <div class="mt-8 flex items-center gap-2">
        <span class="flex h-2 w-2 relative">
            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-cyan-400 opacity-75"></span>
            <span class="relative inline-flex rounded-full h-2 w-2 bg-cyan-500"></span>
        </span>
        <p class="text-xs text-cyan-300 tracking-[0.3em] uppercase font-medium">Sincronizando Rede Neural</p>
    </div>
    
    {{-- Barra de progresso indeterminada --}}
    <div class="mt-4 w-48 h-0.5 bg-gray-800 rounded-full overflow-hidden">
        <div class="h-full bg-gradient-to-r from-cyan-400 to-blue-500 w-1/2 animate-loading-bar"></div>
    </div>
</div>

<script>
    window.addEventListener('load', () => {
        const loader = document.getElementById('global-loader');
        if (loader) {
            loader.style.opacity = '0';
            setTimeout(() => {
                loader.style.display = 'none';
            }, 700);
        }
    });
</script>

<style>
    @keyframes loading-bar {
        0% { transform: translateX(-100%); }
        100% { transform: translateX(200%); }
    }
    .animate-loading-bar {
        animation: loading-bar 1.5s ease-in-out infinite;
    }
    @keyframes scanner-wave {
        0%, 90%, 100% { transform: translateY(100%); }
        95% { transform: translateY(-100%); }
    }
    .animate-scanner-wave {
        animation: scanner-wave 10s ease-in-out infinite;
    }
</style>