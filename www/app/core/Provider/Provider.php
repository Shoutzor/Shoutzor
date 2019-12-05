<?php

namespace Shoutzor\Provider;

use Phalcon\Models\Media;

interface Provider {

    /**
     * Returns the Provider Identifier
     * @return string
     */
    public function getId() : string;

    /**
     * Gets a Media by ID
     * @param $id
     * @param array $attributes
     * @return Media
     */
    public function getMedia($id, $attributes = array()) : Media;

    /**
     * Searches for Media with a query
     * @param $query
     * @param array $filter
     * @return Media
     */
    public function search($query, $filter = array()) : Media;

}
