<?php

namespace App\Services;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Service;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

class TransactionServices
{
    public function getAllOrders(array $validated): Builder
    {
        return Order::query()
            ->with(['customer', 'staff', 'orderItems.service'])
            ->when($validated['customer_id'] ?? null, fn($q) => $q->where('customer_id', $validated['customer_id']))
            ->when($validated['order_status'] ?? null, fn($q) => $q->where('order_status', $validated['order_status']));
    }

    public function create(array $data): Order
    {
        return DB::transaction(function () use ($data) {
            $total_amount = 0;
            $order_items = $data['order_items'] ?? [];
            unset($data['order_items']);

            foreach ($order_items as $item) {
                $service = Service::findOrFail($item['service_id']);
                $total_amount += $service->price * $item['quantity'];
            }

            $data['total_amount'] = $total_amount;
            $order = Order::create($data);

            foreach ($order_items as $item) {
                $service = Service::findOrFail($item['service_id']);
                OrderItem::create([
                    'order_id' => $order->id,
                    'service_id' => $item['service_id'],
                    'quantity' => $item['quantity'],
                    'subtotal' => $service->price * $item['quantity'],
                ]);
            }

            return $order->load('customer', 'staff', 'orderItems.service');
        });
    }

    public function update(int $id, array $data): Order
    {
        return DB::transaction(function () use ($id, $data) {
            $order = Order::findOrFail($id);
            $total_amount = 0;
            $order_items = $data['order_items'] ?? [];
            unset($data['order_items']);

            foreach ($order_items as $item) {
                $service = Service::findOrFail($item['service_id']);
                $total_amount += $service->price * $item['quantity'];
            }

            $data['total_amount'] = $total_amount;
            $order->update($data);

            $order->orderItems()->delete();
            foreach ($order_items as $item) {
                $service = Service::findOrFail($item['service_id']);
                OrderItem::create([
                    'order_id' => $order->id,
                    'service_id' => $item['service_id'],
                    'quantity' => $item['quantity'],
                    'subtotal' => $service->price * $item['quantity'],
                ]);
            }

            return $order->load('customer', 'staff', 'orderItems.service');
        });
    }
}
