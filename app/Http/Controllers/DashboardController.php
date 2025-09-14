<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Item;
use App\Models\Order;
use App\Models\Service;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function __construct()
    {
        // $this->middleware('auth'); // Restrict to authenticated users
    }

    public function index(): JsonResponse
    {
        $totalCustomers = Customer::count();
        $totalServices = Service::count();
        $totalOrders = Order::count();
        $lowItem = Item::where('quantity', '<', 10)->count(); // Example threshold
        $pendingOrders = Order::where('transaction_status', 'Pending')->count();
        $recentOrders = Order::with(['customer'])
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get()
            ->map(fn($order) => [
                'id' => $order->id,
                'customer_name' => $order->customer ? "{$order->customer->first_name} {$order->customer->last_name}" : 'N/A',
                'transaction_date' => $order->transaction_date,
                'total_amount' => $order->total_amount,
                'transaction_status' => $order->transaction_status,
            ]);
        $orderStatusDistribution = Order::select('transaction_status', DB::raw('count(*) as count'))
            ->groupBy('transaction_status')
            ->pluck('count', 'transaction_status')
            ->toArray();
        $revenueByMonth = Order::select(
            DB::raw("DATE_FORMAT(transaction_date, '%Y-%m') as month"),
            DB::raw('SUM(total_amount) as total')
        )
            ->where('transaction_date', '>=', now()->subMonths(6))
            ->groupBy('month')
            ->orderBy('month')
            ->get()
            ->map(fn($row) => [
                'month' => $row->month,
                'total' => (float) $row->total,
            ]);

        return response()->json([
            'content' => [
                'total_customers' => $totalCustomers,
                'total_services' => $totalServices,
                'total_orders' => $totalOrders,
                'low_item' => $lowItem,
                'pending_orders' => $pendingOrders,
                'recent_orders' => $recentOrders,
                'transaction_status_distribution' => $orderStatusDistribution,
                'revenue_by_month' => $revenueByMonth,
            ],
        ]);
    }
}
