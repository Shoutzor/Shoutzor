<?php

namespace App\Http\Controllers\Api;

use App\Package;
use App\Http\Controllers\Controller;
use App\Packages\PackageManager;
use Illuminate\Http\Request;

class PackageApiController extends Controller {

    private PackageManager $pm;

    public function __construct() {
        $this->pm = app(PackageManager::class);
    }

    public function installed(Request $request) {
        $request->validate([
            'id' => 'string'
        ]);

        $this->pm->updateClassmap();
        $packages = $this->pm->fetchPackages();
        $result = [];

        if($request->id !== null) {
            foreach($packages as $pkg) {
                if($request->id === $pkg->getId()) {
                    $result[] = new Package($pkg);
                } else {
                    return response()->json([
                        'message' => 'Package with id ' . $request->id . ' not found'
                    ], 404);
                }
            }
        } else {
            foreach($packages as $pkg) {
                $result[] = new Package($pkg);
            }
        }

        return response()->json($result, 200);
    }

}
