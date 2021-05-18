<?php

namespace App\Events\Internal;

use App\Events\BaseEvent;
use App\Media;
use App\Upload;

/**
 * Class UploadProcessingEvent
 *
 * @package App\Events
 * Gets called when an upload from the queue is ready for processing
 */
class UploadProcessingEvent extends BaseEvent {
    public const NAME = 'upload.processing';

    protected Upload $upload;
    protected Media $media;

    public function __construct(Upload $upload, Media $media) {
        $this->upload = $upload;
        $this->media = $media;
    }

    public function getUpload(): Upload {
        return $this->upload;
    }

    public function getMedia(): Media {
        return $this->media;
    }
}
