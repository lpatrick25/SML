<?php

namespace App\Http\Resources\Customer;

use App\Http\Resources\PaginatedResource;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\JsonResponse;

class CustomerCollection extends PaginatedResource
{
    public function data($collection): AnonymousResourceCollection
    {
        return CustomerResource::collection($collection);
    }

    public function toResponse($request): JsonResponse
    {
        return response()->json([
            'rows' => $this->data($this->collection),
            'pagination' => $this->pagination,
        ]);
    }
}
