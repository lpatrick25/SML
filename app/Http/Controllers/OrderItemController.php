<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderItem\StoreOrderItemRequest;
use App\Http\Requests\OrderItem\UpdateOrderItemRequest;
use App\Http\Resources\OrderItem\OrderItemResource;
use App\Http\Resources\OrderItem\OrderItemCollection;
use App\Models\OrderItem;
use App\Services\OrderItemServices;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class OrderItemController extends Controller
{
    protected $orderItemService;

    public function __construct(OrderItemServices $orderItemService, Request $request)
    {
        parent::__construct($request);
        $this->orderItemService = $orderItemService;
    }

    public function index(Request $request): OrderItemCollection
    {
        $validated = $request->validate([
            'order_id' => 'nullable|exists:orders,id',
            'service_id' => 'nullable|exists:services,id',
            'limit' => 'nullable|integer|min:1',
            'page' => 'nullable|integer|min:1',
        ]);

        $query = $this->orderItemService->getAllOrderItems($validated);
        $orderItems = $query->paginate($this->limit, ['*'], 'page', $this->page);

        return new OrderItemCollection($orderItems);
    }

    public function show(OrderItem $orderItem): JsonResponse
    {
        $orderItem->load('order', 'service');
        return $this->success(new OrderItemResource($orderItem));
    }

    public function store(StoreOrderItemRequest $request): JsonResponse
    {
        $orderItem = $this->orderItemService->create($request->validated());
        $orderItem->load('order', 'service');
        return $this->success(new OrderItemResource($orderItem), 'Order item created', 201);
    }

    public function update(UpdateOrderItemRequest $request, OrderItem $orderItem): JsonResponse
    {
        $orderItem = $this->orderItemService->update($orderItem->id, $request->validated());
        $orderItem->load('order', 'service');
        return $this->success(new OrderItemResource($orderItem), 'Order item updated');
    }

    public function destroy(OrderItem $orderItem): JsonResponse
    {
        $orderItem->delete();
        return $this->success(null, 'Order item deleted');
    }
}
