<x-guest-layout>
    {{-- Fundo opcional: imagem temática apagada --}}
    <div class="fixed inset-0 -z-10">
        <img src="{{ asset('images/bg_register.jpg') }}" alt="ARK Background" class="w-full h-full object-cover opacity-30">
        <div class="absolute inset-0 bg-black/60"></div>
    </div>

    <div class="ark-panel !p-8 max-w-md mx-auto mt-10 border-t-4 border-cyan-400 shadow-[0_0_30px_rgba(0,242,255,0.3)]">
        {{-- Logo ARK centralizado --}}
        <div class="flex justify-center mb-4">
            <img src="{{ asset('images/logo_ark_pequena.png') }}" alt="ARK" class="h-12 w-auto">
        </div>
        <div class="text-center mb-8">
            <h2 class="text-2xl font-medieval font-black uppercase tracking-[0.2em] text-transparent bg-clip-text bg-gradient-to-r from-cyan-200 to-amber-200">
                Criação de Conta
            </h2>
            <p class="text-[10px] text-cyan-400/80 tracking-widest mt-1 uppercase">Registro de Sobrevivente</p>
        </div>

        <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data">
            @csrf

            {{-- Avatar Preview --}}
            <div class="mb-6">
                <label class="text-[10px] text-gray-400 uppercase tracking-widest ml-1 block mb-2 text-center">Registro Visual (Foto)</label>
                <div class="flex justify-center mb-4">
                    <div class="w-24 h-24 bg-black/50 border-2 border-cyan-500/40 rounded-full overflow-hidden flex items-center justify-center relative shadow-[0_0_15px_rgba(0,242,255,0.2)]">
                        <img id="img_preview" class="w-full h-full object-cover hidden">
                        <div id="img_placeholder" class="text-cyan-600">
                            <svg class="w-12 h-12" fill="currentColor" viewBox="0 0 20 20"><path d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"></path></svg>
                        </div>
                    </div>
                </div>
                <input type="file" name="foto" id="foto_input" accept="image/*"
                    class="block w-full text-[10px] text-gray-400 file:mr-4 file:py-1 file:px-4 file:rounded-sm file:border-0 file:text-[10px] file:font-semibold file:bg-cyan-700 file:text-white hover:file:bg-cyan-600 transition-all cursor-pointer">
                <x-input-error :messages="$errors->get('foto')" class="mt-2" />
            </div>

            {{-- Nome --}}
            <div class="mb-4">
                <label class="text-[10px] text-gray-400 uppercase tracking-widest ml-1">Nome</label>
                <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus 
                    class="ark-input">
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>

            {{-- Email --}}
            <div class="mb-4">
                <label class="text-[10px] text-gray-400 uppercase tracking-widest ml-1">Email</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}" required 
                    class="ark-input">
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            {{-- Cargo --}}
            <div class="mb-4">
                <label class="text-[10px] text-gray-400 uppercase tracking-widest ml-1">Atribuição de Usuário (Cargo)</label>
                <select name="cargo" required class="ark-input">
                    <option value="jogador" class="bg-black text-white">Sobrevivente (Jogador)</option>
                    <option value="mestre" class="bg-black text-white">Mestre (Mestre)</option>
                </select>
            </div>

            {{-- Senha --}}
            <div class="mb-4">
                <label class="text-[10px] text-gray-400 uppercase tracking-widest ml-1">Senha</label>
                <input id="password" type="password" name="password" required class="ark-input">
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            {{-- Confirmar Senha --}}
            <div class="mb-6">
                <label class="text-[10px] text-gray-400 uppercase tracking-widest ml-1">Confirmar Senha</label>
                <input id="password_confirmation" type="password" name="password_confirmation" required class="ark-input">
            </div>

            <div class="flex items-center justify-between">
                <a class="text-[10px] text-gray-400 hover:text-cyan-300 uppercase tracking-tighter transition" href="{{ route('login') }}">
                    Possuo registro prévio
                </a>
                <button type="submit" class="ark-btn !py-2 !px-6 !text-xs">
                    Criar Cadastro
                </button>
            </div>
        </form>
    </div>

    <script>
        document.getElementById('foto_input').onchange = evt => {
            const [file] = evt.target.files
            if (file) {
                const preview = document.getElementById('img_preview');
                const placeholder = document.getElementById('img_placeholder');
                preview.src = URL.createObjectURL(file);
                preview.classList.remove('hidden');
                placeholder.classList.add('hidden');
            }
        }
    </script>
</x-guest-layout>