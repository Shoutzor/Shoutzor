<?php

namespace App\Events\Internal;

use App\Upload;
use Symfony\Contracts\EventDispatcher\Event;

/**
 * Class RequestAddedEvent
 *
 * @package App\Events
 * Gets called when a request is added to the Queue
 */
class RequestAddedEvent extends Event {
    public const NAME = 'request.added';

    protected $upload;

    public function __construct(Upload $upload) {
        $this->upload = $upload;
    }

    public function getUpload(): Upload {
        return $this->upload;
    }
}
