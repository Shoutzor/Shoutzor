<?php

namespace Shoutz0r\AcoustId;

use App\Packages\PackageLoader;

class Main extends PackageLoader {

    public function onEnable()
    {
        //Register our service providers
        $this->app->register('Shoutz0r\AcoustId\Providers\PackageServiceProvider');
    }

}
