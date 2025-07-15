<!-- Sidebar -->
<ul class="navbar-nav bg-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('admin.dashboard') }}">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-home"></i>
        </div>
        <div class="sidebar-brand-text mx-3">Kontrakan Admin</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Dashboard -->
    <li class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('admin.dashboard') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Kelola Kontrakan -->
    <li class="nav-item {{ request()->is('admin/kontrakan*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('admin.kontrakan.index') }}">
            <i class="fas fa-building"></i>
            <span>Kelola Kontrakan</span>
        </a>
    </li>

    <!-- Kelola Sewa -->
    <li class="nav-item {{ request()->is('admin/sewa*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('admin.sewa.index') }}">
            <i class="fas fa-calendar-alt"></i>
            <span>Kelola Sewa</span>
        </a>
    </li>

    <!-- Konfirmasi Transaksi -->
    <li class="nav-item {{ request()->is('admin/transaksi*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('admin.transaksi.index') }}">
            <i class="fas fa-money-check-alt"></i>
            <span>Konfirmasi Transaksi</span>
        </a>
    </li>

    <!-- Konfirmasi Pindah -->
    <li class="nav-item {{ request()->is('admin/pindah*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('admin.pindah.index') }}">
            <i class="fas fa-exchange-alt"></i>
            <span>Konfirmasi Pindah</span>
        </a>
    </li>

    <!-- Tanggapi Pengaduan -->
    <li class="nav-item {{ request()->is('admin/pengaduan*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('admin.pengaduan.index') }}">
            <i class="fas fa-comments"></i>
            <span>Tanggapi Pengaduan</span>
        </a>
    </li>
    <!-- Kelola Ulasan -->
    <li class="nav-item {{ request()->is('admin/ulasan*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('admin.ulasan.index') }}">
            <i class="fas fa-comments"></i>
            <span>Kelola Ulasan</span>
        </a>
    </li>

    @php
        $admin = auth()->guard('admin')->user();
    @endphp

    <!-- Kelola Users -->
    @if ($admin->role === 'admin')
        <li class="nav-item {{ request()->is('admin/users*') ? 'active' : '' }}">
            <a class="nav-link" href="{{ route('admin.users.index') }}">
                <i class="fas fa-users-cog"></i>
                <span>Kelola Users</span>
            </a>
        </li>
    @endif

    <!-- Akun -->
    @if ($admin->role === 'super_admin')
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsePages"
                aria-expanded="true" aria-controls="collapsePages">
                <i class="fas fa-users-cog"></i>
                <span>Kelola Akun</span>
            </a>
            <div id="collapsePages" class="collapse" aria-labelledby="headingPages" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <a class="collapse-item {{ request()->is('admin/admins*') ? 'active' : '' }}"
                        href="{{ route('admin.admins.index') }}">
                        <span>Kelola Admin</span>
                    </a>
                    <a class="collapse-item {{ request()->is('admin/users*') ? 'active' : '' }}"
                        href="{{ route('admin.users.index') }}">
                        <span>Kelola Users</span>
                    </a>
                </div>
            </div>
        </li>
    @endif




    {{-- <!-- Sewa -->
    <li class="nav-item {{ request()->is('admin/sewa*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('admin.sewa.index') }}">
            <i class="fas fa-fw fa-file-contract"></i>
            <span>Kelola Sewa</span></a>
    </li>

    <!-- Transaksi -->
    <li class="nav-item {{ request()->is('admin/transaksi*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('admin.transaksi.index') }}">
            <i class="fas fa-fw fa-money-bill-wave"></i>
            <span>Kelola Transaksi</span></a>
    </li>

    <!-- Pengguna -->
    <li class="nav-item {{ request()->is('admin/user*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('admin.user.index') }}">
            <i class="fas fa-fw fa-users"></i>
            <span>Kelola Pengguna</span></a>
    </li>

    <!-- Pengaduan -->
    <li class="nav-item {{ request()->is('admin/pengaduan*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('admin.pengaduan.index') }}">
            <i class="fas fa-fw fa-comment-dots"></i>
            <span>Pengaduan</span></a>
    </li> --}}

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>
<!-- End of Sidebar -->
