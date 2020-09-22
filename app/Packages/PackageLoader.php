<?php

namespace App\Packages;

use App\Helpers\Filesystem as FilesystemHelper;
use \Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\Facades\Log;
use Symfony\Component\Filesystem\Filesystem;

abstract class PackageLoader {

    /**
     * The application instance.
     *
     * @var Application
     */
    protected Application $app;

    /**
     * The package path
     *
     * @var string
     */
    protected string $pkgPath;

    /**
     * Contains the package's shoutzor.package properties
     *
     * @var object
     */
    protected object $pkgProperties;

    protected function parseComposer() : void {
        $this->pkgProperties = json_decode(file_get_contents($this->pkgPath . "/shoutzor.package"));
    }

    /**
     * Create a new package loader instance
     *
     * @param Application $app
     * @return void
     */
    public function __construct(Application $app, string $pkgPath) {
        $this->app      = $app;
        $this->pkgPath  = $pkgPath;

        //Parse the Package composer properties
        $this->parseComposer();
    }

    /**
     * Returns the package ID from the shoutzor.package file
     * @return string
     */
    public function getId() : string {
        return $this->getProperty('id', '');
    }

    /**
     * Returns the package icon from the shoutzor.package file
     * @return string
     */
    public function getIcon() : string {
        return $this->getProperty('icon', '');
    }

    /**
     * Returns the package name from the shoutzor.package file
     *
     * @return string
     */
    public function getName() : string {
        return $this->getProperty('name', '');
    }

    /**
     * Returns the package author from the shoutzor.package file
     *
     * @return string
     */
    public function getAuthor() : string {
        return $this->getProperty('author', '');
    }

    /**
     * Returns the package website from the shoutzor.package file
     *
     * @return string
     */
    public function getWebsite() : string {
        return $this->getProperty('website', '');
    }

    /**
     * Returns the package description from the shoutzor.package file
     *
     * @return string
     */
    public function getDescription() : string {
        return $this->getProperty('description', '');
    }

    /**
     * Returns the package version from the shoutzor.package file
     *
     * @return string
     */
    public function getVersion() : string {
        return $this->getProperty('version', '');
    }

    /**
     * Returns the package license from the shoutzor.package file
     *
     * @return string
     */
    public function getLicense() : string {
        return $this->getProperty('license', '');
    }

    /**
     * Returns the request property's value. If it doesn't exist, the default value will be returned
     * @param string $key
     * @param null $default
     * @return mixed|null
     */
    public function getProperty(string $key, $default = null) {
        if(property_exists($this->pkgProperties, $key)) {
            return $this->pkgProperties->{$key};
        }

        return $default;
    }

    /**
     * Gets called when the package is discovered. This does not load or enable the package yet.
     * This method allows for creating config files before the package is enabled.
     * Additionally, this method creates a symbolic link to the package's resources/static/public directory (if existing)
     *
     * @return void
     */
    public function onDiscover() : void {
        $publicAssetPath    = $this->pkgPath . '/resources/static/public';
        $symlinkPath        = FilesystemHelper::correctDS(storage_path('app/public/packages/' . $this->getId() . '/'));

        //If a public asset path exists, create a symlink to it so we can use those assets in the front-end
        if(file_exists($publicAssetPath) && file_exists($symlinkPath) === false) {
            try {
                symlink(
                    $publicAssetPath,
                    $symlinkPath
                );
            } catch(\Exception $e) {
                Log::error("Could not create package symlink, error: " . $e->getMessage());
            }
        }
    }

    /**
     * Gets called when an package is loaded, this allows to register the packages providers
     *
     * @return void
     */
    abstract public function onLoad() : void;

    /**
     * Gets called when an package is enabled
     *
     * @return void
     */
    abstract public function onEnable() : void;

    /**
     * Gets called when an package is disabled
     *
     * @return void
     */
    abstract public function onDisable() : void;

    /**
     * Gets called when an package is updated
     *
     * @param string $versionFrom the version the package was at, before updating
     * @return void
     */
    abstract public function onUpdate(string $versionFrom) : void;

}
