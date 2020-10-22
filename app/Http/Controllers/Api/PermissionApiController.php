<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\User;
use Spatie\Permission\Models\Permission;
use Illuminate\Http\Request;

class PermissionApiController extends Controller {
    /**
     * Returns a single or all permissions
     * @param Request $request (optional) contains the ID of the permission to get
     * @return \Illuminate\Http\JsonResponse an array of permissions
     */
    public function get(Request $request) {
        $request->validate([
            'id' => 'required|numeric'
        ]);

        $permission = Permission::findById($request->id);

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
     * @param Request $request
     */
    public function user(Request $request) {
        $request->validate([
            'id' => 'numeric',
            'type' => 'string'
        ]);

        if($request->id) {
            if($request->user()->can('admin.permissions.permission.get') === false) {
                return response()->json([
                    'message' => 'You do not have the admin.permissions.permission.get permission'
                ], 403);
            }

            $user = User::find($request->id);

            if(!$user) {
                return response()->json([
                    'message' => 'No user with this ID could be found'
                ], 404);
            }
        } else {
            $user = $request->user();
        }

        $type = 'all';
        if(!$request->type) {
            $type = $request->type;
        }

        switch($type) {
            case "direct":
                $permissions = $user->getDirectPermissions();
                break;

            case "role":
                $permissions = $user->getPermissionsViaRoles();
                break;

            default:
                $permissions = $user->getAllPermissions();
        }

        return response()->json($permissions, 200);
    }
}
