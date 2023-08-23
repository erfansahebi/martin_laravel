<?php

namespace App\Providers;

use App\Services\AuthService;
use App\Services\OrderService;
use App\Services\RolePermissionService;
use App\Services\UserService;
use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Support\DeferrableProvider;

class ServicesServiceProvider extends ServiceProvider implements DeferrableProvider
{

    public function register (): void
    {
        $role_permission_service = new RolePermissionService();

        $this->app->singleton( RolePermissionService::class, function ( $app ) {
            return new RolePermissionService();
        } );

        $this->app->singleton( AuthService::class, function ( $app ) use ( $role_permission_service ) {
            return new AuthService( rolePermissionService: $role_permission_service );
        } );

        $this->app->singleton( UserService::class, function ( $app ) use ( $role_permission_service ) {
            return new UserService( rolePermissionService: $role_permission_service );
        } );

        $this->app->singleton( OrderService::class, function ( $app ) use ( $role_permission_service ) {
            return new OrderService( rolePermissionService: $role_permission_service );
        } );
    }


    public function provides (): array
    {
        return [
            RolePermissionService::class,
            AuthService::class,
            UserService::class,
            OrderService::class,
        ];
    }

}
