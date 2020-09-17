<?php

namespace App\Providers;

use App\Packages\PackageManager;
use Illuminate\Support\ServiceProvider;

class PackagesServiceProvider extends ServiceProvider
{
    private PackageManager $pm;

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //Register our PackageManager
        $this->pm = new PackageManager($this->app);
        $this->app->instance(PackageManager::class, $this->pm);

        //Load all installed packages, this does not initialize them yet
        $this->pm->loadPackages();
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //Register all enabled packages
        $this->pm->registerEnabledPackages();
    }
}
