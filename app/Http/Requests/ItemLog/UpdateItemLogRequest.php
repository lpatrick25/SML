<?php

namespace App\Http\Requests\ItemLog;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateItemLogRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'item_id' => ['required', Rule::exists('item', 'id')],
            'change_type' => ['required', Rule::in(['In', 'Out'])],
            'quantity' => ['required', 'integer', 'min:1'],
            'description' => ['nullable', 'string'],
            'staff_id' => ['nullable', Rule::exists('users', 'id')],
            'log_date' => ['required', 'date'],
        ];
    }

    public function messages(): array
    {
        return [
            'item_id.exists' => 'The selected item item does not exist.',
            'change_type.in' => 'The change type must be one of: In, Out.',
            'quantity.min' => 'The quantity must be at least 1.',
            'staff_id.exists' => 'The selected staff does not exist.',
        ];
    }
}
