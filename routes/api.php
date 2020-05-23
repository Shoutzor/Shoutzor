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

Route::group(['middleware' => 'auth'], function () {
    Route::post('login', 'AuthApiController@login');
    Route::post('register', 'AuthApiController@register');

    Route::group(['middleware' => 'auth:api'], function () {
        Route::get('logout', 'AuthApiController@logout');
        Route::get('user', 'AuthApiController@user');
    });
});

Route::get('album', 'AlbumApiController@get');
Route::get('request', 'RequestApiController@index');
