<?php

namespace App\Http\Controllers;

use App\Http\Requests\Inventory\StoreInventoryRequest;
use App\Http\Requests\Inventory\UpdateInventoryRequest;
use App\Http\Resources\Inventory\InventoryResource;
use App\Http\Resources\Inventory\InventoryCollection;
use App\Models\Inventory;
use App\Services\InventoryServices;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class InventoryController extends Controller
{
    protected $inventoryService;

    public function __construct(InventoryServices $inventoryService, Request $request)
    {
        parent::__construct($request);
        $this->inventoryService = $inventoryService;
    }

    public function index(Request $request): InventoryCollection
    {
        $validated = $request->validate([
            'item_name' => 'nullable|string|max:255',
            'limit' => 'nullable|integer|min:1',
            'page' => 'nullable|integer|min:1',
        ]);

        $query = $this->inventoryService->getAllInventories($validated);
        $inventories = $query->paginate($this->limit, ['*'], 'page', $this->page);

        return new InventoryCollection($inventories);
    }

    public function show(Inventory $inventory): JsonResponse
    {
        return $this->success(new InventoryResource($inventory));
    }

    public function store(StoreInventoryRequest $request): JsonResponse
    {
        $inventory = $this->inventoryService->create($request->validated());
        return $this->success(new InventoryResource($inventory), 'Inventory item created', 201);
    }

    public function update(UpdateInventoryRequest $request, Inventory $inventory): JsonResponse
    {
        $inventory = $this->inventoryService->update($inventory->id, $request->validated());
        return $this->success(new InventoryResource($inventory), 'Inventory item updated');
    }

    public function destroy(Inventory $inventory): JsonResponse
    {
        $inventory->delete();
        return $this->success(null, 'Inventory item deleted');
    }
}
