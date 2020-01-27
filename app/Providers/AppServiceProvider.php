<?php

namespace App\Providers;

use App\Models\Shop;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use App\Observers\ShopObserver;
use Validator;

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
        Validator::extend('checkzero', function($attribute, $value, $parameters, $validator) {
            $collection = collect($value)->firstWhere('buy', '<=' ,0);
            if(!is_null($collection)){
                return false;
            }
            return true;
        });

        Shop::observe(ShopObserver::class);
        Schema::defaultStringLength(191);
    }
}
