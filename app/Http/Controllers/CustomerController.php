<?php

namespace App\Http\Controllers;

use App\Http\Requests\Customer\StoreCustomerRequest;
use App\Http\Requests\Customer\UpdateCustomerRequest;
use App\Http\Resources\Customer\CustomerResource;
use App\Http\Resources\Customer\CustomerCollection;
use App\Models\Customer;
use App\Services\CustomerServices;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    protected $customerService;

    public function __construct(CustomerServices $customerService, Request $request)
    {
        parent::__construct($request);
        $this->customerService = $customerService;
    }

    public function index(Request $request): CustomerCollection
    {
        $validated = $request->validate([
            'email' => 'nullable|email',
            'limit' => 'nullable|integer|min:1',
            'page' => 'nullable|integer|min:1',
        ]);

        $query = $this->customerService->getAllCustomers($validated);
        $customers = $query->paginate($this->limit, ['*'], 'page', $this->page);

        return new CustomerCollection($customers);
    }

    public function show(Customer $customer): JsonResponse
    {
        return $this->success(new CustomerResource($customer));
    }

    public function store(StoreCustomerRequest $request): JsonResponse
    {
        $customer = $this->customerService->create($request->validated());
        return $this->success(new CustomerResource($customer), 'Customer created', 201);
    }

    public function update(UpdateCustomerRequest $request, Customer $customer): JsonResponse
    {
        $customer = $this->customerService->update($customer->id, $request->validated());
        return $this->success(new CustomerResource($customer), 'Customer updated');
    }

    public function destroy(Customer $customer): JsonResponse
    {
        $customer->delete();
        return $this->success(null, 'Customer deleted');
    }
}
