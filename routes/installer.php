<?php

use Illuminate\Support\Facades\Route;

/*
 * --------------------------------------------------------------------------
 * Routes within this group only work for the installer
 * --------------------------------------------------------------------------
 */
Route::get('database/getFields', 'InstallerDatabaseController@getDatabaseFields');
