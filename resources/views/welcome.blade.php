{{-- resources/views/welcome.blade.php --}}
<x-app-layout>
    <x-slot name="title">Bem-vindo ao ARK</x-slot>

    <div class="relative min-h-screen flex items-center">
        {{-- Imagem de fundo mais escura --}}
        <div class="absolute inset-0 z-0">
            <img src="{{ asset('images/Imagem_fundo_welcome.png') }}" alt="ARK Background" class="w-full h-full object-cover opacity-30">
            <div class="absolute inset-0 bg-black/80 backdrop-blur-[3px]"></div>
        </div>

        {{-- Conteúdo principal --}}
        <div class="relative z-10 w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 items-center">
                
                {{-- COLUNA ESQUERDA --}}
                <div class="space-y-6">
                    {{-- Imagem em caixa bem escura --}}
                    <div class="ark-panel !p-4 !bg-black/80 border border-cyan-500/20 flex justify-center shadow-2xl">
                        <img src="{{ asset('images/Imagem1_welcome.png') }}" alt="Sobrevivente ARK" class="max-h-72 w-auto object-contain rounded-lg brightness-90">
                    </div>

                    {{-- Card de texto com tons de Azul/Ciano --}}
                    <div class="ark-panel !p-10 !bg-black/80 border border-cyan-500/20 text-center shadow-2xl">
                        <p class="text-3xl md:text-4xl font-medieval font-bold leading-relaxed">
                            <span class="text-transparent bg-clip-text bg-gradient-to-r from-cyan-400 via-white to-blue-400">
                                Você não é apenas um sobrevivente.
                            </span>
                        </p>
                        <p class="text-2xl md:text-3xl font-medieval mt-6 tracking-wide flex items-center justify-center flex-wrap gap-x-3">
                            <span class="text-cyan-300 drop-shadow-[0_0_8px_rgba(34,211,238,0.5)]">É o autor da sua própria brutalidade no</span>
                            {{-- Imagem ARK --}}
                            <img src="{{ asset('images/logo_ark_pequena.png') }}" alt="ARK" class="inline-block h-10 md:h-12 w-auto align-middle drop-shadow-[0_0_12px_rgba(0,242,255,0.6)]">
                        </p>
                        {{-- Linha decorativa azul --}}
                        <div class="mt-8 w-24 h-0.5 bg-gradient-to-r from-transparent via-cyan-500 to-transparent mx-auto"></div>
                    </div>

                    {{-- Botão de cadastro --}}
                    <div class="flex justify-center pt-4">
                        @guest
                            <a href="{{ route('register') }}" class="ark-btn !px-12 !py-5 !text-xl shadow-[0_0_40px_rgba(0,242,255,0.3)] hover:shadow-[0_0_60px_rgba(0,242,255,0.5)] transition-all">
                                FAÇA SEU CADASTRO
                            </a>
                        @else
                            <a href="{{ route('dashboard') }}" class="ark-btn !px-12 !py-5 !text-xl">
                                ACESSAR PAINEL
                            </a>
                        @endguest
                    </div>
                </div>

                {{-- COLUNA DIREITA: Carrossel --}}
                <div class="relative">
                    <div x-data="carousel()" x-init="init()" 
                         class="relative w-full overflow-hidden rounded-2xl ark-panel !p-3 !bg-black/80 border border-cyan-500/20 shadow-2xl">
                        
                        <div class="relative aspect-video bg-black/40 rounded-lg">
                            <template x-for="(slide, index) in slides" :key="index">
                                <div x-show="current === index" 
                                     x-transition:enter="transition ease-out duration-700"
                                     x-transition:enter-start="opacity-0 scale-105"
                                     x-transition:enter-end="opacity-100 scale-100"
                                     class="absolute inset-0">
                                    <img :src="slide.src" :alt="slide.alt" class="w-full h-full object-contain rounded-lg">
                                </div>
                            </template>
                        </div>

                        {{-- Setas --}}
                        <button @click="prev()" class="absolute left-4 top-1/2 -translate-y-1/2 bg-black/80 text-cyan-400 p-2 rounded-full border border-cyan-500/30 hover:border-cyan-400 transition-all">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                        </button>
                        <button @click="next()" class="absolute right-4 top-1/2 -translate-y-1/2 bg-black/80 text-cyan-400 p-2 rounded-full border border-cyan-500/30 hover:border-cyan-400 transition-all">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Cinzel:wght@400;700;900&display=swap');
        
        .font-medieval {
            font-family: 'Cinzel', serif;
        }

        /* Melhora o contraste dos textos no fundo escuro */
        .ark-panel p {
            text-shadow: 0 2px 10px rgba(0, 0, 0, 0.9);
        }

        .aspect-video img {
            object-fit: contain;
        }
    </style>

    <script>
        function carousel() {
            return {
                current: 0,
                slides: [
                    { src: "{{ asset('images/Gif_carrossel.gif') }}", alt: "ARK" },
                    { src: "{{ asset('images/Imagem2_carrossel.png') }}", alt: "Cenário" },
                    { src: "{{ asset('images/Imagem3_carrossel.png') }}", alt: "Cenário" },
                    { src: "{{ asset('images/Imagem4_carrossel.png') }}", alt: "Cenário" },
                    { src: "{{ asset('images/Imagem5_carrossel.png') }}", alt: "Cenário" },
                    { src: "{{ asset('images/Imagem6_carrossel.png') }}", alt: "Cenário" },
                    { src: "{{ asset('images/Imagem7_carrossel.png') }}", alt: "Cenário" },
                    { src: "{{ asset('images/Imagem8_carrossel.png') }}", alt: "Cenário" },
                    { src: "{{ asset('images/Imagem9_carrossel.png') }}", alt: "Cenário" },
                    { src: "{{ asset('images/Imagem10_carrossel.png') }}", alt: "Cenário" },
                ],
                init() { setInterval(() => this.next(), 5000); },
                next() { this.current = (this.current + 1) % this.slides.length; },
                prev() { this.current = (this.current - 1 + this.slides.length) % this.slides.length; }
            }
        }
    </script>
</x-app-layout>