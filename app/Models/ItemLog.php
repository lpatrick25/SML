<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ItemLog extends Model
{
    protected $fillable = [
        'item_id',
        'transaction_item_id',
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

    public function item()
    {
        return $this->belongsTo(Item::class, 'item_id');
    }

    public function staff()
    {
        return $this->belongsTo(User::class, 'staff_id');
    }
}
