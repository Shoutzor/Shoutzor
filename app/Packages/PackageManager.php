<?php

namespace App\Packages;

use App\Autoload\ClassMapGenerator;
use App\Helpers\Filesystem;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\Facades\Log;

/**
 * The PackageManager handles the loading and registering of all Shoutz0r packages
 *
 * Class PackageManager
 *
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
     * array format: [shoutzor.package filepath] => packageLoaderInstance
     *
     * @var array
     */
    private array $packages = [];

    /**
     * The internal package registry of loaded packages
     * array format: [packageId] => packageLoader_Class_FQDN
     *
     * @var array
     */
    private array $enabledPackages = [];

    /**
     * the classMap array used by the autoloader
     * array format: [class_FQDN] => filepath
     *
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
        $this->app = $app;
        $pkgsClassmap = storage_path('app/packages_classmap.php');
        $pkgsEnabled = storage_path('app/packages_enabled.php');

        // Check if a classmap file exists
        if(file_exists($pkgsClassmap)) {
            $this->classMap = include $pkgsClassmap;
        }

        // Check if the file for enabled packages exists
        if(file_exists($pkgsEnabled)) {
            $this->enabledPackages = include $pkgsEnabled;
        }

        //Register our autoloader method for package files
        spl_autoload_register([$this, 'loadClass'], true, false);
    }

    /**
     * Autoloader method for loading class files from packages
     *
     * @param string $class the class to load
     */
    public function loadClass(string $class): void {
        if(array_key_exists($class, $this->classMap)) {
            include $this->classMap[$class];
        }
    }

    /**
     * Activate the packages marked as "enabled", in the laravel app
     */
    public function activateEnabledPackages(): void {
        //Loop over all enabled packages
        foreach($this->enabledPackages as $pkgClass) {
            //Create the package instance
            $pkg = $this->getPackageInstance($pkgClass, true);

            //Call the onLoad method from the package
            $pkg->onLoad();
        }
    }

    /**
     * Creates the PackageLoader instance from the provided package.
     * This does not activate the package yet.
     *
     * @param string $pkg     the path to the shoutzor.package file
     * @param bool   $isClass if true, assumes $pkg contains the package FQCN
     * @return PackageLoader the instance of the package's PackageLoader class
     * @throws Exception
     */
    protected function getPackageInstance(string $pkg, bool $isClass = false): PackageLoader {
        $pkgPath = dirname($pkg);

        //If $pkg contains the namespace already, $isClass will be set to True
        if($isClass === false) {
            $path = explode("/", $pkgPath);
            $cnt = count($path);

            $pkg = $path[$cnt - 2] . '\\' . $path[$cnt - 1] . '\\Main';
        }

        //Check if the package already exists in our registry
        if(array_key_exists($pkg, $this->packages)) {
            return $this->packages[$pkg];
        }

        //Check if the class exists before attempting to create an instance of it.
        if(class_exists($pkg) === false) {
            //TODO implement exception (and handling of the exception)
            throw new Exception("could not find PackageLoader class");
        }

        //Create the package instance
        $pkgInstance = new $pkg($this->app, $pkgPath);

        //Register the package in our registry
        $this->packages[$pkg] = $pkgInstance;

        //Return the package instance
        return $pkgInstance;
    }

    /**
     * Updates the autoloader classmap when called.
     * This should only be called when packages are installed, removed, or updated.
     *
     * @TODO Until a proper marketplace / online interface is added to install / uninstall plugins, this should pretty
     * much be called with any interaction.
     */
    public function updateClassmap(): void {
        ClassMapGenerator::generate(base_path('packages'), storage_path('app/packages_classmap.php'));
    }

    /**
     * Checks if the provided package is enabled or not
     *
     * @param PackageLoader $package
     * @return bool
     */
    public function isEnabled(PackageLoader $package): bool {
        if(array_key_exists($package->getId(), $this->enabledPackages)) {
            return true;
        }

        return false;
    }

    /**
     * Enables a package
     * Do not forget to call updateEnabledPackagesList to make this permanent
     *
     * @param PackageLoader $package
     */
    public function enablePackage(PackageLoader $package): void {
        $this->enabledPackages[$package->getId()] = get_class($package);
        $package->onEnable();
    }

    /**
     * Disables a package (if it is enabled)
     * Do not forget to call updateEnabledPackagesList to make this permanent
     *
     * @param PackageLoader $package
     */
    public function disablePackage(PackageLoader $package): void {
        if(array_key_exists($package->getId(), $this->enabledPackages)) {
            unset($this->enabledPackages[$package->getId()]);
            $package->onDisable();
        }
    }

    /**
     * Updates the list of enabled packages
     */
    public function updateEnabledPackagesList(): void {
        $map = array_map(function($pkgClassName) {
            return '"' . $pkgClassName . '"';
        }, $this->enabledPackages);

        file_put_contents(storage_path('app/packages_enabled.php'), ClassMapGenerator::createFile($map));
    }

    /**
     * Finds a package by it's ID
     *
     * @param string $id
     * @return PackageLoader|null
     */
    public function findPackageById(string $id): ?PackageLoader {
        $packages = $this->fetchPackages();

        $p = null;

        //Find the package we're looking for.
        foreach($packages as $pkg) {
            if($pkg->getId() === $id) {
                $p = $pkg;
            }
        }

        return $p;
    }

    /**
     * Finds and returns an array of all valid packages that are installed.
     * This method does not check whether packages are enabled or not.
     *
     * @return array
     */
    public function fetchPackages(): array {
        $pkg_root_path = base_path('packages');
        $pkg_pattern = $pkg_root_path . '/*/*/shoutzor.package';

        //Check all installed packages
        foreach(glob($pkg_pattern) as $pkg) {
            $pkg = Filesystem::correctDS($pkg);

            try {
                //Validate the package
                if($this->checkPackage($pkg) === true) {
                    //Get the instance from the package's PackageLoader and add it to the resultset
                    $p = $this->getPackageInstance($pkg);
                    $p->onDiscover();
                    continue;
                }
            }
            catch(Exception $e) {
                //Log an error about the package being invalid
                Log::error("Tried loading an invalid package: " . $pkg);
                Log::error("Reason: " . $e->getMessage());

                ob_start();
                var_dump($e);
                Log::error(ob_end_flush());
            }
            finally {
                //Log an error about the package being invalid
                Log::error("Tried loading an invalid package: " . $pkg);
            }
        }

        return $this->packages;
    }

    /**
     * Create a new package manager instance.
     *
     * @param string $pkg
     * @return boolean
     */
    public function checkPackage(string $pkg): bool {
        $pkgData = json_decode(file_get_contents($pkg), true);

        //Validate that the name, version and namespace fields exist
        //These are the minimum required fields for a Shoutz0r package
        if(array_key_exists("id", $pkgData) && array_key_exists("name", $pkgData) && array_key_exists("author", $pkgData) && array_key_exists("version", $pkgData)) {
            //Package is valid
            return true;
        }

        //Package is invalid
        return false;
    }
}
