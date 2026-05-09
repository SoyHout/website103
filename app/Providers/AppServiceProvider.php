<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\URL;
<<<<<<< HEAD
=======

>>>>>>> 45874bec80604351b66db53d1618b6243c0af111
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
<<<<<<< HEAD
        //Schema::defaultStringLength(191);
	URL::forceScheme('https');
=======
        URL::forceScheme('https');
>>>>>>> 45874bec80604351b66db53d1618b6243c0af111
    }
}
