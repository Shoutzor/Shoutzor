<?php

use Illuminate\Http\Request;
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


Route::post('auth/login',       'AuthApiController@login');
Route::post('auth/register',    'AuthApiController@register');

Route::group(['middleware' => 'auth:api'], function () {
    Route::get('auth/logout',   'AuthApiController@logout');
    Route::get('auth/user',     'AuthApiController@user');

    Route::get('permission/get/{id?}',  'PermissionApiController@get')->middleware('can:admin.permissions.permission.get')->where('id', '[0-9]+');
    Route::get('permission/user',       'PermissionApiController@user')->where('id', '[0-9]+');
    Route::get('permission/user/{id?}', 'PermissionApiController@user')->middleware('can:admin.permissions.permission.get')->where('id', '[0-9]+');
    Route::get('role/get/{id?}',        'RoleApiController@get')->middleware('can:admin.permissions.role.get')->where('id', '[0-9]+');
    Route::get('role/user',             'RoleApiController@user');

    //Admin
    Route::group(['middleware' => 'can:admin.access'], function() {
        //Admin - Packages
        Route::group(['middleware' => 'can:admin.packages'], function() {
            Route::get('package',           'PackageApiController@installed');
            Route::post('package/enable',   'PackageApiController@enable');
            Route::post('package/disable',  'PackageApiController@disable');
        });
    });
});

Route::group(['middleware' => ['can:website.access']], function() {
    Route::get('album',         'AlbumApiController@get');
    Route::get('artist',        'ArtistApiController@get');
    Route::get('request',       'RequestApiController@index');
    Route::get('history',       'HistoryApiController@index');
    Route::get('history/last',  'HistoryApiController@last');
    Route::post('upload',       'UploadApiController@store')->middleware('can:upload');
});
