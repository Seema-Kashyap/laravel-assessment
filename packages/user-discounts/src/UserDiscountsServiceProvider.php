<?php

namespace Acme\UserDiscounts;

use Illuminate\Support\ServiceProvider;

class UserDiscountsServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/config/user-discounts.php', 'user-discounts');
    }

    public function boot()
    {
        $this->publishes([
            __DIR__.'/config/user-discounts.php' => config_path('user-discounts.php'),
        ], 'config');

        $this->loadMigrationsFrom(__DIR__.'/database/migrations');
    }
}
