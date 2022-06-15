<?php

namespace App\HealthCheck;

use App\Helpers\Filesystem;
use Exception;
use Illuminate\Support\Facades\Artisan;
use JetBrains\PhpStorm\Pure;

class SymlinkHealthCheck extends BaseHealthCheck
{

    private array $errors;
    private array $symlinks;

    #[Pure]
    public function __construct(
        array $symlinks
    )
    {
        parent::__construct(
            'Symlinks',
            'Checks if all configured symlinks are created and accessible',
            'All symlinks are created and accessible'
        );

        $this->symlinks = $symlinks;
        $this->errors = [];
    }

    #[Pure]
    public function getStatus(): string
    {
        return $this->isHealthy() ? $this->status : implode("\n", $this->errors);
    }

    public function checkHealth(): void
    {
        $healthCheck = true;
        $caughtErrors = [];

        # Check if all symlinks exist
        foreach ($this->symlinks as $symlinkLocation => $targetLocation) {
            clearstatcache(false, $symlinkLocation);
            if (Filesystem::isSymbolicLink($symlinkLocation) === false) {
                $healthCheck = false;
                $caughtErrors[] = "Missing symlink: $symlinkLocation -> $targetLocation";
                continue;
            }

            if (is_readable($symlinkLocation) === false) {
                $healthCheck = false;
                $caughtErrors[] = "Symlink not readable: $symlinkLocation";
                continue;
            }
        }

        $this->isHealthy = $healthCheck;
        $this->errors = $caughtErrors;
    }

    public function fix(): HealthCheckFixResult
    {
        $result = new HealthCheckFixResult();

        # Remove broken symlinks
        $errors = [];
        foreach ($this->symlinks as $symlinkLocation => $targetLocation) {
            try {
                if (is_link($symlinkLocation) && !file_exists($symlinkLocation)) {
                    unlink($symlinkLocation);
                }
            } catch (Exception $e) {
                $errors[] = "Could not remove broken symlink at $symlinkLocation, reason: " . $e->getMessage();
            }
        }

        try {
            $exitCode = Artisan::call('storage:link');
        } catch (Exception $e) {
            $exitCode = -1;
            $errors[] = "Failed to perform storage:link, reason: " . $e->getMessage();
        }

        if (count($errors) === 0 && $exitCode === 0) {
            $result->setFixed(true);
            $result->setMessage('Symlinks created');
        } else {
            $result->setFixed(false);
            $result->setMessage(implode("\n", $errors));
        }

        return $result;
    }
}
