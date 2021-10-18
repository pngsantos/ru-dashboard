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
Route::get('/clear-cache', function() {
    $exitCode = Artisan::call('cache:clear');
    $exitCode = Artisan::call('view:clear');
    // return what you want
});

Route::get('/sync-axies', function() {
    $exitCode = Artisan::call('AxieUpdates:sync');
    // return what you want
});

Route::get('/pull-slp-api', function() {
    $exitCode = Artisan::call('TodaySLP:pull');
    // return what you want
});

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
    Route::get('/daily_log', 'DashboardController@daily_log')->name('dailyLog');
    Route::get('/axies', 'DashboardController@axies')->name('axies');
    Route::get('/distros', 'DashboardController@distros')->name('distros');
    Route::get('/inventory', 'DashboardController@inventory')->name('inventory');
    Route::get('/payouts', 'DashboardController@payouts')->name('payouts');

    Route::post('/log/export', 'DashboardController@export_logs')->name('logsExport');
    Route::post('/log/import', 'AccountController@import_logs')->name('logsImport');

    Route::prefix('account')->group(function () {
        Route::get('{account_id}/view', 'AccountController@view')->name('accountView');
        Route::get('{account_id}/edit', 'AccountController@edit')->name('accountEdit');
        
        Route::post('store', 'AccountController@store')->name('accountStore');
        Route::post('delete', 'AccountController@delete')->name('accountDelete');
        Route::post('{account_id}/update', 'AccountController@update')->name('accountUpdate');
        Route::post('{account_id}/update_scholar', 'AccountController@update_scholar')->name('scholarUpdate');
        Route::post('import', 'AccountController@import')->name('accountsImport');
        Route::post('kick_scholar', 'AccountController@kick_scholar')->name('kickScholar');
    });

    Route::prefix('payout')->group(function () {
        Route::get('{id}/view', 'PayoutController@view')->name('payoutView');
        Route::get('{id}/edit', 'PayoutController@edit')->name('payoutEdit');
        Route::post('{id}/update', 'PayoutController@update')->name('updatePayout');
        Route::post('finalize', 'PayoutController@finalize')->name('finalizePayout');
    });
});
