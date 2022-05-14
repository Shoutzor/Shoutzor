<?php

namespace App\Events\Internal;

use App\Events\ReadOnlyEvent;
use App\Models\Media;

/**
 * Class ArtistSearchEvent
 * Gets called when shoutz0r (or a plugin) should search for an Artist for the give media file
 *
 * @package App\Events
 */
class ArtistSearchEvent extends ReadOnlyEvent
{
    public const NAME = 'artist.search';

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
