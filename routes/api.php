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

Route::middleware('auth:api')->group(function () {

    // show user infos
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    //logout
    Route::get('logout', 'API\PassportController@logout');


    // Article routes
    Route::get('articles', 'ArticleController@index');
    Route::post('articles', 'ArticleController@store');
    Route::get('articles/{id}', 'ArticleController@show');
    Route::put('articles/{id}', 'ArticleController@update');
    Route::delete('articles/{id}', 'ArticleController@destroy');

});
