<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Auth\Access\Response;

class RequireNotInstalled
{
    public function handle($request, Closure $next)
    {
        if (config('shoutzor.installed') === false) {
            Response::allow();
            return $next($request);
        }

        return redirect(RouteServiceProvider::HOME, 301);
    }
}
