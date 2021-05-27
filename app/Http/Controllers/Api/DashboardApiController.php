<?php

namespace App\Http\Controllers\Api;

use App\HealthCheck\HealthCheckManager;
use App\Helpers\Filesystem;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

class DashboardApiController extends Controller {

    public function getHealthStatus(Request $request) {
        $result = app(HealthCheckManager::class)->getHealthStatus();

        # Return the health status
        return response()->json($result, 200);
    }

    public function fixHealth(Request $request) {
        $result = app(HealthCheckManager::class)->performAutoFix();

        return response()->json($result, 200);
    }

}
