<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Service;
use Carbon\Carbon;

class SalesReportController extends Controller
{
    public function index(Request $request)
    {
        // Get period filter (daily, monthly, yearly, or custom)
        $period = $request->input('period', 'custom');
        $startDate = $request->input('start_date', Carbon::now()->startOfMonth());
        $endDate = $request->input('end_date', Carbon::now()->endOfMonth());

        // Validate dates and set date range based on period
        $start = Carbon::parse($startDate)->startOfDay();
        $end = Carbon::parse($endDate)->endOfDay();

        if ($period === 'daily') {
            $start = Carbon::parse($startDate)->startOfDay();
            $end = Carbon::parse($startDate)->endOfDay();
        } elseif ($period === 'monthly') {
            $start = Carbon::parse($startDate)->startOfMonth();
            $end = Carbon::parse($startDate)->endOfMonth();
        } elseif ($period === 'yearly') {
            $start = Carbon::parse($startDate)->startOfYear();
            $end = Carbon::parse($startDate)->endOfYear();
        }

        // Calculate Incomes
        $dailyIncome = Order::whereDate('transaction_date', $start)
            ->where('payment_status', 'Paid')
            ->sum('total_amount');

        $monthlyIncome = Order::whereBetween('transaction_date', [
            $start->copy()->startOfMonth(),
            $start->copy()->endOfMonth()
        ])
            ->where('payment_status', 'Paid')
            ->sum('total_amount');

        $yearlyIncome = Order::whereBetween('transaction_date', [
            $start->copy()->startOfYear(),
            $start->copy()->endOfYear()
        ])
            ->where('payment_status', 'Paid')
            ->sum('total_amount');

        // Total Revenue (for the selected period)
        $totalRevenue = Order::whereBetween('transaction_date', [$start, $end])
            ->where('payment_status', 'Paid')
            ->sum('total_amount');

        // Order Count
        $transactionCount = Order::whereBetween('transaction_date', [$start, $end])
            ->count();

        // Order Status Distribution
        $statusDistribution = Order::whereBetween('transaction_date', [$start, $end])
            ->groupBy('transaction_status')
            ->selectRaw('transaction_status, COUNT(*) as count')
            ->pluck('count', 'transaction_status')
            ->toArray();

        // Top Services
        $topServices = OrderItem::whereBetween('transactions.transaction_date', [$start, $end])
            ->join('services', 'transaction_items.service_id', '=', 'services.id')
            ->join('transactions', 'transaction_items.transaction_id', '=', 'transactions.id')
            ->groupBy('services.id', 'services.name')
            ->selectRaw('services.name, SUM(transaction_items.subtotal) as total, SUM(transaction_items.quantity) as quantity')
            ->orderByDesc('total')
            ->take(5)
            ->get();

        // Revenue by Month (Last 6 Months)
        $revenueByMonth = Order::where('transaction_date', '>=', Carbon::now()->subMonths(6))
            ->where('payment_status', 'Paid')
            ->groupByRaw('DATE_FORMAT(transaction_date, "%Y-%m")')
            ->selectRaw('DATE_FORMAT(transaction_date, "%Y-%m") as month, SUM(total_amount) as total')
            ->orderBy('month')
            ->get()
            ->map(function ($item) {
                return [
                    'month' => Carbon::createFromFormat('Y-m', $item->month)->format('M Y'),
                    'total' => $item->total
                ];
            });

        // All Orders with Customer and Services
        $transactions = Order::whereBetween('transaction_date', [$start, $end])
            ->with(['customer', 'transactionItems.service'])
            ->orderByDesc('transaction_date')
            ->get()
            ->map(function ($transaction) {
                $services = $transaction->transactionItems->map(function ($item) {
                    return [
                        'name' => $item->service->name,
                        'quantity' => $item->quantity,
                        'subtotal' => $item->subtotal
                    ];
                });
                return [
                    'id' => $transaction->id,
                    'customer_name' => trim($transaction->customer->first_name . ' ' .
                        ($transaction->customer->middle_name ? $transaction->customer->middle_name . ' ' : '') .
                        $transaction->customer->last_name . ' ' .
                        ($transaction->customer->extension ? $transaction->customer->extension : '')),
                    'transaction_date' => $transaction->transaction_date,
                    'total_amount' => $transaction->total_amount,
                    'transaction_status' => $transaction->transaction_status,
                    'services' => $services
                ];
            });

        return view('admin.sales-report', compact(
            'dailyIncome',
            'monthlyIncome',
            'yearlyIncome',
            'totalRevenue',
            'transactionCount',
            'statusDistribution',
            'topServices',
            'revenueByMonth',
            'startDate',
            'endDate',
            'period',
            'transactions'
        ));
    }
}
