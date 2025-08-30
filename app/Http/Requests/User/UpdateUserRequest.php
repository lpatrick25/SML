<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends FormRequest
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
            'phone_number' => ['required', 'string', 'max:20', Rule::unique('users', 'phone_number')->ignore($this->route('user')->id)],
            'email' => ['required', 'email', 'max:255', Rule::unique('users', 'email')->ignore($this->route('user')->id)],
            'address' => ['required', 'string', 'max:500'],
            'password' => ['nullable', 'string', 'min:8', 'confirmed'],
            'role' => ['required', 'in:Admin,Staff,Owner'],
            'status' => ['nullable', 'in:Active,Inactive'],
        ];
    }

    public function messages(): array
    {
        return [
            'phone_number.unique' => 'The phone number is already in use.',
            'email.unique' => 'The email address is already in use.',
            'password.confirmed' => 'The password confirmation does not match.',
        ];
    }
}
