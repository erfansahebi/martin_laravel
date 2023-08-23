<?php

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::group( [
    'prefix' => 'auth',
], base_path( 'routes/groups/auth.php' ) );

Route::group( [
    'prefix'     => 'users',
    'middleware' => [
        'auth:api',
    ],
], base_path( 'routes/groups/user.php' ) );

Route::group( [
    'prefix'     => 'orders',
    'middleware' => [
        'auth:api',
    ],
], base_path( 'routes/groups/order.php' ) );

Route::get( '/health-check', \App\Http\Controllers\HealthCheckController::class );
