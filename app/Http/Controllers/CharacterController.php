<?php

namespace App\Http\Controllers;

use App\Models\Character;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class CharacterController extends Controller
{
    public function index()
    {
        $characters = Auth::user()->characters()->latest()->get();
        return view('fichas.index', compact('characters'));
    }

    public function create()
    {
        return view('fichas.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'level' => 'required|integer|min:1',
            'age' => 'nullable|integer',
            'class_main' => 'required|string',
            'class_sub' => 'nullable|string',
            'custom_class_name' => 'nullable|string|max:255',
            'lore' => 'nullable|string',
            'arsenal' => 'nullable|string',
            'agi' => 'required|integer|min:0',
            'for' => 'required|integer|min:0',
            'int' => 'required|integer|min:0',
            'set' => 'required|integer|min:0',
            'vig' => 'required|integer|min:0',
            'vida' => 'nullable|integer',
            'armadura' => 'nullable|integer',
            'determinacao' => 'nullable|integer',
            'folego' => 'nullable|integer',
            'resistencia' => 'nullable|integer',
        ]);

        if ($request->class_sub === 'nova' && $request->filled('custom_class_name')) {
            $data['class_sub'] = $request->custom_class_name;
        }

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('characters', 'public');
        }

        $data['user_id'] = Auth::id();
        $character = Character::create($data);

        $this->syncRelations($character, $request);

        return redirect()->route('fichas.show', $character->id)->with('success', 'Unidade Registrada.');
    }

    /**
     * MÉTODO SHOW - Resolve o erro de "Undefined Method"
     */
    public function show($id)
    {
        $ficha = Character::with(['mutations', 'bonuses', 'survivorPowers', 'rituals'])
                          ->findOrFail($id);

        // Bloqueia se a ficha não for do usuário logado
        if ($ficha->user_id !== Auth::id()) abort(403, 'Acesso negado ao DNA.');

        return view('fichas.show', compact('ficha'));
    }

    public function edit($id)
    {
        $ficha = Character::with(['mutations', 'bonuses', 'survivorPowers', 'rituals'])
                          ->findOrFail($id);

        // Bloqueia se a ficha não for do usuário logado
        if ($ficha->user_id !== Auth::id()) abort(403);

        return view('fichas.edit', compact('ficha'));
    }

    public function update(Request $request, $id)
    {
        $ficha = Character::findOrFail($id);
        
        if ($ficha->user_id !== Auth::id()) abort(403);

        // Validamos os dados básicos
        $data = $request->except(['mutations', 'bonuses', 'powers', 'rituals', 'image']);

        if ($request->hasFile('image')) {
            if ($ficha->image) Storage::disk('public')->delete($ficha->image);
            $data['image'] = $request->file('image')->store('characters', 'public');
        }

        $ficha->update($data);

        // Sincronização limpa (Remove antigos e insere novos)
        $ficha->mutations()->delete();
        $ficha->bonuses()->delete();
        $ficha->survivorPowers()->delete();
        $ficha->rituals()->delete();

        $this->syncRelations($ficha, $request);

        return redirect()->route('fichas.show', $ficha->id)->with('success', 'DNA Reconfigurado.');
    }

    private function syncRelations(Character $character, Request $request)
    {
        // Mutações
        if ($request->has('mutations') && is_array($request->mutations)) {
            foreach ($request->mutations as $mut) {
                if (!empty($mut['name'])) {
                    $character->mutations()->create($mut);
                }
            }
        }

        // Bônus
        if ($request->has('bonuses') && is_array($request->bonuses)) {
            foreach ($request->bonuses as $bonus) {
                if (!empty($bonus['name'])) {
                    $character->bonuses()->create($bonus);
                }
            }
        }

        // Rituais
        if ($request->has('rituals') && is_array($request->rituals)) {
            foreach ($request->rituals as $ritual) {
                if (!empty($ritual['name'])) {
                    $character->rituals()->create($ritual);
                }
            }
        }

        // Poderes (Mapeado de 'powers' no formulário para 'survivorPowers' no model)
        if ($request->has('powers') && is_array($request->powers)) {
            foreach ($request->powers as $power) {
                if (!empty($power['name'])) {
                    $character->survivorPowers()->create($power);
                }
            }
        }
    }
}