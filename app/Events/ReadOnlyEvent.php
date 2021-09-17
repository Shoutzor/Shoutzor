<?php

namespace App\Events;

use Exception;

/**
 * Creates a read-only event, this event cannot be marked as invalid or stopped from propagating.
 * @package App\Events
 */
class ReadOnlyEvent extends ShoutzorEvent
{
    /**
     * Will throw an exception when called, since you cannot stop propagation of a ReadOnlyEvent
     * @throws Exception
     */
    public function stopPropagation(): void
    {
        //Ignore.
        throw new Exception("Something tried stopping the propagation on a read-only event");
    }

    /**
     * Will throw an exception when called, since you cannot mark a ReadOnlyEvent as invalid
     * @throws Exception
     */
    public function setInvalid($reason = ''): void
    {
        throw new Exception("Something tried marking a read-only event as invalid");
    }

    /**
     * Returns if the event is valid. This will always be true for a ReadOnlyEvent.
     * @return bool will always be true
     */
    public function isValid(): bool
    {
        return true;
    }

    /**
     * Returns if the propagation of this event should be stopped. This will always be false for a ReadOnlyEvent.
     * @return bool will always be false
     */
    public function isPropagationStopped(): bool
    {
        return false;
    }
}
