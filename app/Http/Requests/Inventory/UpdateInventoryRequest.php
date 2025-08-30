<?php

namespace App\Http\Requests\Inventory;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateInventoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'item_name' => ['required', 'string', 'max:255', Rule::unique('inventories', 'item_name')->ignore($this->route('inventory')->id)],
            'description' => ['nullable', 'string'],
            'quantity' => ['required', 'integer', 'min:0'],
            'unit' => ['required', 'string', 'max:50'],
        ];
    }

    public function messages(): array
    {
        return [
            'item_name.unique' => 'The item name is already in use.',
            'quantity.min' => 'The quantity cannot be negative.',
            'unit.required' => 'The unit field is required.',
        ];
    }
}
