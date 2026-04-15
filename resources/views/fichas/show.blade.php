<x-app-layout>
    {{-- Fundo apagado --}}
    <div class="fixed inset-0 -z-10">
        <img src="{{ asset('images/fundo_show.png') }}" alt="Background" class="w-full h-full object-cover opacity-20">
        <div class="absolute inset-0 bg-black/70"></div>
    </div>

    {{-- ÁREA DE CAPTURA: Tudo dentro desta ID será renderizado no PDF --}}
    <div id="capture-area" class="relative py-12 px-6 max-w-7xl mx-auto mb-20 min-h-screen">
        
        {{-- BARRA DE NAVEGAÇÃO SUPERIOR (Escondida no PDF/Impressão) --}}
        <div class="flex justify-between items-center mb-10 animate-fadeInUp no-print">
            <a href="{{ route('fichas.index') }}" 
               class="text-cyan-400 font-display font-black text-sm hover:text-cyan-200 transition flex items-center gap-3 group">
                <span class="text-xl group-hover:-translate-x-2 transition-transform">◀</span> 
                <span class="tracking-widest">VOLTAR AO TERMINAL</span>
            </a>
            <div class="flex gap-4">
                <a href="{{ route('fichas.edit', $ficha->id) }}" 
                   class="bg-amber-600/90 hover:bg-amber-500 px-6 py-2.5 text-sm font-black text-white transition-all rounded-md shadow-[0_0_15px_rgba(245,158,11,0.3)]">
                    EDITAR DADOS
                </a>
                <button onclick="gerarPDF(this)" 
                        class="bg-cyan-600/90 hover:bg-cyan-500 px-6 py-2.5 text-sm font-black text-white transition-all rounded-md shadow-[0_0_15px_rgba(0,242,255,0.3)] flex items-center gap-2">
                    <span id="btn-text">GERAR PDF</span>
                </button>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            {{-- COLUNA ESQUERDA: FOTO E STATUS --}}
            <div class="space-y-6 animate-fadeInUp" style="animation-delay: 0.1s">
                {{-- Imagem principal --}}
                <div class="bg-zinc-900 p-2 shadow-2xl relative overflow-hidden rounded-xl group border border-white/5">
                    @if($ficha->image)
                        <img src="{{ asset('storage/' . $ficha->image) }}" 
                             crossorigin="anonymous"
                             class="w-full grayscale group-hover:grayscale-0 transition-all duration-1000 group-hover:scale-105">
                    @else
                        <div class="w-full aspect-square bg-zinc-800 flex items-center justify-center">
                            <span class="text-zinc-600 font-black tracking-tighter uppercase">Sem Registro Visual</span>
                        </div>
                    @endif
                    <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-transparent to-transparent"></div>
                    <div class="absolute bottom-4 left-4 right-4 bg-black/70 backdrop-blur-sm p-4 rounded-lg border border-cyan-500/30">
                        <span class="text-[10px] block text-cyan-400 uppercase tracking-widest">SINCRONIA</span>
                        <span class="text-xl font-display font-black text-white uppercase tracking-tighter">Bio-Estável</span>
                    </div>
                </div>

                {{-- STATUS VITAIS --}}
                <div class="bg-zinc-900/50 p-6 rounded-xl border border-white/5">
                    <h3 class="text-sm font-display font-black mb-6 text-cyan-300 uppercase tracking-widest border-b border-cyan-500/30 pb-3 italic">
                        Indicadores Vitais
                    </h3>
                    <div class="grid grid-cols-1 gap-5">
                        @php
                            $stats = [
                                'vida' => ['color' => 'text-emerald-400', 'label' => 'Pontos de Vida'],
                                'armadura' => ['color' => 'text-gray-300', 'label' => 'Blindagem'],
                                'determinacao' => ['color' => 'text-purple-400', 'label' => 'Determinação'],
                                'folego' => ['color' => 'text-cyan-300', 'label' => 'Fôlego'],
                                'resistencia' => ['color' => 'text-amber-400', 'label' => 'Resistência']
                            ];
                        @endphp
                        @foreach($stats as $key => $data)
                            <div class="flex justify-between items-end border-b border-white/5 pb-2">
                                <span class="text-xs font-black uppercase tracking-wider text-gray-400">{{ $data['label'] }}</span>
                                <span class="{{ $data['color'] }} font-display font-black text-3xl">{{ $ficha->$key ?? 0 }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>

                {{-- ATRIBUTOS --}}
                <div class="bg-zinc-900/50 p-6 rounded-xl border border-white/5">
                    <h3 class="text-sm font-display font-black mb-6 text-white uppercase tracking-widest border-b border-cyan-500/30 pb-3 italic">
                        Matriz de Atributos
                    </h3>
                    <div class="grid grid-cols-5 gap-3">
                        @foreach(['agi','for','int','set','vig'] as $at)
                            <div class="text-center bg-black/50 p-3 rounded-lg border border-cyan-500/20">
                                <div class="text-[10px] text-cyan-400/70 uppercase font-bold mb-1">{{ strtoupper($at) }}</div>
                                <div class="text-2xl font-display font-black text-white">{{ $ficha->$at ?? 0 }}</div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- COLUNA DIREITA: INFO DETALHADA --}}
            <div class="lg:col-span-2 space-y-6 animate-fadeInUp" style="animation-delay: 0.2s">
                {{-- Nome e Lore --}}
                <div class="bg-zinc-900/50 p-8 rounded-xl border border-white/5 relative overflow-hidden">
                    <div class="absolute top-0 right-0 p-6 opacity-5 text-8xl font-display font-black uppercase italic">
                        {{ $ficha->class_main }}
                    </div>
                    
                    <div class="flex flex-col md:flex-row justify-between items-start mb-8 relative gap-6">
                        <div>
                            <h1 class="text-6xl font-display font-black text-white leading-none uppercase tracking-tighter">
                                {{ $ficha->name }}
                            </h1>
                            <p class="text-cyan-400 tracking-[0.5em] font-bold uppercase mt-3 text-sm">{{ $ficha->class_sub }}</p>
                            <p class="text-xs text-gray-400 mt-2 uppercase tracking-wider">
                                Origem: {{ $ficha->class_main }} | Idade: {{ $ficha->age ?? '??' }} anos
                            </p>
                        </div>
                        <div class="text-right border-l border-cyan-500/50 pl-8 min-w-[120px]">
                            <span class="text-xs text-cyan-400/70 block font-bold uppercase tracking-wider">NÍVEL</span>
                            <span class="text-7xl font-display font-black text-white">{{ $ficha->level }}</span>
                        </div>
                    </div>

                    <div class="bg-black/40 p-6 rounded-lg border-l-4 border-cyan-400 italic text-gray-300 leading-relaxed text-sm">
                        {{ $ficha->lore ?: 'Nenhum registro de lore encontrado no banco de dados.' }}
                    </div>
                </div>

                {{-- Mutações e Bônus --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="bg-zinc-900/50 p-6 rounded-xl border border-white/5 border-t-4 border-orange-500">
                        <h3 class="text-orange-400 font-display font-black mb-5 uppercase tracking-wider text-lg">Mutações</h3>
                        @forelse($ficha->mutations ?? [] as $m)
                            <div class="mb-5 bg-white/5 p-4 rounded-lg border border-orange-500/20">
                                <div class="text-[10px] text-orange-400 font-bold uppercase tracking-wider">{{ $m->origin }}</div>
                                <div class="font-display font-bold text-white uppercase text-base mt-1">{{ $m->name }}</div>
                                <p class="text-xs text-gray-400 mt-2 leading-relaxed">{{ $m->description }}</p>
                            </div>
                        @empty
                            <p class="text-gray-500 italic text-sm text-center py-4">Nenhuma mutação registrada.</p>
                        @endforelse
                    </div>

                    <div class="bg-zinc-900/50 p-6 rounded-xl border border-white/5 border-t-4 border-emerald-500">
                        <h3 class="text-emerald-400 font-display font-black mb-5 uppercase tracking-wider text-lg">Bônus</h3>
                        <div class="space-y-3">
                            @forelse($ficha->bonuses ?? [] as $b)
                                <div class="flex justify-between items-center bg-black/40 p-4 rounded-lg border border-emerald-500/20">
                                    <span class="text-sm uppercase font-bold text-gray-200">{{ $b->name }}</span>
                                    <span class="text-emerald-400 font-display font-black text-xl">+{{ $b->value }}</span>
                                </div>
                            @empty
                                <p class="text-gray-500 italic text-sm text-center py-4">Nenhum bônus neural detectado.</p>
                            @endforelse
                        </div>
                    </div>
                </div>

                {{-- Poderes e Rituais --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="bg-zinc-900/50 p-6 rounded-xl border border-white/5 border-t-4 border-cyan-400">
                        <h3 class="text-cyan-400 font-display font-black mb-5 uppercase tracking-wider text-lg">Poderes de Sobrevivente</h3>
                        @forelse($ficha->survivorPowers ?? [] as $p)
                            <div class="mb-5 bg-white/5 p-4 rounded-lg">
                                <span class="font-display font-bold text-white uppercase text-base tracking-wide">{{ $p->name }}</span>
                                <p class="text-xs text-gray-400 mt-2 leading-relaxed">{{ $p->description }}</p>
                            </div>
                        @empty
                            <p class="text-gray-500 italic text-sm text-center py-4">Sem poderes registrados.</p>
                        @endforelse
                    </div>

                    <div class="bg-zinc-900/50 p-6 rounded-xl border border-white/5 border-t-4 border-red-500">
                        <h3 class="text-red-400 font-display font-black mb-5 uppercase tracking-wider text-lg">Rituais</h3>
                        @forelse($ficha->rituals ?? [] as $r)
                            <div class="mb-5 bg-white/5 p-4 rounded-lg">
                                <span class="text-[8px] bg-red-900/60 text-red-200 px-2 py-0.5 rounded uppercase font-black tracking-wider">{{ $r->type ?? 'Protocolo' }}</span>
                                <span class="font-display font-bold text-white uppercase text-base ml-2">{{ $r->name }}</span>
                                <p class="text-xs text-gray-400 mt-2 leading-relaxed">{{ $r->description }}</p>
                            </div>
                        @empty
                            <p class="text-gray-500 italic text-sm text-center py-4">Sem rituais manifestados.</p>
                        @endforelse
                    </div>
                </div>

                {{-- Arsenal --}}
                <div class="bg-zinc-900/50 p-6 rounded-xl border border-white/5">
                    <h3 class="text-sm font-display font-black mb-4 text-gray-300 uppercase tracking-widest border-b border-white/10 pb-3">Carga & Equipamento</h3>
                    <div class="font-mono text-sm text-cyan-300 bg-black/40 p-5 rounded-lg border border-cyan-500/20 whitespace-pre-wrap break-words text-left uppercase tracking-wider leading-relaxed shadow-inner">
                        {{ trim($ficha->arsenal) ?: 'NENHUM EQUIPAMENTO REGISTRADO.' }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Botão Voltar ao Topo (Escondido no PDF) --}}
    <div class="fixed bottom-6 right-6 no-print">
        <button onclick="window.scrollTo({top: 0, behavior: 'smooth'})" 
                class="bg-cyan-600 hover:bg-cyan-500 p-4 rounded-full shadow-[0_0_20px_rgba(0,242,255,0.4)] text-white transition-all hover:scale-110">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"/>
            </svg>
        </button>
    </div>

    {{-- ESTILOS --}}
    <style>
        @media print {
            .no-print { display: none !important; }
            body { background: #000 !important; }
        }
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-fadeInUp {
            animation: fadeInUp 0.6s ease forwards;
            opacity: 0;
        }
        /* Efeito de flash para o PDF */
        .pdf-flash {
            animation: flashEffect 0.4s ease-out;
        }
        @keyframes flashEffect {
            0% { filter: brightness(1); }
            50% { filter: brightness(2) contrast(1.2); box-shadow: 0 0 50px rgba(0,242,255,0.8); }
            100% { filter: brightness(1); }
        }
    </style>

    {{-- SCRIPTS DE EXPORTAÇÃO --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>

    <script>
    async function gerarPDF(button) {
        const { jsPDF } = window.jspdf;
        const element = document.getElementById('capture-area');
        const originalText = button.innerHTML;
        
        button.innerHTML = "<span>SINCRONIZANDO...</span>";
        button.disabled = true;

        // 🧬 EFEITO DE CHOQUE DE LUZ (flash) antes da captura
        element.classList.add('pdf-flash');
        
        // Aguarda o flash ser percebido
        await new Promise(resolve => setTimeout(resolve, 200));

        try {
            const options = {
                scale: 2.5,
                useCORS: true,
                allowTaint: false,
                backgroundColor: "#0a0a0a",
                onclone: (clonedDoc) => {
                    const area = clonedDoc.getElementById('capture-area');
                    // Remove animações e no-print
                    area.querySelectorAll('.animate-fadeInUp').forEach(el => {
                        el.style.animation = 'none';
                        el.style.opacity = '1';
                        el.style.transform = 'none';
                    });
                    area.querySelectorAll('.no-print').forEach(el => el.remove());
                    // Garante que imagens tenham contraste
                    area.querySelectorAll('img').forEach(img => {
                        img.style.filter = 'brightness(1.1) contrast(1.1)';
                    });
                }
            };

            const canvas = await html2canvas(element, options);
            const imgData = canvas.toDataURL('image/png', 1.0);
            
            const pdf = new jsPDF({
                orientation: canvas.width > canvas.height ? 'l' : 'p',
                unit: 'px',
                format: [canvas.width, canvas.height]
            });

            pdf.addImage(imgData, 'PNG', 0, 0, canvas.width, canvas.height);
            pdf.save(`FICHA_ARK_{{ strtoupper(str_replace(' ', '_', $ficha->name)) }}.pdf`);
            
            button.innerHTML = "<span>EXPORTADO</span>";
        } catch (error) {
            console.error("Erro na geração do PDF:", error);
            button.innerHTML = "<span>FALHA</span>";
        } finally {
            element.classList.remove('pdf-flash');
            setTimeout(() => {
                button.innerHTML = originalText;
                button.disabled = false;
            }, 2000);
        }
    }
    </script>
</x-app-layout>