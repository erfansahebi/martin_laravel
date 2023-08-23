<?php

namespace App\Http\Resources\Courier;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CourierLocationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray ( Request $request ): array
    {
        return [
            'lat'        => $this->lat,
            'long'       => $this->long,
            'updated_at' => $this->updated_at,
        ];
    }
}
