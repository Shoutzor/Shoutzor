<?php

namespace App\Events;

use Symfony\Contracts\EventDispatcher\Event;

/**
 * Class BaseEvent
 * Base Event class to be used by other Events of Shoutz0r
 *
 * @package App\Events
 */
class BaseEvent extends Event
{
    protected bool $valid = true;
    protected string $reason;

    public function getReason(): string
    {
        return $this->reason;
    }

    /**
     * Marks the upload as invalid
     */
    public function setInvalid($reason = '')
    {
        $this->valid = false;
        $this->reason = $reason;
        $this->stopPropagation();
    }

    /**
     * Returns whether the upload is valid or not
     *
     * @return bool
     */
    public function isValid(): bool
    {
        return $this->valid;
    }
}
