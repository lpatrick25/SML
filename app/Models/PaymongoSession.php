<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymongoSession extends Model
{
    use HasFactory;

    protected $fillable = [
        'transaction_id',
        'session_id',
        'checkout_url',
        'client_key',
        'data',
        'status',
    ];

    protected $casts = [
        'data' => 'array',
    ];

    public function transaction()
    {
        return $this->belongsTo(Order::class); // Assuming Transaction model exists; adjust if using Order
    }
}
