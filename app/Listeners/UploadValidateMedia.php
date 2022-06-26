<?php

namespace App\Listeners;

use App\Events\UploadUpdatedEvent;

class UploadValidateMedia
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Handle the event.
     *
     * @param UploadUpdatedEvent $event
     * @return void
     */
    public function handle(UploadUpdatedEvent $event)
    {
        // Check if the uploaded media file is valid
        $media = $event->getMedia();

    }
}
