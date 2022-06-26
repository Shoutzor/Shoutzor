<?php

namespace App\Modules\LastFM\Subscribers;

use App\Events\UploadUpdatedEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class UploadSubscriber implements EventSubscriberInterface
{

    public static function getSubscribedEvents()
    {
        return [UploadUpdatedEvent::NAME => [['onProcessUpload', 0]]];
    }

    /**
     * Handle the event.
     *
     * @param UploadUpdatedEvent $event
     * @return void
     */
    public function onProcessUpload(UploadUpdatedEvent $event)
    {
    }
}
