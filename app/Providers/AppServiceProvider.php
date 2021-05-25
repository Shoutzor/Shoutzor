<?php

namespace App\Providers;

use App\HealthCheck\HealthCheckManager;
use App\HealthCheck\SymlinkHealthCheck;
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
        $this->app->instance(HealthCheckManager::class, $this->healthCheckManager);

        $this->healthCheckManager->registerHealthcheck(new SymlinkHealthCheck());
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot() {
    }
}
