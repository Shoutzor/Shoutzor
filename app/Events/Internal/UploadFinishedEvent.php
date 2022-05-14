<?php

namespace App\Events\Internal;

use App\Events\ReadOnlyEvent;
use App\Models\Media;
use App\Models\Upload;

/**
 * Class UploadFinishedEvent
 * Gets called when an upload from the queue has finished processing
 *
 * @package App\Events
 */
class UploadFinishedEvent extends ReadOnlyEvent
{
    public const NAME = 'upload.finished';

    protected $upload;
    protected $media;

    public function __construct(Upload $upload, Media $media)
    {
        $this->upload = $upload;
        $this->media = $media;
    }

    public function getUpload(): Upload
    {
        return $this->upload;
    }

    public function getMedia(): Media
    {
        return $this->media;
    }
}
