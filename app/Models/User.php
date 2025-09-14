<?php

namespace App\Models;

use App\Support\Traits\HasFullNameTrait;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use Notifiable, HasApiTokens, HasFullNameTrait;

    protected $fillable = [
        'first_name',
        'middle_name',
        'last_name',
        'extension',
        'phone_number',
        'email',
        'address',
        'email_verified_at',
        'password',
        'role',
        'status',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function orders()
    {
        return $this->hasMany(Order::class, 'staff_id');
    }

    public function itemLogs()
    {
        return $this->hasMany(ItemLog::class, 'staff_id');
    }
}
