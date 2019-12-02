<?php

use Illuminate\Http\Request;

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
//------------------auth------------------------
Route::post('login', 'api\UserController@login');
Route::post('register', 'api\UserController@register');
Route::group(['middleware' => 'auth:api'], function () {
Route::post('details', 'api\UserController@details');
});
//-----------------------------
Route::post('search', 'api\ContactController@search')->middleware('auth:api');
Route::post('contacts', 'api\ContactController@store')->middleware('auth:api');
Route::post('contacts/create', 'api\ContactController@store')->middleware('auth:api');
Route::delete('contacts/{id}', 'api\ContactController@destroy')->middleware('auth:api');
Route::get('contacts', 'api\ContactController@index')->middleware('auth:api');
Route::get('contacts/{id}', 'api\ContactController@show')->middleware('auth:api');
Route::get('contacts/show/{id}', 'api\ContactController@show')->middleware('auth:api');
Route::put('contacts/{id}', 'api\ContactController@update')->middleware('auth:api');
