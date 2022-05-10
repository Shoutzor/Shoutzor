<?php

namespace App\MediaSource;

class MediaSource
{
    public function __construct(
        private string $identifier,
        private string $name,
        private string $icon
    ) {}

    public function getIdentifier(): string
    {
        return $this->identifier;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getIcon(): string
    {
        return $this->icon;
    }

    public function toArray(): array
    {
        return get_object_vars($this);
    }
}
