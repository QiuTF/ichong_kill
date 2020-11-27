<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Reward;
use App\Models\RecordCounts;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Player extends Authenticatable
{
    //
    protected $table = 'player';

    protected $fillable = [
        'player', 'password', 'avatar', 'introduction'
    ];

    public function getCreatedAtAttribute($value)
    {
        return date('Y-m-d H:i:s', strtotime($value));
    }

    public function reward()
    {
        return $this->hasOne(Reward::class, 'player_id', 'id');
    }

  
}
