<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionApiController extends Controller
{
    /**
     * Returns a single or all permissions
     *
     * @param int|null $id
     * @return JsonResponse an array of permissions
     */
    public function get(int $id = null)
    {
        $permission = Permission::findById($id);

        if (!$permission) {
            $permissions = Permission::all();
        } else {
            $permissions = [$permission];
        }

        return response()->json($permissions, 200);
    }

    /**
     * Returns the permissions of the requested, or authenticated user
     * Requesting the permissions of other users requires the permission: admin.permissions.permission.get
     * You can filter the permissions via the "type" parameter. Use: all, role or direct.
     * All will return the combined permissions from both direct-user permissions, and the inherited roles
     * Role will return only the permissions inherited from roles
     * Direct will return only the permissions directly assigned to the user
     *
     * @param Request $request
     * @param int|null $id
     * @param string $type
     * @return JsonResponse an array of permissions
     */
    public function user(Request $request, string $uuid = null, string $type = "all")
    {
        if ($uuid) {

            $user = User::find($uuid);

            if (!$user) {
                return response()->json(['message' => 'No user with ID ' . $uuid . ' could be found'], 404);
            }
        } else {
            $user = $request->user();
        }

        if ($user) {
            switch ($type) {
                case "all":
                    $permissions = $user->getAllPermissions();
                    break;

                case "direct":
                    $permissions = $user->getDirectPermissions();
                    break;

                case "role":
                    $permissions = $user->getPermissionsViaRoles();
                    break;

                default:
                    return response()->json(['message' => 'Invalid type provided'], 400);
            }
        } //Guest user
        else {
            $role = Role::findByName('guest');
            $permissions = [];

            //Check if the guest role could be found
            if ($role) {
                $permissions = $role->permissions;
            }
        }

        return response()->json($permissions, 200);
    }
}
