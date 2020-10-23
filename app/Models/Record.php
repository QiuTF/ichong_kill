<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\player;

class Record extends Model
{
    //
    protected $table = 'record';

    public function player()
    {
        return $this->hasOne(player::class, 'id', 'mvp_id');
    }

    public function getCreatedAtAttribute($value)
    {
        return date('Y-m-d H:i:s', strtotime($value));
    }

   
}
