<?php

namespace App\HealthCheck;

use App\Helpers\Filesystem;
use Exception;
use JetBrains\PhpStorm\Pure;

class SymlinkHealthCheck extends BaseHealthCheck
{

    private array $errors;
    private array $symlinks;

    #[Pure]
    public function __construct(
        array $symlinks
    ) {
        parent::__construct(
            'Symlinks',
            'Checks if all configured symlinks are created and accessible',
            'All symlinks are created and accessible'
        );

        $this->symlinks = $symlinks;
        $this->isHealthy = false;
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
                $caughtErrors[] = "Missing symlink: $symlinkLocation";
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

        # No need to perform a fix if we're healthy.
        if ($this->isHealthy()) {
            $result->setFixed(true);
            $result->setMessage('Symlinks healthy, no fix required.');
            return $result;
        }

        $errors = [];

        foreach ($this->symlinks as $symlinkLocation => $targetLocation) {
            try {
                symlink($targetLocation, $symlinkLocation);
            } catch (Exception $e) {
                $errors[] = "Could not create symlink from $targetLocation to $symlinkLocation";
            }
        }

        if (count($errors) === 0) {
            $result->setFixed(true);
            $result->setMessage('Symlinks created');
        } else {
            $result->setFixed(false);
            $result->setMessage(implode("\n", $errors));
        }

        return $result;
    }
}