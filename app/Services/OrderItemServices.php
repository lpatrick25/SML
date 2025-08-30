<?php

namespace App\Services;

use App\Models\OrderItem;
use Illuminate\Database\Eloquent\Builder;

class OrderItemServices
{
    public function getAllOrderItems(array $validated): Builder
    {
        return OrderItem::query()
            ->with(['order', 'service'])
            ->when($validated['order_id'] ?? null, fn($q) => $q->where('order_id', $validated['order_id']))
            ->when($validated['service_id'] ?? null, fn($q) => $q->where('service_id', $validated['service_id']));
    }

    public function create(array $data): OrderItem
    {
        return OrderItem::create($data);
    }

    public function update(int $id, array $data): OrderItem
    {
        $orderItem = OrderItem::findOrFail($id);
        $orderItem->update($data);
        return $orderItem;
    }
}
