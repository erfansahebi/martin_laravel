<?php

namespace App\Rules\Order;

use Closure;
use App\Enums\OrderStatusEnum;
use Illuminate\Contracts\Validation\ValidationRule;

class CourierUpdateOrderStatusRule implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString $fail
     */
    public function validate ( string $attribute, mixed $value, Closure $fail ): void
    {
        if ( ! is_numeric( $value ) || ! in_array( needle: $value, haystack: [
                OrderStatusEnum::AcceptedAndOnTheWayToTheOrigin->value,
                OrderStatusEnum::OnTheWayToTheDestination->value,
                OrderStatusEnum::Canceled->value,
                OrderStatusEnum::Done->value,
            ] ) )
            $fail( "Wrong $attribute value" );
    }
}
