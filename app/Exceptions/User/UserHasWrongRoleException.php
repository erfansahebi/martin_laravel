<?php

namespace App\Exceptions\User;

use App\Enums\ResponseStatusCodeEnum;
use App\Exceptions\BaseException;

class UserHasWrongRoleException extends BaseException
{

    protected function setCode (): void
    {
        $this->code = ResponseStatusCodeEnum::InternalServerError->value;
    }

    protected function setMessage (): void
    {
        $this->message = 'User has wrong role';
    }
}
