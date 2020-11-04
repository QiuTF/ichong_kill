<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Player;
use App\Models\Role;

class RewardUse extends Model
{
    //
    protected $table = 'reward_use';

    public function getCreatedAtAttribute($value)
    {
        return date('Y-m-d H:i:s', strtotime($value));
    }

    public function player()
    {
        return $this->belongsTo(Player::class, 'player_id', 'id');
    }

    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id', 'id');
    }
}
