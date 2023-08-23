<?php

namespace App\Listeners;

use App\Events\LocationChanged;
use App\Exceptions\Corporate\CorporateWebHookException;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendLocationNotification implements ShouldQueue
{
    use InteractsWithQueue;

    /**
     * Create the event listener.
     */
    public function __construct ()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle ( LocationChanged $event ): void
    {
        try
        {
            $response = \Http::post( url: $event->web_hook_address, data: [
                'order_id'        => $event->orderID,
                'courier_user_id' => $event->courierLocation->courier_user_id,
                'lat'             => $event->courierLocation->lat,
                'long'            => $event->courierLocation->long,
                'status'          => $event->status,
            ] );

            if ( ! $response->ok() )
                $this->fail( new CorporateWebHookException( code: $response->status() ) );
        }
        catch ( \Exception $e )
        {
            $this->fail( $e );
        }
    }
}
