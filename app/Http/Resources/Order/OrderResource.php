<?php

namespace App\Http\Resources\Order;

use App\Http\Resources\Resource;

class OrderResource extends Resource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'customer_id' => $this->customer_id,
            'staff_id' => $this->staff_id,
            'transaction_date' => $this->transaction_date->toDateString(),
            'transaction_status' => $this->transaction_status,
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
        ];
    }
}
