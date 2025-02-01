<?php

namespace App\Providers;

use App\Models\MyApplication;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class ConfigServiceProvider extends ServiceProvider
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
        if (Schema::hasTable('my_applications')) {
            config([
                'configs' => MyApplication::all([
                    'key', 'value'
                ])
                    ->keyBy('key')
                    ->transform(function ($setting) {
                        return $setting->value;
                    })
                    ->toArray()
            ]);
        }
    }
}
