<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::namespace('Api')->prefix('modal')->group(function () {
    Route::get('load', 'ModalController@load')->name('loadModal');
});

Route::namespace('Api')->prefix('ruport')->group(function () {
    Route::post('get_token', 'RUPortController@get_token')->name('getApiToken');
    Route::get('get_scholar_info', 'RUPortController@get_scholar_info')->name('getApiScholarInfo');
    Route::get('get_account_logs', 'RUPortController@get_account_logs')->name('getApiAccountLogs');
});