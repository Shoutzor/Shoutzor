<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\User;
use Spatie\Permission\Models\Role;
use Illuminate\Http\Request;

class RoleApiController extends Controller {

    /**
     * Returns a single or all roles, requires the permission: admin.permissions.role.get
     * @param Request $request (optional) contains the ID of the role to get
     * @return \Illuminate\Http\JsonResponse an array of roles
     */
    public function get(Request $request) {
        $request->validate([
            'id' => 'required|numeric'
        ]);

        $role = Role::findById($request->id);

        if (!$role) {
            $roles = Role::all();
        } else {
            $roles = [$role];
        }

        return response()->json($roles, 200);
    }

    /**
     * Returns the roles of the requested, or authenticated user
     * Requesting the roles of other users requires the permission: admin.permissions.role.get
     * @param Request $request
     */
    public function user(Request $request) {
        $request->validate([
            'id' => 'numeric'
        ]);

        if($request->id) {
            if($request->user()->can('admin.permissions.role.get') === false) {
                return response()->json([
                    'message' => 'You do not have the admin.permissions.role.get permission'
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

        $roles = $user->getRoleNames();

        return response()->json($roles, 200);
    }
}
