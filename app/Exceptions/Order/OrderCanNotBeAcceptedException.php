<?php

namespace App\Exceptions\Order;

use App\Enums\ResponseStatusCodeEnum;
use App\Exceptions\BaseException;

class OrderCanNotBeAcceptedException extends BaseException
{

    protected function setCode (): void
    {
        $this->code = ResponseStatusCodeEnum::BadRequest->value;
    }

    protected function setMessage (): void
    {
        $this->message = 'Order can not be accept.';
    }
}
