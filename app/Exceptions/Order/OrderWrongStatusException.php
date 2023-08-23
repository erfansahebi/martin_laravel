<?php

namespace App\Exceptions\Order;

use App\Enums\ResponseStatusCodeEnum;
use App\Exceptions\BaseException;

class OrderWrongStatusException extends BaseException
{

    protected function setCode (): void
    {
        $this->code = ResponseStatusCodeEnum::BadRequest->value;
    }

    protected function setMessage (): void
    {
        $this->message = 'This status is not acceptable.';
    }
}
