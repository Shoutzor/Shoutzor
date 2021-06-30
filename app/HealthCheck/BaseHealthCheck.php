<?php

namespace App\HealthCheck;

use JetBrains\PhpStorm\ArrayShape;
use JetBrains\PhpStorm\Pure;
use phpDocumentor\Reflection\Types\Boolean;

abstract class BaseHealthCheck
{

    protected string $name;
    protected string $description;
    protected string $status;
    protected bool $isHealthy;

    public function __construct($name, $description, $status)
    {
        $this->name = $name;
        $this->description = $description;
        $this->status = $status;
        $this->isHealthy = false;
    }

    #[Pure]
    #[ArrayShape(['name' => "string", 'description' => "string", 'status' => "string", 'healthy' => "bool"])]
    public function toArray(): array
    {
        return [
            'name' => $this->getName(),
            'description' => $this->getDescription(),
            'status' => $this->getStatus(),
            'healthy' => $this->isHealthy()
        ];
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getStatus(): string
    {
        return $this->status;
    }

    public function isHealthy(): bool
    {
        return $this->isHealthy;
    }

    abstract public function checkHealth(): void;

    abstract public function fix(): HealthCheckFixResult;

}