<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Auth\Access\Response;

class RequireInstalled
{
    public function handle($request, Closure $next)
    {
        if (config('shoutzor.installed') === true) {
            Response::allow();
            return $next($request);
        }

        return response()
            ->view('install-required', [], 503);
    }
}
