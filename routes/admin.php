<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Use command line to crate routes.
|
*/

Route::prefix(app()->getLocale())->middleware(['locale'])->group(function () {

    Route::get('/dashboard', 'Admin\DashboardsController@index')->name('admin-dashboard.index')->middleware('admins');
});