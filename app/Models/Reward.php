<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Player;

class Reward extends Model
{
    //
    protected $table = 'reward';

    public function player()
    {
        return $this->belongsTo(Player::class, 'player_id', 'id');
    }

    public function getTypeAttribute($value)
    {
        return $value == 1 ? '身份使用':'其它';
    }
}
