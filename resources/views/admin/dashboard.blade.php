@extends('layouts.master')

@section('APP-TITLE')
    Dashboard
@endsection

@section('active-dashboard')
    active
@endsection

@section('APP-SUBTITLE')
    Overview
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

        .metric-card .card-body {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .metric-card .icon-circle {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 50px;
            height: 50px;
            border-radius: 50%;
        }
    </style>
@endsection

@section('APP-CONTENT')
    <div class="col-sm-12">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="card-title">@yield('APP-SUBTITLE')</h3>
        </div>
        <div class="card-body">
            <!-- Metrics Cards -->
            <div class="row g-4 mb-4 equal-height-row">
                <div class="col-lg-3 col-md-6">
                    <div class="card shadow-sm border-0 metric-card">
                        <div class="card-body">
                            <div class="icon-circle bg-primary bg-opacity-10">
                                <i class="bi bi-people text-primary fs-4"></i>
                            </div>
                            <div class="text-end">
                                <h5 class="card-title mb-1">Total Customers</h5>
                                <h3 class="card-text text-dark fw-bold" id="total-customers">0</h3>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="card shadow-sm border-0 metric-card">
                        <div class="card-body">
                            <div class="icon-circle bg-success bg-opacity-10">
                                <i class="bi bi-cart text-success fs-4"></i>
                            </div>
                            <div class="text-end">
                                <h5 class="card-title mb-1">Total Transactions</h5>
                                <h3 class="card-text text-dark fw-bold" id="total-orders">0</h3>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="card shadow-sm border-0 metric-card">
                        <div class="card-body">
                            <div class="icon-circle bg-warning bg-opacity-10">
                                <i class="bi bi-exclamation-triangle text-warning fs-4"></i>
                            </div>
                            <div class="text-end">
                                <h5 class="card-title mb-1">Low Item</h5>
                                <h3 class="card-text text-dark fw-bold" id="low-item">0</h3>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="card shadow-sm border-0 metric-card">
                        <div class="card-body">
                            <div class="icon-circle bg-info bg-opacity-10">
                                <i class="bi bi-hourglass-split text-info fs-4"></i>
                            </div>
                            <div class="text-end">
                                <h5 class="card-title mb-1">Pending Transactions</h5>
                                <h3 class="card-text text-dark fw-bold" id="pending-orders">0</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Charts -->
            <div class="row g-4 mb-4">
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
            </div>

            <!-- Recent Transactions -->
            <div class="row g-4">
                <div class="col-12">
                    <div class="card shadow-sm border-0">
                        <div class="card-header bg-transparent d-flex justify-content-between align-items-center">
                            <h5 class="card-title mb-0">Recent Transactions</h5>
                        </div>
                        <div class="card-body">
                            <div class="" id="toolbar">
                                <a href="{{ route('orders.index') }}" class="btn btn-sm btn-primary">View All
                                    Transactions</a>
                            </div>
                            <table id="recent-orders-table" data-toggle="table" data-pagination="true" data-search="true"
                                data-show-columns="true" data-show-refresh="true" data-show-toggle="true"
                                data-sticky-header="true" data-url="{{ route('dashboard') }}" data-toolbar="#toolbar">
                                <thead>
                                    <tr>
                                        <th data-field="id">#</th>
                                        <th data-field="customer_name">Customer</th>
                                        <th data-field="transaction_date">Transaction Date</th>
                                        <th data-field="total_amount" data-formatter="formatAmount">Total Amount</th>
                                        <th data-field="transaction_status" data-formatter="formatStatus">Status</th>
                                        <th data-field="action" data-formatter="formatAction">Action</th>
                                    </tr>
                                </thead>
                            </table>
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
                            <a href="{{ route('customers.index') }}" class="btn btn-outline-primary btn-sm">Go to
                                Customers</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="card shadow-sm border-0 text-center equal-height-card">
                        <div class="card-body">
                            <i class="bi bi-gear fs-2 text-success"></i>
                            <h5 class="card-title mt-2">Manage Services</h5>
                            <a href="{{ route('services.index') }}" class="btn btn-outline-success btn-sm">Go to
                                Services</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="card shadow-sm border-0 text-center equal-height-card">
                        <div class="card-body">
                            <i class="bi bi-box-seam fs-2 text-warning"></i>
                            <h5 class="card-title mt-2">Manage Item</h5>
                            <a href="{{ route('items.index') }}" class="btn btn-outline-warning btn-sm">Go to Item</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="card shadow-sm border-0 text-center equal-height-card">
                        <div class="card-body">
                            <i class="bi bi-cart fs-2 text-info"></i>
                            <h5 class="card-title mt-2">Manage Transactions</h5>
                            <a href="{{ route('orders.index') }}" class="btn btn-outline-info btn-sm">Go to
                                Transactions</a>
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
        // Table formatters
        function formatAmount(value) {
            return `$${parseFloat(value).toFixed(2)}`;
        }

        function formatStatus(value) {
            const statusColors = {
                'Pending': 'bg-warning',
                'In Progress': 'bg-info',
                'Completed': 'bg-success',
                'Picked Up': 'bg-primary',
                'Cancelled': 'bg-danger'
            };
            return `<span class="badge ${statusColors[value] || 'bg-secondary'} text-white">${value}</span>`;
        }

        function formatAction(value, row) {
            if (!row || !row.id) {
                return '<span class="text-muted">No actions</span>';
            }
            return `
                <a href="{{ route('orders.index') }}/${row.id}" class="btn btn-sm btn-info" title="View">
                    <i class="bi bi-eye"></i>
                </a>
            `;
        }

        // Check if device is mobile
        function isMobile() {
            return window.innerWidth <= 576;
        }

        $(document).ready(function() {
            // Initialize Bootstrap Table
            $('#recent-orders-table').bootstrapTable({
                exportDataType: 'all',
                exportTypes: ['json', 'csv', 'txt', 'excel'],
                filterControl: true,
                stickyHeader: true,
                pagination: true,
                pageSize: 5,
                pageList: [5, 10, 25],
                search: true,
                showColumns: true,
                showRefresh: true,
                showToggle: true,
                sidePagination: 'server',
                cache: true,
                cacheAmount: 100,
                showCustomView: isMobile(),
                formatNoMatches: function() {
                    return '<div class="text-center p-4">No recent orders found.</div>';
                },
                formatLoadingMessage: function() {
                    return '<div class="text-center"><span class="spinner-border spinner-border-sm"></span> Loading...</div>';
                },
                responseHandler: function(res) {
                    return res.content.recent_orders || [];
                }
            });

            // Toggle custom view on window resize
            $(window).on('resize', function() {
                $('#recent-orders-table').bootstrapTable('toggleCustomView', isMobile());
            });

            // Fetch dashboard data
            $.ajax({
                method: 'GET',
                url: '{{ route('dashboard') }}',
                dataType: 'json',
                cache: false,
                success: function(response) {
                    const data = response.content;

                    // Update metrics
                    $('#total-customers').text(data.total_customers || 0);
                    $('#total-orders').text(data.total_orders || 0);
                    $('#low-item').text(data.low_item || 0);
                    $('#pending-orders').text(data.pending_orders || 0);

                    // Transaction Status Chart
                    const orderStatusCtx = document.getElementById('orderStatusChart').getContext('2d');
                    new Chart(orderStatusCtx, {
                        type: 'pie',
                        data: {
                            labels: Object.keys(data.transaction_status_distribution || {}),
                            datasets: [{
                                data: Object.values(data
                                    .transaction_status_distribution || {}),
                                backgroundColor: ['#FFC107', '#17A2B8', '#28A745',
                                    '#007BFF', '#DC3545'
                                ],
                                borderColor: '#fff',
                                borderWidth: 2
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
                            labels: (data.revenue_by_month || []).map(item => item.month),
                            datasets: [{
                                label: 'Revenue ($)',
                                data: (data.revenue_by_month || []).map(item => item
                                    .total),
                                borderColor: '#007BFF',
                                backgroundColor: 'rgba(0, 123, 255, 0.1)',
                                fill: true,
                                tension: 0.4
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

                    // Refresh table after data load
                    $('#recent-orders-table').bootstrapTable('refresh');
                },
                error: function(xhr) {
                    toastr.error('Error loading dashboard data: ' + (xhr.responseJSON?.message ||
                        'Unknown error'));
                }
            });
        });
    </script>
@endsection
