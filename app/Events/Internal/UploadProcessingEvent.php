<?php

namespace App\Events\Internal;

use App\Media;
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

    protected Upload $upload;
    protected Media $media;
    protected bool $valid = true;

    public function __construct(Upload $upload, Media $media) {
        $this->upload = $upload;
        $this->media = $media;
    }

    public function getUpload() : Upload {
        return $this->upload;
    }

    public function getMedia() : Media {
        return $this->media;
    }

    public function setInvalid() {
        $this->valid = false;
    }

    public function isValid() : bool {
        return $this->valid;
    }
}
