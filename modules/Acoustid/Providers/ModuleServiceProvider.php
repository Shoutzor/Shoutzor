<?php

namespace App\Modules\Acoustid\Providers;

use Caffeinated\Modules\Support\ServiceProvider;
use App\Modules\AcoustId\Subscribers\UploadSubscriber;
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
        $this->loadTranslationsFrom(module_path('acoustid', 'Resources/Lang', 'app'), 'acoustid');
        $this->loadViewsFrom(module_path('acoustid', 'Resources/Views', 'app'), 'acoustid');
        $this->loadMigrationsFrom(module_path('acoustid', 'Database/Migrations', 'app'));
        if(!$this->app->configurationIsCached()) {
            $this->loadConfigsFrom(module_path('acoustid', 'Config', 'app'));
        }
        $this->loadFactoriesFrom(module_path('acoustid', 'Database/Factories', 'app'));

        //Register our event subscriber
        app(EventDispatcher::class)->addSubscriber(new UploadSubscriber());
    }

    /**
     * Register the module services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->register(RouteServiceProvider::class);
        $this->registerConfig();
    }

    /**
     * Register config.
     *
     * @return void
     */
    protected function registerConfig()
    {
        $this->publishes([__DIR__.'/config/config.php' => config_path('shoutzor_acoustid.php')], 'config');
    }
}
