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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('login', 'API\UserController@login');
Route::post('register', 'API\UserController@register');
Route::get('register/confirm', 'API\UserController@confirm');
Route::get('/series/{series}', 'API\SeriesController@series');
Route::get('/profile/{user}', 'API\UserController@profile');
Route::get('/series', 'API\SeriesController@showAllseries');

Route::middleware('auth')->group(function(){

    Route::post('card/update', 'API\UserController@updateCard');
    Route::post('/subscribe', 'API\SubscriptionsController@subscribe');    
    Route::post('/subscription/change', 'API\SubscriptionsController@change');        
    Route::get('series/{series}/lesson/{lesson}', 'API\LessonController@showLesson');

});