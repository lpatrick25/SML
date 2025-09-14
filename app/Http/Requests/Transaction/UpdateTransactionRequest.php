<?php

namespace App\Http\Requests\Transaction;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateTransactionRequest extends FormRequest
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
            'transaction_date' => ['required', 'date'],
            'transaction_status' => ['required', Rule::in(['Pending', 'In Progress', 'Completed', 'Picked Up', 'Cancelled'])],
            'total_amount' => ['required', 'numeric', 'min:0', 'max:99999999.99'],
            'payment_status' => ['required', Rule::in(['Unpaid', 'Paid', 'Partial'])],
            'transaction_items' => ['required', 'array', 'min:1'],
            'transaction_items.*.service_id' => ['required', Rule::exists('services', 'id')],
            'transaction_items.*.quantity' => ['required', 'integer', 'min:1'],
            'transaction_items.*.item_items' => ['sometimes', 'array', 'min:1'],
            'transaction_items.*.item_items.*.item_id' => ['required_with:transaction_items.*.item_items', Rule::exists('items', 'id')],
            'transaction_items.*.item_items.*.quantity' => ['required_with:transaction_items.*.item_items', 'integer', 'min:1'],
        ];
    }

    public function messages(): array
    {
        return [
            'customer_id.exists' => 'The selected customer does not exist.',
            'staff_id.exists' => 'The selected staff does not exist.',
            'transaction_date.required' => 'The transaction date is required.',
            'transaction_date.date' => 'The transaction date must be a valid date.',
            'transaction_status.in' => 'The order status must be one of: Pending, In Progress, Completed, Picked Up, Cancelled.',
            'total_amount.min' => 'The total amount cannot be negative.',
            'total_amount.max' => 'The total amount cannot exceed 99999999.99.',
            'payment_status.in' => 'The payment status must be one of: Unpaid, Paid, Partial.',
            'transaction_items.required' => 'At least one order item is required.',
            'transaction_items.*.service_id.required' => 'Each order item must have a service selected.',
            'transaction_items.*.service_id.exists' => 'The selected service does not exist.',
            'transaction_items.*.quantity.required' => 'Each order item must have a quantity.',
            'transaction_items.*.quantity.min' => 'The quantity must be at least 1.',
            'transaction_items.*.item_items.min' => 'Each order item must include at least one item item if provided.',
            'transaction_items.*.item_items.*.item_id.required_with' => 'Each item item must have an item ID.',
            'transaction_items.*.item_items.*.item_id.exists' => 'The selected item item does not exist.',
            'transaction_items.*.item_items.*.quantity.required_with' => 'Each item item must have a quantity.',
            'transaction_items.*.item_items.*.quantity.min' => 'The item item quantity must be at least 1.',
        ];
    }
}
