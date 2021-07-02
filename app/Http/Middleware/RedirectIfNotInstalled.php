<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Auth\Access\Response;

class RedirectIfNotInstalled
{
    public function handle($request, Closure $next)
    {
        if (config('shoutzor.installed') === true) {
            Response::allow();
            return $next($request);
        }

        return redirect(RouteServiceProvider::INSTALLER);
    }
}
