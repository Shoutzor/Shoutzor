<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Package;
use App\Packages\PackageManager;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PackageApiController extends Controller {

    private PackageManager $pm;

    public function __construct() {
        $this->pm = app(PackageManager::class);
    }

    public function installed(Request $request) {
        $request->validate(['id' => 'string']);

        //@todo this can be removed once the package marketplace is implemented
        //At which point, manual installation of packages via the filesystem is no longer supported
        //(but can still be manually installed via the admin UI)
        $this->pm->updateClassmap();

        $packages = $this->pm->fetchPackages();
        $result = [];

        if($request->id !== null) {
            foreach($packages as $pkg) {
                if($request->id === $pkg->getId()) {
                    $result[] = new Package($pkg);
                }
                else {
                    return response()->json(['message' => 'Package with id ' . $request->id . ' not found'], 404);
                }
            }
        }
        else {
            foreach($packages as $pkg) {
                $result[] = new Package($pkg);
            }
        }

        return response()->json($result, 200);
    }

    /**
     * Enable a package
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function enable(Request $request) {
        $request->validate(['id' => 'string']);

        //@todo this can be removed once the package marketplace is implemented
        //At which point, manual installation of packages via the filesystem is no longer supported
        //(but can still be manually installed via the admin UI)
        $this->pm->updateClassmap();

        //Find the package via it's ID
        $pkg = $this->pm->findPackageById($request->id);

        //Check if the package was found
        if(is_null($pkg) === false) {
            //Enable the package
            $this->pm->enablePackage($pkg);
            $this->pm->updateEnabledPackagesList();

            //Return the success response
            return response()->json(new Package($pkg), 200);
        }

        //Return the failed response
        return response()->json(['message' => 'Package not found'], 400);
    }

    /**
     * Disable a package
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function disable(Request $request) {
        $request->validate(['id' => 'string']);

        //@todo this can be removed once the package marketplace is implemented
        //At which point, manual installation of packages via the filesystem is no longer supported
        //(but can still be manually installed via the admin UI)
        $this->pm->updateClassmap();

        //Find the package via it's ID
        $pkg = $this->pm->findPackageById($request->id);

        //Check if the package was found
        if(is_null($pkg) === false) {
            //Disable the package
            $this->pm->disablePackage($pkg);
            $this->pm->updateEnabledPackagesList();

            //Return the success response
            return response()->json(new Package($pkg), 200);
        }

        //Return the failed response
        return response()->json(['message' => 'Package not found'], 400);
    }

}
