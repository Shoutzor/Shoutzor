<?php

namespace App\Events\Internal;

use App\Artist;
use App\Events\ReadOnlyEvent;

/**
 * Class ArtistCreateEvent
 * Gets called when an artist gets added to Shoutz0r
 *
 * @package App\Events
 */
class ArtistCreateEvent extends ReadOnlyEvent
{
    public const NAME = 'artist.create';

    protected $artist;

    public function __construct(Artist $artist)
    {
        $this->artist = $artist;
    }

    public function getArtist(): Artist
    {
        return $this->artist;
    }
}
