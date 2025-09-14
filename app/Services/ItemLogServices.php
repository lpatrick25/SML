<?php

namespace App\Services;

use App\Models\ItemLog;
use Illuminate\Database\Eloquent\Builder;

class ItemLogServices
{
    public function getAllItemLogs(array $validated): Builder
    {
        return ItemLog::query()
            ->with(['item', 'staff'])
            ->when($validated['item_id'] ?? null, fn($q) => $q->where('item_id', $validated['item_id']))
            ->when($validated['change_type'] ?? null, fn($q) => $q->where('change_type', $validated['change_type']))
            ->when($validated['staff_id'] ?? null, fn($q) => $q->where('staff_id', $validated['staff_id']));
    }

    public function create(array $data): ItemLog
    {
        return ItemLog::create($data);
    }

    public function update(int $id, array $data): ItemLog
    {
        $itemLog = ItemLog::findOrFail($id);
        $itemLog->update($data);
        return $itemLog;
    }
}
