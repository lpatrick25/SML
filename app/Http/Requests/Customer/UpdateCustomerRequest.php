<?php

namespace App\Http\Requests\Customer;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateCustomerRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'first_name' => ['required', 'string', 'max:255'],
            'middle_name' => ['nullable', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'extension' => ['nullable', 'string', 'max:50'],
            'phone' => ['required', 'string', 'max:20', Rule::unique('customers', 'phone')->ignore($this->route('customer')->id)],
            'email' => ['required', 'email', 'max:255', Rule::unique('customers', 'email')->ignore($this->route('customer')->id)],
            'address' => ['required', 'string', 'max:500'],
        ];
    }

    public function messages(): array
    {
        return [
            'phone.unique' => 'The phone number is already in use.',
            'email.unique' => 'The email address is already in use.',
        ];
    }
}
