<?php

namespace App\Observers;

use App\Enums\OrderStatusEnum;
use App\Events\LocationChanged;
use App\Models\Order;

class OrderObserver
{

    public $afterCommit = true;

    /**
     * Handle the Order "created" event.
     */
    public function created ( Order $order ): void
    {
        //
    }

    /**
     * Handle the Order "updated" event.
     */
    public function updated ( Order $order ): void
    {
        if ( $order->isDirty( [ 'status' ] ) && in_array( needle: $order->status, haystack: [
                OrderStatusEnum::AcceptedAndOnTheWayToTheOrigin->value,
                OrderStatusEnum::OnTheWayToTheDestination->value,
                OrderStatusEnum::Done->value,
            ] ) )
            LocationChanged::dispatch( $order->id, $order->corporate->web_hook_address, $order->courierLocation, $order->status );
    }

    /**
     * Handle the Order "deleted" event.
     */
    public function deleted ( Order $order ): void
    {
        //
    }

    /**
     * Handle the Order "restored" event.
     */
    public function restored ( Order $order ): void
    {
        //
    }

    /**
     * Handle the Order "force deleted" event.
     */
    public function forceDeleted ( Order $order ): void
    {
        //
    }
}
