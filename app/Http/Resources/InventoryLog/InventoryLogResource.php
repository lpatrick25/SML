<?php

namespace App\Http\Resources\InventoryLog;

use App\Http\Resources\Resource;

class InventoryLogResource extends Resource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'inventory_id' => $this->inventory_id,
            'change_type' => $this->change_type,
            'quantity' => $this->quantity,
            'description' => $this->description,
            'staff_id' => $this->staff_id,
            'log_date' => $this->log_date->toDateTimeString(),
            'created_at' => $this->created_at->toDateTimeString(),
            'updated_at' => $this->updated_at->toDateTimeString(),
            'inventory' => $this->whenLoaded('inventory', fn() => [
                'id' => $this->inventory->id,
                'item_name' => $this->inventory->item_name,
                'unit' => $this->inventory->unit,
            ]),
            'staff' => $this->whenLoaded('staff', fn() => [
                'id' => $this->staff->id,
                'first_name' => $this->staff->first_name,
                'last_name' => $this->staff->last_name,
                'email' => $this->staff->email,
            ]),
        ];
    }
}
