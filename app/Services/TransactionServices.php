<?php

namespace App\Services;

use App\Http\Resources\Transaction\TransactionResource;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Service;
use App\Models\Item;
use App\Models\ItemLog;
use App\Models\Payment;
use App\Models\PaymongoSession;
use GuzzleHttp\Client;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class TransactionServices
{
    function generateTransactionNumber(): string
    {
        $prefix = "TXN";

        $latestOrder = Order::latest('id')->first();

        // Get the last sequence number
        $lastNumber = $latestOrder
            ? intval(str_replace($prefix . '-', '', $latestOrder->transaction_number))
            : 0;

        $nextNumber = $lastNumber + 1;

        return $prefix . '-' . str_pad($nextNumber, 8, '0', STR_PAD_LEFT);
    }

    public function getAllOrders(array $validated): Builder
    {
        return Order::query()
            ->with(['customer', 'staff', 'transactionItems.service', 'transactionItems.itemLogs.item'])
            ->when($validated['customer_id'] ?? null, fn($q) => $q->where('customer_id', $validated['customer_id']))
            ->when($validated['transaction_status'] ?? null, fn($q) => $q->where('transaction_status', $validated['transaction_status']));
    }

    public function create(array $data): Order
    {
        return DB::transaction(function () use ($data) {

            $transaction = Order::create([
                'transaction_number' => $this->generateTransactionNumber(),
                'customer_id' => $data['customer_id'],
                'staff_id' => $data['staff_id'],
                'transaction_date' => $data['transaction_date'],
                'total_amount' => $data['total_amount'],
            ]);

            $transactionItem = OrderItem::create([
                'transaction_id' => $transaction->id,
                'service_id' => $data['service_id'],
                'quantity' => $data['load'],
                'kilograms' => $data['kilograms'],
                'subtotal' => $data['total_amount']
            ]);

            $item = Item::findOrFail($data['item_id']);
            $deduction = $data['load'] * 2;

            $item->decrement('quantity', $deduction);

            ItemLog::create([
                'item_id' => $data['item_id'],
                'transaction_item_id' => $transactionItem->id,
                'change_type' => 'Out',
                'quantity' => $deduction,
                'description' => "Used in transaction item #{$transactionItem->id} for transaction #{$transaction->id}",
                'staff_id' => $data['staff_id'] ?? null,
            ]);

            return $transaction->load('customer', 'staff', 'transactionItems.service', 'transactionItems.itemLogs.item');
        });
    }

    public function update(int $id, array $data): Order
    {
        return DB::transaction(function () use ($id, $data) {
            // Find the order
            $transaction = Order::findOrFail($id);

            // Update order fields
            $transaction->update([
                'customer_id'      => $data['customer_id'],
                'staff_id'         => $data['staff_id'],
                'transaction_date' => $data['transaction_date'],
                'total_amount'     => $data['total_amount'],
            ]);

            // For simplicity assuming **one transaction item** per order
            $transactionItem = $transaction->transactionItems()->firstOrFail();

            // Reverse old deduction
            $oldDeduction = $transactionItem->quantity * 2;
            $oldItemLog   = $transactionItem->itemLogs()->first();

            if ($oldItemLog) {
                $oldItem = Item::findOrFail($oldItemLog->item_id);
                $oldItem->increment('quantity', $oldDeduction); // return stock
                $oldItemLog->delete();
            }

            // Update transaction item
            $transactionItem->update([
                'service_id' => $data['service_id'],
                'quantity'   => $data['load'],
                'kilograms'  => $data['kilograms'],
                'subtotal'   => $data['total_amount'],
            ]);

            // Apply new deduction
            $deduction = $data['load'] * 2;
            $item      = Item::findOrFail($data['item_id']);
            $item->decrement('quantity', $deduction);

            // Create new log
            ItemLog::create([
                'item_id'             => $data['item_id'],
                'transaction_item_id' => $transactionItem->id,
                'change_type'         => 'Out',
                'quantity'            => $deduction,
                'description'         => "Updated transaction item #{$transactionItem->id} for transaction #{$transaction->id}",
                'staff_id'            => $data['staff_id'] ?? null,
                'log_date'            => now(),
            ]);

            // === Handle PayMongo Session ===
            $paymongoSession = PaymongoSession::where('transaction_id', $id)
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

                // Extract billing + payment method
                $billingData = [
                    'name'  => $attributes['billing']['name'] ?? $transaction->customer->full_name,
                    'email' => $attributes['billing']['email'] ?? $transaction->customer->email,
                    'phone' => $attributes['billing']['phone'] ?? $transaction->customer->phone,
                ];

                $paymentMethod = $attributes['payment_method_types'][0] ?? 'gcash';

                // Create a new PayMongo session if still active
                $paymongoData = $this->createPayMongoSession($transaction, $billingData, $paymentMethod);

                // Instead of delete, update old session as "expired"
                $paymongoSession->update(['status' => 'expired']);
            }

            return $transaction->load('customer', 'staff', 'transactionItems.service', 'transactionItems.itemLogs.item');
        });
    }

    public function updateStatus(int $id, string $status): Order
    {
        $transaction = Order::findOrFail($id);
        $transaction->update(['transaction_status' => $status]);
        return $transaction->load('customer', 'staff', 'transactionItems.service', 'transactionItems.itemLogs.item');
    }

    public function updatePaymentStatus(int $id, string $status): Order
    {
        $transaction = Order::findOrFail($id);
        $transaction->update(['payment_status' => $status]);
        return $transaction->load('customer', 'staff', 'transactionItems.service', 'transactionItems.itemLogs.item');
    }

    public function processPayment(int $transactionId, string $paymentMethod, array $billingData = []): array
    {
        return DB::transaction(function () use ($transactionId, $paymentMethod, $billingData) {
            $transaction = Order::findOrFail($transactionId); // Adjust to Order if needed

            if ($paymentMethod === 'cash') {
                $transaction->update(['payment_status' => 'Paid']);
                Payment::create([
                    'transaction_id' => $transaction->id,
                    'amount' => $transaction->total_amount,
                    'payment_method' => 'Cash',
                ]);
                return ['success' => true, 'message' => 'Payment processed as cash.', 'data' => new TransactionResource($transaction)];
            } elseif (in_array($paymentMethod, ['gcash', 'paymaya'])) {
                // Create PayMongo session
                $paymongoData = $this->createPayMongoSession($transaction, $billingData, $paymentMethod);
                return ['success' => true, 'message' => 'Online payment session created.', 'data' => $paymongoData];
            } else {
                throw new \InvalidArgumentException('Unsupported payment method.');
            }
        });
    }

    private function createPayMongoSession(Order $transaction, array $billingData, string $method): array
    {
        $client = new Client();

        // Prepare billing info from customer if not provided
        if (empty($billingData['name'])) {
            $customer = $transaction->customer;
            $billingData['name'] = trim($customer->first_name . ' ' . ($customer->middle_name ?? '') . ' ' . $customer->last_name);
        }
        if (empty($billingData['email'])) {
            $billingData['email'] = $transaction->customer->email;
        }
        if (empty($billingData['phone'])) {
            $billingData['phone'] = $transaction->customer->phone;
        }

        $body = [
            'data' => [
                'attributes' => [
                    'billing' => [
                        'name' => $billingData['name'],
                        'email' => $billingData['email'],
                        'phone' => $billingData['phone'],
                    ],
                    'send_email_receipt' => true,
                    'show_description' => true,
                    'show_line_items' => true,
                    'description' => 'Laundry Service',
                    'line_items' => [
                        [
                            'currency' => 'PHP',
                            'amount' => (int) ($transaction->total_amount * 100), // Convert to centavos
                            'name' => 'Wash, Dry, Fold', // Customize based on service
                            'quantity' => 1,
                        ],
                    ],
                    'reference_number' => $transaction->transaction_number,
                    'success_url' => route('transactions.success', $transaction->id), // Define this route
                    'payment_method_types' => [$method],
                ],
            ],
        ];

        $response = $client->request('POST', 'https://api.paymongo.com/v1/checkout_sessions', [
            'body' => json_encode($body),
            'headers' => [
                'Content-Type' => 'application/json',
                'Accept' => 'application/json',
                'Authorization' => 'Basic ' . base64_encode(env('PAYMONGO_SECRET_KEY') . ':'), // Use env for key
            ],
        ]);

        $responseData = json_decode($response->getBody(), true);

        if (!isset($responseData['data']['id'])) {
            throw new \Exception('Failed to create PayMongo session.');
        }

        $session = PaymongoSession::create([
            'transaction_id' => $transaction->id,
            'session_id' => $responseData['data']['id'],
            'checkout_url' => $responseData['data']['attributes']['checkout_url'],
            'client_key' => $responseData['data']['attributes']['client_key'],
            'data' => $responseData['data'],
            'status' => $responseData['data']['attributes']['status'],
        ]);

        Log::info('PayMongo session created', ['session_id' => $session->session_id]);

        return [
            'session' => $session,
            'qr_url' => null, // Generate QR in frontend or use a service
        ];
    }

    // Add method to update payment status via webhook (for later implementation)
    public function updateFromPayMongoWebhook(array $payload): void
    {
        // Parse webhook payload, update PaymongoSession status, then update transaction payment_status to 'Paid' and create Payment record
        // Example: if ($payload['data']['attributes']['status'] === 'paid') { ... }
    }
}
