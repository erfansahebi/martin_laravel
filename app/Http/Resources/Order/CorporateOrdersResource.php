<?php

namespace App\Http\Resources\Order;

use App\Enums\OrderStatusEnum;
use App\Http\Resources\User\CourierUserResource;
use App\Http\Resources\User\UserResource;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CorporateOrdersResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray ( Request $request ): array
    {
        $data = [
            ...OrderResource::make( $this )->toArray( request: $request ),
        ];

        if ( empty( $this->courier_user_id ) )
            $data[ 'courier' ] = null;
        elseif ( in_array( needle: $this->status, haystack: [
            OrderStatusEnum::AcceptedAndOnTheWayToTheOrigin->value,
            OrderStatusEnum::OnTheWayToTheDestination->value,
        ] ) )
            $data[ 'courier' ] = CourierUserResource::make( $this->courier )->toArray( request: $request );
        else
            $data[ 'courier' ] = UserResource::make( $this->courier )->toArray( request: $request );

        return $data;
    }
}
