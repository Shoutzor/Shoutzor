<?php

namespace App\Providers;

use App\Events\ShoutzorDispatcher;
use Illuminate\Support\ServiceProvider;
use Symfony\Component\EventDispatcher\EventDispatcher;

class InternalEventServiceProvider extends ServiceProvider
{
    private ShoutzorDispatcher $dispatcher;

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->dispatcher = new ShoutzorDispatcher();
        $this->app->instance(EventDispatcher::class, $this->dispatcher);
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
