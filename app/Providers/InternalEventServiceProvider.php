<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Symfony\Component\EventDispatcher\EventDispatcher;


class InternalEventServiceProvider extends ServiceProvider
{
    private EventDispatcher $dispatcher;

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->dispatcher = new EventDispatcher();
        $this->app->instance('Symfony\Component\EventDispatcher\EventDispatcher', $this->dispatcher);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //TODO automatically load subscribers and listeners
        /*        foreach (glob(app_path() . '/Listeners/Internal/*.php') as $helpersfilename)
                {
                    require_once($helpersfilename);
                }*/
    }
}
