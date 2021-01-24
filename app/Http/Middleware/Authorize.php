<?php

namespace App\Http\Middleware;

use Closure;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;

/**
 * Since the spatie/laravel-permission package doesn't allow natively to assign a role to a guest user
 * this piece of middleware will intercept the request and execute the check manually.
 */
class Authorize extends \Illuminate\Auth\Middleware\Authorize
{
    public function handle($request, Closure $next, $ability, ...$models)
    {
        $user = Auth::user();

        // Check if the user is authenticated
        if(!$user) {
            //Get the Guest role
            $role = Role::findByName('guest');

            //Check if the guest role could be found
            if($role) {
                //Check if the guest role has the permission
                if($role->hasPermissionTo($ability)) {
                    //Permit the request
                    return $next($request);
                }
            }
        }

        $this->gate->authorize($ability, $this->getGateArguments($request, $models));
        return $next($request);
    }
}
