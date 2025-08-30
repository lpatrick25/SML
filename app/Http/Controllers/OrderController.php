<?php

namespace App\Http\Controllers;

use App\Http\Requests\Order\StoreOrderRequest;
use App\Http\Requests\Order\UpdateOrderRequest;
use App\Http\Resources\Order\OrderResource;
use App\Http\Resources\Order\OrderCollection;
use App\Models\Order;
use App\Services\OrderServices;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    protected $orderService;

    public function __construct(OrderServices $orderService, Request $request)
    {
        parent::__construct($request);
        $this->orderService = $orderService;
    }

    public function index(Request $request): OrderCollection
    {
        $validated = $request->validate([
            'customer_id' => 'nullable|exists:customers,id',
            'order_status' => 'nullable|in:Pending,In Progress,Completed,Picked Up,Cancelled',
            'limit' => 'nullable|integer|min:1',
            'page' => 'nullable|integer|min:1',
        ]);

        $query = $this->orderService->getAllOrders($validated);
        $orders = $query->paginate($this->limit, ['*'], 'page', $this->page);

        return new OrderCollection($orders);
    }

    public function show(Order $order): JsonResponse
    {
        $order->load('customer', 'staff');
        return $this->success(new OrderResource($order));
    }

    public function store(StoreOrderRequest $request): JsonResponse
    {
        $order = $this->orderService->create($request->validated());
        $order->load('customer', 'staff');
        return $this->success(new OrderResource($order), 'Order created', 201);
    }

    public function update(UpdateOrderRequest $request, Order $order): JsonResponse
    {
        $order = $this->orderService->update($order->id, $request->validated());
        $order->load('customer', 'staff');
        return $this->success(new OrderResource($order), 'Order updated');
    }

    public function destroy(Order $order): JsonResponse
    {
        $order->delete();
        return $this->success(null, 'Order deleted');
    }
}
