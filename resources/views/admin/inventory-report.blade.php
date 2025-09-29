@extends('layouts.master')

@section('APP-TITLE')
    Inventory Management
@endsection

@section('active-inventory-report')
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
        .filter-form {
            max-width: 300px;
        }
    </style>
@endsection

@section('APP-CONTENT')
    <div class="container-fluid py-4">
        <!-- Filter -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <form action="{{ route('inventory.index') }}" method="GET" class="filter-form">
                            <div class="row g-3 align-items-center">
                                <div class="col-auto">
                                    <label for="low_stock" class="form-label">Stock Status</label>
                                    <select class="form-control" id="low_stock" name="low_stock">
                                        <option value="all" {{ $lowStockFilter == 'all' ? 'selected' : '' }}>All Items</option>
                                        <option value="low" {{ $lowStockFilter == 'low' ? 'selected' : '' }}>Low Stock (≤ {{ $lowStockThreshold }})</option>
                                    </select>
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
                            <div class="bg-primary bg-opacity-10 rounded-circle p-3 me-3">
                                <i class="bi bi-box-seam text-primary fs-4"></i>
                            </div>
                            <div>
                                <h5 class="card-title mb-1">Total Items</h5>
                                <h3 class="card-text text-dark fw-bold">{{ $totalItems }}</h3>
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
                                <h5 class="card-title mb-1">Low Stock Items</h5>
                                <h3 class="card-text text-dark fw-bold">{{ $lowStockItems }}</h3>
                            </div>
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
                        <a href="{{ route('inventory.index') }}" class="btn btn-sm btn-primary">Refresh</a>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th>Quantity</th>
                                        <th>Unit</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($items as $item)
                                        <tr>
                                            <td>{{ $item->id }}</td>
                                            <td>{{ $item->item_name }}</td>
                                            <td>{{ $item->quantity }}</td>
                                            <td>{{ $item->unit }}</td>
                                            <td>
                                                <span class="badge {{ $item->quantity <= $lowStockThreshold ? 'bg-danger' : 'bg-success' }} text-white">
                                                    {{ $item->quantity <= $lowStockThreshold ? 'Low Stock' : 'In Stock' }}
                                                </span>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center">No items found.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
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
                        <a href="{{ route('inventory.index') }}" class="btn btn-sm btn-primary">View All Logs</a>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Item</th>
                                        <th>Change Type</th>
                                        <th>Quantity</th>
                                        <th>Description</th>
                                        <th>Staff</th>
                                        <th>Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($recentLogs as $log)
                                        <tr>
                                            <td>{{ $log['id'] }}</td>
                                            <td>{{ $log['item_name'] }}</td>
                                            <td>
                                                <span class="{{ $log['change_type'] == 'In' ? 'text-success' : 'text-danger' }}">
                                                    {{ $log['change_type'] }}
                                                </span>
                                            </td>
                                            <td>{{ $log['quantity'] }}</td>
                                            <td>{{ $log['description'] }}</td>
                                            <td>{{ $log['staff_name'] }}</td>
                                            <td>{{ $log['log_date'] }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" class="text-center">No recent logs found.</td>
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
