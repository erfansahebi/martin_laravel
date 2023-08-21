<?php

namespace App\Traits;

use App\Enums\ResponseStatusCodeEnum;
use Illuminate\Http\JsonResponse;

trait CustomResponse
{
    public function successResponse ( array $data = [], ResponseStatusCodeEnum|int $code = ResponseStatusCodeEnum::OK ): JsonResponse
    {
        return response()->json( [
            'data'    => $data
        ], $code instanceof ResponseStatusCodeEnum ? $code->value : $code );
    }

    public function failedResponse ( array $data = [], string $message = 'error', ResponseStatusCodeEnum|int $code = ResponseStatusCodeEnum::BadRequest ): JsonResponse
    {
        return response()->json( [
            'message' => $message,
            'data'    => $data
        ], $code instanceof ResponseStatusCodeEnum ? $code->value : $code );
    }
}
