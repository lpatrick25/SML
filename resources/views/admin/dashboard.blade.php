@extends('layouts.master')
@section('APP-TITLE')
    Dashboard
@endsection
@section('active-dashboard')
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
            /* Ensures cards don't collapse too much on small screens */
        }

        .equal-height-card .card-body {
            flex-grow: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }
    </style>
@endsection
@section('APP-CONTENT')
    <div class="container-fluid py-4">
        <!-- Metrics Cards -->
        <div class="row g-4 mb-4">
            <div class="col-lg-3 col-md-6">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="bg-primary bg-opacity-10 rounded-circle p-3 me-3">
                                <i class="bi bi-people text-primary fs-4"></i>
                            </div>
                            <div>
                                <h5 class="card-title mb-1">Total Customers</h5>
                                <h3 class="card-text text-dark fw-bold" id="total-customers">0</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <div class="d-flex align-items-center">
                            <div class="bg-success bg-opacity-10 rounded-circle p-3 me-3">
                                <i class="bi bi-cart text-success fs-4"></i>
                            </div>
                            <div>
                                <h5 class="card-title mb-1">Total Transactions</h5>
                                <h3 class="card-text text-dark fw-bold" id="total-orders">0</h3>
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
                                <i class="bi bi-exclamation-triangle text-warning fs-4"></i>
                            </div>
                            <div>
                                <h5 class="card-title mb-1">Low Item</h5>
                                <h3 class="card-text text-dark fw-bold" id="low-item">0</h3>
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
                                <i class="bi bi-hourglass-split text-info fs-4"></i>
                            </div>
                            <div>
                                <h5 class="card-title mb-1">Pending Transactions</h5>
                                <h3 class="card-text text-dark fw-bold" id="pending-orders">0</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Charts and Recent Transactions -->
        <div class="row g-4">
            <div class="col-lg-6">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-transparent">
                        <h5 class="card-title mb-0">Transaction Status Distribution</h5>
                    </div>
                    <div class="card-body">
                        <canvas id="orderStatusChart" height="200"></canvas>
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
            <div class="col-12">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-transparent d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">Recent Transactions</h5>
                        <a href="{{ route('orders.index') }}" class="btn btn-sm btn-primary">View All Transactions</a>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Customer</th>
                                        <th>Transaction Date</th>
                                        <th>Total Amount</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody id="recent-orders-table"></tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Links -->
        <div class="row g-4 mt-4 equal-height-row">
            <div class="col-lg-3 col-md-6">
                <div class="card shadow-sm border-0 text-center equal-height-card">
                    <div class="card-body">
                        <i class="bi bi-people fs-2 text-primary"></i>
                        <h5 class="card-title mt-2">Manage Customers</h5>
                        <a href="{{ route('customers.index') }}" class="btn btn-outline-primary btn-sm">Go to Customers</a>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="card shadow-sm border-0 text-center equal-height-card">
                    <div class="card-body">
                        <i class="bi bi-gear fs-2 text-success"></i>
                        <h5 class="card-title mt-2">Manage Services</h5>
                        <a href="{{ route('services.index') }}" class="btn btn-outline-success btn-sm">Go to Services</a>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="card shadow-sm border-0 text-center equal-height-card">
                    <div class="card-body">
                        <i class="bi bi-box-seam fs-2 text-warning"></i>
                        <h5 class="card-title mt-2">Manage Item</h5>
                        <a href="{{ route('items.index') }}" class="btn btn-outline-warning btn-sm">Go to
                            Item</a>
                    </div>
                </div>
            </div>
            <div class="col-lg-3 col-md-6">
                <div class="card shadow-sm border-0 text-center equal-height-card">
                    <div class="card-body">
                        <i class="bi bi-cart fs-2 text-info"></i>
                        <h5 class="card-title mt-2">Manage Transactions</h5>
                        <a href="{{ route('orders.index') }}" class="btn btn-outline-info btn-sm">Go to Transactions</a>
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
            // Fetch dashboard data
            $.ajax({
                method: 'GET',
                url: '{{ route('dashboard') }}',
                dataType: 'json',
                cache: false,
                success: function(response) {
                    const data = response.content;

                    // Update metrics
                    $('#total-customers').text(data.total_customers);
                    $('#total-orders').text(data.total_orders);
                    $('#low-item').text(data.low_item);
                    $('#pending-orders').text(data.pending_orders);

                    // Recent orders table
                    const $tbody = $('#recent-orders-table').empty();
                    if (data.recent_orders && data.recent_orders.length) {
                        data.recent_orders.forEach(order => {
                            const statusColors = {
                                'Pending': 'bg-warning',
                                'In Progress': 'bg-info',
                                'Completed': 'bg-success',
                                'Picked Up': 'bg-primary',
                                'Cancelled': 'bg-danger'
                            };
                            $tbody.append(`
                                <tr>
                                    <td>${order.id}</td>
                                    <td>${order.customer_name}</td>
                                    <td>${order.transaction_date}</td>
                                    <td>$${parseFloat(order.total_amount).toFixed(2)}</td>
                                    <td><span class="badge ${statusColors[order.transaction_status] || 'bg-secondary'} text-white">${order.transaction_status}</span></td>
                                    <td>
                                        <a href="{{ route('orders.index') }}/${order.id}" class="btn btn-sm btn-info">
                                            <i class="bi bi-eye"></i> View
                                        </a>
                                    </td>
                                </tr>
                            `);
                        });
                    } else {
                        $tbody.append(
                            '<tr><td colspan="6" class="text-center">No recent orders found.</td></tr>'
                            );
                    }

                    // Transaction Status Chart
                    const orderStatusCtx = document.getElementById('orderStatusChart').getContext('2d');
                    new Chart(orderStatusCtx, {
                        type: 'pie',
                        data: {
                            labels: Object.keys(data.transaction_status_distribution),
                            datasets: [{
                                data: Object.values(data.transaction_status_distribution),
                                backgroundColor: ['#FFC107', '#17A2B8', '#28A745',
                                    '#007BFF', '#DC3545'
                                ],
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
                            labels: data.revenue_by_month.map(item => item.month),
                            datasets: [{
                                label: 'Revenue ($)',
                                data: data.revenue_by_month.map(item => item.total),
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
                                        text: 'Revenue ($)',
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
                },
                error: function(xhr) {
                    toastr.error(
                        `Error loading dashboard data: ${xhr.responseJSON?.message || 'Unknown error'}`
                        );
                }
            });
        });
    </script>
@endsection
