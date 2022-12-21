<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmailController;

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

Route::post('register', 'Api\AuthController@register');
Route::post('login', 'Api\AuthController@login');
// Route::get('/email/verify/{id}/{hash}', [EmailVerificationController::class, '__invoke'])
//     ->middleware(['signed', 'throttle:6,1'])
//     ->name('verification.verify');

//     //Resend the link to verify
// Route::post('/email/verify/resend', function (Request $request) {
//     $request->user()->sendEmailVerificationNotification();
//     return back()->with('message', 'Verification link sent!');
// })->middleware(['auth:api', 'throttle:6,1'])->name('verification.send');

// Route::get('/email/verify/success', function () {
//     return view('mail');
// });


//Route::apiResource('/produks',App\Http\Controllers\ProdukController::class);


Route::group(['middleware' => 'auth:api'], function() {

    Route::get('announcement', 'Api\AnnouncementController@index');
    Route::get('announcement/{id}', 'Api\AnnouncementController@show');
    Route::post('announcement', 'Api\AnnouncementController@store');
    Route::put('announcement/{id}', 'Api\AnnouncementController@update');
    Route::delete('announcement/{id}', 'Api\AnnouncementController@destroy');

    Route::get('produk', 'Api\ProdukController@index');
    Route::get('produk/{id}', 'Api\ProdukController@show');
    Route::post('produk', 'Api\ProdukController@store');
    Route::put('produk/{id}', 'Api\ProdukController@update');
    Route::delete('produk/{id}', 'Api\ProdukController@destroy');

    Route::get('beli', 'Api\BeliController@index');
    Route::get('beli/{id}', 'Api\BeliController@show');
    Route::post('beli', 'Api\BeliController@store');
    Route::put('beli/{id}', 'Api\BeliController@update');
    Route::delete('beli/{id}', 'Api\BeliController@destroy');
    
    Route::get('logout', 'Api\AuthController@logout');
});

// Route::middleware('auth:api')->post('/logout', function (Request $request){
//     $request->user()->token()->delete();
//     return response([
//         'message' => 'Success Logout'
//     ]);
// });