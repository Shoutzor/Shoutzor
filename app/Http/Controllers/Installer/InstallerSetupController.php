<?php

namespace App\Http\Controllers\Installer;

use App\Exceptions\formValidationException;
use App\Http\Controllers\Controller;
use App\Installer\Installer;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/**
 * Handles the API-calls from the Graphical Installer
 */
class InstallerSetupController extends Controller
{
    private Installer $installer;

    public function __construct()
    {
        $this->installer = new Installer();
    }

    /**
     * Returns the steps for the installation
     * @param  Request  $request
     * @return JsonResponse
     */
    public function getSetupSteps(Request $request): JsonResponse
    {
        return response()->json($this->installer->getSteps(), 200);
    }

    /**
     * Returns the valid Database fields
     * @param  Request  $request
     * @return JsonResponse
     */
    public function getDatabaseFields(Request $request): JsonResponse
    {
        return response()->json($this->installer->getDbFields(), 200);
    }

    /**
     * Configures the database
     * @param  Request  $request
     * @return JsonResponse
     */
    public function configureDatabaseSettings(Request $request): JsonResponse
    {
        $step = $this->installer->configureSql($request->dbtype, $request->host, $request->port, $request->database, $request->username, $request->password);
        $result = [
            'connection' => $step->succeeded()
        ];

        // Check if it's a formValidation exception, or regular exception
        if($step->getException() instanceof formValidationException) {
            // $errors will now contain formValidationFieldError[] from the exception
            $errors = $step->getException()->getErrors();

            // Convert the array of formValidationFieldError objects into an array
            foreach($errors as $e) {
                $result['messages'][$e->getField()] = $e->getMessage();
            }
        } elseif($step?->getException()?->getMessage() !== null) {
            $result['messages']['general'] = $step->getException()->getMessage();
        }

        return response()->json($result, 200);
    }

    /**
     * Performs the key:generate step
     * @param  Request  $request
     * @return JsonResponse
     */
    public function doGenerateAppKey(Request $request): JsonResponse
    {
        $step = $this->installer->generateAppKey();
        $result = [
            'status' => $step->succeeded() ? 1 : 0,
            'error' => $step->getException()?->getMessage() ?? ''
        ];

        return response()->json($result, 200);
    }

    /**
     * Performs the migrate database step
     * @param  Request  $request
     * @return JsonResponse
     */
    public function doMigrateDatabase(Request $request): JsonResponse
    {
        $step = $this->installer->migrateDatabase();
        $result = [
            'status' => $step->succeeded() ? 1 : 0,
            'error' => $step->getException()?->getMessage() ?? ''
        ];

        return response()->json($result, 200);
    }

    /**
     * Performs the passport install step
     * @param  Request  $request
     * @return JsonResponse
     */
    public function doPassportInstall(Request $request): JsonResponse
    {
        $step = $this->installer->installPassport();
        $result = [
            'status' => $step->succeeded() ? 1 : 0,
            'error' => $step->getException()?->getMessage() ?? ''
        ];

        return response()->json($result, 200);
    }

    /**
     * Performs the database seeding step
     * @param  Request  $request
     * @return JsonResponse
     */
    public function doDatabaseSeeding(Request $request): JsonResponse
    {
        $step = $this->installer->seedDatabase();
        $result = [
            'status' => $step->succeeded() ? 1 : 0,
            'error' => $step->getException()?->getMessage() ?? ''
        ];

        return response()->json($result, 200);
    }

    /**
     * Performs the finish Install step
     * @param  Request  $request
     * @return JsonResponse
     */
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
