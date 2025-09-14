<?php

namespace App\Http\Resources\Transaction;

use App\Http\Resources\Resource;

class TransactionResource extends Resource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'customer_id' => $this->customer_id,
            'staff_id' => $this->staff_id,
            'transaction_date' => $this->transaction_date,
            'transaction_status' => $this->transaction_status,
            'total_amount' => $this->total_amount,
            'payment_status' => $this->payment_status,
            'customer' => $this->whenLoaded('customer', fn() => [
                'id' => $this->customer->id,
                'first_name' => $this->customer->first_name,
                'last_name' => $this->customer->last_name,
                'email' => $this->customer->email,
            ]),
            'staff' => $this->whenLoaded('staff', fn() => [
                'id' => $this->staff->id,
                'first_name' => $this->staff->first_name,
                'last_name' => $this->staff->last_name,
                'email' => $this->staff->email,
            ]),
            'transaction_items' => $this->whenLoaded('transactionItems', fn() => $this->transactionItems->map(fn($item) => [
                'id' => $item->id,
                'service_id' => $item->service_id,
                'quantity' => $item->quantity,
                'subtotal' => $item->subtotal,
                'service' => $item->service ? [
                    'id' => $item->service->id,
                    'name' => $item->service->name,
                    'price' => $item->service->price,
                    'kilograms' => $item->service->kilograms ?? null, // Include kilograms if available
                ] : null,
                'item_logs' => $item->itemLogs ? $item->itemLogs->map(fn($log) => [
                    'id' => $log->id,
                    'item_id' => $log->item_id,
                    'quantity' => $log->quantity,
                    'item' => $log->item ? [
                        'id' => $log->item->id,
                        'item_name' => $log->item->item_name,
                        'unit' => $log->item->unit,
                    ] : null,
                ]) : [],
            ])),
        ];
    }
}
