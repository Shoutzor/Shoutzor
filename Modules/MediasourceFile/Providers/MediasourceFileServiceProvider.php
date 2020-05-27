<?php

namespace Modules\MediasourceFile\Providers;

use App\MediaSources;
use Illuminate\Support\ServiceProvider;
use Modules\MediasourceFile\Models\MediaSource;

class MediasourceFileServiceProvider extends ServiceProvider
{
    /**
     * @var string $moduleName
     */
    protected $moduleName = 'MediasourceFile';

    /**
     * @var string $moduleNameLower
     */
    protected $moduleNameLower = 'mediasourcefile';

    /**
     * Boot the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerConfig();

        $source = new MediaSource();
        MediaSources::getInstance()->addSource($source);
    }

    /**
     * Register config.
     *
     * @return void
     */
    protected function registerConfig()
    {
        $this->publishes([
            module_path($this->moduleName, 'Config/config.php') => config_path($this->moduleNameLower . '.php'),
        ], 'config');
        $this->mergeConfigFrom(
            module_path($this->moduleName, 'Config/config.php'), $this->moduleNameLower
        );
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {

        return [];
    }
}
