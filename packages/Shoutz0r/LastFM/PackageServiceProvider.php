<?php

namespace Shoutz0r\LastFM;

use Illuminate\Support\ServiceProvider;
use Shoutz0r\LastFM\Subscribers\UploadSubscriber;
use Symfony\Component\EventDispatcher\EventDispatcher;

class PackageServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {

    }

    /**
     * Boot the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerConfig();

        //Register our event subscriber
        app(EventDispatcher::class)->addSubscriber(new UploadSubscriber());
    }

    /**
     * Register config.
     *
     * @return void
     */
    protected function registerConfig()
    {
        $this->publishes([
            __DIR__.'/config/config.php' => config_path('shoutzor_lastfm.php')
        ], 'config');
    }
}
