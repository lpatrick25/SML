<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\ItemLog;

class InventoryController extends Controller
{
    public function index(Request $request)
    {
        // Get filter for low stock
        $lowStockFilter = $request->input('low_stock', 'all');
        $lowStockThreshold = 10; // Configurable low stock threshold

        // Query items
        $itemsQuery = Item::query();
        if ($lowStockFilter === 'low') {
            $itemsQuery->where('quantity', '<=', $lowStockThreshold);
        }
        $items = $itemsQuery->orderBy('item_name')->get();

        // Metrics
        $totalItems = Item::count();
        $lowStockItems = Item::where('quantity', '<=', $lowStockThreshold)->count();

        // Recent Item Logs (last 10)
        $recentLogs = ItemLog::with(['item', 'staff'])
            ->orderByDesc('log_date')
            ->take(10)
            ->get()
            ->map(function ($log) {
                return [
                    'id' => $log->id,
                    'item_name' => $log->item->item_name,
                    'change_type' => $log->change_type,
                    'quantity' => $log->quantity,
                    'description' => $log->description ?? 'No description',
                    'staff_name' => $log->staff ? trim($log->staff->first_name . ' ' .
                        ($log->staff->middle_name ? $log->staff->middle_name . ' ' : '') .
                        $log->staff->last_name . ' ' .
                        ($log->staff->extension ? $log->staff->extension : '')) : 'N/A',
                    'log_date' => $log->log_date->format('M d, Y H:i'),
                ];
            });

        return view('admin.inventory-report', compact(
            'items',
            'totalItems',
            'lowStockItems',
            'recentLogs',
            'lowStockFilter',
            'lowStockThreshold'
        ));
    }
}
