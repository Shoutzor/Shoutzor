<?php

namespace App\Events\Internal;

use App\Artist;
use Symfony\Contracts\EventDispatcher\Event;

/**
 * Class ArtistCreateEvent
 * @package App\Events
 * Gets called when a media object gets added to Shoutz0r
 */
class ArtistCreateEvent extends Event
{
    public const NAME = 'artist.create';

    protected $artist;

    public function __construct(Artist $artist) {
        $this->artist = $artist;
    }

    public function getArtist() : Artist {
        return $this->artist;
    }
}
