<?php

namespace App\HealthCheck;

use App\HealthCheck\BaseHealthCheck;

class HealthCheckManager {

    private array $healthChecks;

    public function __construct() {
        $this->healthChecks = [];
    }

    public function registerHealthCheck(BaseHealthCheck $healthCheck): void {
        $this->healthChecks[] = $healthCheck;
    }

    public function getHealthStatus(): array {
        $data = [];

        foreach($this->healthChecks as $check) {
            $check->checkHealth();
            $data[] = $check->toArray();
        }

        return $data;
    }

    public function performAutoFix(): array {
        $data = [];
        $success = true;

        foreach($this->healthChecks as $check) {
            # Each healthcheck needs to be aware if it's healthy first.
            $check->checkHealth();

            # Skip healthchecks that are already healthy
            if($check->isHealthy()) {
                continue;
            }

            # Next, we can perform the fix
            $result = $check->fix();

            // Check if any of the automatic repairs failed
            if($result->isFixed() === false) {
                $success = false;
            }

            $data[] = [
                'name' => $check->getName(),
                'result' => $result->getMessage()
            ];
        }

        return [
            'result' => $success,
            'data' => $data
        ];
    }
}