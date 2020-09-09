<?php

namespace Modules\ShoutzorAcoustId\Providers;

use App\Events\Internal\UploadProcessingEvent;
use Illuminate\Support\ServiceProvider;
use Modules\ShoutzorAcoustId\Listeners\UploadListener;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        UploadProcessingEvent::NAME => UploadListener::class
    ];
}
