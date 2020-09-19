<?php

namespace App\Packages;

use App\Autoload\ClassMapGenerator;
use \Exception;
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
     * @param  string  $pkg
     * @return boolean
     */
    public function checkPackage(string $pkg) : bool {
        //Decode the json shoutzor.package file
        $pkgData = json_decode($pkg);

        //Validate that the name, version and namespace fields exist
        //These are the minimum required fields for a Shoutz0r package
        if(
            array_key_exists("name", $pkgData) &&
            array_key_exists("version", $pkgData) &&
            array_key_exists("namespace", $pkgData)
        ) {
            //Package is valid
            return true;
        }

        //Package is invalid
        return false;
    }

    /**
     * Creates the PackageLoader instance from the provided package
     */
    protected function getPackageInstance(string $pkg) : PackageLoader {

    }

    /**
     * Loads the packages that are installed, this does not register them in the laravel app yet
     * TODO handle (soft/hard) dependencies
     */
    public function loadEnabledPackages() : void
    {
        $autoloadPkgs = include(storage_path('app/autoload_packages.php'));

        foreach($autoloadPkgs as $pkgClass) {
            try {
                //Instantiate the autoloaded package
                $pkg = new $pkgClass($this->app);

                //Call the onLoad method to activate the package
                $pkg->onLoad();

                //Add the package to our internal registry of loaded packages
                $this->packages[] = $pkg;
            } catch(Exception $e) {
                //Catch any potential errors from a package
                echo "error";
            }
        }
    }

    public function fetchPackages() : array {
        $pkg_root_path  = base_path('packages');
        $pkg_pattern    = $pkg_root_path . '*/*/shoutzor.package';

        $pkgs = [];

        //Check all installed packages
        foreach(glob($pkg_pattern) as $pkg) {
            //Validate the package
            if($this->checkPackage($pkg) === true) {
                //Get the instance from the package's PackageLoader and add it to the resultset
                $pkgs[] = $this->getPackageInstance($pkg);
            } else {
                //Log an error about the package being invalid
                echo "pkg invalid";
            }
        }

        return $pkgs;
    }

    /**
     * Activate the packages marked as "enabled", in the laravel app
     */
    public function activateEnabledPackages() : void {
        //Loop over all registered packages
        foreach($this->packages as $name=>$pkg) {

            //Check if the package is enabled
            if($pkg->enabled === true) {

                //Call the onEnable method from the package
                $pkg->onEnable();
            }
        }
    }

    /**
     * Updates the autoloader classmap
     */
    public function updateAutoloader() {
        ClassMapGenerator::generate(base_path('packages'), storage_path('app/autoload_packages.php'));
    }
}
