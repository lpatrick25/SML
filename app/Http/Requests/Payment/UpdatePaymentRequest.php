<?php

namespace App\Http\Requests\Payment;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdatePaymentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'order_id' => ['required', Rule::exists('orders', 'id')],
            'amount' => ['required', 'numeric', 'min:0', 'max:99999999.99'],
            'payment_date' => ['required', 'date'],
            'payment_method' => ['required', Rule::in(['Cash', 'GCash', 'PayMaya', 'Card', 'Other'])],
        ];
    }

    public function messages(): array
    {
        return [
            'order_id.exists' => 'The selected order does not exist.',
            'amount.min' => 'The amount cannot be negative.',
            'amount.max' => 'The amount cannot exceed 99999999.99.',
            'payment_method.in' => 'The payment method must be one of: Cash, GCash, PayMaya, Card, Other.',
        ];
    }
}
