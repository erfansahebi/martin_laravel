<?php

namespace App\Http\Requests\Order;

use App\Enums\OrderStatusEnum;
use App\Models\Role;
use App\Rules\Location\LatRule;
use App\Rules\Location\LongRule;
use App\Rules\Order\CourierUpdateOrderStatusRule;

class UpdateStatusRequest extends FetchRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize (): bool
    {
        return resolve( \RolePermissionService::class )->userHasAnyRoles( \Auth::user(), Role::COURIER, Role::EMPLOYEE );
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules (): array
    {
        return [
            ...parent::rules(),
            'status' => [
                'required',
                new CourierUpdateOrderStatusRule,
            ],
            'lat'    => [
                'exclude_if:status,' . OrderStatusEnum::Canceled->value,
                'required',
                new LatRule,
            ],
            'long'   => [
                'exclude_if:status,' . OrderStatusEnum::Canceled->value,
                'required',
                new LongRule,
            ],
        ];
    }
}
