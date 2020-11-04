<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Observers\RewardUseObserver;
use App\Models\RewardUse;

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
    }
}
