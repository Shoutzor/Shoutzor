<?php
use Illuminate\Foundation\Application;

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
Route::get('system/health/', 'SystemApiController@getHealthStatus');
Route::post('system/health/fix', 'SystemApiController@fixHealth');

/*
 * --------------------------------------------------------------------------
 * Routes within this group require Shoutz0r to be installed
 * --------------------------------------------------------------------------
 */
Route::group(
    ['middleware' => 'install.finished'],
    function () {
        Route::post('auth/login', 'AuthApiController@login');
        Route::get('role/guest', 'RoleApiController@guest');
        Route::get('permission/user', 'PermissionApiController@user');

        /*
         * --------------------------------------------------------------------------
         * Routes within this group require the website.access permission
         * --------------------------------------------------------------------------
         */
        Route::group(
            ['middleware' => 'can:website.access'],
            function () {
                Route::post('auth/register', 'AuthApiController@register');
                Route::get('album/get/{uuid}', 'AlbumApiController@get');
                Route::get('artist/get/{uuid}', 'ArtistApiController@get');
                Route::get('request', 'RequestApiController@index');
                Route::post('upload', 'UploadApiController@store')->middleware('can:website.upload');
                Route::get('vote/count', 'VoteApiController@count');
            }
        );

        /*
         * --------------------------------------------------------------------------
         * Routes within this group require to be authenticated
         * --------------------------------------------------------------------------
         */
        Route::group(
            ['middleware' => 'auth:api'],
            function () {
                Route::get('auth/logout', 'AuthApiController@logout');
                Route::get('auth/user', 'AuthApiController@user');
                Route::get('role/user', 'RoleApiController@user');

                /*
                * --------------------------------------------------------------------------
                * Routes within this group require the admin.access permission
                * --------------------------------------------------------------------------
                */
                Route::group(
                    ['middleware' => 'can:admin.access'],
                    function () {
                        Route::get('permission/user/{uuid?}', 'PermissionApiController@user')->middleware(
                            'can:admin.permissions.user.get'
                        );
                        Route::get('permission/get/{id?}', 'PermissionApiController@get')->middleware(
                            'can:admin.permissions.permission.get'
                        );
                        Route::get('role/get/{id?}', 'RoleApiController@get')
                            ->middleware('can:admin.permissions.role.get');
                    }
                );
            }
        );
    }
);
