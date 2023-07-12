<?php

namespace App\Http\Controllers;

use App\Http\ApiResponses\FailResponse;
use App\Http\ApiResponses\SuccessResponse;
use App\Http\Requests\OrderCreateRequest;
use App\Http\Requests\OrderDeleteRequest;
use App\Http\Resources\OrderDiscountResource;
use App\Http\Resources\OrderResource;
use App\Http\Services\OrderService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Lang;

class OrderController extends Controller
{
    private OrderService $orderService;
    private FailResponse $failResponse;
    private SuccessResponse $successResponse;

    public function __construct(
        OrderService  $orderService,
        FailResponse    $failResponse,
        SuccessResponse $successResponse
    )
    {
        $this->orderService = $orderService;
        $this->failResponse = $failResponse;
        $this->successResponse = $successResponse;
    }


    public function index(Request $request)
    {
        list($orders, $count) = $this->orderService->index($request->all());
        try {
            return $this->successResponse->setData([
                    'orders' => OrderResource::collection($orders),
                    'count' => $count
                ]
            )->setMessages(
                Lang::get('Orders are listed Successfully'),
            )->send();
        } catch (\Exception $e) {
            return $this->failResponse->setMessages([
                'main' => $e->getMessage(),
            ])->send();
        }

    }

    public function create(OrderCreateRequest $request)
    {
        try {

            return $this->successResponse->setData([
                'order' => new OrderResource($this->orderService->create($request->all()))
            ])->setMessages(
                Lang::get('Order Created Successfully'),
            )->send();
        } catch (\Exception $e) {
            return $this->failResponse->setMessages([
                'main' => $e->getMessage(),
            ])->send();
        }
    }

    public function destroy(Request $request,$id)
    {
        try {
            $this->orderService->delete($id);
            return $this->successResponse->setMessages(
                Lang::get('Order Deleted Successfully'),
            )->send();
        } catch (\Exception $e) {
            return $this->failResponse->setMessages([
                'main' => $e->getMessage(),
            ])->send();
        }
    }

    public function discounts(Request $request, $id)
    {
        try {
            return $this->successResponse->setData([
                'discounts' => new OrderDiscountResource($this->orderService->getOrder($id))
            ])->setMessages(
                Lang::get('Order Discounts Listed Successfully'),
            )->send();
        } catch (\Exception $e) {
            return $this->failResponse->setMessages([
                'main' => $e->getMessage(),
            ])->send();
        }
    }
}
