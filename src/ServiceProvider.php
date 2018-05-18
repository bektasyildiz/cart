<?php

namespace Bektas\Cart;

class ServiceProvider extends \Illuminate\Support\ServiceProvider
{
    const CONFIG_PATH = __DIR__ . '/../config/cart.php';

    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../database/migrations' => $this->app->databasePath() . '/migrations'
        ], 'migrations');

        $this->publishes([
            self::CONFIG_PATH => config_path('cart.php'),
        ], 'config');
    }

    public function register()
    {
        $this->mergeConfigFrom(
            self::CONFIG_PATH,
            'cart'
        );

        $this->app->bind('cart', function () {
            return new Cart();
        });
    }
}
