<?php

use Illuminate\Support\Facades\Route;

Route::group(['middleware' => 'auth:api'], function () {

    // Dashboard
//    Route::group(['prefix' => 'dashboard'], function () {
//        Route::get('/caps', 'DashboardController@caps')->name('dashboard.caps');
//        Route::get('/statuses', 'DashboardController@statuses')->name('dashboard.statuses');
//        Route::get('/affiliates', 'DashboardController@affiliates')->name('dashboard.affiliates');
//        Route::get('/deposits', 'DashboardController@deposits')->name('dashboard.deposits');
//    });

});
