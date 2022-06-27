<?php

namespace App\HealthCheck;

use App\Helpers\Filesystem;
use Exception;
use JetBrains\PhpStorm\Pure;

class EnsureFileHealthCheck extends BaseHealthCheck
{

    private array $errors;
    private array $files;

    #[Pure]
    public function __construct(
        array $files
    )
    {
        parent::__construct(
            'Files accessible',
            'Checks if all configured files are created',
            'All files are created and accessible'
        );

        $this->files = $files;
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
        foreach ($this->files as $fileLocation => $templateLocation) {
            clearstatcache(false, $fileLocation);

            if (is_readable($fileLocation) === false) {
                $healthCheck = false;
                $caughtErrors[] = "File not readable: $fileLocation, this may require a manual fix.";
            }
        }

        $this->isHealthy = $healthCheck;
        $this->errors = $caughtErrors;
    }

    public function fix(): HealthCheckFixResult
    {
        $result = new HealthCheckFixResult();

        $errorResults = [];
        foreach ($this->files as $fileLocation => $templateLocation) {
            if (is_readable($fileLocation) === false) {
                if (!copy($templateLocation, $fileLocation)) {
                    $errorResults[] = "Failed to copy the template from $templateLocation to $fileLocation";
                }
            }
        }

        if (empty($errorResults)) {
            $result->setFixed(true);
            $result->setMessage('Files created');
        } else {
            $result->setFixed(false);
            $result->setMessage(implode("\n", $errorResults));
        }

        return $result;
    }
}
