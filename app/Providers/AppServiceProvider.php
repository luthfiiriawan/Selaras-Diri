<?php

namespace App\Providers;

use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Di belakang proxy Vercel, TLS di-terminate di edge sehingga Laravel
        // mengira request HTTP. Paksa skema https di produksi agar asset()/url()
        // tidak menghasilkan link http:// (mixed-content).
        if ($this->app->environment('production')) {
            URL::forceScheme('https');
        }
    }
}
