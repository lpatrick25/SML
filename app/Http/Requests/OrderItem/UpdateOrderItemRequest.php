<?php

namespace App\Http\Requests\OrderItem;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateOrderItemRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'transaction_id' => ['required', Rule::exists('orders', 'id')],
            'service_id' => ['required', Rule::exists('services', 'id')],
            'quantity' => ['required', 'integer', 'min:1'],
            'subtotal' => ['required', 'numeric', 'min:0', 'max:99999999.99'],
        ];
    }

    public function messages(): array
    {
        return [
            'transaction_id.exists' => 'The selected order does not exist.',
            'service_id.exists' => 'The selected service does not exist.',
            'quantity.min' => 'The quantity must be at least 1.',
            'subtotal.min' => 'The subtotal cannot be negative.',
            'subtotal.max' => 'The subtotal cannot exceed 99999999.99.',
        ];
    }
}
