<?php

namespace App\Http\Requests\Order;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateOrderRequest extends FormRequest
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
        ];
    }

    public function messages(): array
    {
        return [
            'customer_id.exists' => 'The selected customer does not exist.',
            'staff_id.exists' => 'The selected staff does not exist.',
            'transaction_status.in' => 'The order status must be one of: Pending, In Progress, Completed, Picked Up, Cancelled.',
            'total_amount.min' => 'The total amount cannot be negative.',
            'total_amount.max' => 'The total amount cannot exceed 99999999.99.',
            'payment_status.in' => 'The payment status must be one of: Unpaid, Paid, Partial.',
        ];
    }
}
