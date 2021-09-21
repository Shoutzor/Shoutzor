<?php

use Illuminate\Support\Facades\Route;

/*
 * --------------------------------------------------------------------------
 * Routes within this group only work for the installer
 * The middleware prevents the routes from working once shoutz0r is installed
 *
 * The steps & URL slugs are defined in App\Installer\Installer:$installSteps
 * --------------------------------------------------------------------------
 */
Route::group(['middleware' => 'can.install'], function() {
    Route::get('database/getFields', 'InstallerSetupController@getDatabaseFields');
    Route::post('database/configureDatabase', 'InstallerSetupController@configureDatabaseSettings');

    Route::get('setup', 'InstallerSetupController@getSetupSteps');
    Route::get('setup/{slug}', 'InstallerSetupController@installStep')->where('slug', '[a-z\-]+');
});