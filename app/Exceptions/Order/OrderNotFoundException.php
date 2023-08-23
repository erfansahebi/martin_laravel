<?php

namespace App\Exceptions\Order;

use App\Enums\ResponseStatusCodeEnum;
use App\Exceptions\BaseException;

class OrderNotFoundException extends BaseException
{

    protected function setCode (): void
    {
        $this->code = ResponseStatusCodeEnum::NotFound->value;
    }

    protected function setMessage (): void
    {
        $this->message = 'Order not found.';
    }
}
