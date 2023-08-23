<?php

namespace App\Services;

use App\Exceptions\User\UserHasWrongRoleException;
use App\Http\Resources\User\CourierUserResource;
use App\Http\Resources\User\EmployeeUserResource;
use App\Models\CourierLocation;
use App\Models\Order;
use App\Models\Role;
use App\Models\User;

class UserService
{
    public function __construct ( private readonly \RolePermissionService $rolePermissionService )
    {
    }

    public function putInResource ( \Illuminate\Database\Eloquent\Builder|array|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|User $user, bool $single = true ): EmployeeUserResource|CourierUserResource|\Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        if ( $this->rolePermissionService->userHasAnyRoles( $user, Role::EMPLOYEE ) )
            return $single ? EmployeeUserResource::make( $user ) : EmployeeUserResource::collection( $user );
        elseif ( $this->rolePermissionService->userHasAnyRoles( $user, Role::COURIER ) )
            return $single ? CourierUserResource::make( $user ) : CourierUserResource::collection( $user );

        throw new UserHasWrongRoleException();
    }

    public function updateLocation ( int $userID, string|float $lat, string|float $long ): void
    {
        CourierLocation::where( 'courier_user_id', $userID )->update( [
            'lat'  => $lat,
            'long' => $long,
        ] );
    }

    public function getOrders ( User $user ): \Illuminate\Database\Eloquent\Collection|array
    {
        if ( $this->rolePermissionService->userHasAnyRoles( $user, Role::EMPLOYEE ) )
            return resolve( \OrderService::class )->fetchListRelatedWithEmployee( userID: $user->id );
        elseif ( $this->rolePermissionService->userHasAnyRoles( $user, Role::COURIER ) )
            return resolve( \OrderService::class )->fetchHistoryListForCourier( userID: $user->id );

        throw new UserHasWrongRoleException();
    }

    public function getOrdersOfUserCorporates ( int $userID ): \Illuminate\Database\Eloquent\Collection|array
    {
        return Order::with( [
            'corporate',
            'courier' => fn( $query ) => $query->with( [
                'location',
                'roles',
            ] ),
        ] )->whereIn( 'corporate_id', User::with( [
            'corporates',
        ] )->find( $userID )->corporates->pluck( 'id' )->toArray() )->get();
    }

    public function checkUserBelongsToCorporate(User $user, int $corporateID): bool
    {
        if ( $this->rolePermissionService->userHasAnyRoles( $user, Role::EMPLOYEE ) )
            return User::with( [
                'corporates',
            ] )->find( $user->id )->corporates()->where( 'corporates.id', $corporateID )->exists();
        elseif ( $this->rolePermissionService->userHasAnyRoles( $user, Role::COURIER ) )
            return Order::where( 'corporate_id', $corporateID )->where( 'courier_user_id', $user->id )->exists();

        throw new UserHasWrongRoleException();
    }

}
