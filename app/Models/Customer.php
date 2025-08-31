<?php

namespace App\Models;

use App\Support\Traits\HasFullNameTrait;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFullNameTrait;

    protected $fillable = [
        'first_name',
        'middle_name',
        'last_name',
        'extension',
        'phone',
        'email',
        'address',
    ];

    public function orders()
    {
        return $this->hasMany(Order::class, 'customer_id');
    }
}
