<?php

namespace App\Http\Resources\User;

use App\Http\Resources\Courier\CourierLocationResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CourierUserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray ( Request $request ): array
    {
        return [
            ...UserResource::make( $this )->toArray( request: $request ),
            'location' => CourierLocationResource::make( $this->location )->toArray( request: $request ),
        ];
    }
}
