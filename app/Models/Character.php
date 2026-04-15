<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Character extends Model
{
    protected $table = 'fichas'; 

    protected $fillable = [
        'user_id', 'name', 'image', 'level', 'age', 
        'class_main', 'class_sub', 'lore', 'arsenal',
        'agi', 'for', 'int', 'set', 'vig',
        'vida', 'armadura', 'determinacao', 'folego', 
        'resistencia' 
    ];

   // Relacionamentos
    public function user(): BelongsTo { return $this->belongsTo(User::class); }
    public function lastRoll(): HasOne { return $this->hasOne(RollLog::class, 'character_id'); }
    
    // IMPORTANTE: Garantir que as relações existam
    public function mutations(): HasMany { return $this->hasMany(Mutation::class, 'character_id'); }
    public function bonuses(): HasMany { return $this->hasMany(Bonus::class, 'character_id'); }
    public function survivorPowers(): HasMany { return $this->hasMany(SurvivorPower::class, 'character_id'); }
    public function rituals(): HasMany { return $this->hasMany(Ritual::class, 'character_id'); }

   // Garante que se chamar $ficha->mutations e não houver nada, retorne [] em vez de null
public function getMutationsAttribute()
{
    return $this->getRelationValue('mutations') ?? collect();
}

public function getBonusesAttribute()
{
    return $this->getRelationValue('bonuses') ?? collect();
}

public function getSurvivorPowersAttribute()
{
    return $this->getRelationValue('survivorPowers') ?? collect();
}

public function getRitualsAttribute()
{
    return $this->getRelationValue('rituals') ?? collect();
}
}