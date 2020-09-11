<?php

namespace Modules\ShoutzorAcoustId\Listeners;

use App\Events\Internal\UploadProcessingEvent;
use Modules\ShoutzorAcoustId\App\AcoustId;

class UploadListener
{

    private AcoustId $acoustId;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        $this->acoustId = new AcoustId();
    }

    /**
     * Handle the event.
     *
     * @param  UploadProcessingEvent  $event
     * @return void
     */
    public function handle(UploadProcessingEvent $event)
    {
        $this->acoustId->parse($event->getUpload(), $event->getMedia());
    }
}
