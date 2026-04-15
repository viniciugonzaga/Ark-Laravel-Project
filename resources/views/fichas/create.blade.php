<x-app-layout>
    {{-- Fundo apagado --}}
    <div class="fixed inset-0 -z-10">
        <img src="{{ asset('images/fundo_create.png') }}" alt="Background" class="w-full h-full object-cover opacity-20">
        <div class="absolute inset-0 bg-black/70"></div>
    </div>

    <style>
        @keyframes slideDown {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-slideDown {
            animation: slideDown 0.3s ease forwards;
        }
        .ark-input {
            @apply bg-black/40 border border-cyan-500/30 text-white rounded-md px-4 py-2.5 transition-all duration-300;
        }
        .ark-input:focus {
            @apply border-cyan-400 shadow-[0_0_15px_rgba(0,242,255,0.3)] outline-none bg-black/60;
        }
        .section-title {
            @apply text-lg font-display font-black text-cyan-300 uppercase tracking-wider border-b border-cyan-500/30 pb-3 mb-5 flex items-center justify-between;
        }
    </style>

    <form action="{{ route('fichas.store') }}" method="POST" enctype="multipart/form-data" class="relative max-w-7xl mx-auto p-6 space-y-10 pb-40 text-gray-100">
        @csrf

        {{-- CABEÇALHO: FOTO + INFO --}}
        <div class="grid lg:grid-cols-4 gap-6 animate-fadeInUp">
            {{-- Área de upload de imagem com preview --}}
            <div class="ark-panel !p-1 relative group h-80 overflow-hidden rounded-xl">
                <input type="file" name="image" id="photo-input" hidden accept="image/*">
                <label for="photo-input" class="cursor-pointer block h-full">
                    <div class="h-full bg-gradient-to-br from-black/80 to-gray-900/80 flex flex-col items-center justify-center relative">
                        <span id="photo-label" class="z-10 font-display font-black text-cyan-400 group-hover:scale-110 group-hover:text-cyan-300 transition-all duration-300 text-center px-4">
                            <svg class="w-16 h-16 mx-auto mb-3 opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            CARREGAR DNA VISUAL
                        </span>
                        <img id="preview" class="absolute inset-0 w-full h-full object-cover hidden opacity-90 group-hover:opacity-100 transition-all duration-700">
                    </div>
                </label>
            </div>

            {{-- Informações principais --}}
            <div class="lg:col-span-3 ark-panel !p-6 space-y-6">
                <input name="name" class="ark-input !text-4xl !py-3 w-full font-display font-black italic uppercase placeholder:text-gray-600" 
                       placeholder="IDENTIFICAÇÃO DO SUJEITO" required>

                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    <div class="flex flex-col">
                        <label class="text-[10px] text-cyan-400 font-bold uppercase tracking-wider mb-1">NÍVEL</label>
                        <input type="number" name="level" value="1" class="ark-input !text-xl font-bold">
                    </div>
                    <div class="flex flex-col">
                        <label class="text-[10px] text-cyan-400 font-bold uppercase tracking-wider mb-1">IDADE</label>
                        <input type="number" name="age" class="ark-input !text-xl font-bold">
                    </div>
                    <div class="flex flex-col">
                        <label class="text-[10px] text-cyan-400 font-bold uppercase tracking-wider mb-1">ORIGEM</label>
                        <select name="class_main" class="ark-input">
                            <option class="bg-black">Humano</option>
                            <option class="bg-black">Morto-Vivo</option>
                            <option class="bg-black">Meio-Humano</option>
                            <option class="bg-black">Místico</option>
                        </select>
                    </div>
                    <div class="flex flex-col">
                        <label class="text-[10px] text-cyan-400 font-bold uppercase tracking-wider mb-1">ESPECIALIZAÇÃO</label>
                        <select name="class_sub" id="class_sub" onchange="toggleCustom()" class="ark-input">
                            <option value="padrao" class="bg-black">Sobrevivente Padrão</option>
                            <option class="bg-black">Gladio</option>
                            <option class="bg-black">Iberos</option>
                            <option class="bg-black">Orc</option>
                            <option class="bg-black">Fungo</option>
                            <option class="bg-black">Companhia Escarlate</option>
                            <option value="nova" class="bg-black">Nova Especialização +</option>
                        </select>
                    </div>
                </div>
                <input type="text" name="custom_class_name" id="custom_class" 
                       class="ark-input w-full hidden border-dashed" placeholder="DIGITE O NOME DA NOVA CLASSE...">
            </div>
        </div>

        {{-- ATRIBUTOS --}}
        <div class="ark-panel !p-6 animate-fadeInUp" style="animation-delay: 0.1s">
            <div class="section-title">
                <span>MATRIZ DE ATRIBUTOS</span>
                <span class="text-sm font-mono">PONTOS INVESTIDOS: <span id="total" class="text-white font-bold">0</span></span>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-5 gap-4">
                @foreach(['agi','for','int','set','vig'] as $a)
                <div class="bg-black/40 p-4 rounded-lg border border-cyan-500/20 text-center">
                    <label class="block text-xs font-black text-cyan-300 mb-3">{{ strtoupper($a) }}</label>
                    <div class="flex items-center justify-between bg-black/60 px-3 py-2 rounded-md border border-cyan-500/30">
                        <button type="button" onclick="attr('{{$a}}',-1)" 
                                class="text-2xl text-red-400 font-black hover:text-red-300 hover:scale-125 transition-all">−</button>
                        <input id="val-{{$a}}" name="{{$a}}" value="1" 
                               class="bg-transparent text-center w-full font-bold text-xl text-white" readonly>
                        <button type="button" onclick="attr('{{$a}}',1)" 
                                class="text-2xl text-emerald-400 font-black hover:text-emerald-300 hover:scale-125 transition-all">+</button>
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        {{-- GRIDS DINÂMICOS --}}
        <div class="grid md:grid-cols-2 gap-6">
            {{-- MUTAÇÕES --}}
            <div class="ark-panel !p-6 animate-fadeInUp" style="animation-delay: 0.2s">
                <div class="section-title">
                    <span>MUTAÇÕES GENÉTICAS</span>
                    <button type="button" onclick="addMutation()" 
                            class="bg-cyan-500/20 hover:bg-cyan-500/40 text-cyan-300 border border-cyan-500/50 rounded-full w-8 h-8 flex items-center justify-center text-xl font-bold transition-all hover:scale-110">+</button>
                </div>
                <div id="mutations-container" class="space-y-4"></div>
            </div>

            {{-- BÔNUS --}}
            <div class="ark-panel !p-6 animate-fadeInUp" style="animation-delay: 0.3s">
                <div class="section-title">
                    <span>INCREMENTOS (BÔNUS)</span>
                    <button type="button" onclick="addBonus()" 
                            class="bg-cyan-500/20 hover:bg-cyan-500/40 text-cyan-300 border border-cyan-500/50 rounded-full w-8 h-8 flex items-center justify-center text-xl font-bold transition-all hover:scale-110">+</button>
                </div>
                <div id="bonus-container" class="space-y-3"></div>
                <div class="mt-4 text-right text-xs uppercase text-cyan-400 font-bold">
                    Custo Total (Barras / 5): <span id="bonusTotal" class="text-white">0</span>
                </div>
            </div>
        </div>

        {{-- PODERES E RITUAIS --}}
        <div class="grid md:grid-cols-2 gap-6">
            <div class="ark-panel !p-6 animate-fadeInUp" style="animation-delay: 0.4s">
                <div class="section-title">
                    <span>PODERES DE SOBREVIVENTE</span>
                    <button onclick="addPower()" type="button" 
                            class="bg-cyan-500/20 hover:bg-cyan-500/40 text-cyan-300 border border-cyan-500/50 rounded-full w-8 h-8 flex items-center justify-center text-xl font-bold transition-all hover:scale-110">+</button>
                </div>
                <div id="powers-container" class="space-y-4"></div>
            </div>

            <div class="ark-panel !p-6 animate-fadeInUp" style="animation-delay: 0.5s">
                <div class="section-title">
                    <span>RITUAIS & PACTOS</span>
                    <button onclick="addRitual()" type="button" 
                            class="bg-cyan-500/20 hover:bg-cyan-500/40 text-cyan-300 border border-cyan-500/50 rounded-full w-8 h-8 flex items-center justify-center text-xl font-bold transition-all hover:scale-110">+</button>
                </div>
                <div id="rituals-container" class="space-y-4"></div>
            </div>
        </div>

        {{-- TEXTOS LARGOS --}}
        <div class="grid md:grid-cols-2 gap-6 animate-fadeInUp" style="animation-delay: 0.6s">
            <div class="ark-panel !p-6">
                <h3 class="section-title !mb-3">REGISTRO DE LORE</h3>
                <textarea name="lore" class="ark-input w-full h-48 text-sm italic" placeholder="Escreva a trajetória do sujeito..."></textarea>
            </div>
            <div class="ark-panel !p-6">
                <h3 class="section-title !mb-3">ARSENAL & EQUIPAMENTOS</h3>
                <textarea name="arsenal" class="ark-input w-full h-48 text-sm font-mono" placeholder="Itens, armas e recursos..."></textarea>
            </div>
        </div>

        {{-- STATUS VITAIS --}}
        <div class="ark-panel !p-6 bg-cyan-900/5 animate-fadeInUp" style="animation-delay: 0.7s">
            <div class="section-title !text-white">STATUS VITAIS</div>
            <div class="grid grid-cols-2 md:grid-cols-5 gap-4">
                @foreach(['vida','armadura','determinacao','folego','resistencia'] as $s)
                    <div class="flex flex-col">
                        <label class="text-[10px] font-black text-cyan-400/70 uppercase mb-1">{{$s}}</label>
                        <input name="{{$s}}" type="number" class="ark-input !text-center font-bold" value="0">
                    </div>
                @endforeach
            </div>
        </div>

        {{-- BARRA FIXA --}}
        <div class="fixed bottom-0 left-0 w-full flex justify-center gap-6 bg-black/95 backdrop-blur-md p-6 border-t border-cyan-500/30 z-50">
            <a href="{{ route('fichas.index') }}" 
               class="px-10 py-3 border border-red-500/50 text-red-400 hover:bg-red-500/20 hover:text-red-300 transition-all font-bold uppercase tracking-wider rounded-md">Abortar</a>
            <button type="button" onclick="window.print()" 
                    class="px-10 py-3 border border-cyan-500/50 text-cyan-400 hover:bg-cyan-500/20 hover:text-cyan-300 transition-all font-bold uppercase tracking-wider rounded-md">Gerar PDF</button>
            <button type="submit" 
                    class="ark-btn !px-16 !py-3 !text-base shadow-[0_0_30px_rgba(0,242,255,0.3)] hover:shadow-[0_0_50px_rgba(0,242,255,0.5)]">
                Sincronizar DNA
            </button>
        </div>
    </form>

    <script>
        // (MANTIDO O SCRIPT ORIGINAL EXATAMENTE COMO ESTAVA)
        let counters = { mutation: 0, bonus: 0, power: 0, ritual: 0 };

        document.getElementById('photo-input').onchange = e => {
            const [file] = e.target.files;
            if (file) {
                const preview = document.getElementById('preview');
                preview.src = URL.createObjectURL(file);
                preview.classList.remove('hidden');
                document.getElementById('photo-label').classList.add('hidden');
            }
        }

        function attr(id, delta) {
            const el = document.getElementById('val-' + id);
            const newVal = Math.max(0, parseInt(el.value) + delta);
            el.value = newVal;
            
            let t = 0;
            ['agi','for','int','set','vig'].forEach(a => {
                t += (parseInt(document.getElementById('val-' + a).value) - 1);
            });
            document.getElementById('total').innerText = t;
        }

        function createField(containerId, html) {
            const container = document.getElementById(containerId);
            const wrapper = document.createElement('div');
            wrapper.className = "relative group animate-slideDown";
            wrapper.innerHTML = html + `<button type="button" onclick="this.parentElement.remove(); if('${containerId}' === 'bonus-container') sumBonus();" class="absolute -top-2 -right-2 bg-red-600/80 hover:bg-red-500 text-white rounded-full w-6 h-6 flex items-center justify-center text-xs font-bold transition-all">✕</button>`;
            container.appendChild(wrapper);
        }

        function addMutation() {
            const i = counters.mutation++;
            createField('mutations-container', `
                <div class="grid grid-cols-2 gap-2 mb-2">
                    <input name="mutations[${i}][origin]" class="ark-input text-xs" placeholder="ORIGEM (Ex: Radioativa)">
                    <input name="mutations[${i}][name]" class="ark-input text-xs font-bold" placeholder="NOME DA MUTAÇÃO">
                </div>
                <textarea name="mutations[${i}][description]" class="ark-input w-full text-xs h-16" placeholder="Efeitos e detalhes..."></textarea>
            `);
        }

        function addBonus() {
            const i = counters.bonus++;
            createField('bonus-container', `
                <div class="flex gap-2">
                    <input name="bonuses[${i}][name]" class="ark-input flex-1 text-xs" placeholder="Ação/Perícia">
                    <select name="bonuses[${i}][value]" onchange="sumBonus()" class="ark-input text-xs w-24">
                        <option value="5">+5</option>
                        <option value="10">+10</option>
                        <option value="15">+15</option>
                    </select>
                </div>
            `);
            sumBonus();
        }

        function sumBonus() {
            let total = 0;
            document.querySelectorAll('select[name*="bonuses"]').forEach(s => {
                total += (parseInt(s.value) / 5);
            });
            document.getElementById('bonusTotal').innerText = total;
        }

        function addPower() {
            const i = counters.power++;
            createField('powers-container', `
                <input name="powers[${i}][name]" class="ark-input w-full mb-2 font-bold" placeholder="NOME DO PODER">
                <textarea name="powers[${i}][description]" class="ark-input w-full text-xs h-16" placeholder="Regras e ativação..."></textarea>
            `);
        }

        function addRitual() {
            const i = counters.ritual++;
            createField('rituals-container', `
                <div class="flex gap-2 mb-2">
                    <select name="rituals[${i}][type]" class="ark-input text-xs w-28">
                        <option>Ritual</option><option>Pacto</option><option>Conjuração</option>
                    </select>
                    <input name="rituals[${i}][name]" class="ark-input flex-1 font-bold" placeholder="NOME" required>
                </div>
                <textarea name="rituals[${i}][description]" class="ark-input w-full text-xs h-16" placeholder="Custo e efeito..." required></textarea>
            `);
        }

        function toggleCustom() {
            const select = document.getElementById('class_sub');
            const customInput = document.getElementById('custom_class');
            customInput.classList.toggle('hidden', select.value !== 'nova');
        }

        window.onload = () => {
            addMutation();
            addPower();
        };
    </script>
</x-app-layout>