<?php

/**
 *  prefix => 'users',
 *  middleware => 'auth:api'
 */

use App\Http\Controllers\UserController;

Route::get( '/', [
    UserController::class,
    'show'
] );

Route::put( '/', [
    UserController::class,
    'update'
] );

Route::group( [
    'prefix' => 'orders',
], base_path( 'routes/groups/user_order.php' ) );
