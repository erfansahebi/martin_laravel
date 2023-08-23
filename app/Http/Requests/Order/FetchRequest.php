<?php

namespace App\Http\Requests\Order;

use App\Rules\Order\OrderBelongsToUserRule;
use Illuminate\Foundation\Http\FormRequest;

class FetchRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize (): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules (): array
    {
        return [
            'order_id' => [
                'required',
                new OrderBelongsToUserRule( orderService: resolve( \OrderService::class ), user: \Auth::user() ),
            ],
        ];
    }

    public function all ( $keys = null ): array
    {
        return array_replace_recursive( parent::all(), $this->route()->parameters() );
    }
}
