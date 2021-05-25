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
            $result = $check->fix();

            if(!$result) {
                $success = false;
            }

            $data[] = [
                'name' => $check->getName(),
                'result' => $result
            ];
        }

        return [
            'result' => $success,
            'data' => $data
        ];
    }
}