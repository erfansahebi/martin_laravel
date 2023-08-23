<?php

namespace App\Rules\Corporate;

use App\Exceptions\User\UserHasWrongRoleException;
use App\Models\Order;
use App\Models\Role;
use App\Models\User;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class CorporateBelongsToUserRule implements ValidationRule
{
    public function __construct ( private readonly \UserService $userService, private readonly User $user )
    {
    }

    /**
     * Run the validation rule.
     *
     * @param \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString $fail
     */
    public function validate ( string $attribute, mixed $value, Closure $fail ): void
    {
        if ( ! is_numeric( $value ) || ! $this->userService->checkUserBelongsToCorporate( user: $this->user, corporateID: $value ) )
            $fail( 'Corporate not found.' );
    }
}
