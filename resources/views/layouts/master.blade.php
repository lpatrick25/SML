<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('APP-TITLE') | {{ env('APP_NAME') }}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ asset('dist/img/AdminLTELogo.png') }}">

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.css">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">

    <!-- Data Table -->
    <link rel="stylesheet" href="{{ asset('plugins/data-table/css/bootstrap-table.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/data-table/css/bootstrap-table-filter-control.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/data-table/css/bootstrap-table-fixed-columns.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/data-table/css/bootstrap-table-page-jump-to.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/data-table/css/bootstrap-table-sticky-header.css') }}">

    <!-- Toastr -->
    <link rel="stylesheet" href="{{ asset('plugins/toastr/toastr.min.css') }}">

    <!-- Select2 -->
    <link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.css') }}">

    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="{{ asset('plugins/sweetalert2/sweetalert2.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.css') }}">

    <!-- Bootstrap Fileinput -->
    <link rel="stylesheet" href="{{ asset('plugins/bootstrap-fileinput/css/fileinput.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('dist/css/adminlte.min.css') }}">

    @yield('APP-STYLES')
</head>

<body
    class="sidebar-mini layout-fixed control-sidebar-slide-open accent-teal layout-footer-fixed layout-navbar-fixed dark-mode">
    <!-- Site wrapper -->
    <div class="wrapper">
        <!-- Navbar -->
        @include('layouts.navbar')
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar elevation-4 sidebar-dark-teal sidebar-no-expand">
            <!-- Brand Logo -->
            <a href="#" class="brand-link">
                <img src="{{ asset('dist/img/AdminLTELogo.png') }}" alt="Nora - Laundry Logo"
                    class="brand-image img-circle elevation-3" style="opacity: .8">
                <span class="brand-text font-weight-light">Nora - Laundry</span>
            </a>

            <!-- Sidebar -->
            @if (auth()->user()->role == 'Admin')
                @include('admin.sidebar')
            @endif
            @if (auth()->user()->role == 'Staff')
                @include('staff.sidebar')
            @endif
            <!-- /.sidebar -->
        </aside>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1>@yield('APP-TITLE')</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item"><a href="#">Home</a></li>
                                <li class="breadcrumb-item active">@yield('APP-TITLE')</li>
                            </ol>
                        </div>
                    </div>
                </div><!-- /.container-fluid -->
            </section>

            <!-- Main content -->
            <section class="content">

                <!-- Default box -->
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">@yield('APP-SUBTITLE')</h3>
                    </div>
                    <div class="card-body">
                        @yield('APP-CONTENT')
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->

            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->

        <footer class="main-footer">
            <div class="float-right d-none d-sm-block">
                <b>Version</b> 1.0.0
            </div>
            <strong>Copyright &copy; 2014-2021 <a href="#">{{ env('APP_NAME') }}</a>.</strong> All rights
            reserved.
        </footer>
    </div>
    <!-- ./wrapper -->

    <!-- jQuery -->
    <script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
    <!-- Bootstrap 4 -->
    <script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    <!-- Data Table -->
    <script src="{{ asset('plugins/data-table/js/bootstrap-table.js') }}"></script>
    <script src="{{ asset('plugins/data-table/js/bootstrap-table-addrbar.js') }}"></script>
    <script src="{{ asset('plugins/data-table/js/bootstrap-table-auto-refresh.js') }}"></script>
    <script src="{{ asset('plugins/data-table/js/bootstrap-table-custom-view.js') }}"></script>
    <script src="{{ asset('plugins/data-table/js/bootstrap-table-defer-url.js') }}"></script>
    <script src="{{ asset('plugins/data-table/js/bootstrap-table-editable.js') }}"></script>
    <script src="{{ asset('plugins/data-table/js/bootstrap-table-export.js') }}"></script>
    <script src="{{ asset('plugins/data-table/js/bootstrap-table-filter-control.js') }}"></script>
    <script src="{{ asset('plugins/data-table/js/bootstrap-table-fixed-columns.js') }}"></script>
    <script src="{{ asset('plugins/data-table/js/bootstrap-table-mobile.js') }}"></script>
    <script src="{{ asset('plugins/data-table/js/bootstrap-table-multiple-sort.js') }}"></script>
    <script src="{{ asset('plugins/data-table/js/bootstrap-table-page-jump-to.js') }}"></script>
    <script src="{{ asset('plugins/data-table/js/bootstrap-table-pipeline.js') }}"></script>
    <script src="{{ asset('plugins/data-table/js/bootstrap-table-print.js') }}"></script>
    <script src="{{ asset('plugins/data-table/js/bootstrap-table-resizable.js') }}"></script>
    <script src="{{ asset('plugins/data-table/js/bootstrap-table-sticky-header.js') }}"></script>
    <script src="{{ asset('plugins/data-table/js/bootstrap-table-toolbar.js') }}"></script>
    <script src="{{ asset('plugins/data-table/js/utils.js') }}"></script>

    <!-- Toastr -->
    <script src="{{ asset('plugins/toastr/toastr.min.js') }}"></script>

    <!-- jquery-validation -->
    <script src="{{ asset('plugins/jquery-validation/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('plugins/jquery-validation/additional-methods.min.js') }}"></script>

    <!-- Select2 -->
    <script src="{{ asset('plugins/select2/js/select2.js') }}"></script>

    <!-- SweetAlert2 -->
    <script src="{{ asset('plugins/sweetalert2/sweetalert2.all.js') }}"></script>

    <!-- Bootstrap Fileinput -->
    <script src="{{ asset('plugins/bootstrap-fileinput/js/fileinput.min.js') }}"></script>
    <script src="{{ asset('plugins/bootstrap-fileinput/themes/fa5/theme.min.js') }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('dist/js/adminlte.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            // CSRF token setup for AJAX requests
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            toastr.options = {
                closeButton: true,
                progressBar: true,
                positionClass: 'toast-top-right',
                timeOut: 5000
            };

            $('#signOut').click(function(event) {
                event.preventDefault();

                $.ajax({
                    method: 'POST',
                    url: '{{ route('logout') }}',
                    dataType: 'JSON',
                    cache: false,
                    success: function(response) {
                        toastr.success(response.message);
                        location.href = "{{ route('signIn') }}";
                    },
                    error: function(xhr) {
                        let message = 'Unable to logout.';
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            message = xhr.responseJSON.message;
                        }
                        toastr.error(message);
                    }
                });
            });
        });
    </script>
    @yield('APP-SCRIPT')
</body>

</html>
