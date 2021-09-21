<?php

namespace App\Http\Controllers\Installer;

use App\Exceptions\formValidationException;
use App\Http\Controllers\Controller;
use App\Installer\Installer;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

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
        return response()->json(Installer::$installSteps, 200);
    }

    /**
     * Returns the valid Database fields
     * @param  Request  $request
     * @return JsonResponse
     */
    public function getDatabaseFields(Request $request): JsonResponse
    {
        return response()->json(Installer::$dbFields, 200);
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
     * Dynamically call the method from the Installer that belongs to the API slug
     * @param  Request  $request
     * @param  string  $slug
     * @return JsonResponse
     */
    public function installStep(Request $request, string $slug): JsonResponse
    {
        $installSteps = Installer::$installSteps;
        $method = null;

        // Check if the slug exists, if so, get the method that should be called
        foreach($installSteps as $step) {
            if($step['slug'] === $slug) {
                $method = $step['method'];
            }
        }

        // Check if a method was found, else throw a 404.
        if(is_null($method)) {
            throw new NotFoundHttpException;
        }

        // Call the method that belongs to the slug
        $step = $this->installer->{$method}();
        $result = [
            'status' => $step->succeeded() ? 1 : 0,
            'error' => $step->getException()?->getMessage() ?? ''
        ];

        return response()->json($result, 200);
    }
}