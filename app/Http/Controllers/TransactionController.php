<?php

namespace App\Http\Controllers;

use App\Http\Requests\Transaction\StoreTransactionRequest;
use App\Http\Requests\Transaction\UpdateTransactionRequest;
use App\Http\Resources\PaymongoSession\PaymongoSessionResource;
use App\Http\Resources\Transaction\TransactionCollection;
use App\Http\Resources\Transaction\TransactionResource;
use App\Models\Order;
use App\Models\Payment;
use App\Models\PaymongoSession;
use App\Models\Service;
use App\Services\TransactionServices;
use GuzzleHttp\Client;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class TransactionController extends Controller
{
    protected $transactionService;

    public function __construct(TransactionServices $transactionService, Request $request)
    {
        parent::__construct($request);
        $this->transactionService = $transactionService;
    }

    public function index(Request $request): TransactionCollection
    {
        $validated = $request->validate([
            'customer_id' => 'nullable|exists:customers,id',
            'transaction_status' => 'nullable|in:Pending,In Progress,Completed,Picked Up,Cancelled',
            'limit' => 'nullable|integer|min:1',
            'page' => 'nullable|integer|min:1',
        ]);

        $query = $this->transactionService->getAllOrders($validated);
        $transactions = $query->paginate($this->limit, ['*'], 'page', $this->page);

        return new TransactionCollection($transactions);
    }

    public function show(Order $transaction): JsonResponse
    {
        $transaction->load('customer', 'staff', 'transactionItems.service');
        return response()->json(['content' => new TransactionResource($transaction)]);
    }

    public function store(StoreTransactionRequest $request): JsonResponse
    {
        $transaction = $this->transactionService->create($request->validated());
        return response()->json(['content' => new TransactionResource($transaction), 'message' => 'Order created'], 201);
    }

    public function update(UpdateTransactionRequest $request, Order $transaction): JsonResponse
    {
        $transaction = $this->transactionService->update($transaction->id, $request->validated());
        return response()->json(['content' => new TransactionResource($transaction), 'message' => 'Order updated']);
    }

    public function destroy(Order $transaction): JsonResponse
    {
        $transaction->transactionItems()->delete();
        $transaction->delete();
        return response()->json(['message' => 'Order deleted']);
    }

    public function changeStatus(Request $request, Order $transaction): JsonResponse
    {
        $validated = $request->validate([
            'status' => 'required|in:In Progress,Completed,Picked Up,Cancelled'
        ]);

        // Validate status transition
        $currentStatus = $transaction->transaction_status;
        $newStatus = $validated['status'];

        $allowedTransitions = [
            'Pending' => ['In Progress', 'Cancelled'],
            'In Progress' => ['Completed'],
            'Completed' => ['Picked Up'],
        ];

        if (!in_array($newStatus, $allowedTransitions[$currentStatus] ?? [])) {
            return response()->json(['message' => 'Invalid status transition'], 422);
        }

        Log::info("Payment status: {$transaction->payment_status}");
        Log::info("Changing status from $currentStatus to $newStatus for transaction ID {$transaction->id}");

        // Check if transitioning from Completed to Picked Up and payment_status is Unpaid
        if ($currentStatus === 'Completed' && $newStatus === 'Picked Up' && $transaction->payment_status === 'Unpaid') {
            Log::info("Creating payment for transaction ID {$transaction->id} as it is being picked up with Unpaid status");
            $transaction = $this->transactionService->updatePaymentStatus($transaction->id, 'Paid');
            Payment::create([
                'transaction_id' => $transaction->id,
                'amount' => $transaction->total_amount,
                'payment_method' => 'Cash', // Default to Cash, modify as needed based on your requirements
            ]);
        }

        $transaction = $this->transactionService->updateStatus($transaction->id, $validated['status']);
        return response()->json([
            'content' => new TransactionResource($transaction),
            'message' => 'Status updated successfully'
        ]);
    }

    public function getTotalAmount(Request $request)
    {
        $serviceInput = $request->input('service');
        $kilogramsInput = $request->input('kilograms');

        $service = Service::findOrFail($serviceInput);

        if (!$service) {
            return response()->json('Service not found');
        }

        $serviceKilograms = $service->kilograms;

        if ($kilogramsInput > $serviceKilograms) {
            $load = ceil($kilogramsInput / $serviceKilograms);
            $totalAmount = $load * $service->price;
        } else {
            $load = 1;
            $totalAmount = $load * $service->price;
        }

        return response()->json(['load' => $load, 'totalAmount' => $totalAmount]);
    }

    public function processPayment(Request $request, int $transactionId): JsonResponse
    {
        $validated = $request->validate([
            'payment_method' => 'required|in:cash,gcash,paymaya',
            'billing' => 'nullable|array', // For online: name, email, phone overrides
            'billing.name' => 'string',
            'billing.email' => 'email',
            'billing.phone' => 'string',
        ]);

        try {
            $result = $this->transactionService->processPayment($transactionId, $validated['payment_method'], $validated['billing'] ?? []);
            return response()->json($result, $result['success'] ? 200 : 400);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 422);
        }
    }

    // Add success route handler
    public function paymentSuccess(int $transactionId): View
    {
        $transaction = Order::findOrFail($transactionId);

        $paymongoSession = PaymongoSession::where('transaction_id', $transactionId)
            ->where('status', 'active')
            ->latest()
            ->first();

        if ($paymongoSession) {
            // Fetch latest PayMongo session data
            $client = new Client();
            $response = $client->request('GET', 'https://api.paymongo.com/v1/checkout_sessions/' . $paymongoSession->session_id, [
                'headers' => [
                    'Content-Type'  => 'application/json',
                    'Accept'        => 'application/json',
                    'Authorization' => 'Basic ' . base64_encode(env('PAYMONGO_SECRET_KEY') . ':'),
                ],
            ]);

            $responseData = json_decode($response->getBody(), true);
            $attributes   = $responseData['data']['attributes'] ?? [];

            $paymentMethod = $attributes['payment_method_types'][0] ?? 'gcash';

            //Create Payment
            Payment::create([
                'transaction_id' => $transaction->id,
                'amount' => $transaction->total_amount,
                'payment_method' => $paymentMethod,
            ]);

            // Instead of delete, update old session as "expired"
            $paymongoSession->update(['status' => 'paid']);
            $transaction->update(['payment_status' => 'Paid']);
        }

        $transaction = Order::findOrFail($transactionId)->load('customer', 'staff', 'transactionItems.service');
        // Verify payment status via PayMongo if needed
        return view('payment-success', compact('transaction'));
    }

    public function getPayment(Order $transaction): JsonResponse
    {
        $paymongoSession = PaymongoSession::where('transaction_id', $transaction->id)->where('status', '!=', 'expired')->first();

        if (!$paymongoSession) {
            return response()->json(['message' => 'No payment session found'], 404);
        }

        return response()->json([
            'success' => true,
            'data' => new PaymongoSessionResource($paymongoSession)
        ]);
    }
}
