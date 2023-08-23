<?php

namespace App\Observers;

use App\Enums\OrderStatusEnum;
use App\Events\LocationChanged;
use App\Models\CourierLocation;
use App\Models\Order;

class CourierLocationObserver
{
    /**
     * Handle the CourierLocation "created" event.
     */
    public function created ( CourierLocation $courierLocation ): void
    {
        //
    }

    /**
     * Handle the CourierLocation "updated" event.
     */
    public function updated ( CourierLocation $courierLocation ): void
    {
        $orders = Order::with( [ 'corporate', ] )->where( 'courier_user_id', $courierLocation->courier_user_id )->whereIn( 'status', [
            OrderStatusEnum::AcceptedAndOnTheWayToTheOrigin->value,
            OrderStatusEnum::OnTheWayToTheDestination->value,
        ] )->get();
        if ( $orders->isEmpty() )
            return;

        foreach ( $orders as $order )
            LocationChanged::dispatch( $order->id, $order->corporate->web_hook_address, $courierLocation, $order->status );
    }

    /**
     * Handle the CourierLocation "deleted" event.
     */
    public function deleted ( CourierLocation $courierLocation ): void
    {
        //
    }

    /**
     * Handle the CourierLocation "restored" event.
     */
    public function restored ( CourierLocation $courierLocation ): void
    {
        //
    }

    /**
     * Handle the CourierLocation "force deleted" event.
     */
    public function forceDeleted ( CourierLocation $courierLocation ): void
    {
        //
    }
}
