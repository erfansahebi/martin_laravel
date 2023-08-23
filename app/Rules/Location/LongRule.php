<?php

namespace App\Rules\Location;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class LongRule implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString $fail
     */
    public function validate ( string $attribute, mixed $value, Closure $fail ): void
    {
        if ( ! is_numeric( $value ) || empty( normalize_location_long( $value ) ) )
            $fail( "Wrong $attribute" );
    }
}
