<?php

namespace App\Http\Controllers\Api;

use App\HealthCheck\HealthCheckManager;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SystemApiController extends Controller
{

    public function getHealthStatus(Request $request)
    {
        $showInstallSteps = (bool) $request->showInstallSteps;
        $result = app(HealthCheckManager::class)->getHealthStatus($showInstallSteps);

        # Return the health status
        return response()->json($result, 200);
    }

    public function fixHealth(Request $request)
    {
        $showInstallSteps = (bool) $request->showInstallSteps;
        $result = app(HealthCheckManager::class)->performAutoFix($showInstallSteps);

        return response()->json($result, 200);
    }

}
