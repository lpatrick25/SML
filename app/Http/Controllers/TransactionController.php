<?php

namespace App\Http\Controllers;

use App\Http\Requests\Transaction\StoreTransactionRequest;
use App\Http\Requests\Transaction\UpdateTransactionRequest;
use App\Http\Resources\Transaction\TransactionCollection;
use App\Http\Resources\Transaction\TransactionResource;
use App\Models\Order;
use App\Services\TransactionServices;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    protected $transactionService;

    public function __construct(TransactionServices $transactionService, Request $request)
    {
        parent::__construct($request);
        $this->transactionService = $transactionService;
    }

    public function index(Request $request): TransactionCollection
    {
        $validated = $request->validate([
            'customer_id' => 'nullable|exists:customers,id',
            'order_status' => 'nullable|in:Pending,In Progress,Completed,Picked Up,Cancelled',
            'limit' => 'nullable|integer|min:1',
            'page' => 'nullable|integer|min:1',
        ]);

        $query = $this->transactionService->getAllOrders($validated);
        $orders = $query->paginate($this->limit, ['*'], 'page', $this->page);

        return new TransactionCollection($orders);
    }

    public function show(Order $order): JsonResponse
    {
        $order->load('customer', 'staff', 'orderItems.service');
        return response()->json(['content' => new TransactionResource($order)]);
    }

    public function store(StoreTransactionRequest $request): JsonResponse
    {
        $order = $this->transactionService->create($request->validated());
        return response()->json(['content' => new TransactionResource($order), 'message' => 'Order created'], 201);
    }

    public function update(UpdateTransactionRequest $request, Order $order): JsonResponse
    {
        $order = $this->transactionService->update($order->id, $request->validated());
        return response()->json(['content' => new TransactionResource($order), 'message' => 'Order updated']);
    }

    public function destroy(Order $order): JsonResponse
    {
        $order->orderItems()->delete();
        $order->delete();
        return response()->json(['message' => 'Order deleted']);
    }
}
