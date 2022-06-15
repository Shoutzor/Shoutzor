<?php

namespace App\HealthCheck;

class HealthCheckManager
{

    private array $healthChecks;

    public function __construct()
    {
        $this->healthChecks = [];
    }

    public function registerHealthCheck(BaseHealthCheck $healthCheck, $isInstallCheck = false): void
    {
        $this->healthChecks[] = [
            'check' => $healthCheck,
            'isInstallCheck' => $isInstallCheck
        ];
    }

    public function getHealthStatus($includeInstallSteps = false): array
    {
        $data = [];

        foreach ($this->healthChecks as $check) {
            //Check if marked as an install step, then skip it if we don't want these included.
            if ($check['isInstallCheck'] && !$includeInstallSteps) {
                continue;
            }

            $healthCheck = $check['check'];
            $healthCheck->checkHealth();
            $data[] = $healthCheck->toArray();
        }

        return $data;
    }

    public function performAutoFix($includeInstallSteps = false): array
    {
        $data = [];
        $success = true;

        foreach ($this->healthChecks as $check) {
            //Check if marked as an install step, then skip it if we don't want these included.
            if ($check['isInstallCheck'] && !$includeInstallSteps) {
                continue;
            }

            $healthCheck = $check['check'];

            # Each healthcheck needs to be aware if it's healthy first.
            $healthCheck->checkHealth();

            # Skip healthchecks that are already healthy
            if ($healthCheck->isHealthy()) {
                continue;
            }

            # Next, we can perform the fix
            $result = $healthCheck->fix();

            // Check if any of the automatic repairs failed
            if ($result->isFixed() === false) {
                $success = false;
            }

            $data[] = [
                'name' => $healthCheck->getName(),
                'result' => $result->getMessage()
            ];
        }

        return [
            'result' => $success,
            'data' => $data
        ];
    }
}
