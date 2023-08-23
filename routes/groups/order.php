<?php

/**
 *  prefix => 'orders',
 *  middleware => 'auth:api'
 */

use App\Http\Controllers\OrderController;

Route::post( '/', [
    OrderController::class,
    'store'
] );

Route::get( '/', [
    OrderController::class,
    'index'
] );

Route::group( [
    'prefix' => '{order_id}',
], function () {

    Route::get( '/', [
        OrderController::class,
        'show'
    ] );

    Route::put('/', [
        OrderController::class,
        'updateStatus'
    ]);

} );
