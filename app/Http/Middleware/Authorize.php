<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Auth\Access\Response;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;

class Authorize extends \Illuminate\Auth\Middleware\Authorize
{
    /**
     * Since the spatie/laravel-permission package doesn't allow natively to assign a role to a guest user
     * this piece of middleware will intercept the request and execute the check manually.
     */
    public function handle($request, Closure $next, $ability, ...$models)
    {
        $user = Auth::guard('api')->user();

        try {
            // Check if the user is authenticated
            if (!$user) {
                //Get the Guest role
                $role = Role::findByName('guest');

                //Check if the guest role could be found
                if ($role) {
                    //Check if the guest role has the permission
                    if ($role->hasPermissionTo($ability)) {
                        //Permit the request
                        Response::allow();
                        return $next($request);
                    }
                }
            } else {
                if ($user->hasPermissionTo($ability)) {
                    Response::allow();
                    return $next($request);
                }
            }
        }
        catch(\Exception $e) {
            var_dump($ability);
            die();
        }
        return response()->json(["message" => "You do not have the required permissions"], 403);
    }
}
