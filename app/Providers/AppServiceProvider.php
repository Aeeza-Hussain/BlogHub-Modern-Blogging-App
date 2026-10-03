<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        require_once app_path('helpers.php');
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        try {
            if (\Illuminate\Support\Facades\Schema::hasTable('settings')) {
                \Illuminate\Support\Facades\View::share('siteSettings', \App\Models\Setting::getAllKeyValues());
            }
        } catch (\Throwable $e) {
            // Ignore during migrations or CLI operations
        }
    }
}
