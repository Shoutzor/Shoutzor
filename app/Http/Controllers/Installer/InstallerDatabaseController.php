<?php

namespace App\Http\Controllers\Installer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class InstallerDatabaseController extends Controller
{
    private array $dbValues;

    public function __construct()
    {
        //This array defines the required fields for each database type, as well as the validation parameters, type, and dotconfig key
        $this->dbValues = [
            'mysql' => [
                'host' => [
                    'validate' => 'required|string',
                    'dotconfig' => 'database.connections.mysql.host',
                    'type' => 'text',
                    'default' => 'localhost'
                ],
                'port' => [
                    'validate' => 'required|number',
                    'dotconfig' => 'database.connections.mysql.port',
                    'type' => 'text',
                    'default' => '3306'
                ],
                'database' => [
                    'validate' => 'required|string',
                    'dotconfig' => 'database.connections.mysql.database',
                    'type' => 'text',
                    'default' => 'shoutzor'
                ],
                'username' => [
                    'validate' => 'required|string',
                    'dotconfig' => 'database.connections.mysql.username',
                    'type' => 'text',
                    'default' => 'shoutzor'
                ],
                'password' => [
                    'validate' => 'required|string',
                    'dotconfig' => 'database.connections.mysql.password',
                    'type' => 'password',
                    'default' => ''
                ]
            ],
            'pgsql' => [
                'host' => [
                    'validate' => 'required|string',
                    'dotconfig' => 'database.connections.pgsql.host',
                    'type' => 'text',
                    'default' => 'localhost'
                ],
                'port' => [
                    'validate' => 'required|number',
                    'dotconfig' => 'database.connections.pgsql.port',
                    'type' => 'text',
                    'default' => '5432'
                ],
                'database' => [
                    'validate' => 'required|string',
                    'dotconfig' => 'database.connections.pgsql.database',
                    'type' => 'text',
                    'default' => 'shoutzor'
                ],
                'username' => [
                    'validate' => 'required|string',
                    'dotconfig' => 'database.connections.pgsql.username',
                    'type' => 'text',
                    'default' => 'shoutzor'
                ],
                'password' => [
                    'validate' => 'required|string',
                    'dotconfig' => 'database.connections.pgsql.password',
                    'type' => 'password',
                    'default' => ''
                ]
            ],
            'sqlsrv' => [
                'host' => [
                    'validate' => 'required|string',
                    'dotconfig' => 'database.connections.pgsql.host',
                    'type' => 'text',
                    'default' => 'localhost'
                ],
                'port' => [
                    'validate' => 'required|number',
                    'dotconfig' => 'database.connections.pgsql.port',
                    'type' => 'text',
                    'default' => '1433'
                ],
                'database' => [
                    'validate' => 'required|string',
                    'dotconfig' => 'database.connections.pgsql.database',
                    'type' => 'text',
                    'default' => 'shoutzor'
                ],
                'username' => [
                    'validate' => 'required|string',
                    'dotconfig' => 'database.connections.pgsql.username',
                    'type' => 'text',
                    'default' => 'shoutzor'
                ],
                'password' => [
                    'validate' => 'required|string',
                    'dotconfig' => 'database.connections.pgsql.password',
                    'type' => 'password',
                    'default' => ''
                ]
            ]
        ];
    }

    public function getDatabaseFields(Request $request)
    {
        return response()->json($this->dbValues, 200);
    }

    public function configureDatabaseSettings(Request $request)
    {
        // Create initial result array
        $result = [
            'validated' => false,
            'connection' => false,
            'messages' => []
        ];

        // Create a validator that checks if a valid database type has been provided
        $dbTypeValidator = Validator::make($request->all(), [
            'dbtype' => [
                'required',
                'string',
                Rule::in(array_keys($this->dbValues))
            ]
        ]);

        // Validate the provided database type
        if($dbTypeValidator->fails()) {
            $result['messages']['dbtype'] = 'Invalid database type provided';
            return response()->json($result, 200);
        }

        // Select the fields to use based on the selected database type
        $selectedDbValues = $this->dbValues[$request->dbtype];

        // Validate the provided values
        $errors = $request->validate(array_map(function($item) {
            return $item['validate'];
        }, $selectedDbValues));

        // Check if any validation errors occurred
        if(count($errors) > 0) {
            $result['messages'] = $errors;
            return response()->json($result, 200);
        }

        // Config values have passed basic validation
        $result['validated'] = true;

        // Create an array for the new config values
        $configValues = [];
        foreach($selectedDbValues as $name=>$item) {
            $configValues[$item['dotconfig']] = $request->$name;
        }

        // Set the new config values
        config($configValues);

        // Test database connection
        try {
            DB::connection()->getPdo();

            $result['connection'] = true;
            $result['messages'][] = 'Database settings have been set';
        } catch (\Exception $e) {
            $result['messages'][] = $e->getMessage();
        }

        return response()->json($result, 200);
    }
}
