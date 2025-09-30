@extends('layouts.master')

@section('APP-TITLE')
    Sales Report
@endsection

@section('active-sales')
    active
@endsection

@section('APP-SUBTITLE')
    Sales Overview
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
    <div class="col-sm-12">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="card-title">@yield('APP-SUBTITLE')</h3>
        </div>
        <div class="card-body">
            <!-- Date Filter -->
            <div class="row mb-4">
                <div class="col-12">
                    <div class="card shadow-sm border-0">
                        <div class="card-body">
                            <form id="dateFilterForm" action="{{ route('sales-report.index') }}" method="GET"
                                class="date-filter-form">
                                <div class="row g-3 align-items-center">
                                    <div class="col-auto">
                                        <label for="period" class="form-label">Period</label>
                                        <select class="form-control select2" id="period" name="period" required>
                                            <option value="custom" {{ $period == 'custom' ? 'selected' : '' }}>Custom Range
                                            </option>
                                            <option value="daily" {{ $period == 'daily' ? 'selected' : '' }}>Daily</option>
                                            <option value="monthly" {{ $period == 'monthly' ? 'selected' : '' }}>Monthly
                                            </option>
                                            <option value="yearly" {{ $period == 'yearly' ? 'selected' : '' }}>Yearly
                                            </option>
                                        </select>
                                    </div>
                                    <div class="col-auto">
                                        <label for="start_date" class="form-label">Start Date</label>
                                        <input type="date" class="form-control" id="start_date" name="start_date"
                                            value="{{ $startDate }}" required>
                                    </div>
                                    <div class="col-auto" id="end_date_container"
                                        style="{{ $period == 'custom' ? '' : 'display: none;' }}">
                                        <label for="end_date" class="form-label">End Date</label>
                                        <input type="date" class="form-control" id="end_date" name="end_date"
                                            value="{{ $endDate }}">
                                    </div>
                                    <div class="col-auto">
                                        <button type="submit" class="btn btn-primary"><i class="bi bi-funnel"></i>
                                            Filter</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Metrics Cards -->
            <div class="row g-4 mb-4 equal-height-row">
                <div class="col-lg-3 col-md-6">
                    <div class="card shadow-sm border-0 metric-card">
                        <div class="card-body">
                            <div class="icon-circle bg-success bg-opacity-10">
                                <i class="bi bi-currency-dollar text-success fs-4"></i>
                            </div>
                            <div class="text-end">
                                <h5 class="card-title mb-1">Daily Income</h5>
                                <h3 class="card-text text-dark fw-bold" id="daily-income">
                                    ₱{{ number_format($dailyIncome, 2) }}</h3>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="card shadow-sm border-0 metric-card">
                        <div class="card-body">
                            <div class="icon-circle bg-primary bg-opacity-10">
                                <i class="bi bi-currency-dollar text-primary fs-4"></i>
                            </div>
                            <div class="text-end">
                                <h5 class="card-title mb-1">Monthly Income</h5>
                                <h3 class="card-text text-dark fw-bold" id="monthly-income">
                                    ₱{{ number_format($monthlyIncome, 2) }}</h3>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="card shadow-sm border-0 metric-card">
                        <div class="card-body">
                            <div class="icon-circle bg-info bg-opacity-10">
                                <i class="bi bi-currency-dollar text-info fs-4"></i>
                            </div>
                            <div class="text-end">
                                <h5 class="card-title mb-1">Yearly Income</h5>
                                <h3 class="card-text text-dark fw-bold" id="yearly-income">
                                    ₱{{ number_format($yearlyIncome, 2) }}</h3>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="card shadow-sm border-0 metric-card">
                        <div class="card-body">
                            <div class="icon-circle bg-warning bg-opacity-10">
                                <i class="bi bi-cart text-warning fs-4"></i>
                            </div>
                            <div class="text-end">
                                <h5 class="card-title mb-1">Total Transactions</h5>
                                <h3 class="card-text text-dark fw-bold" id="transaction-count">{{ $transactionCount }}</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- All Transactions -->
            <div class="row g-4 mb-4">
                <div class="col-12">
                    <div class="card shadow-sm border-0">
                        <div class="card-header bg-transparent d-flex justify-content-between align-items-center">
                            <h5 class="card-title mb-0">All Transactions</h5>
                            <div id="toolbar">
                                <a href="{{ route('sales-report.index') }}" class="btn btn-sm btn-primary"><i
                                        class="bi bi-arrow-clockwise"></i> Refresh</a>
                            </div>
                        </div>
                        <div class="card-body">
                            <table id="transactions-table" data-toggle="table" data-pagination="true" data-search="true"
                                data-show-columns="true" data-show-refresh="true" data-show-toggle="true"
                                data-show-export="true" data-sticky-header="true"
                                data-url="{{ route('sales-report.index') }}" data-toolbar="#toolbar">
                                <thead>
                                    <tr>
                                        <th data-field="id">#</th>
                                        <th data-field="customer_name">Customer</th>
                                        <th data-field="transaction_date" data-formatter="formatDate">Transaction Date
                                        </th>
                                        <th data-field="services" data-formatter="formatServices">Services</th>
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

            <!-- Charts -->
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
                        <div class="card-header bg-transparent d-flex justify-content-between align-items-center">
                            <h5 class="card-title mb-0">Top Services</h5>
                            <div id="services-toolbar">
                                <a href="{{ route('sales-report.index') }}" class="btn btn-sm btn-primary"><i
                                        class="bi bi-arrow-clockwise"></i> Refresh</a>
                            </div>
                        </div>
                        <div class="card-body">
                            <table id="services-table" data-toggle="table" data-pagination="true" data-search="true"
                                data-show-columns="true" data-show-refresh="true" data-show-toggle="true"
                                data-show-export="true" data-sticky-header="true"
                                data-url="{{ route('sales-report.index') }}" data-toolbar="#services-toolbar">
                                <thead>
                                    <tr>
                                        <th data-field="name">Service Name</th>
                                        <th data-field="total" data-formatter="formatAmount">Total Revenue</th>
                                        <th data-field="quantity">Quantity Sold</th>
                                    </tr>
                                </thead>
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
        // Table formatters
        function formatDate(value) {
            return value ? new Date(value).toLocaleDateString('en-US', {
                month: 'short',
                day: '2-digit',
                year: 'numeric'
            }) : 'N/A';
        }

        function formatServices(value) {
            if (!value || !Array.isArray(value)) return 'N/A';
            return `<div class="services-list">${value.map(service =>
                `<div>${service.name} (Qty: ${service.quantity}, ₱${parseFloat(service.subtotal).toFixed(2)})</div>`
            ).join('')}</div>`;
        }

        function formatAmount(value) {
            return `₱${parseFloat(value).toFixed(2)}`;
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
                <a href="orders/${row.id}" class="btn btn-sm btn-info" title="View">
                    <i class="bi bi-eye"></i>
                </a>
            `;
        }

        // Check if device is mobile
        function isMobile() {
            return window.innerWidth <= 576;
        }

        $(document).ready(function() {
            // Initialize Select2
            $('.select2').select2({
                theme: 'bootstrap4',
                width: '100%',
                placeholder: 'Select an option',
                allowClear: true
            });

            // Toggle end date visibility
            $('#period').on('change', function() {
                $('#end_date_container').toggle($(this).val() === 'custom');
            });

            // Initialize Transactions Table
            $('#transactions-table').bootstrapTable({
                exportDataType: 'all',
                exportTypes: ['json', 'csv', 'txt', 'excel'],
                filterControl: true,
                stickyHeader: true,
                pagination: true,
                pageSize: 10,
                pageList: [10, 25, 50, 100],
                search: true,
                showColumns: true,
                showRefresh: true,
                showToggle: true,
                sidePagination: 'server',
                cache: true,
                cacheAmount: 100,
                showCustomView: isMobile(),
                formatNoMatches: function() {
                    return '<div class="text-center p-4">No transactions found.</div>';
                },
                formatLoadingMessage: function() {
                    return '<div class="text-center"><span class="spinner-border spinner-border-sm"></span> Loading...</div>';
                },
                responseHandler: function(res) {
                    return res.transactions || [];
                }
            });

            // Initialize Services Table
            $('#services-table').bootstrapTable({
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
                    return '<div class="text-center p-4">No services found.</div>';
                },
                formatLoadingMessage: function() {
                    return '<div class="text-center"><span class="spinner-border spinner-border-sm"></span> Loading...</div>';
                },
                responseHandler: function(res) {
                    return res.topServices || [];
                }
            });

            // Toggle custom view on window resize
            $(window).on('resize', function() {
                $('#transactions-table').bootstrapTable('toggleCustomView', isMobile());
                $('#services-table').bootstrapTable('toggleCustomView', isMobile());
            });

            // Form validation for date filter
            $('#dateFilterForm').validate({
                rules: {
                    period: {
                        required: true
                    },
                    start_date: {
                        required: true
                    },
                    end_date: {
                        required: function() {
                            return $('#period').val() === 'custom';
                        }
                    }
                },
                errorElement: 'span',
                errorPlacement: function(error, element) {
                    error.addClass('invalid-feedback');
                    element.closest('.col-auto').append(error);
                },
                highlight: function(element) {
                    $(element).addClass('is-invalid');
                },
                unhighlight: function(element) {
                    $(element).removeClass('is-invalid');
                },
                submitHandler: function(form) {
                    Swal.fire({
                        title: "Apply Filter",
                        text: "Are you sure you want to apply this date filter?",
                        icon: "info",
                        showCancelButton: true,
                        confirmButtonColor: "#3085d6",
                        cancelButtonColor: "#d33",
                        confirmButtonText: "Yes, apply it!"
                    }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                method: 'GET',
                                url: $(form).attr('action'),
                                data: $(form).serialize(),
                                dataType: 'json',
                                cache: false,
                                success: function(response) {
                                    // Update metrics
                                    $('#daily-income').text(
                                        `₱${parseFloat(response.dailyIncome || 0).toFixed(2)}`
                                        );
                                    $('#monthly-income').text(
                                        `₱${parseFloat(response.monthlyIncome || 0).toFixed(2)}`
                                        );
                                    $('#yearly-income').text(
                                        `₱${parseFloat(response.yearlyIncome || 0).toFixed(2)}`
                                        );
                                    $('#transaction-count').text(response
                                        .transactionCount || 0);

                                    // Refresh tables
                                    $('#transactions-table').bootstrapTable(
                                        'refresh');
                                    $('#services-table').bootstrapTable('refresh');

                                    // Update charts
                                    updateCharts(response);
                                    toastr.success('Filter applied successfully');
                                },
                                error: function(xhr) {
                                    toastr.error('Error applying filter: ' + (xhr
                                        .responseJSON?.message ||
                                        'Unknown error'));
                                }
                            });
                        }
                    });
                }
            });

            // Function to update charts
            function updateCharts(data) {
                // Transaction Status Chart
                const statusCtx = document.getElementById('statusChart').getContext('2d');
                new Chart(statusCtx, {
                    type: 'pie',
                    data: {
                        labels: Object.keys(data.statusDistribution || {}),
                        datasets: [{
                            data: Object.values(data.statusDistribution || {}),
                            backgroundColor: ['#FFC107', '#17A2B8', '#28A745', '#007BFF',
                                '#DC3545'],
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
                        labels: (data.revenueByMonth || []).map(item => item.month),
                        datasets: [{
                            label: 'Revenue (₱)',
                            data: (data.revenueByMonth || []).map(item => item.total),
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
            }

            // Initial chart rendering
            updateCharts({
                statusDistribution: @json($statusDistribution),
                revenueByMonth: @json($revenueByMonth)
            });
        });
    </script>
@endsection
