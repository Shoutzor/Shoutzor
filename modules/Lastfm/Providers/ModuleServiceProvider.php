<?php

namespace App\Modules\Lastfm\Providers;

use Caffeinated\Modules\Support\ServiceProvider;
use App\Modules\LastFM\Subscribers\UploadSubscriber;
use Symfony\Component\EventDispatcher\EventDispatcher;

class ModuleServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the module services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadTranslationsFrom(module_path('lastfm', 'Resources/Lang', 'app'), 'lastfm');
        $this->loadViewsFrom(module_path('lastfm', 'Resources/Views', 'app'), 'lastfm');
        $this->loadMigrationsFrom(module_path('lastfm', 'Database/Migrations', 'app'));
        if(!$this->app->configurationIsCached()) {
            $this->loadConfigsFrom(module_path('lastfm', 'Config', 'app'));
        }
        $this->loadFactoriesFrom(module_path('lastfm', 'Database/Factories', 'app'));

        //Register our event subscriber
        app(EventDispatcher::class)->addSubscriber(new UploadSubscriber());
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->registerConfig();
    }

    /**
     * Register config.
     *
     * @return void
     */
    protected function registerConfig()
    {
        $this->publishes([__DIR__.'/config/config.php' => config_path('shoutzor_lastfm.php')], 'config');
    }
}
