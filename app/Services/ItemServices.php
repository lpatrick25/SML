<?php

namespace App\Services;

use App\Models\Item;
use Illuminate\Database\Eloquent\Builder;

class ItemServices
{
    public function getAllItems(array $validated): Builder
    {
        return Item::query()
            ->when($validated['item_name'] ?? null, fn($q) => $q->where('item_name', 'like', '%' . $validated['item_name'] . '%'));
    }

    public function create(array $data): Item
    {
        return Item::create($data);
    }

    public function update(int $id, array $data): Item
    {
        $item = Item::findOrFail($id);
        $item->update($data);
        return $item;
    }
}
