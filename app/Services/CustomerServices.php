<?php

namespace App\Services;

use App\Models\Customer;
use Illuminate\Database\Eloquent\Builder;

class CustomerServices
{
    public function getAllCustomers(array $validated): Builder
    {
        return Customer::query()
            ->when($validated['email'] ?? null, fn($q) => $q->where('email', $validated['email']));
    }

    public function create(array $data): Customer
    {
        return Customer::create($data);
    }

    public function update(int $id, array $data): Customer
    {
        $customer = Customer::findOrFail($id);
        $customer->update($data);
        return $customer;
    }
}
