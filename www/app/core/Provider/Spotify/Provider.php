<?php

namespace Shoutzor\Provider\Spotify;

use Phalcon\Models\Media;
use Shoutzor\Provider\Provider as IProvider;

class Provider implements IProvider
{

    /**
     * @inheritDoc
     */
    public function getMedia($id, $attributes = array()): Media
    {
        // TODO: Implement getMedia() method.
    }

    /**
     * @inheritDoc
     */
    public function search($query, $filter = array()): Media
    {
        // TODO: Implement search() method.
    }

}