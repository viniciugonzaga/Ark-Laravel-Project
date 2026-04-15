<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SurvivorPower extends Model
{
    // Define a tabela caso o Laravel não encontre automaticamente 
    // (Opcional, mas seguro se o banco usar snake_case)
    protected $table = 'survivor_powers';

    protected $fillable = [
        'character_id',
        'name',
        'description'
    ];

    /**
     * Relacionamento Inverso: O Poder pertence a uma Ficha (Character)
     */
    public function character(): BelongsTo
    {
        return $this->belongsTo(Character::class);
    }
}