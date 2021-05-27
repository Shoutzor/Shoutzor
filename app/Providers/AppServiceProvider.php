<?php

namespace App\Providers;

use App\HealthCheck\HealthCheckManager;
use App\HealthCheck\SymlinkHealthCheck;
use App\HealthCheck\WritableDirsHealthCheck;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider {

    private HealthCheckManager $healthCheckManager;

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register() {
        $this->healthCheckManager = new HealthCheckManager();
        $this->healthCheckManager->registerHealthcheck(new SymlinkHealthCheck(config('filesystems.links')));
        $this->healthCheckManager->registerHealthCheck(
            new WritableDirsHealthCheck(
                [
                    storage_path()
                ]
            )
        );

        $this->app->instance(HealthCheckManager::class, $this->healthCheckManager);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot() {
    }
}
