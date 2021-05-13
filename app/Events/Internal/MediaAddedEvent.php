<?php

namespace App\Events\Internal;

use App\Upload;
use Symfony\Contracts\EventDispatcher\Event;

/**
 * Class MediaAddedEvent
 *
 * @package App\Events
 * Gets called when a media object gets added to Shoutz0r
 */
class MediaAddedEvent extends Event {
    public const NAME = 'media.added';

    protected $upload;

    public function __construct(Upload $upload) {
        $this->upload = $upload;
    }

    public function getUpload(): Upload {
        return $this->upload;
    }
}
