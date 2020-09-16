<?php

namespace App\Events\Internal;

use App\Media;
use App\Upload;
use Symfony\Contracts\EventDispatcher\Event;

/**
 * Class UploadFinishedEvent
 * @package App\Events
 * Gets called when an upload from the queue has finished processing
 */
class UploadFinishedEvent extends Event
{
    public const NAME = 'upload.finished';

    protected $upload;
    protected $media;

    public function __construct(Upload $upload, ?Media $media) {
        $this->upload = $upload;
        $this->media = $media;
    }

    public function getUpload() : Upload {
        return $this->upload;
    }

    public function getMedia() : Media {
        return $this->media;
    }
}
