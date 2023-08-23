<?php

namespace App\Http\Resources\User;

use App\Http\Resources\Corporate\CorporateResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class EmployeeUserResource extends JsonResource
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
            'corporates' => CorporateResource::collection( $this->corporates )->toArray( request: $request ),
        ];
    }
}
