<?php

namespace App\Listeners;

use App\Events\Internal\UploadProcessingEvent;

class UploadValidateMedia {
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct() {
    }

    /**
     * Handle the event.
     *
     * @param UploadProcessingEvent $event
     * @return void
     */
    public function handle(UploadProcessingEvent $event) {
        // Check if the uploaded media file is valid
        $media = $event->getMedia();

    }
}