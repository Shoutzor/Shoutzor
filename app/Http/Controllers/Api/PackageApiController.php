<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Package;
use App\Packages\PackageManager;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PackageApiController extends Controller
{
    public function __construct()
    {
        //$this->pm = app(PackageManager::class);
    }

    public function installed(Request $request)
    {
        $request->validate(['id' => 'string']);

        return response()->json([], 200);
    }

    /**
     * Enable a package
     *
     * @param  Request  $request
     * @return JsonResponse
     */
    public function enable(Request $request)
    {
        $request->validate(['id' => 'string']);

        //Return the failed response
        return response()->json(['message' => 'Package not found'], 400);
    }

    /**
     * Disable a package
     *
     * @param  Request  $request
     * @return JsonResponse
     */
    public function disable(Request $request)
    {
        $request->validate(['id' => 'string']);

        //Return the failed response
        return response()->json(['message' => 'Package not found'], 400);
    }

}
