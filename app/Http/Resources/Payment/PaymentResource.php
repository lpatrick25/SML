<?php

namespace App\Http\Resources\Payment;

use App\Http\Resources\Resource;

class PaymentResource extends Resource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'order_id' => $this->order_id,
            'amount' => $this->amount,
            'payment_date' => $this->payment_date->toDateTimeString(),
            'payment_method' => $this->payment_method,
            'created_at' => $this->created_at->toDateTimeString(),
            'updated_at' => $this->updated_at->toDateTimeString(),
            'order' => $this->whenLoaded('order', fn() => [
                'id' => $this->order->id,
                'customer_id' => $this->order->customer_id,
                'order_date' => $this->order->order_date->toDateString(),
                'order_status' => $this->order->order_status,
            ]),
        ];
    }
}
