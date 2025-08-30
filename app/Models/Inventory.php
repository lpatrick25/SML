<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    protected $table = 'inventories';

    protected $fillable = [
        'item_name',
        'description',
        'quantity',
        'unit',
    ];

    public function inventoryLogs()
    {
        return $this->hasMany(InventoryLog::class, 'inventory_id');
    }
}
