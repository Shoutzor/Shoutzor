<?php

namespace App\Events\Internal;

use App\Events\ReadOnlyEvent;
use App\Upload;

/**
 * Class UploadFailedEvent
 *
 * @package App\Events
 * Gets called when an upload from the queue has been processed, but was deemed invalid
 */
class UploadFailedEvent extends ReadOnlyEvent {
    public const NAME = 'upload.failed';

    protected $upload;

    public function __construct(Upload $upload) {
        $this->upload = $upload;
    }

    public function getUpload(): Upload {
        return $this->upload;
    }
}
