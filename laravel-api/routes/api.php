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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::middleware('api')->group(function() {
    Route::post('/login', 'AuthController@login');
    Route::post('/register', 'AuthController@register');
    Route::get('/', 'AuthController@forbidden')->name('forbidden');

    Route::middleware('auth:api')->group(function() {
        Route::get('/user', 'UserController@index');
        Route::put('/user', 'UserController@update');
        Route::delete('/user', 'UserController@destroy');

        Route::get('/menu', 'MenuController@index');
        Route::resource('/poli', 'PoliController')->except(['create', 'edit']);
    });
});
