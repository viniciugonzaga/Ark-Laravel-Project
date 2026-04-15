<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CharacterController; 
use App\Http\Controllers\RolagemController;
use App\Http\Controllers\RegraController;
use App\Http\Controllers\PerfilController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RollController; 

/*
|--------------------------------------------------------------------------
| 1. ROTAS PÚBLICAS
|--------------------------------------------------------------------------
*/
Route::get('/regras/download', [RegraController::class, 'download'])->name('regras.download');
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/regras', [RegraController::class, 'index'])->name('regras');
// No seu routes/web.php

/*
|--------------------------------------------------------------------------
| 2. ÁREA RESTRITA (SISTEMA DE RPG)
|--------------------------------------------------------------------------
*/

// Adicione este redirecionamento ou renomeie a rota para evitar o erro de RouteNotFound
Route::get('/dashboard', function () {
    return redirect()->route('home');
})->name('dashboard');

Route::middleware(['auth'])->group(function () {
    
    // Tela de Perfil Customizada (Sobrevivente)
    Route::get('/perfil', [PerfilController::class, 'index'])->name('perfil');


    Route::resource('fichas', CharacterController::class);

   // Sistema de Rolagem de Dados e Eventos (NOVA IMPLEMENTAÇÃO)
    Route::middleware(['auth'])->group(function () {
    // Definimos o nome como 'rolagens' para resolver o erro do seu menu
    Route::get('/rolagens', [RollController::class, 'index'])->name('rolagens');
    
    // Rotas auxiliares para o funcionamento do JS
    Route::get('/rolagens/char/{id}', [RollController::class, 'loadCharacter'])->name('rolagens.load');
    Route::post('/rolagens/save', [RollController::class, 'saveRoll'])->name('rolagens.save');
});
    // Rotas de Manutenção de Conta (Breeze Original)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
});

require __DIR__.'/auth.php';