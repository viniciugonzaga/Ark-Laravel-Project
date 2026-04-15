<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ritual extends Model
{
    protected $fillable = [
        'character_id',
        'type',
        'name',
        'description'
    ];

    public function character()
    {
        return $this->belongsTo(Character::class);
    }
    
    
}