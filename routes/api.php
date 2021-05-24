<?php

use App\Mail\SendMailUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
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

Route::middleware('auth:api')->get('/user', function(Request $request) {
    return $request->user();
});

Route::group([
                 'prefix' => 'users',
                 'as'     => '.users',
             ], function() {
    Route::post('/', 'App\Http\Controllers\Users\UserController@store')->name('store');
});

Route::group([
                 'prefix' => 'transactions',
                 'as'     => '.transactions',
             ], function() {
    Route::post('/', 'App\Http\Controllers\Transactions\TransactionController@store')->name('store');
});

Route::post('/sendEmail', function() {
    Mail::to('gislanefabiano@gmail.com')->send(new SendMailUser());
});
