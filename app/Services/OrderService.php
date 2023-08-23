<?php

namespace App\Services;

use App\Enums\OrderStatusEnum;
use App\Exceptions\Order\OrderNotFoundException;
use App\Exceptions\Order\OrderCanNotBeAcceptedException;
use App\Exceptions\Order\OrderWrongStatusException;
use App\Exceptions\User\UserHasWrongRoleException;
use App\Http\Resources\Order\CorporateOrdersResource;
use App\Http\Resources\Order\CourierOrdersResource;
use App\Models\Order;
use App\Models\Role;
use App\Models\User;

class OrderService
{
    public function __construct ( private readonly \RolePermissionService $rolePermissionService )
    {
    }

    public function create ( ...$data ): Order
    {
        return Order::create( [
            ...$data,
            'status' => OrderStatusEnum::Pending->value,
        ] );
    }

    public function fetchListRelatedWithUser ( User $user ): \Illuminate\Database\Eloquent\Collection|array
    {
        if ( $this->rolePermissionService->userHasAnyRoles( $user, Role::COURIER ) )
            return $this->fetchAvailableListForCourier();
        elseif ( $this->rolePermissionService->userHasAnyRoles( $user, Role::EMPLOYEE ) )
            return $this->fetchListRelatedWithEmployee( userID: $user->id );

        throw new UserHasWrongRoleException();
    }

    public function fetchAvailableListForCourier (): \Illuminate\Database\Eloquent\Collection|array
    {
        return Order::with( [
            'corporate',
            'courier' => fn( $query ) => $query->with( [
                'location',
                'roles',
            ] ),
        ] )->where( 'status', OrderStatusEnum::Pending->value )->get();
    }

    public function fetchHistoryListForCourier ( int $userID ): \Illuminate\Database\Eloquent\Collection|array
    {
        return Order::with( [
            'corporate',
            'courier' => fn( $query ) => $query->with( [
                'location',
                'roles',
            ] ),
        ] )->where( 'courier_user_id', $userID )->get();
    }

    public function fetchListRelatedWithEmployee ( int $userID ): \Illuminate\Database\Eloquent\Collection|array
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

    public function fetchByID ( string $orderID ): \Illuminate\Database\Eloquent\Collection|Order
    {
        return Order::with( [
            'corporate',
            'courier' => fn( $query ) => $query->with( [
                'location',
                'roles',
            ] ),
        ] )->find( $orderID );
    }

    public function putInResource ( User $user, \Illuminate\Database\Eloquent\Builder|array|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model $order, bool $single = true ): CourierOrdersResource|CorporateOrdersResource|\Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        if ( $this->rolePermissionService->userHasAnyRoles( $user, Role::COURIER ) )
            return $single ? CourierOrdersResource::make( $order ) : CourierOrdersResource::collection( $order );
        elseif ( $this->rolePermissionService->userHasAnyRoles( $user, Role::EMPLOYEE ) )
            return $single ? CorporateOrdersResource::make( $order ) : CorporateOrdersResource::collection( $order );

        throw new UserHasWrongRoleException();
    }

    public function userRelatedWithOrder ( User $user, string $orderID ): bool
    {
        if ( $this->rolePermissionService->userHasAnyRoles( $user, Role::EMPLOYEE ) )
            return $user->corporates()->where( 'corporates.id', Order::find( $orderID )->corporate_id )->exists();
        elseif ( $this->rolePermissionService->userHasAnyRoles( $user, Role::COURIER ) )
            return Order::where( 'id', $orderID )->where( function ( $query ) use ( $user ) {
                $query->where( 'courier_user_id', $user->id )->orWhere( 'status', OrderStatusEnum::Pending->value );
            } )->exists();

        throw new UserHasWrongRoleException();
    }

    public function updateStatus ( User $user, string $orderID, int $status, string|float|null $lat, string|float|null $long ): Order
    {
        $order = Order::find( $orderID );

        $is_employee = $this->rolePermissionService->userHasAnyRoles( $user, Role::EMPLOYEE );

        if ( $status == OrderStatusEnum::Canceled->value && $order->status = OrderStatusEnum::AcceptedAndOnTheWayToTheOrigin->value && $is_employee )
        {
            $order->status = OrderStatusEnum::Canceled->value;
            $order->save();

            return $order;
        }
        elseif ( $is_employee )
            throw new OrderNotFoundException();
        elseif ( $status - $order->status != 1 )
            throw new OrderWrongStatusException();

        resolve( \UserService::class )->updateLocation( userID: $user->id, lat: $lat, long: $long );

        switch ( $status )
        {
            case OrderStatusEnum::AcceptedAndOnTheWayToTheOrigin->value:
                return $this->acceptation( userID: $user->id, orderID: $orderID );
            case OrderStatusEnum::OnTheWayToTheDestination->value:
            case OrderStatusEnum::Done->value:
                $order->courier_user_id = $user->id;
                $order->status          = $status;
                break;
            default:
                throw new OrderWrongStatusException();
        }

        $order->save();

        return $order;
    }

    protected function acceptation ( int $userID, string $orderID ): Order
    {
        return \DB::transaction( function () use ( $userID, $orderID ) {
            $order = Order::where( 'id', $orderID )->where( 'status', OrderStatusEnum::Pending->value )->lockForUpdate()->first();
            if ( empty( $order ) )
                throw new OrderCanNotBeAcceptedException();

            $order->status          = OrderStatusEnum::AcceptedAndOnTheWayToTheOrigin->value;
            $order->courier_user_id = $userID;
            $order->save();

            return $order;
        } );
    }

}
