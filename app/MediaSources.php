<?php

namespace App;

use Exception;

class MediaSources {

    private static $instance = null;

    /*
     * Contains all MediaSource objects as value, with their identifiers as the key
     */
    private static $sources = [];

    private function __construct() {}

    public static function getInstance() : MediaSources {
        if(self::$instance === null) {
            self::$instance = new MediaSources();
        }

        return self::$instance;
    }

    /**
     * Add a MediaSource to the store
     * @param MediaSource $source
     * @throws Exception if a MediaSource with the same identifier field already exists
     */
    public static function addSource(MediaSource $source) : void {
        if(array_key_exists($source::identifier, self::$sources)) {
            throw new Exception("A MediaSource with the identifier: '".$source::identifier."' already exists!");
        }

        self::$sources[$source::identifier] = $source;
    }

    /**
     * Get a MediaSource from the store
     * @param String $identifier the identifier from the MediaSource
     * @return MediaSource|null returns null if no MediaSource with the provided identifier exist in the store
     */
    public static function getSource(String $identifier) : ?MediaSource {
        if(array_key_exists($identifier, self::$sources)) {
            return self::$sources[$identifier];
        }

        return null;
    }
}
