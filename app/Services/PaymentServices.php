<?php

namespace App\Services;

use App\Models\Payment;
use Illuminate\Database\Eloquent\Builder;

class PaymentServices
{
    public function getAllPayments(array $validated): Builder
    {
        return Payment::query()
            ->with('order')
            ->when($validated['transaction_id'] ?? null, fn($q) => $q->where('transaction_id', $validated['transaction_id']))
            ->when($validated['payment_method'] ?? null, fn($q) => $q->where('payment_method', $validated['payment_method']));
    }

    public function create(array $data): Payment
    {
        return Payment::create($data);
    }

    public function update(int $id, array $data): Payment
    {
        $payment = Payment::findOrFail($id);
        $payment->update($data);
        return $payment;
    }
}
