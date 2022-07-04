<?php

namespace App\GraphQL\Subscriptions;

use Illuminate\Http\Request as HttpRequest;
use Nuwave\Lighthouse\Schema\Types\GraphQLSubscription;
use Nuwave\Lighthouse\Subscriptions\Subscriber;

final class RequestAdded extends GraphQLSubscription
{
    /**
     * Check if subscriber is allowed to listen to the subscription.
     *
     * @param Subscriber $subscriber
     * @param HttpRequest $request
     * @return bool
     */
    public function authorize(Subscriber $subscriber, HttpRequest $request): bool
    {
        return true;
    }

    /**
     * Filter which subscribers should receive the subscription.
     *
     * @param Subscriber $subscriber
     * @param  mixed  $root
     * @return bool
     */
    public function filter(Subscriber $subscriber, $root): bool
    {
        return true;
    }
}
