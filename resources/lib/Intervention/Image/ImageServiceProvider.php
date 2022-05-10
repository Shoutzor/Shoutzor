<?php

namespace Intervention\Image;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Foundation\Application as IlluminateApplication;
use Illuminate\Support\ServiceProvider;
use Intervention\Image\Provider\ProviderInterface;
use Laravel\Lumen\Application as LumenApplication;

class ImageServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Actual provider
     *
     * @var ServiceProvider
     */
    protected $provider;

    /**
     * Create a new service provider instance.
     *
     * @param  Application  $app
     * @return void
     */
    public function __construct($app)
    {
        parent::__construct($app);

        $this->provider = $this->getProvider();
    }

    /**
     * Return ServiceProvider according to Laravel version
     *
     * @return ProviderInterface
     */
    private function getProvider()
    {
        if ($this->app instanceof LumenApplication) {
            $provider = '\Intervention\Image\ImageServiceProviderLumen';
        } elseif (version_compare(IlluminateApplication::VERSION, '5.0', '<')) {
            $provider = '\Intervention\Image\ImageServiceProviderLaravel4';
        } else {
            $provider = '\Intervention\Image\ImageServiceProviderLaravel5';
        }

        return new $provider($this->app);
    }

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        if (method_exists($this->provider, 'boot')) {
            return $this->provider->boot();
        }
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        return $this->provider->register();
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['image'];
    }
}
