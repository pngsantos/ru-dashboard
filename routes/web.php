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

Route::get('/', 'DashboardController@index')->name('dashboard');
Route::get('/tracker', 'DashboardController@tracker')->name('tracker');

Route::prefix('account')->group(function () {
    Route::post('store', 'AccountController@store')->name('accountStore');
    Route::post('import', 'AccountController@import')->name('accountsImport');
});
