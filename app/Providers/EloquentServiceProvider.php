<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Shop;
use App\Observers\ShopObserver;
class EloquentServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        /*\Log::info('EloquentServiceProvider');
        Shop::observe(ShopObserver::class);*/
    }
}
