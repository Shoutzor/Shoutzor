<?php

namespace Shoutz0r\LastFM;

use App\Packages\PackageLoader;

class Main extends PackageLoader {

    public function onLoad(): void {
        //Register our service providers
        $this->app->register('Shoutz0r\LastFM\Providers\PackageServiceProvider');
    }

    public function onEnable(): void { }

    public function onDisable(): void { }

    public function onUpdate(string $versionFrom): void { }
}
