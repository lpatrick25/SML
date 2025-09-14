<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $table = 'items';

    protected $fillable = [
        'item_name',
        'description',
        'quantity',
        'unit',
    ];

    public function itemLogs()
    {
        return $this->hasMany(ItemLog::class, 'item_id');
    }
}
