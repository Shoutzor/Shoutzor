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

        //return response('Shoutz0r is not yet installed. Please check the README for information on how to install.', 503);
        return response()
            ->view('install-required', [], 503);
    }
}
