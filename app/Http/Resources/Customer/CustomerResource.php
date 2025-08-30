<?php

namespace App\Http\Resources\Customer;

use App\Http\Resources\Resource;

class CustomerResource extends Resource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'first_name' => $this->first_name,
            'middle_name' => $this->middle_name,
            'last_name' => $this->last_name,
            'extension' => $this->extension,
            'phone' => $this->phone,
            'email' => $this->email,
            'address' => $this->address,
            'created_at' => $this->created_at->toDateTimeString(),
            'updated_at' => $this->updated_at->toDateTimeString(),
        ];
    }
}
