<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->register('Shoutz0r\AcoustId\PackageServiceProvider');
        $this->app->register('Shoutz0r\LastFM\PackageServiceProvider');
    }
}
