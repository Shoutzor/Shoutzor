<?php

namespace App\Modules\LastFM\Subscribers;

use App\Events\Internal\UploadProcessingEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class UploadSubscriber implements EventSubscriberInterface
{

    public static function getSubscribedEvents()
    {
        return [UploadProcessingEvent::NAME => [['onProcessUpload', 0]]];
    }

    /**
     * Handle the event.
     *
     * @param UploadProcessingEvent $event
     * @return void
     */
    public function onProcessUpload(UploadProcessingEvent $event)
    {
    }
}
