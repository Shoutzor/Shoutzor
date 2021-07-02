<?php

use Illuminate\Support\Facades\Route;

/*
 * --------------------------------------------------------------------------
 * Routes within this group only work for the installer
 * --------------------------------------------------------------------------
 */
Route::get('database/getFields', 'InstallerDatabaseController@getDatabaseFields');
Route::post('database/configureDatabase', 'InstallerDatabaseController@configureDatabaseSettings');

Route::get('setup', 'InstallerSetupController@getSetupSteps');
Route::prefix('setup')->group(function() {
    Route::get('migrate-database', 'InstallerSetupController@doMigrateDatabase');
    Route::get('generate-keys', 'InstallerSetupController@doPassportInstall');
    Route::get('seed-database', 'InstallerSetupController@doDatabaseSeeding');
    Route::get('finish-install', 'InstallerSetupController@doFinishInstall');
});