<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Auth\Access\Response;

class RedirectIfInstalled
{
    /**
     * Since the spatie/laravel-permission package doesn't allow natively to assign a role to a guest user
     * this piece of middleware will intercept the request and execute the check manually.
     */
    public function handle($request, Closure $next)
    {
        if (config('shoutzor.installed') === false) {
            Response::allow();
            return $next($request);
        }

        return redirect(RouteServiceProvider::HOME);
    }
}
