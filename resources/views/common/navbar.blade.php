<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('homepage') }}">
        <div class="sidebar-brand-text mx-3">TRANG CHỦ</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">
    <br>
    <img src="{{ asset('/storage/img/users/' . $user['photo']) }}" width="100px"
        class="rounded mx-auto d-block rounded-circle " alt="...">

    <!-- Nav Items -->
    <div class="nav-item">
        <a class="nav-link collapsed" href="{{ route('list_tours') }}">
            <i class="fa-solid fa-earth-asia" aria-hidden="true"></i>
            <span>Thông tin các tour</span>
        </a>
    </div>

    <div class="nav-item">
        <a class="nav-link collapsed" href="{{ route('list_users') }}">
            <i class="fa fa-user-circle" aria-hidden="true"></i>
            <span>Thông tin người dùng</span>
        </a>
    </div>

    <div class="nav-item">
        <a class="nav-link collapsed" href="{{ route('list_reviews') }}">
            <i class="fa fa-star" aria-hidden="true"></i>
            <span>Thông tin các đánh giá</span>
        </a>
    </div>

    <div class="nav-item">
        <a class="nav-link collapsed" href="{{ route('list_bookings') }}">
            <i class="fa fa-bag-shopping" aria-hidden="true"></i>
            <span>Thông tin các đơn đặt</span>
        </a>
    </div>

    <div class="nav-item">
        <a class="nav-link collapsed" href="{{ route('bookings_on_tour') }}">
            <i class="fa fa-wallet" aria-hidden="true"></i>
            <span>Thống kê các đơn đặt theo tour</span>
        </a>
    </div>

    <div class="nav-item">
        <a class="nav-link collapsed" href="{{ route('auth.logout') }}">
            <i class="fa-solid fa-right-from-bracket" aria-hidden="true"></i>
            <span>Đăng xuất</span>
        </a>
    </div>

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>
</ul>
<!-- End of Sidebar -->
