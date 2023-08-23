<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\DestroyRequest;
use App\Http\Requests\Auth\StoreRequest;
use Illuminate\Http\JsonResponse;

class AuthController extends Controller
{

    public function __construct ( private readonly \AuthService $authService )
    {
    }

    public function store ( StoreRequest $request ): JsonResponse
    {
        $validated_data = $request->validated();

        $auth_detail = $this->authService->login( phoneNumber: $validated_data[ 'phone_number' ], password: $validated_data[ 'password' ] );

        $data = [
            'user'  => resolve( \UserService::class )->putInResource( user: $auth_detail[ 'user' ] )->toArray( request: $request ),
            'token' => $this->authService->tokenFormatter( token: $auth_detail[ 'token' ] ),
        ];

        return $this->successResponse( data: $data );
    }

    public function destroy ( DestroyRequest $request ): JsonResponse
    {
        $request->validated();

        $this->authService->logout( user: \Auth::user() );

        return $this->successResponse();
    }

}
