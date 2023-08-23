<?php

namespace App\Exceptions\Global;

use App\Enums\ResponseStatusCodeEnum;
use App\Exceptions\BaseException;

class AccessDeniedException extends BaseException
{

    protected function setCode (): void
    {
        $this->code = ResponseStatusCodeEnum::Forbidden->value;
    }

    protected function setMessage (): void
    {
        $this->message = 'Access Denied.';
    }
}
