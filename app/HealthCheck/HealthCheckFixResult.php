<?php

namespace App\HealthCheck;

class HealthCheckFixResult
{

    private bool $fixed;
    private string $message;

    public function __construct()
    {
        $this->fixed = false;
        $this->message = '';
    }

    public function isFixed(): bool
    {
        return $this->fixed;
    }

    public function setFixed(bool $fixed): void
    {
        $this->fixed = $fixed;
    }

    public function getMessage(): string
    {
        return $this->message;
    }

    public function setMessage(string $message): void
    {
        $this->message = $message;
    }

}