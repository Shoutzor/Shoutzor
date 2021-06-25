<?php

namespace App\Events\Internal;

use App\Album;
use App\Events\ReadOnlyEvent;

/**
 * Class AlbumCreateEvent
 *
 * @package App\Events
 * Gets called when an album gets added to Shoutz0r
 */
class AlbumCreateEvent extends ReadOnlyEvent
{
    public const NAME = 'artist.create';

    protected $album;

    public function __construct(Album $album)
    {
        $this->album = $album;
    }

    public function getAlbum(): Album
    {
        return $this->album;
    }
}
