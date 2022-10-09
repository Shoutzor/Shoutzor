<?php

namespace App\Policies;

use App\Models\Role;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class RolePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the model.
     *
     * @param  ?User  $user
     * @param  ?Role  $role
     * @return Response|bool
     */
    public function view(?User $user = null, ?Role $role = null) : Response|bool
    {
        if($role) {
            // Guest role is always visible
            if (strtolower($role->name) === 'guest') {
                return true;
            }
        }

        // admin permission to list roles is authorized too
        if($user?->hasPermissionTo('admin.role.list')) {
            return true;
        }

        if($role) {
            // Finally if the user has the requested role it is allowed too
            if ($user->hasRole($role->name)) {
                return true;
            }
        }

        // Otherwise, deny the request.
        return false;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  User  $user
     * @return Response|bool
     */
    public function create(User $user) : Response|bool
    {
        // Simply check if the user has the permission to create a role
        return $user->can('admin.role.create');
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  User  $user
     * @param  Role  $role
     * @return Response|bool
     */
    public function update(User $user, Role $role) : Response|bool
    {
        return $user->can('admin.role.edit');
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  User  $user
     * @param  Role  $role
     * @return Response|bool
     */
    public function delete(User $user, Role $role) : Response|bool
    {
        // System-protected roles cannot be deleted as these have hard-coded references
        // (for example the "guest" role is used for unauthenticated users)
        if($role->protected) {
            return false;
        }

        // Else, check if the user has the permission to delete roles
        return $user->can('admin.role.delete');
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  User  $user
     * @param  Role  $role
     * @return Response|bool
     */
    public function forceDelete(User $user, Role $role) : Response|bool
    {
        return $this->delete($user, $role);
    }
}
