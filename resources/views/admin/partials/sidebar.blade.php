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

    <!-- Kelola Users -->
    <li class="nav-item {{ request()->is('admin/users*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('admin.users.index') }}">
            <i class="fas fa-users-cog"></i>
            <span>Kelola Users</span>
        </a>
    </li>
    <!-- Kelola Testimoni -->
    <li class="nav-item {{ request()->is('admin/testimoni*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('admin.testimoni.index') }}">
            <i class="fas fa-comments"></i>
            <span>Kelola Testimoni</span>
        </a>
    </li>




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
