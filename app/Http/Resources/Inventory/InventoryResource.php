<?php

namespace App\Http\Resources\Inventory;

use App\Http\Resources\Resource;

class InventoryResource extends Resource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'item_name' => $this->item_name,
            'description' => $this->description,
            'quantity' => $this->quantity,
            'unit' => $this->unit,
            'created_at' => $this->created_at->toDateTimeString(),
            'updated_at' => $this->updated_at->toDateTimeString(),
        ];
    }
}
