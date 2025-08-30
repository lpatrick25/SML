<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Hash;

class UserServices
{
    public function getAllUsers(array $validated): Builder
    {
        return User::query()
            ->when($validated['email'] ?? null, fn($q) => $q->where('email', $validated['email']));
    }

    public function create(array $data): User
    {
        $data['password'] = Hash::make($data['password']);
        return User::create($data);
    }

    public function update(int $id, array $data): User
    {
        $user = User::findOrFail($id);
        if (isset($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        }
        $user->update($data);
        return $user;
    }

    public function changePassword(int $id, array $data): User
    {
        $user = User::findOrFail($id);
        if (isset($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        }
        $user->update($data);
        return $user;
    }

    public function changeStatus(int $id): User
    {
        $user = User::findOrFail($id);

        if ($user->status === 'Active') {
            $user->status = 'Inactive';
        } else {
             $user->status = 'Active';
        }

        $user->save();
        return $user;
    }
}
