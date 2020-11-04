<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Reward;

class Player extends Model
{
    //
    protected $table = 'player';

    public function getCreatedAtAttribute($value)
    {
        return date('Y-m-d H:i:s', strtotime($value));
    }

    public function reward()
    {
        return $this->hasOne(Reward::class, 'player_id', 'id');
    }
}
