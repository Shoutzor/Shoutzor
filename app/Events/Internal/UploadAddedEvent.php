<?php

namespace App\Events\Internal;

use App\Upload;
use Symfony\Contracts\EventDispatcher\Event;

/**
 * Class UploadAddedEvent
 * @package App\Events
 * Gets called when a file has been uploaded, the file wont be parsed until UploadProcessingEvent is called
 */
class UploadAddedEvent extends Event
{
    public const NAME = 'upload.added';

    protected $upload;

    public function __construct(Upload $upload) {
        $this->upload = $upload;
    }

    public function getUpload() : Upload {
        return $this->upload;
    }
}
