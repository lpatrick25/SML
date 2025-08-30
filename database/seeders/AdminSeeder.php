<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'first_name' => 'Admin',
            'middle_name' => null,
            'last_name' => 'User',
            'extension' => null,
            'phone_number' => '1234567890',
            'email' => 'admin@example.com',
            'address' => '123 Admin Street, City',
            'email_verified_at' => now(),
            'password' => Hash::make('admin123'),
            'role' => 'Admin',
        ]);
    }
}
