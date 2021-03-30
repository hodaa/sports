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


Route::resource('v1/weeks', \App\Http\Controllers\WeekController::class);
Route::resource('v1/seasons', \App\Http\Controllers\SeasonController::class);
Route::get('v1/matches-by-year', [\App\Http\Controllers\MatchController::class,'getMatchesByYear']);

Route::resource('v1/matches', \App\Http\Controllers\MatchController::class);

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});
