<?php

namespace App\Modules\AcoustId\Subscribers;

use App\Events\Internal\UploadProcessingEvent;
use Shoutz0r\AcoustId\Lib\AcoustId;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class UploadSubscriber implements EventSubscriberInterface
{
    private AcoustId $acoustId;

    /**
     * Create the event subscriber.
     *
     * @return void
     */
    public function __construct()
    {
        $this->acoustId = new AcoustId(config('packages.shoutzor.acoustid.apikey', ''));
    }

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
        $this->acoustId->parse($event->getUpload(), $event->getMedia());
    }
}
