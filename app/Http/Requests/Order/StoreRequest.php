<?php

namespace App\Http\Requests\Order;

use App\Models\Role;
use App\Rules\Auth\PhoneNumberRule;
use App\Rules\Corporate\CorporateBelongsToUserRule;
use App\Rules\Location\LatRule;
use App\Rules\Location\LongRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{


    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize (): bool
    {
        return resolve( \RolePermissionService::class )->userHasAnyRoles( \Auth::user(), Role::EMPLOYEE );
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules (): array
    {
        return [
            'corporate_id'          => [
                'required',
                new CorporateBelongsToUserRule( userService: resolve( \UserService::class ), user: \Auth::user() ),
            ],
            'origin_lat'            => [
                'required',
                new LatRule,
            ],
            'origin_long'           => [
                'required',
                new LongRule,
            ],
            'origin_address'        => [
                'required',
                'string',
                'max:255'
            ],
            'provider_name'         => [
                'required',
                'string',
                'max:255'
            ],
            'provider_phone_number' => [
                'required',
                new PhoneNumberRule,
            ],
            'destination_lat'       => [
                'required',
                new LatRule,
            ],
            'destination_long'      => [
                'required',
                new LongRule,
            ],
            'destination_address'   => [
                'required',
                'string',
                'max:255'
            ],
            'receiver_name'         => [
                'required',
                'string',
                'max:255'
            ],
            'receiver_phone_number' => [
                'required',
                new PhoneNumberRule,
            ],
        ];
    }

    public function prepareForValidation (): void
    {
        $this->merge( [
            'provider_phone_number' => normalize_phone_number( $this->provider_phone_number ),
            'receiver_phone_number' => normalize_phone_number( $this->receiver_phone_number ),
            'origin_lat'            => normalize_location_lat( $this->origin_lat ),
            'origin_long'           => normalize_location_long( $this->origin_long ),
            'destination_lat'       => normalize_location_lat( $this->destination_lat ),
            'destination_long'      => normalize_location_long( $this->destination_long ),
        ] );
    }
}
