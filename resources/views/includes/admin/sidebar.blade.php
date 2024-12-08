<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('dashboard-admin') }}">

        <div class="sidebar-brand-text mx-3">Poliklinik Admin</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item {{ Route::is('dashboard-admin') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('dashboard-admin') }}">
            <i class="fas fa-hospital"></i>
            <span>Dashboard</span>
        </a>
    </li>

    <li class="nav-item {{ Route::is('doctors.index') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('doctors.index') }}">
            <i class="fas fa-user-md"></i>
            <span>Data Dokter</span>
        </a>
    </li>

    <li class="nav-item {{ Route::is('patients.index') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('patients.index') }}">
            <i class="fas fa-head-side-virus"></i>
            <span>Data Pasien</span>
        </a>
    </li>

    <li class="nav-item {{ Route::is('clinics.index') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('clinics.index') }}">
            <i class="fas fa-clinic-medical"></i>
            <span>Data Poli</span>
        </a>
    </li>

    <li class="nav-item {{ Route::is('medicines.index') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('medicines.index') }}">
            <i class="fas fa-pills"></i>
            <span>Data Obat</span>
        </a>
    </li>

    <hr class="sidebar-divider">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>
<!-- End of Sidebar -->
