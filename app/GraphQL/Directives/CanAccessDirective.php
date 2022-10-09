<?php

namespace App\GraphQL\Directives;

use Closure;
use GraphQL\Type\Definition\ResolveInfo;
use Nuwave\Lighthouse\Exceptions\AuthorizationException;
use Nuwave\Lighthouse\Schema\Directives\BaseDirective;
use Nuwave\Lighthouse\Schema\Values\FieldValue;
use Nuwave\Lighthouse\Support\Contracts\FieldMiddleware;
use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use Spatie\Permission\Models\Role;

final class CanAccessDirective extends BaseDirective implements FieldMiddleware
{
    public static function definition(): string
    {
        return /** @lang GraphQL */ <<<'GRAPHQL'
"""
Check if the user has the given permissioon
"""
directive @canAccess(
    """
    If authentication is required, defaults to false
    """
    requireAuth: Boolean
    """
    The permissions to check for
    """
    permissions: [String!]
    """
    The roles to check for
    """
    roles: [String!]
) on FIELD_DEFINITION
GRAPHQL;
    }

    /**
     * Ensure the user is authorized to access this field.
     */
    public function handleField(FieldValue $fieldValue, Closure $next): FieldValue
    {
        $previousResolver = $fieldValue->getResolver();

        $fieldValue->setResolver(function ($root, array $args, GraphQLContext $context, ResolveInfo $resolveInfo) use ($previousResolver) {
            $user = $context?->user();
            $requireAuth = $this->directiveArgValue('requireAuth', false);
            $permissions = $this->directiveArgValue('permissions', []);
            $roles = $this->directiveArgValue('roles', []);

            if(!$user && $requireAuth) {
                throw new AuthorizationException("Users are required to be authenticated to access this data");
            }

            // If the user is unauthenticated, but a role is required, return false.
            if (!$user) {
                $guestRole = Role::findByName('guest');

                if(!$guestRole) {
                    throw new \Exception("Guest role not found, your shoutz0r installation might be corrupted");
                }

                // Check if any roles other then "guest" are requested, as these can not be satisfied.
                if(
                    count($roles) > 1 ||
                    (count($roles) === 1 &&
                    !in_array("guest", $roles))
                ) {
                    throw new AuthorizationException("User is unauthenticated");
                }

                foreach ($permissions as $permission) {
                    if(!$guestRole->hasPermissionTo($permission, 'api')) {
                        throw new AuthorizationException("Guest does not have the '$permission' permission.");
                    }
                }
            }
            // If the user is authenticated
            else {
                foreach ($permissions as $permission) {
                    if(!$user->hasPermissionTo($permission, 'api')) {
                        throw new AuthorizationException("User does not have the '$permission' permission.");
                    }
                }

                foreach ($roles as $role) {
                    if (!$user->hasRole($role)) {
                        throw new AuthorizationException("User does not have the '$role' role.");
                    }
                }
            }

            return $previousResolver($root, $args, $context, $resolveInfo);
        });

        return $next($fieldValue);
    }
}
