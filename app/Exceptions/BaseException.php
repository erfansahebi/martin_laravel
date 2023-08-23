<?php

namespace App\Exceptions;

use App\Traits\CustomResponse;
use Exception;
use Illuminate\Http\JsonResponse;
use Throwable;

abstract class BaseException extends Exception
{
    use CustomResponse;

    public function __construct ( string $message = "", private array $data = [], int $code = 400, ?Throwable $previous = null )
    {
        parent::__construct( $message, $code, $previous );

        $this->setCode();
        $this->setMessage();
    }

    abstract protected function setCode (): void;

    abstract protected function setMessage (): void;


    public function render (): JsonResponse
    {
        return $this->failedResponse( data: $this->data, message: $this->message, code: $this->code );
    }
}
