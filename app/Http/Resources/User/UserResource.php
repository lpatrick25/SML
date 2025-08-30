<?php

namespace App\Http\Resources\User;

use App\Http\Resources\Resource;

class UserResource extends Resource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'first_name' => $this->first_name,
            'middle_name' => $this->middle_name,
            'last_name' => $this->last_name,
            'extension' => $this->extension,
            'phone_number' => $this->phone_number,
            'fullname' => $this->full_name,
            'email' => $this->email,
            'address' => $this->address,
            'email_verified_at' => $this->email_verified_at ? $this->email_verified_at->toDateTimeString() : null,
            'role' => $this->role,
            'status' => $this->status,
            'created_at' => $this->created_at->toDateTimeString(),
            'updated_at' => $this->updated_at->toDateTimeString(),
        ];
    }
}
