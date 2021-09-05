<?php

namespace App\Events\Internal;

use App\Events\BaseEvent;
use App\Upload;

/**
 * Class UploadAddedEvent
 * Gets called when a file has been uploaded, the file wont be parsed until UploadProcessingEvent is called
 *
 * @package App\Events
 */
class UploadAddedEvent extends BaseEvent
{
    public const NAME = 'upload.added';

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
