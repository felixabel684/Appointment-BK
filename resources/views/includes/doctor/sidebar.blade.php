<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('dashboard-doctor') }}">

        <div class="sidebar-brand-text mx-3">Poliklinik Dokter</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item {{ Route::is('dashboard-doctor') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('dashboard-doctor') }}">
            <i class="fas fa-hospital"></i>
            <span>Dashboard</span>
        </a>
    </li>

    <li class="nav-item {{ Route::is('schedules.index') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('schedules.index') }}">
            <i class="fas fa-calendar-alt"></i>
            <span>Jadwal Periksa</span>
        </a>
    </li>

    <li class="nav-item {{ Route::is('examinations.index') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('examinations.index') }}">
            <i class="fas fa-stethoscope"></i>
            <span>Memeriksa Pasien</span>
        </a>
    </li>

    <li class="nav-item {{ Route::is('history.index') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('history.index') }}">
            <i class="fas fa-history"></i>
            <span>Riwayat Pasien</span>
        </a>
    </li>

    <li class="nav-item {{ Route::is('profile.index') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('profile.index') }}">
            <i class="fas fa-user-md"></i>
            <span>Profile</span>
        </a>
    </li>

    <hr class="sidebar-divider">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>
<!-- End of Sidebar -->
