<?php

namespace App\Http\Controllers;

use App\Http\Requests\Payment\StorePaymentRequest;
use App\Http\Requests\Payment\UpdatePaymentRequest;
use App\Http\Resources\Payment\PaymentResource;
use App\Http\Resources\Payment\PaymentCollection;
use App\Models\Payment;
use App\Services\PaymentServices;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    protected $paymentService;

    public function __construct(PaymentServices $paymentService, Request $request)
    {
        parent::__construct($request);
        $this->paymentService = $paymentService;
    }

    public function index(Request $request): PaymentCollection
    {
        $validated = $request->validate([
            'transaction_id' => 'nullable|exists:orders,id',
            'payment_method' => 'nullable|in:Cash,GCash,PayMaya,Card,Other',
            'limit' => 'nullable|integer|min:1',
            'page' => 'nullable|integer|min:1',
        ]);

        $query = $this->paymentService->getAllPayments($validated);
        $payments = $query->paginate($this->limit, ['*'], 'page', $this->page);

        return new PaymentCollection($payments);
    }

    public function show(Payment $payment): JsonResponse
    {
        $payment->load('order');
        return $this->success(new PaymentResource($payment));
    }

    public function store(StorePaymentRequest $request): JsonResponse
    {
        $payment = $this->paymentService->create($request->validated());
        $payment->load('order');
        return $this->success(new PaymentResource($payment), 'Payment created', 201);
    }

    public function update(UpdatePaymentRequest $request, Payment $payment): JsonResponse
    {
        $payment = $this->paymentService->update($payment->id, $request->validated());
        $payment->load('order');
        return $this->success(new PaymentResource($payment), 'Payment updated');
    }

    public function destroy(Payment $payment): JsonResponse
    {
        $payment->delete();
        return $this->success(null, 'Payment deleted');
    }
}
