<x-guest-layout>
    <div class="fixed inset-0 -z-10">
        <img src="{{ asset('images/bg_login.jpg') }}" alt="ARK Background" class="w-full h-full object-cover opacity-30">
        <div class="absolute inset-0 bg-black/60"></div>
    </div>

    <div class="ark-panel !p-8 max-w-md mx-auto mt-10 border-t-4 border-cyan-400 shadow-[0_0_30px_rgba(0,242,255,0.3)]">
        <div class="flex justify-center mb-4">
            <img src="{{ asset('images/logo_ark_pequena.png') }}" alt="ARK" class="h-12 w-auto">
        </div>
        <div class="text-center mb-6">
            <h2 class="text-2xl font-medieval font-black uppercase tracking-[0.2em] text-transparent bg-clip-text bg-gradient-to-r from-cyan-200 to-amber-200">
                Confirmação de Segurança
            </h2>
            <p class="text-[10px] text-cyan-400/80 uppercase tracking-widest">Área Protegida</p>
        </div>

        <div class="mb-6 text-sm text-gray-300 text-center leading-relaxed">
            Esta é uma área segura. Confirme sua senha para continuar.
        </div>

        <form method="POST" action="{{ route('password.confirm') }}">
            @csrf

            <div class="mb-6">
                <label class="text-[10px] text-gray-400 uppercase tracking-widest ml-1">Senha Atual</label>
                <input id="password" type="password" name="password" required autocomplete="current-password" class="ark-input">
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <button type="submit" class="ark-btn w-full !py-3 font-bold uppercase tracking-[0.2em]">
                Confirmar
            </button>
        </form>
    </div>
</x-guest-layout>