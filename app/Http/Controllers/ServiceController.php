<?php

namespace App\Http\Controllers;

use App\Http\Requests\Service\StoreServiceRequest;
use App\Http\Requests\Service\UpdateServiceRequest;
use App\Http\Resources\Service\ServiceResource;
use App\Http\Resources\Service\ServiceCollection;
use App\Models\Service;
use App\Services\ServiceServices;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    protected $serviceService;

    public function __construct(ServiceServices $serviceService, Request $request)
    {
        parent::__construct($request);
        $this->serviceService = $serviceService;
    }

    public function index(Request $request): ServiceCollection
    {
        $validated = $request->validate([
            'name' => 'nullable|string|max:255',
            'limit' => 'nullable|integer|min:1',
            'page' => 'nullable|integer|min:1',
        ]);

        $query = $this->serviceService->getAllServices($validated);
        $services = $query->paginate($this->limit, ['*'], 'page', $this->page);

        return new ServiceCollection($services);
    }

    public function show(Service $service): JsonResponse
    {
        return $this->success(new ServiceResource($service));
    }

    public function store(StoreServiceRequest $request): JsonResponse
    {
        $service = $this->serviceService->create($request->validated());
        return $this->success(new ServiceResource($service), 'Service created', 201);
    }

    public function update(UpdateServiceRequest $request, Service $service): JsonResponse
    {
        $service = $this->serviceService->update($service->id, $request->validated());
        return $this->success(new ServiceResource($service), 'Service updated');
    }

    public function destroy(Service $service): JsonResponse
    {
        $service->delete();
        return $this->success(null, 'Service deleted');
    }
}
