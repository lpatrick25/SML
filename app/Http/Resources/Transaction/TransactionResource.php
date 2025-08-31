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
            'order_date' => $this->order_date->toDateString(),
            'order_status' => $this->order_status,
            'total_amount' => $this->total_amount,
            'payment_status' => $this->payment_status,
            'created_at' => $this->created_at->toDateTimeString(),
            'updated_at' => $this->updated_at->toDateTimeString(),
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
            'order_items' => $this->whenLoaded('orderItems', fn() => $this->orderItems->map(fn($item) => [
                'id' => $item->id,
                'service_id' => $item->service_id,
                'quantity' => $item->quantity,
                'subtotal' => $item->subtotal,
                'service' => $item->service ? [
                    'id' => $item->service->id,
                    'name' => $item->service->name,
                    'price' => $item->service->price,
                ] : null,
            ])),
        ];
    }
}
