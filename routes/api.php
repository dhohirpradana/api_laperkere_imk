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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    // return $request->user();
    return auth()->user();
});

// Route::get('foto', 'FotoController@index');
Route::get('lpm', 'lpmController@index');

Route::post('login', 'API\UserController@login');
Route::post('register', 'API\UserController@register');

Route::group(['middleware' => 'auth:api'], function () {
// Route::group(["middleware" => ["jwt.verify"]], function () {
    Route::post('profile', 'API\UserController@details');

    Route::post('lpm', 'lpmController@create');

    Route::post('uploadFoto', 'lpmController@uploadFoto');

    Route::get('/lpm/{id}', 'lpmController@detail');
    Route::put('/lpm/{id}', 'lpmController@update');
    Route::delete('/lpm/{id}', 'lpmController@delete');
});
