<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::resource('/produk',
\App\Http\Controllers\ProdukController::class);

Route::resource('/announcement',
\App\Http\Controllers\AnnouncementController::class);

Route::get('/announcement', 'App\Http\Controllers\AnnouncementController@index')->name('announcement.index');