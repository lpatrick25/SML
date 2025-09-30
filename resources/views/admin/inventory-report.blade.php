@extends('layouts.master')

@section('APP-TITLE')
    Inventory Management
@endsection

@section('active-inventory')
    active
@endsection

@section('APP-SUBTITLE')
    Inventory Overview
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

        .filter-form {
            max-width: 300px;
        }
    </style>
@endsection

@section('APP-CONTENT')
    <div class="col-sm-12">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h3 class="card-title">@yield('APP-SUBTITLE')</h3>
        </div>
        <div class="card-body">
            <!-- Filter -->
            <div class="row mb-4">
                <div class="col-12">
                    <div class="card shadow-sm border-0">
                        <div class="card-body">
                            <form id="filterForm" action="{{ route('inventory.index') }}" method="GET" class="filter-form">
                                <div class="row g-3 align-items-center">
                                    <div class="col-auto">
                                        <label for="low_stock" class="form-label">Stock Status</label>
                                        <select class="form-control select2" id="low_stock" name="low_stock" required>
                                            <option value="all" {{ $lowStockFilter == 'all' ? 'selected' : '' }}>All
                                                Items</option>
                                            <option value="low" {{ $lowStockFilter == 'low' ? 'selected' : '' }}>Low
                                                Stock (≤ {{ $lowStockThreshold }})</option>
                                        </select>
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
                            <div class="icon-circle bg-primary bg-opacity-10">
                                <i class="bi bi-box-seam text-primary fs-4"></i>
                            </div>
                            <div class="text-end">
                                <h5 class="card-title mb-1">Total Items</h5>
                                <h3 class="card-text text-dark fw-bold" id="total-items">{{ $totalItems }}</h3>
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
                                <h5 class="card-title mb-1">Low Stock Items</h5>
                                <h3 class="card-text text-dark fw-bold" id="low-stock-items">{{ $lowStockItems }}</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Items Table -->
            <div class="row g-4 mb-4">
                <div class="col-12">
                    <div class="card shadow-sm border-0">
                        <div class="card-header bg-transparent d-flex justify-content-between align-items-center">
                            <h5 class="card-title mb-0">Inventory Items</h5>
                            <div id="items-toolbar">
                                <a href="{{ route('inventory.index') }}" class="btn btn-sm btn-primary"><i
                                        class="bi bi-arrow-clockwise"></i> Refresh</a>
                            </div>
                        </div>
                        <div class="card-body">
                            <table id="items-table" data-toggle="table" data-pagination="true" data-search="true"
                                data-show-columns="true" data-show-refresh="true" data-show-toggle="true"
                                data-show-export="true" data-sticky-header="true" data-url="{{ route('inventory.index') }}"
                                data-toolbar="#items-toolbar">
                                <thead>
                                    <tr>
                                        <th data-field="id">#</th>
                                        <th data-field="item_name">Name</th>
                                        <th data-field="quantity">Quantity</th>
                                        <th data-field="unit">Unit</th>
                                        <th data-field="quantity" data-formatter="formatStatus">Status</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Item Logs -->
            <div class="row g-4">
                <div class="col-12">
                    <div class="card shadow-sm border-0">
                        <div class="card-header bg-transparent d-flex justify-content-between align-items-center">
                            <h5 class="card-title mb-0">Recent Item Logs</h5>
                            <div id="logs-toolbar">
                                <a href="{{ route('inventory.index') }}" class="btn btn-sm btn-primary"><i
                                        class="bi bi-arrow-clockwise"></i> View All Logs</a>
                            </div>
                        </div>
                        <div class="card-body">
                            <table id="logs-table" data-toggle="table" data-pagination="true" data-search="true"
                                data-show-columns="true" data-show-refresh="true" data-show-toggle="true"
                                data-show-export="true" data-sticky-header="true" data-url="{{ route('inventory.index') }}"
                                data-toolbar="#logs-toolbar">
                                <thead>
                                    <tr>
                                        <th data-field="id">#</th>
                                        <th data-field="item_name">Item</th>
                                        <th data-field="change_type" data-formatter="formatChangeType">Change Type</th>
                                        <th data-field="quantity">Quantity</th>
                                        <th data-field="description">Description</th>
                                        <th data-field="staff_name">Staff</th>
                                        <th data-field="log_date" data-formatter="formatDate">Date</th>
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
    <script type="text/javascript">
        // Table formatters
        function formatStatus(value, row) {
            const threshold = {{ $lowStockThreshold }};
            const badgeClass = value <= threshold ? 'bg-danger' : 'bg-success';
            return `<span class="badge ${badgeClass} text-white">${value <= threshold ? 'Low Stock' : 'In Stock'}</span>`;
        }

        function formatChangeType(value) {
            const textClass = value === 'In' ? 'text-success' : 'text-danger';
            return `<span class="${textClass}">${value}</span>`;
        }

        function formatDate(value) {
            return value ? new Date(value).toLocaleDateString('en-US', {
                month: 'short',
                day: '2-digit',
                year: 'numeric'
            }) : 'N/A';
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

            // Initialize Items Table
            $('#items-table').bootstrapTable({
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
                    return '<div class="text-center p-4">No items found.</div>';
                },
                formatLoadingMessage: function() {
                    return '<div class="text-center"><span class="spinner-border spinner-border-sm"></span> Loading...</div>';
                },
                responseHandler: function(res) {
                    return res.items || [];
                }
            });

            // Initialize Logs Table
            $('#logs-table').bootstrapTable({
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
                    return '<div class="text-center p-4">No recent logs found.</div>';
                },
                formatLoadingMessage: function() {
                    return '<div class="text-center"><span class="spinner-border spinner-border-sm"></span> Loading...</div>';
                },
                responseHandler: function(res) {
                    return res.recentLogs || [];
                }
            });

            // Toggle custom view on window resize
            $(window).on('resize', function() {
                $('#items-table').bootstrapTable('toggleCustomView', isMobile());
                $('#logs-table').bootstrapTable('toggleCustomView', isMobile());
            });

            // Form validation for filter
            $('#filterForm').validate({
                rules: {
                    low_stock: {
                        required: true
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
                        text: "Are you sure you want to apply this stock status filter?",
                        icon: "info",
                        showCancelButton: true,
                        confirmButtonColor: "#3085d6",
                        cancelButtonColor: "#d33",
                confirmButtonText: "Yes",
                cancelButtonText: "No",
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
                                    $('#total-items').text(response.totalItems ||
                                    0);
                                    $('#low-stock-items').text(response
                                        .lowStockItems || 0);

                                    // Refresh tables
                                    $('#items-table').bootstrapTable('refresh');
                                    $('#logs-table').bootstrapTable('refresh');

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
        });
    </script>
@endsection
