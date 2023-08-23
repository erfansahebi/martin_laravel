<?php

namespace App\Exceptions\User;

use App\Enums\ResponseStatusCodeEnum;
use App\Exceptions\BaseException;

class UserNotFoundException extends BaseException
{
    //
    protected function setCode (): void
    {
        $this->code = ResponseStatusCodeEnum::NotFound->value;
    }

    protected function setMessage (): void
    {
        $this->message = 'User not found';
    }
}
