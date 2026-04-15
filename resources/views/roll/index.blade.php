{{-- resources/views/rolagens/index.blade.php --}}
<x-app-layout>
    <div class="fixed inset-0 -z-10">
        <img src="{{ asset('images/fundo_rolagens.png') }}" class="w-full h-full object-cover opacity-20">
        <div class="absolute inset-0 bg-gradient-to-b from-cyan-950/80 via-blue-950/70 to-black/90"></div>
    </div>

    <div class="relative max-w-7xl mx-auto p-6 space-y-6 text-white">
        
        {{-- HEADER E HISTÓRICO RÁPIDO --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <div class="lg:col-span-2 relative rounded-2xl bg-cyan-950/20 backdrop-blur-md border border-cyan-400/30 p-6 shadow-[0_0_30px_rgba(0,242,255,0.15)] overflow-hidden">
                <div class="absolute top-0 right-0 p-4 opacity-5 text-8xl font-display font-black italic text-cyan-200">🎲</div>
                <h2 class="relative text-xl font-display font-black tracking-widest uppercase text-transparent bg-clip-text bg-gradient-to-r from-cyan-200 to-blue-200 mb-4">
                    [ Terminal de Operações de Campo ]
                </h2>
                <select id="character-select" class="w-full bg-black/40 backdrop-blur-sm border border-cyan-400/40 text-cyan-200 p-4 rounded-xl focus:ring-2 focus:ring-cyan-400/50 focus:border-cyan-300 transition-all font-bold uppercase text-sm">
                    <option value="" class="bg-cyan-950 text-gray-400">-- SELECIONE UMA UNIDADE --</option>
                    @foreach($characters as $char)
                        <option value="{{ $char->id }}" class="bg-cyan-950 text-cyan-200">{{ strtoupper($char->name) }} (NÍVEL {{ $char->level }})</option>
                    @endforeach
                </select>
            </div>

            <div class="rounded-2xl bg-cyan-950/20 backdrop-blur-md border border-cyan-400/30 p-5 shadow-[0_0_30px_rgba(0,242,255,0.15)]">
                <h3 class="text-xs text-cyan-300 uppercase mb-3 font-bold tracking-widest border-b border-cyan-400/20 pb-2">Última Transmissão</h3>
                <div id="history-dice" class="text-sm text-white font-mono italic bg-black/20 p-3 rounded-lg border border-cyan-400/20">--</div>
                
                <h3 class="text-xs text-purple-300 uppercase mt-5 mb-3 font-bold tracking-widest border-b border-purple-400/20 pb-2">Evento de Campo</h3>
                <div id="history-event" class="text-sm text-purple-200 font-mono italic bg-black/20 p-3 rounded-lg border border-purple-400/20">--</div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            
            {{-- COLUNA ESQUERDA: STATUS E TESTES --}}
            <div class="space-y-6">
                {{-- PREVIEW DA FICHA --}}
                <div id="char-preview" class="relative rounded-2xl bg-cyan-950/20 backdrop-blur-md border border-cyan-400/30 p-6 shadow-[0_0_30px_rgba(0,242,255,0.15)] opacity-40 transition-all duration-700 overflow-hidden">
                    <div class="absolute inset-0 bg-gradient-to-r from-transparent via-cyan-400/5 to-transparent -translate-x-full group-hover:translate-x-full transition-transform duration-1500"></div>
                    <h3 class="text-xs uppercase text-cyan-300 mb-5 tracking-widest font-display">Status da Unidade Selecionada</h3>
                    
                    <div id="attr-preview" class="grid grid-cols-5 gap-3 text-center text-[10px] mb-8">
                        @foreach(['for','agi','int','vig','set'] as $a)
                            <div class="bg-black/30 backdrop-blur-sm border border-cyan-400/20 p-3 rounded-xl">
                                <span class="block text-cyan-300/70 font-bold uppercase mb-1">{{ $a }}</span>
                                <span class="text-2xl font-display font-black text-white">--</span>
                            </div>
                        @endforeach
                    </div>

                    <div class="grid grid-cols-2 gap-6">
                        <div>
                            <h4 class="text-xs uppercase text-emerald-300 mb-2 font-display tracking-wider">Bônus Ativos</h4>
                            <div id="bonus-preview" class="text-xs text-gray-200 leading-relaxed bg-black/20 p-3 rounded-lg border border-emerald-400/20">--</div>
                        </div>
                        <div>
                            <h4 class="text-xs uppercase text-cyan-300 mb-2 font-display tracking-wider">Mutações</h4>
                            <div id="mutation-preview" class="text-xs text-gray-200 leading-relaxed bg-black/20 p-3 rounded-lg border border-cyan-400/20">--</div>
                        </div>
                    </div>
                </div>

                {{-- ROLAGEM POR ATRIBUTO --}}
                <div class="rounded-2xl bg-cyan-950/20 backdrop-blur-md border border-cyan-400/30 p-6 shadow-[0_0_30px_rgba(0,242,255,0.15)]">
                    <h3 class="text-base font-display font-black text-transparent bg-clip-text bg-gradient-to-r from-cyan-200 to-blue-200 mb-5 uppercase tracking-wider">Módulos de Teste (Atributo)</h3>
                    <div id="attr-rolls" class="space-y-4">
                        <div class="text-center text-xs text-cyan-300/50 py-6 italic">Aguardando sincronização com unidade...</div>
                    </div>
                </div>
            </div>

            {{-- COLUNA DIREITA: DADOS LIVRES E EVENTOS --}}
            <div class="space-y-6">
                {{-- DICE SYSTEM 3D --}}
                <div class="rounded-2xl bg-cyan-950/20 backdrop-blur-md border border-cyan-400/30 p-6 shadow-[0_0_30px_rgba(0,242,255,0.15)]">
                    <h3 class="text-xs font-bold text-cyan-300 uppercase mb-5 tracking-widest font-display border-b border-cyan-400/20 pb-3">Manual Dice Roller</h3>
                    
                    {{-- Representação visual dos dados --}}
                    <div id="dice-container" class="grid grid-cols-7 gap-2 mb-8"></div>
                    
                    <div class="space-y-5">
                        <div class="flex gap-3">
                            <select id="mode" class="flex-1 bg-black/40 border border-cyan-400/30 p-3 rounded-xl text-xs uppercase font-bold text-cyan-200 focus:ring-cyan-400/50">
                                <option value="sum">Somar Tudo</option>
                                <option value="max">Maior Valor</option>
                            </select>
                            <input type="number" id="bonus-manual" placeholder="Bônus" class="w-24 bg-black/40 border border-cyan-400/30 p-3 rounded-xl text-center text-sm text-white font-bold focus:ring-cyan-400/50">
                        </div>

                        {{-- BÔNUS RÁPIDO --}}
                        <div class="grid grid-cols-6 gap-2">
                            @foreach([5,10,15,20,25,30] as $b)
                                <button onclick="setBonus({{ $b }})" class="bg-black/40 border border-cyan-400/20 hover:bg-cyan-500/30 text-cyan-200 text-xs font-bold p-2 rounded-lg transition-all hover:scale-105">
                                    +{{ $b }}
                                </button>
                            @endforeach
                        </div>

                        <button onclick="rollDice()" class="w-full bg-gradient-to-r from-cyan-500 to-blue-500 hover:from-cyan-400 hover:to-blue-400 p-5 rounded-xl font-display font-black uppercase tracking-[0.3em] transition-all text-black shadow-[0_0_30px_rgba(0,242,255,0.4)] hover:shadow-[0_0_50px_rgba(0,242,255,0.7)]">
                            Executar Rolagem Livre
                        </button>
                    </div>
                    
                    {{-- Resultado com animação 3D --}}
                    <div id="dice-result-display" class="mt-8 p-6 bg-black/40 backdrop-blur-sm border border-cyan-400/30 rounded-xl hidden">
                        <div class="flex items-center gap-4">
                            <div id="dice-3d-container" class="w-20 h-20 perspective-1000"></div>
                            <div class="flex-1">
                                <div id="total-result" class="text-6xl font-display font-black text-transparent bg-clip-text bg-gradient-to-r from-cyan-200 to-white">0</div>
                                <div id="individual-rolls" class="text-xs text-cyan-300/80 mt-2 font-mono uppercase tracking-wider"></div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- EVENTOS --}}
                <div class="rounded-2xl bg-cyan-950/20 backdrop-blur-md border border-purple-400/30 p-6 shadow-[0_0_30px_rgba(168,85,247,0.15)]">
                    <h3 class="font-display font-bold text-base text-transparent bg-clip-text bg-gradient-to-r from-purple-200 to-purple-300 mb-5 uppercase tracking-wider">Protocolo de Eventos Aleatórios</h3>
                    <div class="grid grid-cols-2 gap-4">
                        <button onclick="rollEvent('clima')" class="bg-purple-500/10 backdrop-blur-sm border border-purple-400/30 hover:bg-purple-500/30 p-4 rounded-xl text-xs font-black uppercase tracking-wider text-purple-200 transition-all shadow-[0_0_15px_rgba(168,85,247,0.2)] hover:shadow-[0_0_25px_rgba(168,85,247,0.4)]">
                            Sincronizar Clima
                        </button>
                        <button onclick="rollEvent('encontro')" class="bg-purple-500/10 backdrop-blur-sm border border-purple-400/30 hover:bg-purple-500/30 p-4 rounded-xl text-xs font-black uppercase tracking-wider text-purple-200 transition-all shadow-[0_0_15px_rgba(168,85,247,0.2)] hover:shadow-[0_0_25px_rgba(168,85,247,0.4)]">
                            Detectar Ameaça
                        </button>
                    </div>
                    <div id="event-display" class="mt-5 p-4 bg-black/40 border border-purple-400/30 rounded-xl hidden font-mono text-purple-200 text-sm"></div>
                </div>
            </div>
        </div>
    </div>

    {{-- ESTILOS ESPECÍFICOS --}}
    <style>
        .perspective-1000 { perspective: 1000px; }
        .dice-3d {
            width: 80px; height: 80px;
            position: relative;
            transform-style: preserve-3d;
            transition: transform 0.01s linear;
        }
        .dice-face {
            position: absolute;
            width: 80px; height: 80px;
            background: rgba(0, 20, 40, 0.9);
            border: 2px solid #0cf;
            box-shadow: 0 0 15px #0cf inset, 0 0 20px #0cf;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 30px;
            font-weight: bold;
            color: #fff;
            text-shadow: 0 0 10px #0cf;
            border-radius: 12px;
            backdrop-filter: blur(4px);
        }
        .dice-face.front  { transform: rotateY(0deg) translateZ(40px); }
        .dice-face.back   { transform: rotateY(180deg) translateZ(40px); }
        .dice-face.right  { transform: rotateY(90deg) translateZ(40px); }
        .dice-face.left   { transform: rotateY(-90deg) translateZ(40px); }
        .dice-face.top    { transform: rotateX(90deg) translateZ(40px); }
        .dice-face.bottom { transform: rotateX(-90deg) translateZ(40px); }
    </style>

    <script>
        const diceTypes = [4, 6, 8, 10, 12, 20, 100];
        let diceState = {};
        let selectedCharId = null;
        let selectedCharData = null;

        // Inicializa interface de dados (estilizada)
        const container = document.getElementById('dice-container');
        diceTypes.forEach(d => {
            diceState[d] = 0;
            const dieDiv = document.createElement('div');
            dieDiv.className = "bg-black/40 backdrop-blur-sm border border-cyan-400/20 rounded-xl p-2 text-center cursor-pointer hover:border-cyan-400 hover:shadow-[0_0_15px_rgba(0,242,255,0.4)] transition-all select-none group";
            dieDiv.innerHTML = `
                <div class="text-[10px] text-cyan-300/70 font-bold uppercase tracking-wider">D${d}</div>
                <div id="count-${d}" class="text-xl font-display font-black text-white">0</div>
                <div class="flex justify-between mt-1 opacity-0 group-hover:opacity-100 transition-opacity">
                    <span class="text-emerald-400 text-lg font-bold cursor-pointer hover:scale-125" onclick="event.stopPropagation(); updateDice(${d}, 1)">+</span>
                    <span class="text-rose-400 text-lg font-bold cursor-pointer hover:scale-125" onclick="event.stopPropagation(); updateDice(${d}, -1)">−</span>
                </div>
            `;
            dieDiv.addEventListener('click', (e) => {
                if (!e.target.closest('span')) updateDice(d, 1);
            });
            dieDiv.addEventListener('contextmenu', (e) => {
                e.preventDefault();
                updateDice(d, -1);
            });
            container.appendChild(dieDiv);
        });

        function updateDice(d, val) {
            diceState[d] = Math.max(0, diceState[d] + val);
            document.getElementById(`count-${d}`).innerText = diceState[d];
        }

        function setBonus(val) {
            document.getElementById('bonus-manual').value = val;
        }

        // Animação 3D do dado
        function animateDice3D(finalValue, faces = 20) {
            const container3d = document.getElementById('dice-3d-container');
            container3d.innerHTML = '';
            
            const dice = document.createElement('div');
            dice.className = 'dice-3d';
            const faceValue = finalValue || '?';
            
            // Cria 6 faces
            const positions = ['front', 'back', 'right', 'left', 'top', 'bottom'];
            positions.forEach(pos => {
                const face = document.createElement('div');
                face.className = `dice-face ${pos}`;
                face.textContent = pos === 'front' ? faceValue : ['⚀','⚁','⚂','⚃','⚄','⚅'][Math.floor(Math.random()*6)];
                dice.appendChild(face);
            });
            
            container3d.appendChild(dice);
            
            // Rotação aleatória inicial
            let rotX = Math.random() * 360;
            let rotY = Math.random() * 360;
            dice.style.transform = `rotateX(${rotX}deg) rotateY(${rotY}deg)`;
            
            // Animação de giro
            const startTime = performance.now();
            const duration = 600;
            
            function animateSpin(now) {
                const elapsed = now - startTime;
                const progress = Math.min(elapsed / duration, 1);
                const easeOut = 1 - Math.pow(1 - progress, 3);
                
                const spinX = rotX + (1 - easeOut) * 720;
                const spinY = rotY + (1 - easeOut) * 720;
                dice.style.transform = `rotateX(${spinX}deg) rotateY(${spinY}deg)`;
                
                if (progress < 1) {
                    requestAnimationFrame(animateSpin);
                } else {
                    dice.style.transform = `rotateX(${rotX}deg) rotateY(${rotY}deg)`;
                }
            }
            
            requestAnimationFrame(animateSpin);
        }

        // CARREGA PERSONAGEM
        document.getElementById('character-select').addEventListener('change', async function() {
            selectedCharId = this.value;
            if(!selectedCharId) return;

            const res = await fetch(`/rolagens/char/${selectedCharId}`);
            const data = await res.json();
            selectedCharData = data.char;

            const preview = document.getElementById('char-preview');
            preview.classList.remove('opacity-40');

            document.getElementById('attr-preview').innerHTML = `
                ${['for','agi','int','vig','set'].map(a => `
                    <div class="bg-black/30 backdrop-blur-sm border border-cyan-400/20 p-3 rounded-xl">
                        <span class="block text-cyan-300/70 font-bold uppercase mb-1">${a}</span>
                        <span class="text-2xl font-display font-black text-white">${data.char[a]}</span>
                    </div>
                `).join('')}
            `;

            document.getElementById('bonus-preview').innerHTML = data.char.bonuses?.map(b => `<div class="flex justify-between"><span>${b.name}</span><span class="text-emerald-300">+${b.value}</span></div>`).join('') || 'Nenhum bônus neural.';
            document.getElementById('mutation-preview').innerHTML = data.char.mutations?.map(m => `<div>${m.name}</div>`).join('') || 'DNA estável.';

            if(data.lastRoll){
                document.getElementById('history-dice').innerText = data.lastRoll.dice_result || '--';
                document.getElementById('history-event').innerText = data.lastRoll.event_result || '--';
            }

            generateAttrBlocks();
        });

        function generateAttrBlocks() {
            const container = document.getElementById('attr-rolls');
            container.innerHTML = '';
            for(let i=0; i<3; i++){
                const div = document.createElement('div');
                div.className = "bg-black/40 backdrop-blur-sm border border-cyan-400/20 p-4 rounded-xl flex items-center gap-3";
                div.innerHTML = `
                    <select id="attr-${i}" class="bg-black/60 border border-cyan-400/30 text-cyan-200 p-2 rounded-lg text-xs font-bold uppercase focus:ring-cyan-400/50">
                        <option value="for">FOR</option><option value="agi">AGI</option>
                        <option value="int">INT</option><option value="vig">VIG</option>
                        <option value="set">SET</option>
                    </select>
                    <input id="bonus-${i}" type="number" placeholder="Bônus" class="w-20 bg-black/60 border border-cyan-400/30 p-2 rounded-lg text-center text-xs text-white focus:ring-cyan-400/50">
                    <button onclick="rollAttribute(${i})" class="bg-cyan-600 hover:bg-cyan-500 px-5 py-2 rounded-lg text-xs font-black uppercase tracking-wider text-black transition-all ml-auto">Rolar</button>
                    <div id="result-${i}" class="min-w-[100px] text-right font-display font-black text-cyan-200 text-lg">---</div>
                `;
                container.appendChild(div);
            }
        }

        function rollAttribute(i){
            if(!selectedCharData) return alert('Sincronize uma unidade primeiro!');
            const attr = document.getElementById(`attr-${i}`).value;
            const bonus = parseInt(document.getElementById(`bonus-${i}`).value) || 0;
            const qtdDados = selectedCharData[attr];
            
            let rolls = [];
            for(let x=0; x < qtdDados; x++) rolls.push(Math.floor(Math.random()*20)+1);
            
            const max = Math.max(...rolls);
            const total = max + bonus;
            
            document.getElementById(`result-${i}`).innerText = `${total} (${max}+${bonus})`;
            
            // Anima dado 3D com o resultado
            animateDice3D(total);
            
            saveToDB(`TESTE ${attr.toUpperCase()}: ${total}`, null);
        }

        function rollDice() {
            if(!selectedCharId) return alert('Selecione uma unidade!');
            let total = 0; let rollsDetail = [];
            const mode = document.getElementById('mode').value;
            const bonus = parseInt(document.getElementById('bonus-manual').value) || 0;

            for (let d in diceState) {
                if (diceState[d] > 0) {
                    let currentRolls = [];
                    for (let i = 0; i < diceState[d]; i++) currentRolls.push(Math.floor(Math.random() * d) + 1);
                    total += (mode === 'sum') ? currentRolls.reduce((a, b) => a + b, 0) : Math.max(...currentRolls);
                    rollsDetail.push(`D${d}:[${currentRolls.join(',')}]`);
                }
            }
            total += bonus;
            const display = document.getElementById('dice-result-display');
            display.classList.remove('hidden');
            document.getElementById('total-result').innerText = total;
            document.getElementById('individual-rolls').innerText = rollsDetail.join(' | ');
            
            animateDice3D(total);
            saveToDB(`LIVRE: ${total} ${rollsDetail.join(' ')}`, null);
        }

        const eventos = {
            clima: ["Tempestade de Areia: -2 VIG", "Neblina Espessa: -5 Precisão", "Calor Extremo: Consumo de Água x2"],
            encontro: ["Pegadas de Rex", "Sinal de Supply Drop", "Raptor avistado!"]
        };

        function rollEvent(type) {
            if(!selectedCharId) return;
            const result = eventos[type][Math.floor(Math.random() * eventos[type].length)];
            const display = document.getElementById('event-display');
            display.classList.remove('hidden');
            display.innerText = `> ${result}`;
            saveToDB(null, result);
        }

        function saveToDB(dice, event) {
            fetch('/rolagens/save', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content },
                body: JSON.stringify({ character_id: selectedCharId, dice_result: dice, event_result: event })
            }).then(() => {
                if(dice) document.getElementById('history-dice').innerText = dice;
                if(event) document.getElementById('history-event').innerText = event;
            });
        }
    </script>
</x-app-layout>