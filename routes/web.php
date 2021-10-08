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

Route::get('/', 'AuthController@login')->name('login');

// Route::get('/login', 'AuthController@login')->name('login');
Route::post('/login', 'AuthController@do_login')->name('doLogin');
Route::get('/logout', 'AuthController@do_logout')->name('doLogout');

Route::prefix('account')->group(function () {
    Route::get('/{account_id}', 'AccountController@index')->name('accountIndex');
    Route::get('/{log_id}/edit_log', 'AccountController@edit_log')->name('logEdit');
    Route::post('/{log_id}/update_log', 'AccountController@update_log')->name('logUpdate');
});


Route::middleware('auth')->group(function () {
    Route::get('/tracker', 'DashboardController@tracker')->name('tracker');
    Route::get('/axies', 'DashboardController@axies')->name('axies');
    Route::get('/finance', 'DashboardController@finance')->name('finance');

    Route::prefix('account')->group(function () {
        Route::get('{account_id}/view', 'AccountController@view')->name('accountView');
        Route::get('{account_id}/edit', 'AccountController@edit')->name('accountEdit');
        
        Route::post('store', 'AccountController@store')->name('accountStore');
        Route::post('delete', 'AccountController@delete')->name('accountDelete');
        Route::post('{account_id}/update', 'AccountController@update')->name('accountUpdate');
        Route::post('import', 'AccountController@import')->name('accountsImport');
        Route::post('import_logs', 'AccountController@import_logs')->name('logsImport');
        Route::post('kick_scholar', 'AccountController@kick_scholar')->name('kickScholar');
    });

    Route::prefix('payout')->group(function () {
        Route::get('{id}/view', 'AccountController@view')->name('payoutView');
    });
});
