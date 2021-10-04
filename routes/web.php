<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/test', 'DashboardController@test')->name('test');
Route::get('/seed', 'DashboardController@seed')->name('seed');

Route::get('/', 'DashboardController@index')->name('dashboard');

Route::get('/login', 'AuthController@login')->name('login');
Route::post('/login', 'AuthController@do_login')->name('doLogin');

Route::middleware('auth')->group(function () {
    Route::get('/tracker', 'DashboardController@tracker')->name('tracker');

    Route::prefix('account')->group(function () {
        Route::get('{account_id}/view', 'AccountController@view')->name('accountView');
        Route::post('store', 'AccountController@store')->name('accountStore');
        Route::post('import', 'AccountController@import')->name('accountsImport');
    });
});
