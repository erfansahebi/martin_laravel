<?php

namespace App\Http\Resources\Order;

use App\Http\Resources\Corporate\CorporateResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray ( Request $request ): array
    {
        return [
            'id'          => $this->id,
            'origin'      => [
                'origin_lat'            => $this->origin_lat,
                'origin_long'           => $this->origin_long,
                'origin_address'        => $this->origin_address,
                'provider_name'         => $this->provider_name,
                'provider_phone_number' => $this->provider_phone_number,
            ],
            'destination' => [
                'destination_lat'       => $this->destination_lat,
                'destination_long'      => $this->destination_long,
                'destination_address'   => $this->destination_address,
                'receiver_name'         => $this->receiver_name,
                'receiver_phone_number' => $this->receiver_phone_number,
            ],
            'status'      => $this->status,
            'corporate'   => CorporateResource::make( $this->corporate )->toArray( request: $request ),
        ];
    }
}
