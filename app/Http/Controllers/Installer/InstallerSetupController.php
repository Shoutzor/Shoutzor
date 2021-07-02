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

class InstallerSetupController extends Controller
{
    private array $installSteps;

    public function __construct()
    {
        $this->installSteps = [
            [
                'name' => 'Database migrations',
                'description' => 'Creates tables and indexes in the database',
                'slug' => 'migrate-database',
                'running' => false,
                'status' => -1
            ],
            [
                'name' => 'Generate Encryption Keys',
                'description' => 'creates the encryption keys needed to generate secure access tokens',
                'slug' => 'generate-keys',
                'running' => false,
                'status' => -1
            ],
            [
                'name' => 'Database seeding',
                'description' => 'Adds initial data to the database',
                'slug' => 'seed-database',
                'running' => false,
                'status' => -1
            ],
            [
                'name' => 'Finishing up',
                'description' => 'Finalize the installation',
                'slug' => 'finish-install',
                'running' => false,
                'status' => -1
            ]
        ];
    }

    public function getSetupSteps(Request $request)
    {
        return response()->json($this->installSteps, 200);
    }

    public function doMigrateDatabase(Request $request)
    {
        // Create initial result array
        $result = [
            'status' => 1,
            'error' => ''
        ];

        try {
            # Clear the cache config
            Artisan::call('migrate --force');
        } catch (Exception $e) {
            $result['status'] = 0;
            $result['error'] = $e->getMessage();
        }

        return response()->json($result, 200);
    }

    public function doPassportInstall(Request $request)
    {
        // Create initial result array
        $result = [
            'status' => 1,
            'error' => ''
        ];

        try {
            # Run the passport:install command
            Artisan::call('passport:install --force');
        } catch (Exception $e) {
            $result['status'] = 0;
            $result['error'] = $e->getMessage();
        }

        return response()->json($result, 200);
    }

    public function doDatabaseSeeding(Request $request)
    {
        // Create initial result array
        $result = [
            'status' => 1,
            'error' => ''
        ];

        try {
            # Seed the database
            Artisan::call('db:seed');
        } catch (Exception $e) {
            $result['status'] = 0;
            $result['error'] = $e->getMessage();
        }

        return response()->json($result, 200);
    }

    public function doFinishInstall(Request $request)
    {
        // Create initial result array
        $result = [
            'status' => 1,
            'error' => ''
        ];

        try {
            # Set installed to true
            config(['shoutzor.installed' => true]);

            // Set installed to true in the .env file too
            $editor = DotenvEditor::load();
            $editor->setKey('SHOUTZOR_INSTALLED', "true")->save();

            # Rebuild the config cache
            Artisan::call('config:cache');
        } catch (Exception $e) {
            $result['status'] = 0;
            $result['error'] = $e->getMessage();
        }

        return response()->json($result, 200);
    }
}
