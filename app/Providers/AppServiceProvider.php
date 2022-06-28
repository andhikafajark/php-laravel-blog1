<?php

namespace App\Providers;

use Carbon\Carbon;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(): void
    {
        if ((bool)env('APP_FORCE_HTTPS', false)) {
            URL::forceScheme('https');
        }

        Carbon::setLocale(env('APP_LOCALE', 'en'));
    }
}
