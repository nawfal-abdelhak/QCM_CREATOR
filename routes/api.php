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


Route::post('receiveData', 'Api\ApiController@receiveData');
Route::get('fetchMyQuizzes', 'Api\ApiController@fetchMyQuizzes');
Route::get('fetchQuizUsers/{quizId}', 'Api\ApiController@fetchQuizUsers');


Route::post('login', 'Api\LoginController@login');
Route::post('refresh', 'Api\LoginController@refresh');

Route::middleware('auth:api')->group(function () {

    Route::get('fetchAuth', 'Api\LoginController@fetchAuth');
    Route::post('logout', 'Api\LoginController@logout');

    Route::get('fetchMyQuizzes', 'Api\ApiController@fetchMyQuizzes');
});
