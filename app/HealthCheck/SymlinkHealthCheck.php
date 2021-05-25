<?php

namespace App\HealthCheck;

use App\Helpers\Filesystem;
use Illuminate\Support\Facades\Artisan;
use JetBrains\PhpStorm\Pure;

class SymlinkHealthCheck extends BaseHealthCheck {

    private array $errors;

    #[Pure]
    public function __construct() {
        parent::__construct(
            'Symlinks',
            'Checks if all configured symlinks are created and accessible',
            'All symlinks are created and accessible'
        );

        $this->isHealthy    = true;
        $this->errors       = [];
    }

    #[Pure]
    public function getStatus(): string {
        return $this->isHealthy() ? $this->status : implode("<br />", $this->errors);
    }

    public function checkHealth(): void {
        $healthCheck = true;
        $caughtErrors = [];

        # Check if all symlinks exist
        $symLinks = config('filesystems.links');

        foreach($symLinks as $symlinkLocation=>$targetLocation) {
            clearstatcache(false, $symlinkLocation);
            if(Filesystem::isSymbolicLink($symlinkLocation) === false) {
                $healthCheck = false;
                $caughtErrors[] = "Missing symlink: $symlinkLocation";
                continue;
            }

            if(is_readable($symlinkLocation) === false) {
                $healthCheck = false;
                $caughtErrors[] = "Symlink not readable: $symlinkLocation";
                continue;
            }
        }

        $this->isHealthy = $healthCheck;
        $this->errors = $caughtErrors;
    }

    public function fix(): bool {
        $exitCode = Artisan::call('storage:link');

        if($exitCode === 0) {
            return true;
        }

        return false;
    }
}