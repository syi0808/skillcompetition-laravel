<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\UserController;
use App\Http\Controllers\CalendarController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\CampgroundController;

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

Route::post("/register", 'UserController@create');
Route::post("/login", 'UserController@login');
Route::get("/logout", 'UserController@logout');

Route::get("/calendar", 'CalendarController@getCalendarByMonth');

Route::post('/reservation', 'ReservationController@create');

Route::get("/campground", 'CampgroundController@getCampground');
