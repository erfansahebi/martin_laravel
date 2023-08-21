<?php

namespace App\Observers;

use App\Models\CourierLocation;

class CourierLocationObserver
{
    /**
     * Handle the CourierLocation "created" event.
     */
    public function created(CourierLocation $courierLocation): void
    {
        //
    }

    /**
     * Handle the CourierLocation "updated" event.
     */
    public function updated(CourierLocation $courierLocation): void
    {
        //
    }

    /**
     * Handle the CourierLocation "deleted" event.
     */
    public function deleted(CourierLocation $courierLocation): void
    {
        //
    }

    /**
     * Handle the CourierLocation "restored" event.
     */
    public function restored(CourierLocation $courierLocation): void
    {
        //
    }

    /**
     * Handle the CourierLocation "force deleted" event.
     */
    public function forceDeleted(CourierLocation $courierLocation): void
    {
        //
    }
}
