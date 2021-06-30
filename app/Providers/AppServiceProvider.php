<?php

namespace App\Providers;

use App\HealthCheck\CacheHealthCheck;
use App\HealthCheck\EnsureFileHealthCheck;
use App\HealthCheck\HealthCheckManager;
use App\HealthCheck\SymlinkHealthCheck;
use App\HealthCheck\WritableDirsHealthCheck;
use App\Helpers\Filesystem;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{

    private HealthCheckManager $healthCheckManager;

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->healthCheckManager = new HealthCheckManager();
        $this->healthCheckManager->registerHealthcheck(new SymlinkHealthCheck(config('filesystems.links')), false);
        $this->healthCheckManager->registerHealthCheck(
            new WritableDirsHealthCheck(
                [
                    Filesystem::correctDS(storage_path()),
                    Filesystem::correctDS(storage_path('app/public/album/')),
                    Filesystem::correctDS(storage_path('app/public/artist/')),
                    Filesystem::correctDS(storage_path('app/public/packages/'))
                ]
            ),
            false
        );
        $this->healthCheckManager->registerHealthcheck(new CacheHealthCheck(), false);
        $this->healthCheckManager->registerHealthcheck(
            new EnsureFileHealthCheck(
                [
                    base_path('.env') => base_path('.env.template')
                ]
            ),
            true
        );

        $this->app->instance(HealthCheckManager::class, $this->healthCheckManager);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
    }
}
