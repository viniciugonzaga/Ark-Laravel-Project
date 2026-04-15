<x-app-layout>
    {{-- Fundo apagado --}}
    <div class="fixed inset-0 -z-10">
        <img src="{{ asset('images/fundo_edit.png') }}" alt="Background" class="w-full h-full object-cover opacity-20">
        <div class="absolute inset-0 bg-black/70"></div>
    </div>

    <div class="relative py-12 px-6 max-w-7xl mx-auto">
        <form action="{{ route('fichas.update', $ficha->id) }}" method="POST" enctype="multipart/form-data">
            @csrf 
            @method('PUT')

            {{-- CABEÇALHO DE CONTROLE --}}
            <div class="flex justify-between items-end mb-10 border-b border-cyan-500/30 pb-6">
                <div>
                    <h2 class="text-5xl font-display font-black text-white uppercase tracking-tighter italic">Reconfigurar DNA</h2>
                    <p class="text-cyan-400 font-bold uppercase tracking-widest text-xs mt-2">Sincronizando: {{ $ficha->name }}</p>
                </div>
                <div class="flex gap-4">
                    <a href="{{ route('fichas.index') }}" class="ark-panel !py-3 !px-8 text-sm font-black text-gray-400 hover:text-white transition-all border border-white/10">CANCELAR</a>
                    <button type="submit" class="ark-btn !px-12 !py-3 !text-base shadow-[0_0_30px_rgba(0,242,255,0.3)]">SALVAR ALTERAÇÕES</button>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                
                {{-- COLUNA 1: BIOMETRIA E ATRIBUTOS --}}
                <div class="space-y-6">
                    <div class="ark-panel !p-4">
                        <label class="text-[10px] font-black text-cyan-400 block mb-3 uppercase tracking-widest">Biometria (IMG)</label>
                        @if($ficha->image)
                            <img src="{{ asset('storage/' . $ficha->image) }}" class="w-full h-48 object-cover rounded-lg mb-4 border border-cyan-500/30">
                        @endif
                        <input type="file" name="image" class="w-full text-xs text-gray-400">
                    </div>

                    <div class="ark-panel !p-6">
                        <h3 class="text-sm font-black mb-6 text-cyan-400 uppercase text-center border-b border-cyan-500/20 pb-3">Atributos de Base</h3>
                        <div class="grid grid-cols-5 gap-2">
                            @foreach(['agi','for','int','set','vig'] as $at)
                                <div class="text-center">
                                    <label class="text-[10px] font-black text-cyan-400/70 uppercase">{{ $at }}</label>
                                    <input type="number" name="{{ $at }}" value="{{ $ficha->$at }}" class="w-full bg-black/50 border border-cyan-500/40 text-white text-center p-2 rounded font-bold">
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="ark-panel !p-4 grid grid-cols-2 gap-3">
                        <h3 class="col-span-2 text-[10px] font-black text-cyan-400 uppercase tracking-widest">Status Vitais</h3>
                        @foreach(['vida', 'armadura', 'determinacao', 'folego', 'resistencia'] as $stat)
                            <div>
                                <label class="text-[9px] font-black text-gray-500 uppercase">{{ $stat }}</label>
                                <input type="number" name="{{ $stat }}" value="{{ $ficha->$stat }}" class="ark-input w-full !p-2">
                            </div>
                        @endforeach
                    </div>
                </div>

                {{-- COLUNA 2 & 3: IDENTIDADE E LISTAS DINÂMICAS --}}
                <div class="lg:col-span-2 space-y-6">
                    <div class="ark-panel !p-6 grid grid-cols-4 gap-4">
                        <div class="col-span-3">
                            <label class="text-[10px] font-black text-cyan-400 uppercase">Designação do Sobrevivente</label>
                            <input type="text" name="name" value="{{ $ficha->name }}" class="ark-input w-full !text-2xl font-black uppercase">
                        </div>
                        <div>
                            <label class="text-[10px] font-black text-cyan-400 uppercase text-center block">Nível</label>
                            <input type="number" name="level" value="{{ $ficha->level }}" class="ark-input w-full !text-2xl text-center font-black">
                        </div>
                    </div>

                    {{-- MUTAÇÕES --}}
                    <div class="ark-panel !p-6 border-l-4 border-orange-600">
                        <div class="flex justify-between items-center mb-4 border-b border-white/5 pb-2">
                            <h3 class="text-base font-black text-orange-400 uppercase italic">Mutações de DNA</h3>
                            <button type="button" onclick="addField('mutations', 'mutations-container')" class="text-[10px] bg-orange-500/20 px-3 py-1 rounded text-orange-300 font-bold hover:bg-orange-500/40 transition-all border border-orange-500/30">+ ADICIONAR</button>
                        </div>
                        <div id="mutations-container" class="space-y-3">
                            @foreach($ficha->mutations as $i => $m)
                                <div class="grid grid-cols-4 gap-2 bg-black/40 p-3 rounded-lg relative border border-white/5">
                                    <input type="text" name="mutations[{{$i}}][origin]" value="{{ $m->origin }}" class="ark-input text-[10px]" placeholder="ORIGEM">
                                    <input type="text" name="mutations[{{$i}}][name]" value="{{ $m->name }}" class="ark-input col-span-2 font-bold text-orange-400" placeholder="NOME DA MUTAÇÃO">
                                    <textarea name="mutations[{{$i}}][description]" class="ark-input col-span-4 text-xs h-12 italic text-gray-400">{{ $m->description }}</textarea>
                                    <button type="button" onclick="this.parentElement.remove()" class="absolute -right-2 -top-2 bg-red-600 text-white rounded-full w-5 h-5 text-[10px] flex items-center justify-center shadow-lg">✕</button>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    {{-- RITUAIS / PACTOS / CONJURAÇÕES --}}
                    <div class="ark-panel !p-6 border-l-4 border-purple-600">
                        <div class="flex justify-between items-center mb-4 border-b border-white/5 pb-2">
                            <h3 class="text-base font-black text-purple-400 uppercase italic">Conhecimento Arcano / Pactos</h3>
                            <button type="button" onclick="addField('rituals', 'rituals-container')" class="text-[10px] bg-purple-500/20 px-3 py-1 rounded text-purple-300 font-bold hover:bg-purple-500/40 transition-all border border-purple-500/30">+ NOVO REGISTRO</button>
                        </div>
                        <div id="rituals-container" class="space-y-3">
                            @foreach($ficha->rituals as $i => $r)
                                <div class="grid grid-cols-3 gap-2 bg-black/40 p-3 rounded-lg relative border border-white/5">
                                    <select name="rituals[{{$i}}][type]" class="ark-input text-[10px] font-black text-purple-400 bg-black uppercase">
                                        <option value="ritual" {{ $r->type == 'ritual' ? 'selected' : '' }}>RITUAL</option>
                                        <option value="pacto" {{ $r->type == 'pacto' ? 'selected' : '' }}>PACTO</option>
                                        <option value="conjuracao" {{ $r->type == 'conjuracao' ? 'selected' : '' }}>CONJURAÇÃO</option>
                                    </select>
                                    <input type="text" name="rituals[{{$i}}][name]" value="{{ $r->name }}" class="ark-input col-span-2 font-bold uppercase" placeholder="NOME">
                                    <textarea name="rituals[{{$i}}][description]" class="ark-input col-span-2 text-xs h-10 italic text-gray-400">{{ $r->description }}</textarea>
                                    <button type="button" onclick="this.parentElement.remove()" class="absolute -right-2 -top-2 bg-red-600 text-white rounded-full w-5 h-5 text-[10px] flex items-center justify-center shadow-lg">✕</button>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    {{-- BÔNUS E CAPACIDADES --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        {{-- BÔNUS --}}
                        <div class="ark-panel !p-4 border-t-2 border-emerald-500">
                            <div class="flex justify-between items-center mb-3">
                                <h3 class="text-xs font-black text-emerald-400 uppercase tracking-tighter">Bônus Ativos</h3>
                                <button type="button" onclick="addField('bonuses', 'bonuses-container')" class="text-[9px] bg-emerald-500/10 px-2 py-0.5 rounded text-emerald-400 border border-emerald-500/20">+ ADD</button>
                            </div>
                            <div id="bonuses-container" class="grid grid-cols-1 gap-2">
                                @foreach($ficha->bonuses as $i => $b)
                                    <div class="bg-black/40 p-2 rounded relative border border-white/5">
                                        <input type="text" name="bonuses[{{$i}}][name]" value="{{ $b->name }}" class="ark-input w-full text-[10px] font-bold text-emerald-400 mb-1" placeholder="NOME">
                                        <input type="text" name="bonuses[{{$i}}][value]" value="{{ $b->value }}" class="ark-input w-full text-[10px]" placeholder="VALOR (ex: +2)">
                                        <button type="button" onclick="this.parentElement.remove()" class="absolute -right-1 -top-1 bg-red-600 text-white rounded-full w-4 h-4 text-[8px] flex items-center justify-center">✕</button>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        {{-- CAPACIDADES (POWERS) --}}
                        <div class="ark-panel !p-4 border-t-2 border-cyan-500">
                            <div class="flex justify-between items-center mb-3">
                                <h3 class="text-xs font-black text-cyan-400 uppercase tracking-tighter">Capacidades e Poderes</h3>
                                <button type="button" onclick="addField('powers', 'powers-container')" class="text-[9px] bg-cyan-500/10 px-2 py-0.5 rounded text-cyan-400 border border-cyan-500/20">+ ADD</button>
                            </div>
                            <div id="powers-container" class="space-y-2">
                                @foreach($ficha->survivorPowers as $i => $p)
                                    <div class="bg-black/40 p-2 rounded relative border border-white/5">
                                        <input type="text" name="powers[{{$i}}][name]" value="{{ $p->name }}" class="ark-input w-full text-xs font-bold text-cyan-400 mb-1 uppercase" placeholder="NOME">
                                        <textarea name="powers[{{$i}}][description]" class="ark-input w-full text-[10px] h-10 italic text-gray-400" placeholder="DESCRIÇÃO">{{ $p->description }}</textarea>
                                        <button type="button" onclick="this.parentElement.remove()" class="absolute -right-1 -top-1 bg-red-600 text-white rounded-full w-4 h-4 text-[8px] flex items-center justify-center">✕</button>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    {{-- TEXTOS LONGOS --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div class="ark-panel !p-6">
                            <label class="text-[10px] font-black text-cyan-400 uppercase block mb-2">Histórico (Lore)</label>
                            <textarea name="lore" class="ark-input w-full h-32 text-sm italic leading-relaxed">{{ $ficha->lore }}</textarea>
                        </div>
                        <div class="ark-panel !p-6">
                            <label class="text-[10px] font-black text-cyan-400 uppercase block mb-2">Arsenal de Combate</label>
                            <textarea name="arsenal" class="ark-input w-full h-32 font-mono text-xs text-gray-300">{{ $ficha->arsenal }}</textarea>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

    {{-- SCRIPTS DE DINAMISMO --}}
    <script>
        let counts = {
            mutations: {{ $ficha->mutations->count() }},
            rituals: {{ $ficha->rituals->count() }},
            bonuses: {{ $ficha->bonuses->count() }},
            powers: {{ $ficha->survivorPowers->count() }}
        };

        function addField(type, containerId) {
            const i = counts[type]++;
            const container = document.getElementById(containerId);
            let html = '';

            if(type === 'mutations') {
                html = `<div class="grid grid-cols-4 gap-2 bg-black/40 p-3 rounded-lg relative border border-white/5 animate-slideDown">
                    <input type="text" name="mutations[${i}][origin]" class="ark-input text-[10px]" placeholder="ORIGEM">
                    <input type="text" name="mutations[${i}][name]" class="ark-input col-span-2 font-bold text-orange-400" placeholder="NOVA MUTAÇÃO">
                    <textarea name="mutations[${i}][description]" class="ark-input col-span-4 text-xs h-12 italic" placeholder="EFEITOS..."></textarea>
                    <button type="button" onclick="this.parentElement.remove()" class="absolute -right-2 -top-2 bg-red-600 text-white rounded-full w-5 h-5 text-[10px] flex items-center justify-center">✕</button>
                </div>`;
            } else if(type === 'rituals') {
                html = `<div class="grid grid-cols-3 gap-2 bg-black/40 p-3 rounded-lg relative border border-white/5 animate-slideDown">
                    <select name="rituals[${i}][type]" class="ark-input text-[10px] font-black text-purple-400 bg-black">
                        <option value="ritual">RITUAL</option>
                        <option value="pacto">PACTO</option>
                        <option value="conjuracao">CONJURAÇÃO</option>
                    </select>
                    <input type="text" name="rituals[${i}][name]" class="ark-input col-span-2 font-bold uppercase" placeholder="NOME">
                    <textarea name="rituals[${i}][description]" class="ark-input col-span-2 text-xs h-10 italic" placeholder="DESCRIÇÃO..."></textarea>
                    <button type="button" onclick="this.parentElement.remove()" class="absolute -right-2 -top-2 bg-red-600 text-white rounded-full w-5 h-5 text-[10px] flex items-center justify-center">✕</button>
                </div>`;
            } else if(type === 'bonuses') {
                html = `<div class="bg-black/40 p-2 rounded relative border border-white/5 animate-slideDown">
                    <input type="text" name="bonuses[${i}][name]" class="ark-input w-full text-[10px] font-bold text-emerald-400 mb-1" placeholder="NOME">
                    <input type="text" name="bonuses[${i}][value]" class="ark-input w-full text-[10px]" placeholder="VALOR">
                    <button type="button" onclick="this.parentElement.remove()" class="absolute -right-1 -top-1 bg-red-600 text-white rounded-full w-4 h-4 text-[8px] flex items-center justify-center">✕</button>
                </div>`;
            } else if(type === 'powers') {
                html = `<div class="bg-black/40 p-2 rounded relative border border-white/5 animate-slideDown">
                    <input type="text" name="powers[${i}][name]" class="ark-input w-full text-xs font-bold text-cyan-400 mb-1 uppercase" placeholder="NOME">
                    <textarea name="powers[${i}][description]" class="ark-input w-full text-[10px] h-10 italic" placeholder="DESCRIÇÃO..."></textarea>
                    <button type="button" onclick="this.parentElement.remove()" class="absolute -right-1 -top-1 bg-red-600 text-white rounded-full w-4 h-4 text-[8px] flex items-center justify-center">✕</button>
                </div>`;
            }
            container.insertAdjacentHTML('beforeend', html);
        }
    </script>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Orbitron:wght@400;900&display=swap');
        .font-display { font-family: 'Orbitron', sans-serif; }
        .ark-panel { background: rgba(0, 0, 0, 0.8); border: 1px solid rgba(0, 242, 255, 0.1); border-radius: 12px; backdrop-filter: blur(10px); }
        .ark-input { background: rgba(255, 255, 255, 0.05); border: 1px solid rgba(255, 255, 255, 0.1); color: white; border-radius: 4px; padding: 0.5rem; transition: 0.2s; }
        .ark-input:focus { border-color: #00f2ff; outline: none; box-shadow: 0 0 15px rgba(0, 242, 255, 0.1); background: rgba(255, 255, 255, 0.08); }
        .ark-btn { background: #00f2ff; color: #000; font-weight: 900; border-radius: 4px; transition: 0.3s; cursor: pointer; text-transform: uppercase; letter-spacing: 1px; }
        .ark-btn:hover { background: #fff; transform: translateY(-2px); }
        @keyframes slideDown { from { opacity: 0; transform: translateY(-10px); } to { opacity: 1; transform: translateY(0); } }
        .animate-slideDown { animation: slideDown 0.3s ease-out; }
    </style>
</x-app-layout>