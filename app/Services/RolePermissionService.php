<?php

namespace App\Services;

use App\Models\User;

class RolePermissionService
{
    public function userHasAnyRoles ( User $user, ...$roles ): bool
    {
        return $user->hasAnyRole( ...$roles );
    }
}
