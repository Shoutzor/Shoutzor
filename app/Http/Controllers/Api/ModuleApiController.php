<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ModuleApiController extends Controller
{
    public function __construct()
    {
        //$this->pm = app(PackageManager::class);
    }

    public function get(Request $request)
    {
        return response()->json([], 200);
    }

    /**
     * Enable a Module
     *
     * @param  Request  $request
     * @return JsonResponse
     */
    public function enable(Request $request)
    {
        $request->validate(['id' => 'string']);

        //Return the failed response
        return response()->json(['message' => 'Module not found'], 400);
    }

    /**
     * Disable a Module
     *
     * @param  Request  $request
     * @return JsonResponse
     */
    public function disable(Request $request)
    {
        $request->validate(['id' => 'string']);

        //Return the failed response
        return response()->json(['message' => 'Module not found'], 400);
    }

}
