<?php

namespace App\GraphQL\Subscriptions;

use Illuminate\Http\Request;
use GraphQL\Type\Definition\ResolveInfo;
use Nuwave\Lighthouse\Schema\Types\GraphQLSubscription;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use Nuwave\Lighthouse\Subscriptions\Subscriber;

final class LastPlayedUpdated extends GraphQLSubscription
{
    /**
     * Check if subscriber is allowed to listen to the subscription.
     *
     * @param Subscriber $subscriber
     * @param Request $request
     * @return bool
     */
    public function authorize(Subscriber $subscriber, Request $request): bool
    {
        return true;

        /*$user = $subscriber->context->user;
        $author = User::find($subscriber->args['author']);

        return $user->can('website.access', $author);*/
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
        //Everyone should receive this event.
        return true;
    }

    /**
     * Resolve the subscription.
     *
     * @param  \App\Models\Request  $root
     * @param  array<string, mixed>  $args
     * @param GraphQLContext $context
     * @param ResolveInfo $resolveInfo
     * @return mixed
     */
    public function resolve($root, array $args, GraphQLContext $context, ResolveInfo $resolveInfo): Request
    {
        // Optionally manipulate the `$root` item before it gets broadcasted to
        // subscribed client(s).
        $root->load(['media', 'media.artists', 'requested_by']);

        return $root;
    }
}
