<?php

use Illuminate\Http\Request;

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

Route::group(['prefix' => 'v1'], function(){
    Route::group(['prefix' => 'auth'], function () {
        Route::post('login', 'API\AuthController@login');

        Route::group(['middleware' => 'api'], function(){
            Route::post('logout', 'API\AuthController@logout');
            Route::post('refresh', 'API\AuthController@refresh');
            Route::get('me', 'API\AuthController@me');
        });
    });


    Route::group(['middleware' => 'api'], function(){
        Route::get('users', 'API\UsersController@index');
        Route::post('users', 'API\UsersController@addUser');
        Route::post('users/changerole', 'API\UsersController@changeRole');

        Route::get('posts', 'API\PostController@index');
        Route::post('posts', 'API\PostController@add');
        Route::get('post/{id}', 'API\PostController@view');
    });
});
