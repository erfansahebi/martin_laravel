<?php

namespace App\Http\Resources\Corporate;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CorporateResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray ( Request $request ): array
    {
        return [
            'id'   => $this->id,
            'name' => $this->name,
        ];
    }
}
