<?php

namespace App\Services;

use App\Models\Order;
use Illuminate\Database\Eloquent\Builder;

class OrderServices
{
    public function getAllOrders(array $validated): Builder
    {
        return Order::query()
            ->with(['customer', 'staff'])
            ->when($validated['customer_id'] ?? null, fn($q) => $q->where('customer_id', $validated['customer_id']))
            ->when($validated['order_status'] ?? null, fn($q) => $q->where('order_status', $validated['order_status']));
    }

    public function create(array $data): Order
    {
        return Order::create($data);
    }

    public function update(int $id, array $data): Order
    {
        $order = Order::findOrFail($id);
        $order->update($data);
        return $order;
    }
}
