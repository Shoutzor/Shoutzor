<?php

namespace App\Providers;

use App\Packages\PackageManager;
use Illuminate\Support\ServiceProvider;

class PackagesServiceProvider extends ServiceProvider {
    private PackageManager $pm;

    /**
     * Load the packagemanager and the registered packages.
     *
     * @return void
     */
    public function register() {
        //Register our PackageManager
        $this->pm = new PackageManager($this->app);
        $this->app->instance(PackageManager::class, $this->pm);

        //Load all installed packages, this does not activate them yet
        $this->pm->loadPackages();
    }

    /**
     * Load enabled packages.
     *
     * @return void
     */
    public function boot() {
        //Activate all enabled packages
        $this->pm->registerEnabledPackages();
    }
}
