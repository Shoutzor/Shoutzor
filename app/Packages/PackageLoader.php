<?php

namespace App\Packages;

use \Illuminate\Contracts\Foundation\Application;

abstract class PackageLoader {

    /**
     * The application instance.
     *
     * @var Application
     */
    protected Application $app;

    /**
     * Contains the package's composer.json properties
     *
     * @var object
     */
    protected object $composerProperties;

    protected function parseComposer() : void {
        $this->composerProperties = json_decode(__DIR__ . "/composer.json");
    }

    /**
     * Create a new package loader instance
     *
     * @param Application $app
     * @return void
     */
    public function __construct(Application $app) {
        $this->app = $app;

        //Parse the Package composer properties
        $this->parseComposer();
    }

    /**
     * Returns the package name from the composer.json file
     *
     * @return string
     */
    public function getName() : string {
        return $this->getProperty('name', '');
    }

    /**
     * Returns the package author from the composer.json file
     *
     * @return string
     */
    public function getAuthor() : string {
        return $this->getProperty('author', '');
    }

    /**
     * Returns the package website from the composer.json file
     *
     * @return string
     */
    public function getWebsite() : string {
        return $this->getProperty('website', '');
    }

    /**
     * Returns the package description from the composer.json file
     *
     * @return string
     */
    public function getDescription() : string {
        return $this->getProperty('description', '');
    }

    /**
     * Returns the package version from the composer.json file
     *
     * @return string
     */
    public function getVersion() : string {
        return $this->getProperty('version', '');
    }

    /**
     * Returns the package license from the composer.json file
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
        if(property_exists($this->composerProperties, $key)) {
            return $this->composerProperties->{$key};
        }

        return $default;
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

}
