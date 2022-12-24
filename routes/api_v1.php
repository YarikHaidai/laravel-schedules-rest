<?php

use Illuminate\Support\Facades\Route;

// Schedules

// Auth required
Route::group(['middleware' => 'auth', 'prefix' => 'schedules'], function () {
    Route::post('/', 'ScheduleController@store')->name('schedules.store');
    Route::patch('/{schedule}', 'ScheduleController@update')->name('schedules.update');
    Route::get('/{schedule}', 'ScheduleController@show')->name('schedules.show');
    Route::delete('/{schedule}', 'ScheduleController@destroy')->name('schedules.destroy');
});

// Not required
Route::group(['middleware' => 'auth:api', 'prefix' => 'schedules'], function () {
    Route::post('/', 'ScheduleController@store')->name('schedules.store');
});
