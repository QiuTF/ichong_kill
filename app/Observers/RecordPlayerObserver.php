<?php

namespace App\Observers;

use App\Models\PlayerRecord;
use App\Models\RecordCounts;

class RecordPlayerObserver
{
    /**
     * Handle the player record "created" event.
     *
     * @param  \App\PlayerRecord  $playerRecord
     * @return void
     */
    public function created(PlayerRecord $playerRecord)
    {
        // 赢了
        if ($playerRecord->score <> 0) {
            $recordCounts = RecordCounts::query()->where('player_id', $playerRecord->player_id)->first();
            $recordCounts->fails = 0;
            $recordCounts->increment('wins', 1);

            $recordCounts->save();
        }

         // 输了
         if ($playerRecord->score == 0) {
            $recordCounts = RecordCounts::query()->where('player_id', $playerRecord->player_id)->first();
            $recordCounts->wins = 0;
            $recordCounts->increment('fails', 1);

            $recordCounts->save();
        }
    }

    /**
     * Handle the player record "updated" event.
     *
     * @param  \App\PlayerRecord  $playerRecord
     * @return void
     */
    public function updated(PlayerRecord $playerRecord)
    {
        //
    }

    /**
     * Handle the player record "deleted" event.
     *
     * @param  \App\PlayerRecord  $playerRecord
     * @return void
     */
    public function deleted(PlayerRecord $playerRecord)
    {
        //
    }

    /**
     * Handle the player record "restored" event.
     *
     * @param  \App\PlayerRecord  $playerRecord
     * @return void
     */
    public function restored(PlayerRecord $playerRecord)
    {
        //
    }

    /**
     * Handle the player record "force deleted" event.
     *
     * @param  \App\PlayerRecord  $playerRecord
     * @return void
     */
    public function forceDeleted(PlayerRecord $playerRecord)
    {
        //
    }
}
