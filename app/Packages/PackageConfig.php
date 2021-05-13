<?php

namespace App\Packages;

class PackageConfig {

    protected string $file;

    protected function __construct(string $file) {
        $this->file = $file;
    }

    /**
     * Create an empty config file
     *
     * @param string $file
     * @return PackageConfig
     */
    public static function create(string $file): PackageConfig {

    }

    /**
     * Create a config file using a source config file.
     * This will add any non-existing keys to the file if it already exists
     *
     * @param string $file
     * @param string $source
     * @return PackageConfig
     */
    public static function createFrom(string $file, string $source): PackageConfig {

    }

    /**
     * Load an existing config file
     *
     * @param string $file
     * @return PackageConfig|null
     */
    public static function load(string $file): ?PackageConfig {
        $file = config_path("packages/$file");

        if(file_exists($file)) {
            return new PackageConfig($file);
        }

        return null;
    }

}
