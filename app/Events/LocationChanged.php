<?php

namespace App\Events;

use App\Models\CourierLocation;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class LocationChanged
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /**
     * Create a new event instance.
     */
    public function __construct ( public string $orderID, public string $web_hook_address, public CourierLocation $courierLocation, public int $status )
    {

    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn (): array
    {
        return [
            new PrivateChannel( 'channel-name' ),
        ];
    }
}
