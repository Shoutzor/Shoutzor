<?php

namespace App\Events\Internal;

use App\Upload;
use Symfony\Contracts\EventDispatcher\Event;

/**
 * Class MediaPlayingEvent
 *
 * @package App\Events
 * Gets called when a media object started playing on Shoutz0r
 */
class MediaPlayingEvent extends Event {
    public const NAME = 'media.playing';

    protected $upload;

    public function __construct(Upload $upload) {
        $this->upload = $upload;
    }

    public function getUpload(): Upload {
        return $this->upload;
    }
}
