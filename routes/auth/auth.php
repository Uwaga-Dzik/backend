<?php

use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'auth'], function () {
    Route::post('register', 'Auth\AuthController@register');
    Route::post('login', 'Auth\AuthController@login');
});

Route::group(['middleware' => 'auth:api'], function() {
    Route::get('me', 'Auth\AuthController@me');
    Route::get('logout', 'Auth\AuthController@logout');
});
