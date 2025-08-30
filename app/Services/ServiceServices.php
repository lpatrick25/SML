<?php

namespace App\Services;

use App\Models\Service;
use Illuminate\Database\Eloquent\Builder;

class ServiceServices
{
    public function getAllServices(array $validated): Builder
    {
        return Service::query()
            ->when($validated['name'] ?? null, fn($q) => $q->where('name', 'like', '%' . $validated['name'] . '%'));
    }

    public function create(array $data): Service
    {
        return Service::create($data);
    }

    public function update(int $id, array $data): Service
    {
        $service = Service::findOrFail($id);
        $service->update($data);
        return $service;
    }
}
