<?php

namespace App\Events;

/**
 * Class ReadOnlyEvent
 *
 * @package App\Events
 * Creates a read-only event, this cannot be marked invalid or stopped from propagating.
 */
class ReadOnlyEvent extends BaseEvent {
    public function stopPropagation(): void {
        //Ignore.
    }

    /**
     * Marks the upload as invalid
     */
    public function setInvalid($reason = '') {
        //Ignore.
    }

    /**
     * Returns whether the upload is valid or not
     * @return bool
     */
    public function isValid(): bool {
        return true;
    }

    public function isPropagationStopped(): bool {
        return false;
    }
}
