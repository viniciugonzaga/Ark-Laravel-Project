<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RollLog extends Model
{
    protected $fillable = ['user_id', 'character_id', 'dice_result', 'event_result'];
    protected $casts = ['dice_result' => 'array'];

    public function ficha() {
        return $this->belongsTo(Ficha::class, 'character_id');
    }
}