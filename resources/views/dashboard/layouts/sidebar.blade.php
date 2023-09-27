<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ url('dashboard') }}">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fa-solid fa-gauge"></i>
        </div>
        <div class="sidebar-brand-text mx-3">18 Admin</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item {{ Route::current()->getName() == 'dashboard.partner.index' ? 'active' : '' }}">
        <a class="nav-link" href="{{ url('dashboard/partner') }}">
            <i class="fas fa-fw fa-shop"></i>
            <span>Partner</span></a>
    </li>
    <li class="nav-item {{ Route::current()->getName() == 'dashboard.category.index' ? 'active' : '' }}">
        <a class="nav-link" href="{{ url('dashboard/category') }}">
            <i class="fas fa-fw fa-tag"></i>
            <span>Category</span></a>
    </li>
    <li class="nav-item {{ Route::current()->getName() == 'dashboard.package.index' ? 'active' : '' }}">
        <a class="nav-link" href="{{ url('dashboard/package') }}">
            <i class="fas fa-fw fa-money-bill"></i>
            <span>Package</span></a>
    </li>
    <li class="nav-item {{ Route::current()->getName() == 'dashboard.transaction.index' ? 'active' : '' }}">
        <a class="nav-link" href="{{ url('dashboard/transaction') }}">
            <i class="fas fa-fw fa-money-bill"></i>
            <span>Transaction</span></a>
    </li>
    <li class="nav-item {{ Route::current()->getName() == 'dashboard.banner.index' ? 'active' : '' }}">
        <a class="nav-link" href="{{ url('dashboard/banner') }}">
            <i class="fas fa-fw fa-image"></i>
            <span>Banner</span></a>
    </li>
    <li class="nav-item {{ Route::current()->getName() == 'dashboard.squarefeed.index' ? 'active' : '' }}">
        <a class="nav-link" href="{{ url('dashboard/squarefeed') }}">
            <i class="fas fa-fw fa-images"></i>
            <span>Square Feed</span></a>
    </li>
    <li class="nav-item {{ Route::current()->getName() == 'dashboard.review.index' ? 'active' : '' }}">
        <a class="nav-link" href="{{ url('dashboard/review') }}">
            <i class="fas fa-fw fa-star"></i>
            <span>Review</span></a>
    </li>
    <li class="nav-item {{ Route::current()->getName() == 'dashboard.customer.index' ? 'active' : '' }}">
        <a class="nav-link" href="{{ url('dashboard/customer') }}">
            <i class="fas fa-fw fa-users"></i>
            <span>Customer</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>
<!-- End of Sidebar -->
