<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::pattern('id', '[0-9]+');
Route::pattern('uuid', '[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}');

/*
 * --------------------------------------------------------------------------
 * These routes are always available
 * --------------------------------------------------------------------------
 */
Route::get('role/guest', 'RoleApiController@guest');
Route::get('permission/user', 'PermissionApiController@user');

/*
 * --------------------------------------------------------------------------
 * Routes within this group require to be authenticated
 * --------------------------------------------------------------------------
 */
Route::group(
    ['middleware' => 'auth:sanctum'],
    function () {
        Route::post('upload', 'UploadApiController@store')->middleware('can:website.upload');
        Route::get('role/user', 'RoleApiController@user');
    }
);
