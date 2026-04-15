<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Atributo extends Model
{

public function ficha() {
    return $this->belongsTo(Ficha::class);
}


}
