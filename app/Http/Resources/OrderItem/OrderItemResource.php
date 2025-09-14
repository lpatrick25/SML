<?php

namespace App\Http\Resources\OrderItem;

use App\Http\Resources\Resource;

class OrderItemResource extends Resource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'transaction_id' => $this->transaction_id,
            'service_id' => $this->service_id,
            'quantity' => $this->quantity,
            'subtotal' => $this->subtotal,
            'created_at' => $this->created_at->toDateTimeString(),
            'updated_at' => $this->updated_at->toDateTimeString(),
            'order' => $this->whenLoaded('order', fn() => [
                'id' => $this->order->id,
                'customer_id' => $this->order->customer_id,
                'transaction_date' => $this->order->transaction_date->toDateString(),
                'transaction_status' => $this->order->transaction_status,
            ]),
            'service' => $this->whenLoaded('service', fn() => [
                'id' => $this->service->id,
                'name' => $this->service->name,
                'price' => $this->service->price,
            ]),
        ];
    }
}
