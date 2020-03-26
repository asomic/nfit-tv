<?php

/**
 *  TENANT ROUTES
 */
Route::middleware(['web', 'auth'])
    ->namespace('App\Http\Controllers\Tenant')
    ->group(function () {

    Route::get('/', 'HomeController@index')->name('home');

    Route::get('/cn', 'HomeController@cn');

    Route::post('expired-plans', 'HomeController@ExpiredPlan')->name('expiredplans');

    Route::get('/withoutrenewal', 'HomeController@withoutrenewal');

    Route::get('/incomes-summary', 'HomeController@incomessummary');

    /**
     *  CLASES ROUTES
     */
    Route::get('clases/{clase}/reservations', 'Admin\Clases\ClaseController@reservations')
        ->name('admin.clases.reservations');

    Route::get('get-wods', 'Admin\Clases\ClaseController@getWods');

    Route::get('get-clases', 'Admin\Clases\ClaseController@getClases');

    Route::get('/clases/type-select/', 'Admin\Clases\ClaseController@typeSelect')
            ->name('clases.type');

    /**
     *  Videos ROUTES
     */
    Route::resource('videos', 'Admin\Videos\VideoController');
});
