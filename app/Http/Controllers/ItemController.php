<?php

namespace App\Http\Controllers;

use App\Http\Requests\Item\StoreItemRequest;
use App\Http\Requests\Item\UpdateItemRequest;
use App\Http\Resources\Item\ItemResource;
use App\Http\Resources\Item\ItemCollection;
use App\Models\Item;
use App\Services\ItemServices;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    protected $itemService;

    public function __construct(ItemServices $itemService, Request $request)
    {
        parent::__construct($request);
        $this->itemService = $itemService;
    }

    public function index(Request $request): ItemCollection
    {
        $validated = $request->validate([
            'item_name' => 'nullable|string|max:255',
            'limit' => 'nullable|integer|min:1',
            'page' => 'nullable|integer|min:1',
        ]);

        $query = $this->itemService->getAllItems($validated);
        $items = $query->paginate($this->limit, ['*'], 'page', $this->page);

        return new ItemCollection($items);
    }

    public function show(Item $item): JsonResponse
    {
        return $this->success(new ItemResource($item));
    }

    public function store(StoreItemRequest $request): JsonResponse
    {
        $item = $this->itemService->create($request->validated());
        return $this->success(new ItemResource($item), 'Item item created', 201);
    }

    public function update(UpdateItemRequest $request, Item $item): JsonResponse
    {
        $item = $this->itemService->update($item->id, $request->validated());
        return $this->success(new ItemResource($item), 'Item item updated');
    }

    public function destroy(Item $item): JsonResponse
    {
        $item->delete();
        return $this->success(null, 'Item item deleted');
    }
}
