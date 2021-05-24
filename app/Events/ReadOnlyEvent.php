<?php

namespace App\Events;

use Exception;

/**
 * Class ReadOnlyEvent
 *
 * @package App\Events
 * Creates a read-only event, this cannot be marked invalid or stopped from propagating.
 */
class ReadOnlyEvent extends BaseEvent {
    public function stopPropagation(): void {
        //Ignore.
        throw new Exception("Something tried stopping the propagation on a read-only event");
    }

    /**
     * Marks the upload as invalid
     *
     * @throws Exception
     */
    public function setInvalid($reason = '') {
        throw new Exception("Something tried marking a read-only event as invalid");
    }

    /**
     * Returns whether the upload is valid or not
     *
     * @return bool
     */
    public function isValid(): bool {
        return true;
    }

    public function isPropagationStopped(): bool {
        return false;
    }
}
