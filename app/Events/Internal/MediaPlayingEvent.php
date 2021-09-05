<?php

namespace App\Events\Internal;

use App\Events\ReadOnlyEvent;
use App\Media;

/**
 * Class MediaPlayingEvent
 * Gets called when a media object started playing on Shoutz0r
 *
 * @package App\Events
 */
class MediaPlayingEvent extends ReadOnlyEvent
{
    public const NAME = 'media.playing';

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
