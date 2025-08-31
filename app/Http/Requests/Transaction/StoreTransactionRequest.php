<?php

namespace App\Http\Requests\Transaction;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreTransactionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'customer_id' => ['required', Rule::exists('customers', 'id')],
            'staff_id' => ['nullable', Rule::exists('users', 'id')],
            'order_date' => ['required', 'date'],
            'order_status' => ['required', Rule::in(['Pending', 'In Progress', 'Completed', 'Picked Up', 'Cancelled'])],
            'total_amount' => ['required', 'numeric', 'min:0', 'max:99999999.99'],
            'payment_status' => ['required', Rule::in(['Unpaid', 'Paid', 'Partial'])],
            'order_items' => ['required', 'array', 'min:1'],
            'order_items.*.service_id' => ['required', Rule::exists('services', 'id')],
            'order_items.*.quantity' => ['required', 'integer', 'min:1'],
        ];
    }

    public function messages(): array
    {
        return [
            'customer_id.exists' => 'The selected customer does not exist.',
            'staff_id.exists' => 'The selected staff does not exist.',
            'order_status.in' => 'The order status must be one of: Pending, In Progress, Completed, Picked Up, Cancelled.',
            'total_amount.min' => 'The total amount cannot be negative.',
            'total_amount.max' => 'The total amount cannot exceed 99999999.99.',
            'payment_status.in' => 'The payment status must be one of: Unpaid, Paid, Partial.',
            'order_items.required' => 'At least one order item is required.',
            'order_items.*.service_id.required' => 'Each order item must have a service selected.',
            'order_items.*.service_id.exists' => 'The selected service does not exist.',
            'order_items.*.quantity.required' => 'Each order item must have a quantity.',
            'order_items.*.quantity.min' => 'The quantity must be at least 1.',
        ];
    }
}
