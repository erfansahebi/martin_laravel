<?php

namespace App\Http\Requests\Auth;

use App\Rules\Auth\PhoneNumberExistsRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize (): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules (): array
    {
        return [
            'phone_number' => [
                'required',
                new PhoneNumberExistsRule,
            ],
            'password'     => [
                'required',
                'string',
            ],
        ];
    }

    public function prepareForValidation (): void
    {
        $this->merge( [
            'phone_number' => normalize_phone_number( $this->phone_number ),
        ] );
    }

}
