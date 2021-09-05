<?php

namespace App\Events\Internal;

use App\Events\ReadOnlyEvent;
use App\Upload;

/**
 * Class UploadProcessingEvent
 * Gets called when an upload from the queue is being processed
 *
 * @package App\Events
 */
class UploadProcessingEvent extends ReadOnlyEvent
{
    public const NAME = 'upload.processing';

    protected Upload $upload;

    public function __construct(Upload $upload)
    {
        $this->upload = $upload;
    }

    public function getUpload(): Upload
    {
        return $this->upload;
    }
}
