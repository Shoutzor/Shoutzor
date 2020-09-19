<?php

namespace App\Packages;

use App\Autoload\ClassMapGenerator;
use \Exception;
use Facade\Ignition\Support\Packagist\Package;
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
     * the classMap array used by the autoloader
     * @var array
     */
    private array $classMap = [];

    /**
     * Create a new package manager instance.
     *
     * @param Application $app
     * @return void
     */
    public function __construct(Application $app) {
        $this->app      = $app;
        $pkgsClassmap   = storage_path('app/packages_classmap.php');

        // Check if a classmap file exists
        if(file_exists($pkgsClassmap)) {
            $this->classMap = include $pkgsClassmap;
        }

        //Register our autoloader method for package files
        spl_autoload_register([$this, 'loadClass'], true, false);
    }

    /**
     * Autoloader method for loading class files from packages
     *
     * @param string $class the class to load
     */
    public function loadClass(string $class) : void {
        if(array_key_exists($this->classMap, $class)) {
            include $this->classMap[$class];
        }
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
     * Creates the PackageLoader instance from the provided package.
     * This does not activate the package yet.
     *
     * @param string $pkg the path to the shoutzor.package file
     * @return PackageLoader the instance of the package's PackageLoader class
     */
    protected function getPackageInstance(string $pkg) : PackageLoader {
        $path = explode(dirname($pkg), "/");
        $cnt = count($path);

        $namespace = $path[$cnt - 2] . '\\' . $path[$cnt - 1] . '\\PackageLoader';

        if(class_exists($namespace) === false) {
            //TODO implement exception (and handling of the exception)
            echo "couldn't find class, error in autoloader?";
        }

        return new $namespace();
    }

    /**
     * Finds and returns an array of all valid packages that are installed.
     * This method does not check whether packages are enabled or not.
     *
     * @return array
     */
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
     * Updates the autoloader classmap when called.
     * This should only be called when packages are installed, removed, or updated.
     */
    public function updateAutoloader() : void {
        ClassMapGenerator::generate(base_path('packages'), storage_path('app/packages_classmap.php'));
    }
}
