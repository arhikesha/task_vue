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

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:api');

//Route::group(['middleware'=>'auth:api'],function(){


    Route::get('task', 'TaskController@index');

    Route::put('task', 'TaskController@store');

    Route::post('task', 'TaskController@store');

    Route::delete('task/{id}', 'TaskController@destroy');
//});