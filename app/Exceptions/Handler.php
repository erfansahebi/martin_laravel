<?php

namespace App\Exceptions;

use App\Enums\ResponseStatusCodeEnum;
use App\Traits\CustomResponse;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;
use Spatie\Permission\Exceptions\UnauthorizedException as SpatieUnauthorizedException;
use Illuminate\Validation\UnauthorizedException;
use Symfony\Component\Finder\Exception\AccessDeniedException;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    use CustomResponse;

    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'password',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register (): void
    {
        $this->reportable( function ( Throwable $e ) {
            //
        } );
    }

    public function render ( $request, Throwable $e ): \Illuminate\Http\Response|\Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse|\Symfony\Component\HttpFoundation\Response
    {
        if ( $e instanceof ValidationException )
            return $this->failedResponse( data: $e->errors(), message: 'validation_failed', code: ResponseStatusCodeEnum::BadRequest );
        elseif ( $e instanceof AccessDeniedException )
            return $this->failedResponse( data: [], message: $e->getMessage(), code: ResponseStatusCodeEnum::Forbidden );
        elseif ( $e instanceof AuthenticationException )
            return $this->failedResponse( data: [], message: $e->getMessage(), code: ResponseStatusCodeEnum::Forbidden );
        elseif ( $e instanceof UnauthorizedException )
            return $this->failedResponse( data: [], message: $e->getMessage(), code: ResponseStatusCodeEnum::Forbidden );
        elseif ( $e instanceof SpatieUnauthorizedException )
            return $this->failedResponse( data: [], message: $e->getMessage(), code: ResponseStatusCodeEnum::Forbidden );
        elseif ( $e instanceof AccessDeniedHttpException )
            return $this->failedResponse( data: [], message: $e->getMessage(), code: ResponseStatusCodeEnum::Forbidden );
        elseif ( $e instanceof AuthorizationException )
            return $this->failedResponse( data: [], message: $e->getMessage(), code: ResponseStatusCodeEnum::Forbidden );
        elseif ( $e instanceof NotFoundHttpException )
            return $this->failedResponse( data: [], message: $e->getMessage(), code: ResponseStatusCodeEnum::Forbidden );


        return parent::render( $request, $e );
    }
}
