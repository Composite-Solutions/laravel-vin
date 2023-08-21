<?php

namespace Composite\LaravelVin;

use Illuminate\Support\ServiceProvider;

class VinServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind('vin', static function () {
            return new Vin();
        });

        $this->app->alias('vin', Vin::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
