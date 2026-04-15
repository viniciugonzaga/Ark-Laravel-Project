<?php

namespace App\Http\Controllers;

use App\Models\Character;
use App\Models\RollLog;
use Illuminate\Http\Request;

class RollController extends Controller
{
    public function index() {
        // Puxa apenas as fichas do usuário logado
        $characters = Character::where('user_id', auth()->id())->get();
        return view('roll.index', compact('characters'));
    }

    public function loadCharacter($id)
  {
    // O SEGREDO ESTÁ NO "WITH": ele traz as tabelas filhas junto
    $char = Character::with(['mutations', 'bonuses'])
        ->where('user_id', auth()->id())
        ->findOrFail($id);

    // Busca a última rolagem registrada
    $lastRoll = \App\Models\RollLog::where('character_id', $id)
        ->where('user_id', auth()->id())
        ->latest()
        ->first();

    return response()->json([
        'char' => $char,
        'lastRoll' => $lastRoll
    ]);
  }

    public function saveRoll(Request $request) {
        RollLog::updateOrCreate(
            ['character_id' => $request->character_id, 'user_id' => auth()->id()],
            ['dice_result' => $request->dice_result, 'event_result' => $request->event_result]
        );
        return response()->json(['status' => 'Sincronizado']);
    }
}