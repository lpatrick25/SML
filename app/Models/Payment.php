<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'order_id',
        'amount',
        'payment_date',
        'payment_method',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'payment_date' => 'datetime',
        'payment_method' => 'string',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class, 'order_id');
    }
}
