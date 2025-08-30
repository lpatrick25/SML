<?php

namespace App\Services;

use App\Models\InventoryLog;
use Illuminate\Database\Eloquent\Builder;

class InventoryLogServices
{
    public function getAllInventoryLogs(array $validated): Builder
    {
        return InventoryLog::query()
            ->with(['inventory', 'staff'])
            ->when($validated['inventory_id'] ?? null, fn($q) => $q->where('inventory_id', $validated['inventory_id']))
            ->when($validated['change_type'] ?? null, fn($q) => $q->where('change_type', $validated['change_type']))
            ->when($validated['staff_id'] ?? null, fn($q) => $q->where('staff_id', $validated['staff_id']));
    }

    public function create(array $data): InventoryLog
    {
        return InventoryLog::create($data);
    }

    public function update(int $id, array $data): InventoryLog
    {
        $inventoryLog = InventoryLog::findOrFail($id);
        $inventoryLog->update($data);
        return $inventoryLog;
    }
}
