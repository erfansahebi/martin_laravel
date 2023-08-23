<?php

namespace App\Rules\Auth;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class PhoneNumberRule implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString $fail
     */
    public function validate ( string $attribute, mixed $value, Closure $fail ): void
    {
        if ( ! is_string( $value ) || empty( normalize_phone_number( $value ) ) )
            $fail( "Wrong $attribute" );
    }
}
