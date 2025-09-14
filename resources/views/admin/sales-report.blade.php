@extends('layouts.master')

@section('APP-TITLE')
    Sales Report
@endsection

@section('active-sales-report')
    active
@endsection

@section('APP-STYLES')
    <style>
        .equal-height-row {
            display: flex;
            flex-wrap: wrap;
        }

        .equal-height-card {
            display: flex;
            flex-direction: column;
            height: 100%;
            min-height: 150px;
        }

        .equal-height-card .card-body {
            flex-grow: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }

        .date-filter-form {
            max-width: 600px;
        }

        .services-list {
            max-height: 100px;
            overflow-y: auto;
        }
    </style>
@endsection

@section('APP-CONTENT')
    <div class="container-fluid py-4">
        <!-- Date Filter -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <form action="{{ route('sales-report.index') }}" method="GET" class="date-filter-form">
                            <div class="row g-3 align-items-center">
                                <div class="col-auto">
                                    <label for="period" class="form-label">Period</label>
                                    <select class="form-control" id="period" name="period">
                                        <option value="custom" {{ $period == 'custom' ? 'selected' : '' }}>Custom Range
                                        </option>
                                        <option value="daily" {{ $period == 'daily' ? 'selected' : '' }}>Daily</option>
                                        <option value="monthly" {{ $period == 'monthly' ? 'selected' : '' }}>Monthly
                                        </option>
                                        <option value="yearly" {{ $period == 'yearly' ? 'selected' : '' }}>Yearly</option>
                                    </select>
                                </div>
                                <div class="col-auto">
                                    <label for="start_date" class="form-label">Start Date</label>
                                    <input type="date" class="form-control" id="start_date" name="start_date"
                                        value="{{ $startDate }}">
                                </div>
                                <div class="col-auto" id="end_date_container"
                                    style="{{ $period == 'custom' ? '' : 'display: none;' }}">
                                    <label for="end_date" class="form-label">End Date</label>
                                    <input type="date" class="form-control" id="end_date" name="end_date"
                                        value="{{ $endDate }}">
                                </div>
                                <div class="col-auto">
                                    <button type="submit" class="btn btn-primary">Filter</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Metrics Cards -->
        <div class="row g-4 mb-4">
            <div class="col-lg-3 col-md-6">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="bg-success bg-opacity-10 rounded-circle p-3 me-3">
                                <i class="bi bi-currency-dollar text-success fs-4"></i>
                            </div>
                            <div>
                                <h5 class="card-title mb-1">Daily Income</h5>
                                <h3 class="card-text text-dark fw-bold">₱{{ number_format($dailyIncome, 2) }}</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="bg-primary bg-opacity-10 rounded-circle p-3 me-3">
                                <i class="bi bi-currency-dollar text-primary fs-4"></i>
                            </div>
                            <div>
                                <h5 class="card-title mb-1">Monthly Income</h5>
                                <h3 class="card-text text-dark fw-bold">₱{{ number_format($monthlyIncome, 2) }}</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="bg-info bg-opacity-10 rounded-circle p-3 me-3">
                                <i class="bi bi-currency-dollar text-info fs-4"></i>
                            </div>
                            <div>
                                <h5 class="card-title mb-1">Yearly Income</h5>
                                <h3 class="card-text text-dark fw-bold">₱{{ number_format($yearlyIncome, 2) }}</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="bg-warning bg-opacity-10 rounded-circle p-3 me-3">
                                <i class="bi bi-cart text-warning fs-4"></i>
                            </div>
                            <div>
                                <h5 class="card-title mb-1">Total Transactions</h5>
                                <h3 class="card-text text-dark fw-bold">{{ $transactionCount }}</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- All Transactions -->
        <div class="row g-4">
            <div class="col-12">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-transparent d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">All Transactions</h5>
                        <a href="{{ route('sales-report.index') }}" class="btn btn-sm btn-primary">Refresh</a>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Customer</th>
                                        <th>Transaction Date</th>
                                        <th>Services</th>
                                        <th>Total Amount</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($transactions as $transaction)
                                        <tr>
                                            <td>{{ $transaction['id'] }}</td>
                                            <td>{{ $transaction['customer_name'] }}</td>
                                            <td>{{ \Carbon\Carbon::parse($transaction['transaction_date'])->format('M d, Y') }}
                                            </td>
                                            <td>
                                                <div class="services-list">
                                                    @foreach ($transaction['services'] as $service)
                                                        <div>{{ $service['name'] }} (Qty: {{ $service['quantity'] }},
                                                            ₱{{ number_format($service['subtotal'], 2) }})</div>
                                                    @endforeach
                                                </div>
                                            </td>
                                            <td>₱{{ number_format($transaction['total_amount'], 2) }}</td>
                                            <td>
                                                @php
                                                    $statusColors = [
                                                        'Pending' => 'bg-warning',
                                                        'In Progress' => 'bg-info',
                                                        'Completed' => 'bg-success',
                                                        'Picked Up' => 'bg-primary',
                                                        'Cancelled' => 'bg-danger',
                                                    ];
                                                    $badgeClass =
                                                        $statusColors[$transaction['transaction_status']] ??
                                                        'bg-secondary';
                                                @endphp
                                                <span class="badge {{ $badgeClass }} text-white">
                                                    {{ $transaction['transaction_status'] }}
                                                </span>
                                            </td>
                                            <td>
                                                <a href="{{ route('transactions.show', $transaction['id']) }}"
                                                    class="btn btn-sm btn-info">
                                                    <i class="bi bi-eye"></i> View
                                                </a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" class="text-center">No transactions found.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Charts and Top Services -->
        <div class="row g-4 mb-4">
            <div class="col-lg-6">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-transparent">
                        <h5 class="card-title mb-0">Transaction Status Distribution</h5>
                    </div>
                    <div class="card-body">
                        <canvas id="statusChart" height="200"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-transparent">
                        <h5 class="card-title mb-0">Revenue by Month (Last 6 Months)</h5>
                    </div>
                    <div class="card-body">
                        <canvas id="revenueChart" height="200"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Top Services -->
        <div class="row g-4 mb-4">
            <div class="col-12">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-transparent">
                        <h5 class="card-title mb-0">Top Services</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Service Name</th>
                                        <th>Total Revenue</th>
                                        <th>Quantity Sold</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($topServices as $service)
                                        <tr>
                                            <td>{{ $service->name }}</td>
                                            <td>₱{{ number_format($service->total, 2) }}</td>
                                            <td>{{ $service->quantity }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="3" class="text-center">No services found.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('APP-SCRIPT')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            // Toggle end date visibility based on period selection
            $('#period').on('change', function() {
                if ($(this).val() === 'custom') {
                    $('#end_date_container').show();
                } else {
                    $('#end_date_container').hide();
                }
            });

            // Transaction Status Chart
            const statusCtx = document.getElementById('statusChart').getContext('2d');
            new Chart(statusCtx, {
                type: 'pie',
                data: {
                    labels: @json(array_keys($statusDistribution)),
                    datasets: [{
                        data: @json(array_values($statusDistribution)),
                        backgroundColor: ['#FFC107', '#17A2B8', '#28A745', '#007BFF', '#DC3545'],
                        borderColor: '#fff',
                        borderWidth: 2,
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                font: {
                                    size: 14
                                }
                            }
                        }
                    }
                }
            });

            // Revenue Chart
            const revenueCtx = document.getElementById('revenueChart').getContext('2d');
            new Chart(revenueCtx, {
                type: 'line',
                data: {
                    labels: @json($revenueByMonth->pluck('month')),
                    datasets: [{
                        label: 'Revenue (₱)',
                        data: @json($revenueByMonth->pluck('total')),
                        borderColor: '#007BFF',
                        backgroundColor: 'rgba(0, 123, 255, 0.1)',
                        fill: true,
                        tension: 0.4,
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true,
                            title: {
                                display: true,
                                text: 'Revenue (₱)',
                                font: {
                                    size: 14
                                }
                            }
                        },
                        x: {
                            title: {
                                display: true,
                                text: 'Month',
                                font: {
                                    size: 14
                                }
                            }
                        }
                    },
                    plugins: {
                        legend: {
                            display: false
                        }
                    }
                }
            });
        });
    </script>
@endsection
