<?php

namespace App\Rules\Order;

use App\Models\User;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class OrderBelongsToUserRule implements ValidationRule
{

    public function __construct ( private readonly \OrderService $orderService, private readonly User $user )
    {
    }

    /**
     * Run the validation rule.
     *
     * @param \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString $fail
     */
    public function validate ( string $attribute, mixed $value, Closure $fail ): void
    {
        if ( ! \Str::isUuid( $value ) || ! $this->orderService->userRelatedWithOrder( user: $this->user, orderID: $value ) )
            $fail( 'Order not found.' );
    }
}
