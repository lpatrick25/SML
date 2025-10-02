{{-- resources/views/success.blade.php --}}
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Payment Success</title>
    <!-- Bootstrap 4 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <!-- AdminLTE -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
</head>

<body class="hold-transition layout-top-nav">

    <div class="wrapper">

        <!-- Navbar (optional) -->
        <nav class="main-header navbar navbar-expand-md navbar-light navbar-white">
            <div class="container">
                <a href="{{ url('/') }}" class="navbar-brand">
                    <span class="brand-text font-weight-light">Nora Monton Laundry Shop</span>
                </a>
            </div>
        </nav>

        <!-- Content Wrapper -->
        <div class="content-wrapper">
            <div class="content-header">
                <div class="container">
                    <h1 class="m-0 text-success"><i class="fas fa-check-circle"></i> Payment Successful 🎉</h1>
                </div>
            </div>

            <div class="content">
                <div class="container">

                    <!-- Success Alert -->
                    <div class="alert alert-success">
                        Thank you! Your payment has been successfully processed.
                    </div>

                    <!-- Transaction Details -->
                    <div class="card card-success">
                        <div class="card-header">
                            <h3 class="card-title">Transaction Details</h3>
                        </div>
                        <div class="card-body">
                            <p><strong>Transaction No:</strong> {{ $transaction->transaction_number }}</p>
                            <p><strong>Date:</strong> {{ $transaction->transaction_date }}</p>
                            <p><strong>Status:</strong>
                                <span class="badge badge-info">{{ $transaction->transaction_status }}</span>
                            </p>
                            <p><strong>Payment Status:</strong>
                                <span class="badge badge-success">{{ $transaction->payment_status }}</span>
                            </p>
                            <p><strong>Total Amount:</strong> ₱{{ number_format($transaction->total_amount, 2) }}</p>
                        </div>
                    </div>

                    <!-- Customer Details -->
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Customer Details</h3>
                        </div>
                        <div class="card-body">
                            <p><strong>Name:</strong>
                                {{ $transaction->customer->first_name }}
                                {{ $transaction->customer->middle_name }}
                                {{ $transaction->customer->last_name }}
                                {{ $transaction->customer->extension }}
                            </p>
                            <p><strong>Phone:</strong> {{ $transaction->customer->phone }}</p>
                            <p><strong>Email:</strong> {{ $transaction->customer->email }}</p>
                            <p><strong>Address:</strong> Brgy. {{ $transaction->customer->address }}, Abuyog, Leyte</p>
                        </div>
                    </div>

                    <!-- Services Availed -->
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Services Availed</h3>
                        </div>
                        <div class="card-body">
                            @if ($transaction->transactionItems->isEmpty())
                                <p class="text-muted">No services availed.</p>
                            @else
                                <div class="row">
                                    @foreach ($transaction->transactionItems as $item)
                                        <div class="col-md-6 col-lg-4 mb-3">
                                            <div class="card h-100 shadow-sm">
                                                <div class="card-body">
                                                    <h5 class="card-title mb-2">{{ $item->service->name }}</h5>
                                                    <p class="card-text text-muted small">
                                                        {{ $item->service->description ?? 'No description available.' }}
                                                    </p>
                                                    <ul class="list-unstyled mb-0">
                                                        <li><strong>Load:</strong> {{ $item->quantity }}</li>
                                                        <li><strong>Kilograms:</strong> {{ $item->kilograms }}</li>
                                                        <li><strong>Subtotal:</strong>
                                                            ₱{{ number_format($item->subtotal, 2) }}</li>
                                                    </ul>
                                                </div>
                                                <div class="card-footer text-right">
                                                    <span class="badge badge-info">{{ $item->service->kilograms }}
                                                        kg/service</span>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Payment Info -->
                    <div class="card">
                        <div class="card-header">
                            <h3 class="card-title">Payment Information</h3>
                        </div>
                        <div class="card-body">
                            @php
                                $payment = $transaction->payments()->latest()->first();
                            @endphp
                            @if ($payment)
                                <p><strong>Amount Paid:</strong> ₱{{ number_format($payment->amount, 2) }}</p>
                                <p><strong>Payment Method:</strong> {{ $payment->payment_method }}</p>
                                <p><strong>Date:</strong> {{ $payment->payment_date }}</p>
                            @else
                                <p>No payment record found.</p>
                            @endif
                        </div>
                    </div>

                    <!-- Back to Home -->
                    {{-- <a href="{{ url('/') }}" class="btn btn-primary">
                        <i class="fas fa-home"></i> Back to Home
                    </a> --}}

                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>

</body>

</html>
