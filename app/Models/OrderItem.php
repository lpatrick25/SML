<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    public $table = 'transaction_items';

    protected $fillable = [
        'transaction_id',
        'service_id',
        'quantity',
        'kilograms',
        'subtotal',
    ];

    protected $casts = [
        'subtotal' => 'decimal:2',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class, 'transaction_id');
    }

    public function service()
    {
        return $this->belongsTo(Service::class, 'service_id');
    }

    public function itemLogs()
    {
        return $this->hasMany(ItemLog::class, 'transaction_item_id');
    }
}
