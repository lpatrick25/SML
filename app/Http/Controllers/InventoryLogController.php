<?php

namespace App\Http\Controllers;

use App\Http\Requests\InventoryLog\StoreInventoryLogRequest;
use App\Http\Requests\InventoryLog\UpdateInventoryLogRequest;
use App\Http\Resources\InventoryLog\InventoryLogResource;
use App\Http\Resources\InventoryLog\InventoryLogCollection;
use App\Models\InventoryLog;
use App\Services\InventoryLogServices;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class InventoryLogController extends Controller
{
    protected $inventoryLogService;

    public function __construct(InventoryLogServices $inventoryLogService, Request $request)
    {
        parent::__construct($request);
        $this->inventoryLogService = $inventoryLogService;
    }

    public function index(Request $request): InventoryLogCollection
    {
        $validated = $request->validate([
            'inventory_id' => 'nullable|exists:inventory,id',
            'change_type' => 'nullable|in:In,Out',
            'staff_id' => 'nullable|exists:users,id',
            'limit' => 'nullable|integer|min:1',
            'page' => 'nullable|integer|min:1',
        ]);

        $query = $this->inventoryLogService->getAllInventoryLogs($validated);
        $inventoryLogs = $query->paginate($this->limit, ['*'], 'page', $this->page);

        return new InventoryLogCollection($inventoryLogs);
    }

    public function show(InventoryLog $inventoryLog): JsonResponse
    {
        $inventoryLog->load('inventory', 'staff');
        return $this->success(new InventoryLogResource($inventoryLog));
    }

    public function store(StoreInventoryLogRequest $request): JsonResponse
    {
        $inventoryLog = $this->inventoryLogService->create($request->validated());
        $inventoryLog->load('inventory', 'staff');
        return $this->success(new InventoryLogResource($inventoryLog), 'Inventory log created', 201);
    }

    public function update(UpdateInventoryLogRequest $request, InventoryLog $inventoryLog): JsonResponse
    {
        $inventoryLog = $this->inventoryLogService->update($inventoryLog->id, $request->validated());
        $inventoryLog->load('inventory', 'staff');
        return $this->success(new InventoryLogResource($inventoryLog), 'Inventory log updated');
    }

    public function destroy(InventoryLog $inventoryLog): JsonResponse
    {
        $inventoryLog->delete();
        return $this->success(null, 'Inventory log deleted');
    }
}
