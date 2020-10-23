<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Player;

class PlayerRecord extends Model
{
    //
    protected $table = 'record_player';

    public function player()
    {
        return $this->belongsTo(Player::class, 'player_id', 'id');
    }

    public function getCreatedAtAttribute($value)
    {
        return date('Y-m-d H:i:s', strtotime($value));
    }

    public function getRoleTypeAttribute($value)
    {
        return [1=>'坏人',2=>'好人'][$value];
    }
}
