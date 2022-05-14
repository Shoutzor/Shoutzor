<?php

namespace App\HealthCheck;

use JetBrains\PhpStorm\Pure;

class WritableFilesHealthCheck extends BaseHealthCheck
{

    private array $errors;
    private array $files;

    #[Pure]
    public function __construct(
        array $files
    ) {
        parent::__construct(
            'Writable files',
            'Checks if all configured files are writable',
            'All files are writable'
        );

        $this->files = $files;
        $this->errors = [];
    }

    #[Pure]
    public function getStatus(): string
    {
        if ($this->isHealthy()) {
            return $this->status;
        } else {
            return "The following errors may require a manual fix:\n".implode("\n", $this->errors);
        }
    }

    public function checkHealth(): void
    {
        $healthCheck = true;
        $caughtErrors = [];

        # Check if all symlinks exist
        foreach ($this->files as $file) {
            clearstatcache(false, $file);

            if (file_exists($file) === false) {
                $healthCheck = false;
                $caughtErrors[] = "Missing: $file";
                continue;
            }

            if (is_writable($file) === false) {
                $healthCheck = false;
                $caughtErrors[] = "Not writable: $file";
                continue;
            }
        }

        $this->isHealthy = $healthCheck;
        $this->errors = $caughtErrors;
    }

    public function fix(): HealthCheckFixResult
    {
        // Not quite sure how to fix this by code. IMO a sysadmin should do this manually.
        $result = new HealthCheckFixResult();

        $success = true;
        $actions = [];

        # Iterate over all files that are required
        foreach ($this->files as $file) {
            # Make sure the file exists, create if not.
            if (file_exists($file) === false) {
                # Create the file
                if (file_put_contents($file, '') !== false) {
                    $actions[] = "Created: $file";
                } else {
                    $success = false;
                    $actions[] = "Failed to create: $file";
                    continue;
                }
            }

            if (is_writable($file) === false) {
                $success = false;
                $actions[] = "Not writable (manual fix required): $file";
            }
        }

        $result->setFixed($success);
        $result->setMessage(implode("\n", $actions));

        return $result;
    }
}
