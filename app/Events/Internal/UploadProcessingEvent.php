<?php

namespace App\Events\Internal;

use App\Upload;
use Symfony\Contracts\EventDispatcher\Event;

/**
 * Class UploadProcessingEvent
 * @package App\Events
 * Gets called when an upload from the queue is ready for processing
 */
class UploadProcessingEvent extends Event
{
    public const NAME = 'upload.processing';

    protected $upload;

    public function __construct(Upload $upload) {
        $this->upload = $upload;
    }

    public function getUpload() : Upload {
        return $this->upload;
    }
}
