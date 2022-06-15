<?php

namespace App\Events;

use Symfony\Component\EventDispatcher\EventDispatcher;

class ShoutzorDispatcher extends EventDispatcher
{
    /**
     * Get all of the listeners for a given event name.
     *
     * @param string|null $eventName
     * @return array
     */
    public function getListeners(string $eventName = null)
    {
        $listeners = parent::getListeners($eventName);

        die("I work!");

        if ($eventName == 'eloquent.saved: App\Product') {
            $listeners = array_reverse($listeners);
        }

        return $listeners;
    }
}
