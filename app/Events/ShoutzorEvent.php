<?php

namespace App\Events;

use Symfony\Contracts\EventDispatcher\Event;

/**
  * Base Event class to be used by internal Events from Shoutz0r (ie: non-frontend)
 * @package App\Events
 */
class ShoutzorEvent extends Event
{
    protected bool $valid = true;
    protected string $reason;

    /**
     * Returns the reason why the event is marked as invalid
     * @return string
     */
    public function getReason(): string
    {
        return $this->reason;
    }

    /**
     * Marks the upload as invalid
     * @param  string  $reason if set, defines the reason why the event is invalid
     */
    public function setInvalid($reason = ''): void
    {
        $this->valid = false;
        $this->reason = $reason;
        $this->stopPropagation();
    }

    /**
     * Returns whether the event is valid or not
     * @return bool
     */
    public function isValid(): bool
    {
        return $this->valid;
    }
}
