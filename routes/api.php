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


Route::post('login', 'API\PassportController@login');
Route::post('register', 'API\PassportController@register');

//Route::middleware('auth:api')->group(function () {

    //Route::group(['middleware' => 'permission:admin'], function () {
        //  User routes
        Route::get('users', 'UserController@index');
        Route::post('users', 'UserController@store');
        Route::get('users/{id}', 'UserController@show');
        Route::post('users/{id}/update', 'UserController@update');
        Route::post('users/delete', 'UserController@destroy');
        Route::post('users/unique-email', 'UserController@checkUniqueEmail');

        //Articles routes
        Route::post('articles/{id}/update', 'ArticleController@update');
        Route::delete('articles/{id}', 'ArticleController@destroy');
    //});

    //Route::group(['middleware' => 'permission:admin,editor'], function () {
        // Article routes
        Route::post('articles', 'ArticleController@index');
        Route::get('articles', 'ArticleController@index');
        Route::post('articles/add', 'ArticleController@store');
        Route::get('articles/{id}', 'ArticleController@show');
    //});

    //logout
    Route::get('logout', 'API\PassportController@logout');
//});
