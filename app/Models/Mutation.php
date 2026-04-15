<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Mutation extends Model
{
    protected $fillable = [
        'character_id',
        'origin',
        'name',
        'description'
    ];

    public function character()
    {
        return $this->belongsTo(Character::class);
    }
}