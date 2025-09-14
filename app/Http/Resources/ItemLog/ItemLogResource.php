<?php

namespace App\Http\Resources\ItemLog;

use App\Http\Resources\Resource;

class ItemLogResource extends Resource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'item_id' => $this->item_id,
            'change_type' => $this->change_type,
            'quantity' => $this->quantity,
            'description' => $this->description,
            'staff_id' => $this->staff_id,
            'log_date' => $this->log_date->toDateTimeString(),
            'created_at' => $this->created_at->toDateTimeString(),
            'updated_at' => $this->updated_at->toDateTimeString(),
            'item' => $this->whenLoaded('item', fn() => [
                'id' => $this->item->id,
                'item_name' => $this->item->item_name,
                'unit' => $this->item->unit,
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
