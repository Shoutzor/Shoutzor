<?php

namespace App\Http\Controllers\Installer;

use App\Exceptions\formValidationException;
use App\Http\Controllers\Controller;
use App\Installer\Installer;
use Illuminate\Http\Request;
use \Illuminate\Http\JsonResponse;

class InstallerDatabaseController extends Controller
{
    private Installer $installer;

    public function __construct()
    {
        $this->installer = new Installer();
    }

    public function getDatabaseFields(Request $request): JsonResponse
    {
        return response()->json($this->installer->getDbFields(), 200);
    }

    public function configureDatabaseSettings(Request $request): JsonResponse
    {
        $step = $this->installer->configureSql($request->dbtype, $request->host, $request->port, $request->database, $request->username, $request->password);
        $result = [
            'connection' => $step->succeeded()
        ];

        if($step->getException() instanceof formValidationException) {
            $errors = $step->getException()->getErrors();

            foreach($errors as $name=>$reason) {
                $result['messages'][$name] = $reason;
            }
        } elseif($step?->getException()?->getMessage() !== null) {
            $result['messages']['general'] = $step->getException()->getMessage();
        }

        return response()->json($result, 200);
    }
}
