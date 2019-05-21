<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Formatter\Currency;

class CurrencyServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
//        $this->app->singleton(Currency::class, function ($app) {
//            return new Currency();
//        });
        $this->app->bind('currency', function ($app) {
            return new Currency();
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
