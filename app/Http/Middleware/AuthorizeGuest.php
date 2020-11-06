<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Auth\Access\Response;
use Illuminate\Support\Facades\Gate;
use Spatie\Permission\Models\Role;

/**
 * Since the spatie/laravel-permission package doesn't allow natively to assign a role to a guest user
 * this piece of middleware will intercept the request and execute the check manually.
 */
class AuthorizeGuest
{

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function handle($request, Closure $next)
    {
        Gate::before(function ($user, $ability) {
            if(!$user) {
                $role = Role::findByName('guest');

                //Check if the guest role could be found
                if($role) {
                    //Check if the guest role has the permission
                    if($role->hasPermissionTo($ability)) {
                        //Permit the request
                        Response::allow("");
                    }
                }
            }
        });

        return $next($request);
    }
}
