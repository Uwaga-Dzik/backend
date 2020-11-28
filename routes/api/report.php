<?php

use Illuminate\Support\Facades\Route;

Route::group(['middleware' => 'auth:api'], function() {
    Route::post('report', 'Api\Report\ReportController@store');
    Route::put('report/{id}', 'Api\Report\ReportController@update');
    Route::delete('report/{id}', 'Api\Report\ReportController@delete');
    Route::get('report/{latitude}/{longitude}/{radius}', 'Api\Report\ReportController@indexByRadius');
});
