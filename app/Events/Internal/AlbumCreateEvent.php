<?php

namespace App\Events\Internal;

use App\Album;
use Symfony\Contracts\EventDispatcher\Event;

/**
 * Class AlbumCreateEvent
 * @package App\Events
 * Gets called when an album gets added to Shoutz0r
 */
class AlbumCreateEvent extends Event
{
    public const NAME = 'artist.create';

    protected $album;
    protected $exists = false;

    public function __construct(Album $album) {
        $this->album = $album;
    }

    public function getAlbum() : Album {
        return $this->album;
    }

    public function setExists() : void {
        $this->exists = true;
    }

    public function exists() : bool {
        return $this->exists;
    }
}
