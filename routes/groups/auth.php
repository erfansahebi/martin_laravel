<?php

/*
 *  prefix => auth,
 */

use App\Http\Controllers\AuthController;

Route::group( [
    'middleware' => [
        'guest:api',
    ],
], function () {

    Route::post( '/login', [
        AuthController::class,
        'store'
    ] );

} );

Route::group( [
    'middleware' => [
        'auth:api',
    ],
], function () {

    Route::post( '/logout', [
        AuthController::class,
        'destroy'
    ] );

} );
