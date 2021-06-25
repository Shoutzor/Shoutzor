<?php

namespace App\Events\Internal;

use App\Events\ReadOnlyEvent;
use App\Media;

/**
 * Class AlbumSearchEvent
 *
 * @package App\Events
 * Gets called when shoutz0r (or a plugin) should search for an Album for the give media file
 */
class AlbumSearchEvent extends ReadOnlyEvent
{
    public const NAME = 'album.search';

    protected Media $media;

    public function __construct(Media $media)
    {
        $this->media = $media;
    }

    public function getMedia(): Media
    {
        return $this->media;
    }
}
