<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Symfony\Component\EventDispatcher\EventDispatcher;

class InternalEventServiceProvider extends ServiceProvider {
    private EventDispatcher $dispatcher;

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register() {
        $this->dispatcher = new EventDispatcher();
        $this->app->instance(EventDispatcher::class, $this->dispatcher);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot() {
    }
}
