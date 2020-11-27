<?php

namespace App\Observers;

use App\Models\Player;
use App\Models\RecordCounts;

class PlayerObserver
{

    /**
     * Handle the player "created" event.
     *
     * @param \App\player $player
     *
     * @return void
     */
    public function created(Player $player)
    {
        //
        $recordCounts = new RecordCounts();
        $recordCounts->player_id = $player->id;
        $recordCounts->wins = 0;
        $recordCounts->fails = 0;
        $recordCounts->save();
    }
}
