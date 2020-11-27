<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Observers\RewardUseObserver;
use App\Models\RewardUse;
use App\Observers\RecordPlayerObserver;
use App\Models\PlayerRecord;
use App\Observers\PlayerObserver;
use App\Models\Player;

class AppServiceProvider extends ServiceProvider
{

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
        RewardUse::observe(RewardUseObserver::class);
        PlayerRecord::observe(RecordPlayerObserver::class);
        Player::observe(PlayerObserver::class);
    }
}
