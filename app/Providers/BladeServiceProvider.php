<?php

namespace App\Providers;

use App\Facades\Agent;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class BladeServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        Blade::if('isMobile', function () {
            return Agent::userAgent()->isMobile();
        });

        Blade::directive('elseMobile', function () {
            return '<?php else: ?>';
        });

        Blade::directive('endIsMobile', function () {
            return '<?php endif; ?>';
        });
    }
}
