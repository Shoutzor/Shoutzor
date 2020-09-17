<?php

namespace App\Packages;

use \Illuminate\Contracts\Foundation\Application;

/**
 * The PackageManager handles the loading and registering of all Shoutz0r packages
 *
 * Class PackageManager
 * @package App\Packages
 */
class PackageManager {

    /**
     * The application instance.
     *
     * @var Application
     */
    private Application $app;

    /**
     * The internal package registry
     *
     * @var array
     */
    private array $packages = [];

    /**
     * Create a new package manager instance.
     *
     * @param Application $app
     * @return void
     */
    public function __construct(Application $app) {
        $this->app = $app;
    }

    /**
     * Create a new package manager instance.
     *
     * @param  string  $path
     * @return boolean
     */
    public function checkPackage(string $path) : bool {

    }

    /**
     * Creates the PackageLoader instance from the provided package
     */
    protected function loadPackage(string $path) : PackageLoader {



    }

    /**
     * Loads the packages that are installed, this does not register them in the laravel app yet
     * TODO handle (soft/hard) dependencies
     */
    public function loadPackages() : void {
        $pkg_root_path  = base_path('packages');
        $pkg_pattern    = $pkg_root_path . '*/*/shoutzor.package';

        //Check all installed packages
        foreach(glob($pkg_pattern) as $pkg) {
            //Location of the package
            $pkg_path = dirname($pkg);

            //Validate the package
            if($this->checkPackage($pkg_path) === true) {
                //Get the instance from the package's PackageLoader
                $p = $this->loadPackage($pkg_path);

                //Add the package to the internal registry
                $this->packages[$p->getName()] = (object) [
                    'enabled' => $p->getEnabled(),
                    'loader' => $p
                ];
            } else {
                //Log an error about the package being invalid
            }
        }
    }

    /**
     * Registers the packages marked as "enabled" in the laravel app
     */
    public function registerEnabledPackages() : void {
        //Loop over all registered packages
        foreach($this->packages as $name=>$pkg) {

            //Check if the package is enabled
            if($pkg->enabled === true) {

                //Call the onEnable method from the package
                $pkg->onEnable();
            }
        }
    }

}
