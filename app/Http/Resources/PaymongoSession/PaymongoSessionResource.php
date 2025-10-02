<?php

namespace App\Http\Resources\PaymongoSession;

use App\Http\Resources\Resource;

class PaymongoSessionResource extends Resource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'transaction_id' => $this->transaction_id,
            'session_id' => $this->session_id,
            'checkout_url' => $this->checkout_url,
            'client_key' => $this->client_key,
            'data' => $this->total_amount,
            'status' => $this->status,
            'transaction' => $this->whenLoaded('transaction', fn() => $this->transaction->map(fn($transaction) => [
                'customer_id' => $transaction->customer_id,
                'staff_id' => $transaction->staff_id,
                'transaction_date' => $transaction->transaction_date,
                'transaction_status' => $transaction->transaction_status,
                'total_amount' => $transaction->total_amount,
                'payment_status' => $transaction->payment_status,
            ])),
        ];
    }
}
