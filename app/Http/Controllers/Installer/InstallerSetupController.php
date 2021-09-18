<?php

namespace App\Http\Controllers\Installer;

use App\Http\Controllers\Controller;
use App\Installer\Installer;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class InstallerSetupController extends Controller
{
    private Installer $installer;

    public function __construct()
    {
        $this->installer = new Installer();
    }

    public function getSetupSteps(Request $request): JsonResponse
    {
        return response()->json($this->installer->getSteps(), 200);
    }

    public function doMigrateDatabase(Request $request): JsonResponse
    {
        $step = $this->installer->migrateDatabase();
        $result = [
            'status' => $step->succeeded() ? 1 : 0,
            'error' => $step->getException()?->getMessage() ?? ''
        ];

        return response()->json($result, 200);
    }

    public function doPassportInstall(Request $request): JsonResponse
    {
        $step = $this->installer->installPassport();
        $result = [
            'status' => $step->succeeded() ? 1 : 0,
            'error' => $step->getException()?->getMessage() ?? ''
        ];

        return response()->json($result, 200);
    }

    public function doDatabaseSeeding(Request $request): JsonResponse
    {
        $step = $this->installer->seedDatabase();
        $result = [
            'status' => $step->succeeded() ? 1 : 0,
            'error' => $step->getException()?->getMessage() ?? ''
        ];

        return response()->json($result, 200);
    }

    public function doFinishInstall(Request $request): JsonResponse
    {
        $step = $this->installer->finishInstall();
        $result = [
            'status' => $step->succeeded() ? 1 : 0,
            'error' => $step->getException()?->getMessage() ?? ''
        ];

        return response()->json($result, 200);
    }
}
