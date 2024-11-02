<?php

namespace DarksLight2\BetsApiSDK\Providers;

use Illuminate\Support\ServiceProvider;

class BetsApiSDKServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../config/betsapi-sdk.php', 'betsapi-sdk');
    }

    public function boot(): void
    {
        $this->publishes([
            __DIR__.'/../config/betsapi-sdk.php' => config_path('betsapi-sdk.php'),
        ], 'betsapi-sdk-config');
    }
}
