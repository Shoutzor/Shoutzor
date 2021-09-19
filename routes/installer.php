<?php

use Illuminate\Support\Facades\Route;

/*
 * --------------------------------------------------------------------------
 * Routes within this group only work for the installer
 * The middleware prevents the routes from working once shoutz0r is installed
 * --------------------------------------------------------------------------
 */
Route::group(['middleware' => 'can.install'], function() {
    Route::get('database/getFields', 'InstallerSetupController@getDatabaseFields');
    Route::post('database/configureDatabase', 'InstallerSetupController@configureDatabaseSettings');

    Route::get('setup', 'InstallerSetupController@getSetupSteps');
    Route::prefix('setup')->group(function() {
        Route::get('migrate-database', 'InstallerSetupController@doMigrateDatabase');
        Route::get('generate-keys', 'InstallerSetupController@doPassportInstall');
        Route::get('seed-database', 'InstallerSetupController@doDatabaseSeeding');
        Route::get('finish-install', 'InstallerSetupController@doFinishInstall');
    });
});