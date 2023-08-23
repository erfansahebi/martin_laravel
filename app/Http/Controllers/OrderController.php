<?php

namespace App\Http\Controllers;

use App\Http\Requests\Order\CancellationRequest;
use App\Http\Requests\Order\IndexRequest;
use App\Http\Requests\Order\ShowRequest;
use App\Http\Requests\Order\StoreRequest;
use App\Http\Requests\Order\UpdateStatusRequest;
use Illuminate\Http\JsonResponse;

class OrderController extends Controller
{

    public function __construct ( private readonly \OrderService $orderService )
    {
    }

    public function store ( StoreRequest $request ): JsonResponse
    {
        $validated_data = $request->validated();

        $order = $this->orderService->create( ...$validated_data );

        $data = [
            'order' => $this->orderService->putInResource( user: \Auth::user(), order: $order )->toArray( request: $request ),
        ];

        return $this->successResponse( data: $data );
    }

    public function index ( IndexRequest $request ): JsonResponse
    {
        $request->validated();

        $user = \Auth::user();

        $orders = $this->orderService->fetchListRelatedWithUser( user: $user );

        $data = [
            'orders' => $this->orderService->putInResource( user: $user, order: $orders, single: false )->toArray( request: $request ),
        ];

        return $this->successResponse( data: $data );
    }

    public function show ( ShowRequest $request ): JsonResponse
    {
        $validated_data = $request->validated();

        $order = $this->orderService->fetchByID( orderID: $validated_data[ 'order_id' ] );

        $data = [
            'order' => $this->orderService->putInResource( user: \Auth::user(), order: $order )->toArray( request: $request ),
        ];

        return $this->successResponse( data: $data );
    }

    public function updateStatus ( UpdateStatusRequest $request ): JsonResponse
    {
        $validated_data = $request->validated();

        $user = \Auth::user();

        $order = $this->orderService->updateStatus( user: $user, orderID: $validated_data[ 'order_id' ], status: $validated_data[ 'status' ], lat: $validated_data[ 'lat' ] ?? null, long: $validated_data[ 'long' ] ?? null );

        $data = [
            'order' => $this->orderService->putInResource( user: $user, order: $order ),
        ];

        return $this->successResponse( data: $data );
    }

}
