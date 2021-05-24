<?php

namespace App\Http\Controllers\Api;

use App\Helpers\Filesystem;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

class DashboardApiController extends Controller {

    public function getHealthStatus(Request $request) {
        $healthStatus = [
            'symlinks' => [
                'healthy' => true,
                'status' => 'All symlinks are created and accessible'
            ]
        ];

        # Check if all symlinks exist
        $symLinks = config('filesystems.links');
        foreach($symLinks as $symlinkLocation=>$targetLocation) {
            clearstatcache(false, $symlinkLocation);
            if(Filesystem::isSymbolicLink($symlinkLocation) === false) {
                $healthStatus['symlinks']['healthy'] = false;
                $healthStatus['symlinks']['status'] = "Not all symlinks exist";
                break;
            }

            if(is_readable($symlinkLocation) === false) {
                $healthStatus['symlinks']['healthy'] = false;
                $healthStatus['symlinks']['status'] = "Not all symlinks are readable, check: $symlinkLocation";
                break;
            }
        }

        # Return the health status
        return response()->json($healthStatus, 200);
    }

    public function fixHealth(Request $request) {
        # Ensure all required symlinks exist
        $exitCode = Artisan::call('storage:link');

        return response()->json(["exitCode" => $exitCode], 200);
    }

}
