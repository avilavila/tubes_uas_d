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
Route::apiResource('/produks',App\Http\Controllers\ProdukController::class);

Route::apiResource('/announcements',App\Http\Controllers\AnnouncementController::class);

// Route::group(['middleware' => 'auth:api'], function() {
//     Route::get('announcement', 'Api\AnnouncementController@index');
//     Route::get('announcement/{id}', 'Api\AnnouncementController@show');
//     Route::post('announcement', 'Api\AnnouncementController@store');
//     Route::put('announcement/{id}', 'Api\AnnouncementController@update');
//     Route::delete('announcement/{id}', 'Api\AnnouncementController@destroy');
// });