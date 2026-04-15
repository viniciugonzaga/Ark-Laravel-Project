<x-app-layout>
    <div class="max-w-5xl mx-auto p-6">

        <div class="ark-panel p-10 text-center border border-cyan-500/30 shadow-[0_0_40px_rgba(0,242,255,0.2)]">

            <h1 class="text-3xl font-display font-black text-cyan-400 uppercase tracking-widest mb-6">
                Manual do Sobrevivente
            </h1>

            <p class="text-gray-400 mb-10 text-sm leading-relaxed max-w-2xl mx-auto">
                Este documento contém todas as regras do sistema Ark RPG. 
                Leia com atenção para compreender combate, atributos, mutações e sobrevivência.
            </p>

            <div class="bg-black/50 border border-cyan-500/20 rounded-lg p-6 mb-8">
                <p class="text-xs text-cyan-300 uppercase tracking-wider">
                    Versão do Documento
                </p>
                <p class="text-white font-bold text-lg">
                    ARK RPG - Manual Oficial
                </p>
            </div>

            <a href="{{ route('regras.download') }}"
               class="inline-block bg-cyan-600 hover:bg-cyan-500 px-10 py-4 font-black uppercase tracking-widest text-white rounded shadow-[0_0_20px_rgba(0,242,255,0.3)] transition-all hover:scale-105">
                Baixar Agora
            </a>

        </div>

    </div>
</x-app-layout>