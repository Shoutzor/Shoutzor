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

/*
 * --------------------------------------------------------------------------
 * These routes are always available
 * --------------------------------------------------------------------------
 */
Route::post('auth/login', 'AuthApiController@login');
Route::post('auth/register', 'AuthApiController@register');
Route::get('role/guest', 'RoleApiController@guest');
Route::get('permission/user', 'PermissionApiController@user');
Route::get('permission/get/{id?}', 'PermissionApiController@get')->middleware('can:admin.permissions.permission.get')->where('id', '[0-9]+');
Route::get('role/get/{id?}', 'RoleApiController@get')->middleware('can:admin.permissions.role.get')->where('id', '[0-9]+');

/*
 * --------------------------------------------------------------------------
 * Routes within this group require to be authenticated
 * --------------------------------------------------------------------------
 */
Route::group(['middleware' => 'auth:api'], function() {
    Route::get('auth/logout', 'AuthApiController@logout');
    Route::get('auth/user', 'AuthApiController@user');
    Route::get('role/user', 'RoleApiController@user');
    Route::post('upload', 'UploadApiController@store')->middleware('can:upload');

    Route::get('permission/user/{id?}', 'PermissionApiController@user')->middleware('can:admin.permissions.permission.get')->where('id', '[0-9]+');

    /*
    * --------------------------------------------------------------------------
    * Routes within this group require the website.access permission
    * --------------------------------------------------------------------------
    */
    Route::group(['middleware' => 'can:admin.access'], function() {
        //Admin - Packages
        Route::group(['middleware' => 'can:admin.packages'], function() {
            Route::get('package', 'PackageApiController@installed');
            Route::post('package/enable', 'PackageApiController@enable');
            Route::post('package/disable', 'PackageApiController@disable');
        });
    });

    /*
     * --------------------------------------------------------------------------
     * Routes within this group require the website.access permission
     * --------------------------------------------------------------------------
     */
    Route::group(['middleware' => 'can:website.access'], function() {
        Route::get('album/get/{id}', 'AlbumApiController@get')->where('id', '[0-9]+');
        Route::get('artist/get/{id}', 'ArtistApiController@get')->where('id', '[0-9]+');
        Route::get('request', 'RequestApiController@index');
    });
});
