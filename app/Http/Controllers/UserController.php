<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\Order\IndexRequest;
use App\Http\Requests\User\ShowRequest;
use App\Http\Requests\User\UpdateRequest;
use Illuminate\Http\JsonResponse;

class UserController extends Controller
{
    public function __construct ( private readonly \UserService $userService )
    {
    }

    public function show ( ShowRequest $request ): JsonResponse
    {
        $request->validated();

        $data = [
            'user' => $this->userService->putInResource( user: \Auth::user() )->toArray( request: $request ),
        ];

        return $this->successResponse( data: $data );
    }

    public function update ( UpdateRequest $request ): JsonResponse
    {
        $validated_data = $request->validated();

        $this->userService->updateLocation( userID: \Auth::id(), lat: $validated_data[ 'lat' ], long: $validated_data[ 'long' ] );

        return $this->successResponse();
    }

    public function orderIndex ( IndexRequest $request ): JsonResponse
    {
        $request->validated();

        $user = \Auth::user();

        $orders = $this->userService->getOrders( user: $user );

        $data = [
            'orders' => resolve( \OrderService::class )->putInResource( user: $user, order: $orders, single: false )->toArray( request: $request ),
        ];

        return $this->successResponse( data: $data );
    }
}
