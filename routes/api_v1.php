<?php

use Illuminate\Support\Facades\Route;

// Schedules

// Auth required
Route::group(['middleware' => 'auth', 'prefix' => 'schedules'], function () {
    Route::post('/', 'ScheduleController@store')->name('schedules.store');
    Route::get('/{schedule}', 'ScheduleController@show')->name('schedules.show');
});

// Not required
Route::group(['middleware' => 'auth:api', 'prefix' => 'schedules'], function () {
    Route::post('/', 'ScheduleController@store')->name('schedules.store');
});
