<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
<!-- Brand Logo -->
<a href="index3.html" class="brand-link text-center">
    <span class="brand-text font-weight-bold">Acsan Admin</span>
</a>

<!-- Sidebar -->
<div class="sidebar">
    <!-- Sidebar Menu -->
    <nav class="mt-2">
    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <!-- Add icons to the links using the .nav-icon class with font-awesome or any other icon font library -->
        <li class="nav-item">
            <a href="{{ route('admin.dashboard') }}" class="nav-link {{ Route::current()->getName() == 'admin.dashboard' ? 'active' : '' }}">
                <i class="nav-icon fas fa-tachometer-alt"></i>
                <p>Dashboard</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('admin.products.index') }}" class="nav-link {{ Route::current()->getName() == 'admin.products.index' ? 'active' : '' }}">
                <i class="nav-icon fas fa-boxes"></i>
                <p>Products</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('admin.attributes.index') }}" class="nav-link {{ Route::current()->getName() == 'admin.attributes.index' ? 'active' : '' }}">
                <i class="nav-icon fas fa-box"></i>
                <p>Attributes</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('admin.orders.index') }}" class="nav-link {{ Route::current()->getName() == 'admin.orders.index' ? 'active' : '' }}">
                <i class="nav-icon fas fa-list-alt"></i>
                <p>Orders</p>
            </a>
        </li>
        <li class="nav-item">
            <a href="{{ route('admin.customers.index') }}" class="nav-link {{ Route::current()->getName() == 'admin.customers.index' ? 'active' : '' }}">
                <i class="nav-icon fas fa-users"></i>
                <p>Customers</p>
            </a>
        </li>
        {{-- <li class="nav-item">
            <a href="{{ route('admin.products.index') }}" class="nav-link {{ Route::current()->getName() == 'admin.categories.index' ? 'active' : '' }}">
                <i class="nav-icon fas fa-th"></i>
                <p>Categories</p>
            </a>
        </li> --}}
        <li class="nav-item">
            <a href="{{ route('admin.feedbacks.index') }}" class="nav-link {{ Route::current()->getName() == 'admin.feedbacks.index' ? 'active' : '' }}">
                <i class="nav-icon fas fa-envelope-open-text"></i>
                <p>Feedbacks</p>
            </a>
        </li>
        <li class="nav-item has-treeview menu-open">
            <a href="#" class="nav-link">
                <i class="nav-icon fas fa-book"></i>
                <p>Reports<i class="fas fa-angle-left right"></i></p>
            </a>
            <ul class="nav nav-treeview">
                <li class="nav-item">
                    <a href="{{ route('admin.sales-report') }}" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Sales Report</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.sales-report') }}" class="nav-link">
                        <i class="far fa-circle nav-icon"></i>
                        <p>Total Sales Report</p>
                    </a>
                </li>
            </ul>
        </li>
    </ul>
    </nav> <!-- /.sidebar-menu -->
</div>

</aside>
<!-- /.sidebar -->