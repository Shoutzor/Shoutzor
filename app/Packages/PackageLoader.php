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
        return (!isset($this->composerProperties->name) ? '' : $this->composerProperties->name);
    }

    /**
     * Returns the package description from the composer.json file
     *
     * @return string
     */
    public function getDescription() : string {
        return (!isset($this->composerProperties->description) ? '' : $this->composerProperties->description);
    }

    /**
     * Returns the package version from the composer.json file
     *
     * @return string
     */
    public function getVersion() : string {
        return (!isset($this->composerProperties->version) ? '' : $this->composerProperties->version);
    }

    /**
     * Returns the package authors from the composer.json file
     *
     * @return array
     */
    public function getAuthors() : array {
        return (!isset($this->composerProperties->authors) ? [] : $this->composerProperties->authors);
    }

    /**
     * Returns the package license from the composer.json file
     *
     * @return string
     */
    public function getLicense() : string {
        return (!isset($this->composerProperties->license) ? [] : $this->composerProperties->license);
    }

    /**
     * Returns the package license from the composer.json file
     *
     * @return bool
     */
    public function getEnabled() : bool {
        return (!isset($this->composerProperties->enabled) ? false : $this->composerProperties->enabled);
    }

    /**
     * Gets called when an package is enabled, this allows to register the packages providers
     *
     * @return void
     */
    abstract public function onEnable() : void;

}
