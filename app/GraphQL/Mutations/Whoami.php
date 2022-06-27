<?php

namespace App\GraphQL\Mutations;

use DanielDeWit\LighthouseSanctum\Traits\HasAuthenticatedUser;
use DanielDeWit\LighthouseSanctum\Traits\HasUserModel;
use Exception;
use GraphQL\Type\Definition\ResolveInfo;
use Illuminate\Contracts\Auth\Factory as AuthFactory;
use JetBrains\PhpStorm\ArrayShape;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;

/**
 * Override the original class because that always expects an email & password combination
 * Shoutz0r however uses a username & password combination
 */
class Whoami
{
    use HasAuthenticatedUser;
    use HasUserModel;

    protected AuthFactory $authFactory;

    public function __construct(AuthFactory $authFactory)
    {
        $this->authFactory = $authFactory;
    }

    /**
     * @param ResolveInfo $resolveInfo
     * @return string[]
     */
    #[ArrayShape(['user' => "\App\Models\User"])] public function __invoke($_, array $args, GraphQLContext $context, ResolveInfo $resolveInfo): array
    {
        $this->resolveInfo = $resolveInfo;
        $user = $this->getAuthenticatedUser();

        return [
            'user' => $this->getModelFromUser($user),
        ];
    }

    protected function getAuthFactory(): AuthFactory
    {
        return $this->authFactory;
    }
}
