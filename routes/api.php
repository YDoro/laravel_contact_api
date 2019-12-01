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
Route::resource('contacts', 'api\ContactController')->middleware('auth:api');
Route::post('contacts/search', 'api\ContactController@search')->middleware('auth:api');
