<?php

namespace App\Services;

use App\Models\Inventory;
use Illuminate\Database\Eloquent\Builder;

class InventoryServices
{
    public function getAllInventories(array $validated): Builder
    {
        return Inventory::query()
            ->when($validated['item_name'] ?? null, fn($q) => $q->where('item_name', 'like', '%' . $validated['item_name'] . '%'));
    }

    public function create(array $data): Inventory
    {
        return Inventory::create($data);
    }

    public function update(int $id, array $data): Inventory
    {
        $inventory = Inventory::findOrFail($id);
        $inventory->update($data);
        return $inventory;
    }
}
