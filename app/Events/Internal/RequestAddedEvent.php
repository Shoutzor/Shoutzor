<?php

namespace App\Events\Internal;

use App\Events\ReadOnlyEvent;
use App\Request;

/**
 * Class RequestAddedEvent
 *
 * @package App\Events
 * Gets called when a request is added to the Queue
 */
class RequestAddedEvent extends ReadOnlyEvent
{
    public const NAME = 'request.added';

    protected Request $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function getRequest(): Request
    {
        return $this->request;
    }
}
