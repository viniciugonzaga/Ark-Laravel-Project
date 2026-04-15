<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rolagem extends Model
{
    
    protected $fillable = ['ficha_id', 'dados', 'evento'];

    
    protected $casts = [
        'dados' => 'array',
    ];

    // Relacionamento inverso
    public function ficha()
    {
        return $this->belongsTo(Ficha::class);
    }
}