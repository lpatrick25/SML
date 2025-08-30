<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InventoryLog extends Model
{
    protected $fillable = [
        'inventory_id',
        'change_type',
        'quantity',
        'description',
        'staff_id',
        'log_date',
    ];

    protected $casts = [
        'log_date' => 'datetime',
        'change_type' => 'string',
    ];

    public function inventory()
    {
        return $this->belongsTo(Inventory::class, 'inventory_id');
    }

    public function staff()
    {
        return $this->belongsTo(User::class, 'staff_id');
    }
}
