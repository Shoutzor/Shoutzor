<?php

namespace App\GraphQL\Subscriptions;

use App\Models\Request;
use GraphQL\Type\Definition\ResolveInfo;
use Illuminate\Http\Request as HttpRequest;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Nuwave\Lighthouse\Schema\Types\GraphQLSubscription;
use Nuwave\Lighthouse\Subscriptions\Subscriber;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;

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
        Log::info("authorize called");
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
        Log::info("filter called");
        return true;
    }

    /**
     * Encode topic name.
     *
     * @param Subscriber $subscriber
     * @param  string  $fieldName
     * @return string
     */
    public function encodeTopic(Subscriber $subscriber, string $fieldName): string
    {
        // Create a unique topic name based on the `author` argument
        Log::info("encode");
        Log::info(Str::snake($fieldName));
        return Str::snake($fieldName);
    }

    /**
     * Decode topic name.
     *
     * @param  string  $fieldName
     * @param  Request  $root
     * @return string
     */
    public function decodeTopic(string $fieldName, $root): string
    {
        Log::info("decode");
        Log::info(Str::snake($fieldName));

        return Str::snake($fieldName);
    }

    /**
     * Resolve the subscription.
     *
     * @param  Request $root
     * @param  array<string, mixed>  $args
     * @param  GraphQLContext  $context
     * @param  ResolveInfo  $resolveInfo
     * @return mixed
     */
    public function resolve($root, array $args, GraphQLContext $context, ResolveInfo $resolveInfo): Request
    {
        Log::info("resolve called");
        $root->load(['media', 'requested_by']);
        return $root;
    }
}
