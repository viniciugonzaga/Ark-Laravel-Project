<x-app-layout>
    {{-- Fundo apagado --}}
    <div class="fixed inset-0 -z-10">
        <img src="{{ asset('images/fundo_index.png') }}" alt="Background" class="w-full h-full object-cover opacity-20">
        <div class="absolute inset-0 bg-black/70"></div>
    </div>

    <div class="relative py-12 px-6 max-w-7xl mx-auto">
        {{-- Título com efeito Ark --}}
        <div class="flex justify-center mb-12">
            <x-ark-title title="Suas Fichas" />
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-8">
            {{-- BOTÃO NOVO --}}
            <a href="{{ route('fichas.create') }}" 
               class="ark-card group h-[380px] flex flex-col items-center justify-center border-dashed !border-2 !border-cyan-500/30 hover:!border-cyan-400 transition-all duration-500 hover:shadow-[0_0_30px_rgba(0,242,255,0.3)]">
                <span class="text-6xl text-cyan-400 group-hover:scale-125 group-hover:rotate-90 transition-all duration-500">+</span>
                <span class="mt-6 font-display font-black text-xs tracking-[0.3em] text-cyan-300/80 group-hover:text-cyan-200 transition-colors">INJETAR NOVO DNA</span>
            </a>

            @foreach($characters as $char)
                <div class="ark-card group h-[380px] p-0 flex flex-col animate-fadeInUp" style="animation-delay: {{ $loop->index * 0.05 }}s">
                    {{-- BADGE CLASSE --}}
                    <div class="absolute top-0 left-0 z-10 bg-gradient-to-r from-cyan-600 to-blue-600 px-4 py-1.5 text-[10px] font-black uppercase shadow-lg">
                        {{ $char->class_sub }}
                    </div>

                    {{-- BOTÕES DE AÇÃO --}}
                    <div class="absolute top-2 right-2 flex gap-2 z-20 opacity-0 group-hover:opacity-100 transition-opacity duration-300">
                        <a href="{{ route('fichas.edit', $char->id) }}" 
                           class="bg-amber-600/90 hover:bg-amber-500 p-2 rounded-md text-white shadow-[0_0_10px_rgba(245,158,11,0.3)] transition-all hover:scale-110"
                           title="Editar">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/></svg>
                        </a>
                        <form action="{{ route('fichas.destroy', $char->id) }}" method="POST" 
                              onsubmit="return confirm('Deseja deletar permanentemente este registro de DNA?')">
                            @csrf @method('DELETE')
                            <button class="bg-red-600/90 hover:bg-red-500 p-2 rounded-md text-white shadow-[0_0_10px_rgba(239,68,68,0.3)] transition-all hover:scale-110"
                                    title="Deletar">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                            </button>
                        </form>
                    </div>
                    
                    <a href="{{ route('fichas.show', $char->id) }}" class="flex flex-col h-full">
                        {{-- Imagem com efeito --}}
                        <div class="h-56 overflow-hidden rounded-t-lg bg-black/50 border-b border-cyan-500/20">
                            <img src="{{ asset('storage/' . $char->image) }}" 
                                 class="w-full h-full object-cover opacity-80 group-hover:opacity-100 group-hover:scale-110 transition-all duration-700 filter grayscale group-hover:grayscale-0">
                        </div>
                        
                        <div class="p-4 flex-1 flex flex-col">
                            <h3 class="text-xl font-display font-black uppercase text-white truncate border-b border-cyan-500/30 pb-2 group-hover:text-cyan-200 transition-colors">
                                {{ $char->name }}
                            </h3>
                            <div class="flex justify-between mt-3 text-[10px] font-bold">
                                <span class="text-cyan-400">ID: #{{ str_pad($char->id, 4, '0', STR_PAD_LEFT) }}</span>
                                <span class="text-gray-400 uppercase tracking-wider">LVL {{ $char->level }}</span>
                            </div>
                            <div class="mt-auto pt-4">
                                <div class="bg-cyan-500/10 text-center py-2 text-[10px] font-black text-cyan-300 border border-cyan-500/30 group-hover:bg-cyan-500 group-hover:text-black transition-all duration-300 uppercase tracking-widest">
                                    Acessar Registro
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
    </div>

    <style>
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-fadeInUp {
            animation: fadeInUp 0.6s ease forwards;
            opacity: 0;
        }
    </style>
</x-app-layout>