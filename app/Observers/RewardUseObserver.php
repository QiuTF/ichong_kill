<?php

namespace App\Observers;

use App\Models\RewardUse;
use App\Models\Reward;

class RewardUseObserver
{
    /**
     * Handle the reward use "created" event.
     *
     * @param  \App\RewardUse  $rewardUse
     * @return void
     */
    public function created(RewardUse $rewardUse)
    {
        //
        $reward = Reward::query()->where('player_id', $rewardUse->player_id)->first();
        $reward->decrement('amount', 1);
        $reward->save();
    }

    /**
     * Handle the reward use "updated" event.
     *
     * @param  \App\RewardUse  $rewardUse
     * @return void
     */
    public function updated(RewardUse $rewardUse)
    {
        //
    }

    /**
     * Handle the reward use "deleted" event.
     *
     * @param  \App\RewardUse  $rewardUse
     * @return void
     */
    public function deleted(RewardUse $rewardUse)
    {
        //
        $reward = Reward::query()->where('player_id', $rewardUse->player_id)->first();
        $reward->increment('amount', 1);
        $reward->save();
    }

    /**
     * Handle the reward use "restored" event.
     *
     * @param  \App\RewardUse  $rewardUse
     * @return void
     */
    public function restored(RewardUse $rewardUse)
    {
        //
    }

    /**
     * Handle the reward use "force deleted" event.
     *
     * @param  \App\RewardUse  $rewardUse
     * @return void
     */
    public function forceDeleted(RewardUse $rewardUse)
    {
        //
    }
}
