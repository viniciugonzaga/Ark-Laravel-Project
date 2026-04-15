<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PerfilController extends Controller
{
   public function index()
{
    // Pegamos o usuário logado e as fichas dele
    $user = auth()->user();
    $fichas = $user->fichas; 

    // Enviamos para a view com os nomes exatos que ela espera
    return view('perfil', compact('user', 'fichas'));
}

public function update(Request $request)
{
    $user = auth()->user();
    $user->update($request->only('name', 'email'));
    
    return back()->with('status', 'Bio-dados atualizados com sucesso.');
}
}