<?php

namespace App\GraphQL\Directives;

use Closure;
use Nuwave\Lighthouse\Exceptions\DefinitionException;
use Nuwave\Lighthouse\Schema\Directives\BaseDirective;
use Nuwave\Lighthouse\Schema\Values\FieldValue;
use Nuwave\Lighthouse\Support\Contracts\FieldMiddleware;
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
        $fieldValue->setResolver(function ($root, $args, $context) {
            $user = $context?->user();
            $requireAuth = $this->directiveArgValue('requireAuth', false);
            $permissions = $this->directiveArgValue('permissions', []);
            $roles = $this->directiveArgValue('roles', []);

            if(!$user && $requireAuth) {
                throw new DefinitionException("Users are required to be authenticated to access this data");
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
                    throw new DefinitionException("User is unauthenticated");
                }

                foreach ($permissions as $permission) {
                    if(!$guestRole->hasPermissionTo($permission, 'api')) {
                        throw new DefinitionException("Guest does not have the '$permission' permission.");
                    }
                }
            }
            // If the user is authenticated
            else {
                foreach ($permissions as $permission) {
                    if(!$user->hasPermissionTo($permission, 'api')) {
                        throw new DefinitionException("User does not have the '$permission' permission.");
                    }
                }

                foreach ($roles as $role) {
                    if (!$user->hasRole($role)) {
                        throw new DefinitionException("User does not have the '$role' role.");
                    }
                }
            }

            return true;
        });

        return $next($fieldValue);
    }
}
