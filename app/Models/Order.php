<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'transactions';

    protected $fillable = [
        'transaction_number',
        'customer_id',
        'staff_id',
        'transaction_date',
        'transaction_status',
        'total_amount',
        'payment_status',
    ];

    protected $casts = [
        'total_amount' => 'decimal:2',
        'transaction_status' => 'string',
        'payment_status' => 'string',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function staff()
    {
        return $this->belongsTo(User::class, 'staff_id');
    }

    public function transactionItems()
    {
        return $this->hasMany(OrderItem::class, 'transaction_id');
    }

    public function payments()
    {
        return $this->hasMany(Payment::class, 'transaction_id');
    }
}
