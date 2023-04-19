<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class ServiceClassProvider extends ServiceProvider
{
    /**
     * 実装クラス, Interface共通のPrefix
     * @var Array
     */
    private const PREFIXES = [
        'AdminCsv',
    ];

    /**
     * Register services.
     */
    public function register(): void
    {
        foreach (self::PREFIXES as $prefix) {
            $this->app->bind(
                "App\Services\Interfaces\\{$prefix}ServiceInterface",
                "App\Services\\{$prefix}Service"
            );
        }
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}