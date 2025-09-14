<?php

namespace App\Http\Controllers;

use App\Http\Requests\ItemLog\StoreItemLogRequest;
use App\Http\Requests\ItemLog\UpdateItemLogRequest;
use App\Http\Resources\ItemLog\ItemLogResource;
use App\Http\Resources\ItemLog\ItemLogCollection;
use App\Models\ItemLog;
use App\Services\ItemLogServices;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ItemLogController extends Controller
{
    protected $itemLogService;

    public function __construct(ItemLogServices $itemLogService, Request $request)
    {
        parent::__construct($request);
        $this->itemLogService = $itemLogService;
    }

    public function index(Request $request): ItemLogCollection
    {
        $validated = $request->validate([
            'item_id' => 'nullable|exists:item,id',
            'change_type' => 'nullable|in:In,Out',
            'staff_id' => 'nullable|exists:users,id',
            'limit' => 'nullable|integer|min:1',
            'page' => 'nullable|integer|min:1',
        ]);

        $query = $this->itemLogService->getAllItemLogs($validated);
        $itemLogs = $query->paginate($this->limit, ['*'], 'page', $this->page);

        return new ItemLogCollection($itemLogs);
    }

    public function show(ItemLog $itemLog): JsonResponse
    {
        $itemLog->load('item', 'staff');
        return $this->success(new ItemLogResource($itemLog));
    }

    public function store(StoreItemLogRequest $request): JsonResponse
    {
        $itemLog = $this->itemLogService->create($request->validated());
        $itemLog->load('item', 'staff');
        return $this->success(new ItemLogResource($itemLog), 'Item log created', 201);
    }

    public function update(UpdateItemLogRequest $request, ItemLog $itemLog): JsonResponse
    {
        $itemLog = $this->itemLogService->update($itemLog->id, $request->validated());
        $itemLog->load('item', 'staff');
        return $this->success(new ItemLogResource($itemLog), 'Item log updated');
    }

    public function destroy(ItemLog $itemLog): JsonResponse
    {
        $itemLog->delete();
        return $this->success(null, 'Item log deleted');
    }
}
