<?php

namespace App\Http\Requests\User;

use App\Models\Role;
use App\Rules\Location\LatRule;
use App\Rules\Location\LongRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize (): bool
    {
        return resolve( \RolePermissionService::class )->userHasAnyRoles( \Auth::user(), Role::COURIER );
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules (): array
    {
        return [
            'lat'  => [
                'required',
                new LatRule,
            ],
            'long' => [
                'required',
                new LongRule,
            ],
        ];
    }

    public function prepareForValidation (): void
    {
        $this->merge( [
            'lat'  => normalize_location_lat( $this->lat ),
            'long' => normalize_location_long( $this->long ),
        ] );
    }
}
