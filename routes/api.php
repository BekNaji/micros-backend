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
    return $request->user();
});


Route::middleware(['api','cors'])->prefix('action')->group(function() {

	Route::get('all','Api\ActionController@all');
	Route::get('get','Api\ActionController@get');
	Route::get('gain','Api\ActionController@gain');
	Route::post('save','Api\ActionController@save');
	Route::post('delete','Api\ActionController@delete');
	Route::post('update','Api\ActionController@update');
	Route::get('ie','Api\ActionController@ie');
});

Route::prefix('category')->group(function() {
	Route::get('all','Api\CategoryController@all');
	Route::get('get','Api\CategoryController@get');
	Route::post('save','Api\CategoryController@save');
	Route::post('update','Api\CategoryController@update');
	Route::post('delete','Api\CategoryController@delete');
	Route::get('getGain','Api\CategoryController@getGain');
	Route::get('getCost','Api\CategoryController@getCost');
});

