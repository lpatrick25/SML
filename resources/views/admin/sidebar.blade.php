<ul class="navbar-nav iq-main-menu" id="sidebar-menu">
    <!-- Section: Home -->
    <li class="nav-item static-item">
        <a class="nav-link static-item disabled" href="#" tabindex="-1">
            <span class="default-icon">Home</span>
            <span class="mini-icon">-</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link @yield('active-dashboard')" aria-current="page" href="{{ route('admin.dashboard') }}">
            <i class="bi bi-speedometer2"></i>
            <span class="item-name">Dashboard</span>
        </a>
    </li>
    <li>
        <hr class="hr-horizontal">
    </li>

    <!-- Section: Main Components -->
    <li class="nav-item static-item">
        <a class="nav-link static-item disabled" href="#" tabindex="-1">
            <span class="default-icon">Main Components</span>
            <span class="mini-icon">-</span>
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link @yield('active-user-list')" href="{{ route('admin.userList') }}">
            <i class="bi bi-person-lines-fill"></i>
            <span class="item-name">User List</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link @yield('active-customers-management')" href="{{ route('admin.customersManagement') }}">
            <i class="bi bi-people"></i>
            <span class="item-name">Customers</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link @yield('active-services-management')" href="{{ route('admin.servicesManagement') }}">
            <i class="bi bi-gear"></i>
            <span class="item-name">Services</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link @yield('active-item-management')" href="{{ route('admin.itemManagement') }}">
            <i class="bi bi-box-seam"></i>
            <span class="item-name">Items</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link @yield('active-orders-management')" href="{{ route('admin.ordersManagement') }}">
            <i class="bi bi-bag-check"></i>
            <span class="item-name">Transactions</span>
        </a>
    </li>
    <li>
        <hr class="hr-horizontal">
    </li>

    <!-- Section: User Components -->
    {{-- <li class="nav-item static-item">
        <a class="nav-link static-item disabled" href="#" tabindex="-1">
            <span class="default-icon">User Components</span>
            <span class="mini-icon">-</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link @yield('active-user-list')" href="{{ route('admin.userList') }}">
            <i class="bi bi-person-lines-fill"></i>
            <span class="item-name">User List</span>
        </a>
    </li> --}}
    {{-- <li class="nav-item">
        <a class="nav-link @yield('active-user-management')" href="{{ route('admin.userManagement') }}">
            <i class="bi bi-person-gear"></i>
            <span class="item-name">User Management</span>
        </a>
    </li> --}}


    <!-- Section: User Components -->
    <li class="nav-item static-item">
        <a class="nav-link static-item disabled" href="#" tabindex="-1">
            <span class="default-icon">Report Components</span>
            <span class="mini-icon">-</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link @yield('active-sales-report')" href="{{ route('admin.salesReport') }}">
            <i class="bi bi-file-earmark-bar-graph"></i>
            <span class="item-name">Sales Report</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link @yield('active-inventory-report')" href="{{ route('admin.inventoryReport') }}">
            <i class="bi bi-clipboard-data"></i>
            <span class="item-name">Inventory Report</span>
        </a>
    </li>
    <li>
        <hr class="hr-horizontal">
    </li>
</ul>
