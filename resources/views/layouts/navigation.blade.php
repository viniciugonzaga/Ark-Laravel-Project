<nav x-data="{ open: false }" class="relative z-50 bg-black border-b border-cyan-500/30 shadow-[0_0_20px_rgba(0,242,255,0.15)] backdrop-blur-sm">
    {{-- Linha de scanner animada na parte inferior --}}
    <div class="absolute bottom-0 left-0 w-full h-[2px] bg-gradient-to-r from-transparent via-cyan-400 to-transparent animate-pulse"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            {{-- Lado Esquerdo: Logo e Links --}}
            <div class="flex">
                {{-- Logo com efeito de glow --}}
                <div class="shrink-0 flex items-center group">
                    <a href="{{ route('home') }}" class="transition-all duration-300 hover:scale-105">
                        <x-application-logo class="block h-9 w-auto fill-current text-cyan-300 drop-shadow-[0_0_2px_rgba(0,242,255,0.8)]" />
                    </a>
                </div>

                {{-- Links de Navegação (Desktop) --}}
                <div class="hidden space-x-1 sm:-my-px sm:ms-10 sm:flex">
                    @php
                        $links = [
                            ['route' => 'home', 'label' => 'Início'],
                            ['route' => 'regras', 'label' => 'Regras'],
                        ];
                        if (auth()->check()) {
                            $links[] = ['route' => 'rolagens', 'label' => 'Rolagens'];
                            $links[] = ['route' => 'fichas.index', 'label' => 'Fichas'];
                        }
                    @endphp

                    @foreach ($links as $link)
                        <x-nav-link 
                            :href="route($link['route'])" 
                            :active="request()->routeIs($link['route'] . '*')" 
                            class="relative px-4 py-3 text-sm font-medium tracking-[0.15em] uppercase transition-all duration-300
                                   {{ request()->routeIs($link['route'] . '*') 
                                      ? 'text-cyan-300 font-bold' 
                                      : 'text-gray-400 hover:text-cyan-300' }}
                                    before:absolute before:bottom-0 before:left-0 before:h-[2px] before:w-full before:origin-left before:scale-x-0 before:bg-gradient-to-r before:from-cyan-400 before:to-blue-500 before:transition-transform before:duration-300 hover:before:scale-x-100"
                        >
                            {{ $link['label'] }}
                            @if(request()->routeIs($link['route'] . '*'))
                                <span class="absolute -bottom-[1px] left-0 w-full h-[2px] bg-gradient-to-r from-cyan-400 to-blue-500 shadow-[0_0_10px_#00f2ff]"></span>
                            @endif
                        </x-nav-link>
                    @endforeach
                </div>
            </div>

            {{-- Lado Direito: Perfil / Login --}}
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                @auth
                    {{-- Dropdown do Usuário com estilo Ark --}}
                    <x-dropdown align="right" width="56">
                        <x-slot name="trigger">
                            <button class="group inline-flex items-center px-4 py-1.5 border rounded-full text-xs font-bold uppercase tracking-wider transition-all duration-300
                                           bg-gradient-to-r from-black/80 to-gray-900/80 
                                           border-cyan-500/40 hover:border-cyan-400
                                           text-gray-300 hover:text-cyan-200
                                           shadow-[0_0_15px_rgba(0,242,255,0.2)] hover:shadow-[0_0_20px_rgba(0,242,255,0.5)]
                                           focus:outline-none">
                                {{-- Avatar --}}
                                <div class="w-8 h-8 rounded-full border border-cyan-500/50 overflow-hidden mr-2 shadow-[0_0_10px_rgba(0,242,255,0.3)] group-hover:border-cyan-400">
                                    @if(Auth::user()->foto)
                                        <img src="{{ asset('storage/' . Auth::user()->foto) }}" class="w-full h-full object-cover">
                                    @else
                                        <div class="w-full h-full bg-gradient-to-br from-cyan-900/50 to-blue-900/50 flex items-center justify-center">
                                            <span class="text-sm text-cyan-300 font-black uppercase drop-shadow-[0_0_5px_#00f2ff]">{{ substr(Auth::user()->name, 0, 1) }}</span>
                                        </div>
                                    @endif
                                </div>
                                
                                <span class="max-w-[120px] truncate">{{ Auth::user()->name }}</span>

                                <div class="ms-2 transition-transform duration-300 group-hover:rotate-180">
                                    <svg class="fill-current h-4 w-4 text-cyan-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            {{-- Dropdown Content - Z-INDEX ALTO AQUI --}}
                            <div class="relative z-[60] bg-gray-950 border border-cyan-500/30 rounded-lg shadow-[0_0_30px_rgba(0,0,0,0.9)] p-1">
                                <x-dropdown-link :href="route('perfil')" class="block px-4 py-2 text-sm text-gray-300 hover:text-cyan-300 hover:bg-cyan-950/30 rounded-md transition-colors duration-200">
                                    <span class="flex items-center">
                                        <svg class="w-4 h-4 mr-2 text-cyan-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                        Meu Perfil
                                    </span>
                                </x-dropdown-link>

                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <x-dropdown-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();" class="block px-4 py-2 text-sm text-red-400 hover:text-red-300 hover:bg-red-950/30 rounded-md transition-colors duration-200">
                                        <span class="flex items-center">
                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                                            Sair da Conta
                                        </span>
                                    </x-dropdown-link>
                                </form>
                            </div>
                        </x-slot>
                    </x-dropdown>
                @else
                    <div class="space-x-4 flex items-center">
                        <a href="{{ route('login') }}" class="relative text-xs uppercase tracking-widest font-bold text-gray-400 hover:text-cyan-300 transition-colors duration-300 after:absolute after:bottom-0 after:left-0 after:h-[1px] after:w-full after:origin-right after:scale-x-0 after:bg-cyan-400 after:transition-transform after:duration-300 hover:after:origin-left hover:after:scale-x-100">
                            Acessar
                        </a>
                        <a href="{{ route('register') }}" class="ark-btn text-[10px] !py-2 !px-5 !text-xs">
                            Criar Sobrevivente
                        </a>
                    </div>
                @endauth
            </div>

            {{-- Menu Mobile (Hamburguer) --}}
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-cyan-400 hover:text-cyan-200 hover:bg-gray-900 focus:outline-none transition duration-150 ease-in-out border border-cyan-500/20 hover:border-cyan-400">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    {{-- Menu Mobile Dropdown --}}
    <div x-show="open" 
         x-transition:enter="transition ease-out duration-200" 
         x-transition:enter-start="opacity-0 scale-95" 
         x-transition:enter-end="opacity-100 scale-100" 
         class="sm:hidden relative z-[60] bg-black/95 backdrop-blur-md border-t border-cyan-500/30">
        <div class="pt-2 pb-3 space-y-1">
            @foreach ($links as $link)
                <x-responsive-nav-link :href="route($link['route'])" :active="request()->routeIs($link['route'] . '*')" class="block px-4 py-3 text-base font-medium text-gray-300 hover:text-cyan-300 border-l-4 {{ request()->routeIs($link['route'] . '*') ? 'border-cyan-400 text-cyan-300' : 'border-transparent' }}">
                    {{ $link['label'] }}
                </x-responsive-nav-link>
            @endforeach
        </div>

        <div class="pt-4 pb-1 border-t border-cyan-500/20">
            @auth
                <div class="flex items-center px-4">
                    <div class="w-10 h-10 rounded-full border border-cyan-500/50 overflow-hidden">
                         @if(Auth::user()->foto)
                            <img src="{{ asset('storage/' . Auth::user()->foto) }}" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full bg-cyan-900/50 flex items-center justify-center">
                                <span class="text-cyan-300 font-black uppercase">{{ substr(Auth::user()->name, 0, 1) }}</span>
                            </div>
                        @endif
                    </div>
                    <div class="ml-3">
                        <div class="text-base font-medium text-white">{{ Auth::user()->name }}</div>
                        <div class="text-sm font-medium text-cyan-400/80">{{ Auth::user()->email }}</div>
                    </div>
                </div>
                <div class="mt-3 space-y-1">
                    <x-responsive-nav-link :href="route('perfil')" class="text-gray-300">Meu Perfil</x-responsive-nav-link>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <x-responsive-nav-link :href="route('logout')" onclick="event.preventDefault(); this.closest('form').submit();" class="text-red-400">
                            Sair da Conta
                        </x-responsive-nav-link>
                    </form>
                </div>
            @endauth
        </div>
    </div>
</nav>