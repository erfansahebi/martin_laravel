<?php

namespace App\Exceptions\Corporate;

use App\Exceptions\BaseException;

class CorporateWebHookException extends BaseException
{

    protected function setCode (): void
    {
    }

    protected function setMessage (): void
    {
        $this->message = 'Error in web hook';
    }
}
