<?php

namespace App\Providers;

use App\HealthCheck\CacheHealthCheck;
use App\HealthCheck\EnsureFileHealthCheck;
use App\HealthCheck\HealthCheckManager;
use App\HealthCheck\SymlinkHealthCheck;
use App\HealthCheck\WritableDirsHealthCheck;
use App\HealthCheck\WritableFilesHealthCheck;
use App\Helpers\Filesystem;
use App\MediaSource\MediaSource;
use App\MediaSource\MediaSourceManager;
use App\Models\Upload;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{

    private MediaSourceManager $mediaSourceManager;
    private HealthCheckManager $healthCheckManager;

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->mediaSourceManager = new MediaSourceManager();
        $this->healthCheckManager = new HealthCheckManager();

        $this->app->instance(MediaSourceManager::class, $this->mediaSourceManager);
        $this->app->instance(HealthCheckManager::class, $this->healthCheckManager);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Register the default media filetype sources (local audio file & local video file)
        // Other sources can be added as a module (ie: youtube, spotify, etc.)
        $this->mediaSourceManager->registerSource(new MediaSource('audio', 'audio file', ''));
        $this->mediaSourceManager->registerSource(new MediaSource('video', 'video file', ''));

        //Register the system healthchecks
        $this->healthCheckManager->registerHealthcheck(
            new EnsureFileHealthCheck(
                [
                    base_path('.env') => base_path('.env.template')
                ]
            ),
            true
        );

        $this->healthCheckManager->registerHealthCheck(
            new WritableFilesHealthCheck(
                [
                    Filesystem::correctDS(base_path('.env'))
                ]
            ),
            false
        );
        $this->healthCheckManager->registerHealthCheck(
            new WritableDirsHealthCheck(
                [
                    Filesystem::correctDS(public_path()),
                    Filesystem::correctDS(storage_path()),
                    Filesystem::correctDS(storage_path('logs/')),
                    Filesystem::correctDS(storage_path('app/public/album/')),
                    Filesystem::correctDS(storage_path('app/public/artist/')),
                    Filesystem::correctDS(storage_path('app/public/packages/')),
                    Filesystem::correctDS(storage_path('app/public/media/')),
                    Filesystem::correctDS(storage_path('app/' . Upload::STORAGE_PATH))
                ]
            ),
            false
        );
        $this->healthCheckManager->registerHealthcheck(new SymlinkHealthCheck(config('filesystems.links')), false);
        $this->healthCheckManager->registerHealthcheck(new CacheHealthCheck(), false);
    }
}
