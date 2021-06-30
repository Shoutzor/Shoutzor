<?php

namespace App\Http\Controllers\Installer;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Jackiedo\DotenvEditor\Facades\DotenvEditor;

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
                    'dotenv' => 'DB_HOST',
                    'type' => 'text',
                    'default' => 'localhost'
                ],
                'port' => [
                    'validate' => 'required|numeric|integer',
                    'dotconfig' => 'database.connections.mysql.port',
                    'dotenv' => 'DB_PORT',
                    'type' => 'text',
                    'default' => '3306'
                ],
                'database' => [
                    'validate' => 'required|string',
                    'dotconfig' => 'database.connections.mysql.database',
                    'dotenv' => 'DB_DATABASE',
                    'type' => 'text',
                    'default' => 'shoutzor'
                ],
                'username' => [
                    'validate' => 'required|string',
                    'dotconfig' => 'database.connections.mysql.username',
                    'dotenv' => 'DB_USERNAME',
                    'type' => 'text',
                    'default' => 'shoutzor'
                ],
                'password' => [
                    'validate' => 'required|string',
                    'dotconfig' => 'database.connections.mysql.password',
                    'dotenv' => 'DB_PASSWORD',
                    'type' => 'password',
                    'default' => ''
                ]
            ],
            'pgsql' => [
                'host' => [
                    'validate' => 'required|string',
                    'dotconfig' => 'database.connections.pgsql.host',
                    'dotenv' => 'DB_HOST',
                    'type' => 'text',
                    'default' => 'localhost'
                ],
                'port' => [
                    'validate' => 'required|numeric|integer',
                    'dotconfig' => 'database.connections.pgsql.port',
                    'dotenv' => 'DB_PORT',
                    'type' => 'text',
                    'default' => '5432'
                ],
                'database' => [
                    'validate' => 'required|string',
                    'dotconfig' => 'database.connections.pgsql.database',
                    'dotenv' => 'DB_DATABASE',
                    'type' => 'text',
                    'default' => 'shoutzor'
                ],
                'username' => [
                    'validate' => 'required|string',
                    'dotconfig' => 'database.connections.pgsql.username',
                    'dotenv' => 'DB_USERNAME',
                    'type' => 'text',
                    'default' => 'shoutzor'
                ],
                'password' => [
                    'validate' => 'required|string',
                    'dotconfig' => 'database.connections.pgsql.password',
                    'dotenv' => 'DB_PASSWORD',
                    'type' => 'password',
                    'default' => ''
                ]
            ],
            'sqlsrv' => [
                'host' => [
                    'validate' => 'required|string',
                    'dotconfig' => 'database.connections.sqlsrv.host',
                    'dotenv' => 'DB_HOST',
                    'type' => 'text',
                    'default' => 'localhost'
                ],
                'port' => [
                    'validate' => 'required|numeric|integer',
                    'dotconfig' => 'database.connections.sqlsrv.port',
                    'dotenv' => 'DB_PORT',
                    'type' => 'text',
                    'default' => '1433'
                ],
                'database' => [
                    'validate' => 'required|string',
                    'dotconfig' => 'database.connections.sqlsrv.database',
                    'dotenv' => 'DB_DATABASE',
                    'type' => 'text',
                    'default' => 'shoutzor'
                ],
                'username' => [
                    'validate' => 'required|string',
                    'dotconfig' => 'database.connections.sqlsrv.username',
                    'dotenv' => 'DB_USERNAME',
                    'type' => 'text',
                    'default' => 'shoutzor'
                ],
                'password' => [
                    'validate' => 'required|string',
                    'dotconfig' => 'database.connections.sqlsrv.password',
                    'dotenv' => 'DB_PASSWORD',
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
        if ($dbTypeValidator->fails()) {
            $result['messages']['dbtype'] = 'Invalid database type provided';
            return response()->json($result, 200);
        }

        // Select the fields to use based on the selected database type
        $selectedDbValues = $this->dbValues[$request->dbtype];

        // Validate the provided values
        $errors = Validator::make($request->all(), array_map(function ($item) {
            return $item['validate'];
        }, $selectedDbValues));

        $errors = $errors->errors()->getMessages();
        $errors = array_map(function ($item) {
            return $item[0];
        }, $errors);

        // Check if any validation errors occurred
        if (count($errors) > 0) {
            $result['messages'] = $errors;
            return response()->json($result, 200);
        }

        // Create an array for the new config values
        $dotConfigValues = [];
        $dotEnvValues = [];
        foreach ($selectedDbValues as $name => $item) {
            $dotConfigValues[$item['dotconfig']] = $request->$name;
            $dotEnvValues[$item['dotenv']] = $request->$name;
        }

        // Load the new config values in the current session
        config($dotConfigValues);

        // Test database connection
        try {
            DB::connection()->getPdo();
            $result['connection'] = true;

            //Write the values to the .env file
            $editor = DotenvEditor::load();
            $editor->setKey('DB_CONNECTION', $request->dbtype)
                ->setKeys($dotEnvValues)
                ->save();

            # Clear the cache config
            Artisan::call('config:cache');
        } catch (Exception $e) {
            $result['messages']['general'] = $e->getMessage();
        }

        return response()->json($result, 200);
    }
}
