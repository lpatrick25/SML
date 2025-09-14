<?php

namespace App\Services;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Service;
use App\Models\Item;
use App\Models\ItemLog;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

class TransactionServices
{
    public function getAllOrders(array $validated): Builder
    {
        return Order::query()
            ->with(['customer', 'staff', 'transactionItems.service', 'transactionItems.itemLogs.item'])
            ->when($validated['customer_id'] ?? null, fn($q) => $q->where('customer_id', $validated['customer_id']))
            ->when($validated['transaction_status'] ?? null, fn($q) => $q->where('transaction_status', $validated['transaction_status']));
    }

    public function create(array $data): Order
    {
        return DB::transaction(function () use ($data) {
            $total_amount = 0;
            $transaction_items = $data['transaction_items'] ?? [];
            unset($data['transaction_items']);

            // Validate item quantities
            foreach ($transaction_items as $item) {
                $service = Service::findOrFail($item['service_id']);
                $total_amount += $service->price * $item['quantity'];
                foreach ($item['item_items'] ?? [] as $invItem) {
                    $item = Item::findOrFail($invItem['item_id']);
                    if ($item->quantity < $invItem['quantity']) {
                        throw new \Exception("Insufficient item for {$item->item_name}");
                    }
                }
            }

            $data['total_amount'] = $total_amount;
            $transaction = Order::create($data);

            foreach ($transaction_items as $index => $item) {
                $service = Service::findOrFail($item['service_id']);
                $transactionItem = OrderItem::create([
                    'transaction_id' => $transaction->id,
                    'service_id' => $item['service_id'],
                    'quantity' => $item['quantity'],
                    'subtotal' => $service->price * $item['quantity'],
                ]);

                foreach ($item['item_items'] ?? [] as $invItem) {
                    $item = Item::findOrFail($invItem['item_id']);
                    $item->decrement('quantity', $invItem['quantity']);
                    ItemLog::create([
                        'item_id' => $invItem['item_id'],
                        'transaction_item_id' => $transactionItem->id,
                        'change_type' => 'Out',
                        'quantity' => $invItem['quantity'],
                        'description' => "Used in transaction item #{$transactionItem->id} for transaction #{$transaction->id}",
                        'staff_id' => $data['staff_id'] ?? null,
                    ]);
                }
            }

            return $transaction->load('customer', 'staff', 'transactionItems.service', 'transactionItems.itemLogs.item');
        });
    }

    public function update(int $id, array $data): Order
    {
        return DB::transaction(function () use ($id, $data) {
            $transaction = Order::findOrFail($id);
            $total_amount = 0;
            $transaction_items = $data['transaction_items'] ?? [];
            unset($data['transaction_items']);

            // Restore item quantities for existing items
            foreach ($transaction->transactionItems as $existingItem) {
                foreach ($existingItem->itemLogs as $log) {
                    Item::find($log->item_id)->increment('quantity', $log->quantity);
                    $log->delete();
                }
            }

            // Validate new item quantities
            foreach ($transaction_items as $item) {
                $service = Service::findOrFail($item['service_id']);
                $total_amount += $service->price * $item['quantity'];
                foreach ($item['item_items'] ?? [] as $invItem) {
                    $item = Item::findOrFail($invItem['item_id']);
                    if ($item->quantity < $invItem['quantity']) {
                        throw new \Exception("Insufficient item for {$item->item_name}");
                    }
                }
            }

            $data['total_amount'] = $total_amount;
            $transaction->update($data);

            $transaction->transactionItems()->delete();
            foreach ($transaction_items as $index => $item) {
                $service = Service::findOrFail($item['service_id']);
                $transactionItem = OrderItem::create([
                    'transaction_id' => $transaction->id,
                    'service_id' => $item['service_id'],
                    'quantity' => $item['quantity'],
                    'subtotal' => $service->price * $item['quantity'],
                ]);

                foreach ($item['item_items'] ?? [] as $invItem) {
                    $item = Item::findOrFail($invItem['item_id']);
                    $item->decrement('quantity', $invItem['quantity']);
                    ItemLog::create([
                        'item_id' => $invItem['item_id'],
                        'transaction_item_id' => $transactionItem->id,
                        'change_type' => 'Out',
                        'quantity' => $invItem['quantity'],
                        'description' => "Used in transaction item #{$transactionItem->id} for transaction #{$transaction->id}",
                        'staff_id' => $data['staff_id'] ?? null,
                    ]);
                }
            }

            return $transaction->load('customer', 'staff', 'transactionItems.service', 'transactionItems.itemLogs.item');
        });
    }

    public function updateStatus(int $id, string $status): Order
    {
        $transaction = Order::findOrFail($id);
        $transaction->update(['transaction_status' => $status]);
        return $transaction->load('customer', 'staff', 'transactionItems.service', 'transactionItems.itemLogs.item');
    }

    public function updatePaymentStatus(int $id, string $status): Order
    {
        $transaction = Order::findOrFail($id);
        $transaction->update(['payment_status' => $status]);
        return $transaction->load('customer', 'staff', 'transactionItems.service', 'transactionItems.itemLogs.item');
    }
}
