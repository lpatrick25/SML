<?php

namespace App\Http\Requests\Service;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateServiceRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255', Rule::unique('services', 'name')->ignore($this->route('service')->id)],
            'description' => ['nullable', 'string'],
            'kilograms' => ['required', 'integer', 'min:1'],
            'price' => ['required', 'numeric', 'min:0', 'max:999999.99'],
        ];
    }

    public function messages(): array
    {
        return [
            'name.unique' => 'The service name is already in use.',
            'kilograms.min' => 'The kilograms must be at least 1.',
            'price.min' => 'The price cannot be negative.',
            'price.max' => 'The price cannot exceed 999999.99.',
        ];
    }
}
