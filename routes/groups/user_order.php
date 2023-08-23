<?php

/**
 *  prefix => 'users/orders',
 *  middleware => [
 *      'auth:api'
 *  ],
 */

use App\Http\Controllers\UserController;

Route::get('/', [
    UserController::class,
    'orderIndex'
]);
