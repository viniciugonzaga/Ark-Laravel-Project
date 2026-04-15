<x-app-layout>
    @auth
        {{-- CONTEÚDO PARA QUEM ESTÁ LOGADO (Dashboard/Painel) --}}
        <x-slot name="header">Terminal de Comando ARK</x-slot>
        
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="ark-panel !p-8 !bg-black/80 border border-cyan-500/20 shadow-2xl">
                    <h2 class="text-2xl font-medieval text-cyan-400">Bem-vindo de volta, {{ Auth::user()->name }}</h2>
                    <p class="text-gray-400 mt-2">O sistema está operacional. Selecione uma função no menu superior.</p>
                    
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-8">
                        {{-- Atalhos rápidos para o jogador logado --}}
                        <a href="{{ route('fichas.index') }}" class="ark-panel !p-4 border-cyan-500/10 hover:border-cyan-400 transition text-center">
                            <span class="text-cyan-300 font-medieval">Minhas Fichas</span>
                        </a>
                        <a href="{{ route('perfil') }}" class="ark-panel !p-4 border-cyan-500/10 hover:border-cyan-400 transition text-center">
                            <span class="text-cyan-300 font-medieval">Dados do Sobrevivente</span>
                        </a>
                        <a href="{{ route('rolagens') }}" class="ark-panel !p-4 border-cyan-500/10 hover:border-cyan-400 transition text-center">
                            <span class="text-cyan-300 font-medieval">Centro de Dados (Dados)</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    @else
        {{-- CONTEÚDO DA LANDING PAGE (O front azul medieval que fizemos) --}}
        {{-- Todo aquele código com o carrossel e o botão de cadastro entra aqui --}}
        <div class="relative min-h-screen flex items-center">
             </div>
    @endauth
</x-app-layout>