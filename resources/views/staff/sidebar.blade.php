<div class="sidebar">
    <!-- Sidebar user (optional) -->
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
            <img src="{{ asset('dist/img/user2-160x160.jpg') }}" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
            <a href="#" class="d-block">
                {{ auth()->check() && auth()->user()->full_name ? auth()->user()->full_name : 'Unknown User' }}
            </a>
        </div>
    </div>

    <!-- Sidebar Menu -->
    <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column">
            <li class="nav-header">HOME</li>
            <li class="nav-item">
                <a href="{{ route('admin.dashboard') }}" class="nav-link @yield('active-dashboard')">
                    <i class="nav-icon bi bi-speedometer2"></i>
                    <p>Dashboard</p>
                </a>
            </li>

            <li class="nav-header">MAIN COMPONENTS</li>
            <li class="nav-item">
                <a href="{{ route('admin.customersManagement') }}" class="nav-link @yield('active-customers')">
                    <i class="bi bi-people"></i>
                    <p>Customers</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('admin.ordersManagement') }}" class="nav-link @yield('active-transactions')">
                    <i class="bi bi-bag-check"></i>
                    <p>Transactions</p>
                </a>
            </li>

        </ul>
    </nav>
    <!-- /.sidebar-menu -->
</div>
