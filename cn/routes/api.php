<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\UserController;
use \App\Http\Controllers\RecommendTripController;
use \App\Http\Controllers\GallaryController;

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

Route::get('/check_id', 'UserController@checkIdDuplicated');
Route::post('/register', 'UserController@create');
Route::post('/login', 'UserController@login');
Route::get('/logout', 'UserController@logout');

Route::get('/recommend_trip', 'RecommendTripController@read');
Route::get('/recommend_trip/rank', 'RecommendTripController@getRankedTrips');
Route::post('/recommend_trip', 'RecommendTripController@create');

Route::get('/images', 'GallaryController@read');
Route::post('/images', 'GallaryController@upload');
Route::get('/images/{image}', 'GallaryController@getImage');
