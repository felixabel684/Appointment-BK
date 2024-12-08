<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('dashboard-patient') }}">

        <div class="sidebar-brand-text mx-3">Poliklinik Pasien</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item {{ Route::is('dashboard-patient') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('dashboard-patient') }}">
            <i class="fas fa-hospital"></i>
            <span>Dashboard</span>
        </a>
    </li>

    <li class="nav-item {{ Route::is('examination_patients.index') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('examination_patients.index') }}">
            <i class="fas fa-stethoscope"></i>
            <span>Pemeriksaan</span>
        </a>
    </li>

    <hr class="sidebar-divider">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>
<!-- End of Sidebar -->
