<?php

namespace App\Rules\Auth;

use App\Models\User;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class PhoneNumberExistsRule implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString $fail
     */
    public function validate ( string $attribute, mixed $value, Closure $fail ): void
    {
        if ( ! is_string( $value ) || empty( $phone_number = normalize_phone_number( $value ) ) || ! User::where( 'phone_number', $phone_number )->exists() )
            $fail( "User not found." );
    }
}
