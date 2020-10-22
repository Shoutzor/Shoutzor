<?php

namespace App\Http\Controllers\Api;

use App\Request;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionApiController extends Controller {

    public function getRole() {
        $roles = Role::all();
        return response()->json($roles, 200);
    }

    public function getPermission() {
        $permissions = Permission::all();
        return response()->json($permissions, 200);
    }

}
