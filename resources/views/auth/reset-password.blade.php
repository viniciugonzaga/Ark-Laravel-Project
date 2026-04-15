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
                Nova Senha
            </h2>
            <p class="text-[10px] text-cyan-400/80 uppercase tracking-widest">Redefinir Credenciais</p>
        </div>

        <form method="POST" action="{{ route('password.store') }}">
            @csrf
            <input type="hidden" name="token" value="{{ $request->route('token') }}">

            <div class="mb-4">
                <label class="text-[10px] text-gray-400 uppercase tracking-widest ml-1">Email</label>
                <input id="email" type="email" name="email" value="{{ old('email', $request->email) }}" required autofocus class="ark-input">
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <div class="mb-4">
                <label class="text-[10px] text-gray-400 uppercase tracking-widest ml-1">Nova Senha</label>
                <input id="password" type="password" name="password" required class="ark-input">
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <div class="mb-6">
                <label class="text-[10px] text-gray-400 uppercase tracking-widest ml-1">Confirmar Nova Senha</label>
                <input id="password_confirmation" type="password" name="password_confirmation" required class="ark-input">
                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
            </div>

            <button type="submit" class="ark-btn w-full !py-3 font-bold uppercase tracking-[0.2em]">
                Redefinir Senha
            </button>
        </form>
    </div>
</x-guest-layout>