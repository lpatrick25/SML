<?php

namespace App\Http\Resources\Service;

use App\Http\Resources\Resource;

class ServiceResource extends Resource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'kilograms' => $this->kilograms,
            'price' => $this->price,
            'created_at' => $this->created_at->toDateTimeString(),
            'updated_at' => $this->updated_at->toDateTimeString(),
        ];
    }
}
