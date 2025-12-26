<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <a href="{{ route('admin.dashboard') }}" class="brand-link">
        <span class="brand-text font-weight-light">POLIKLINIK</span>
    </a>

    <div class="sidebar">
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="https://www.gravatar.com/avatar/2c7d9f6f281ecd3bd65ab915bca6dd57s=100"
                    class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block">Halo! {{ Auth::user()->nama }}</a>
            </div>
        </div>

        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                data-accordion="false">

                {{-- ROLE ADMIN --}}
                @if (Auth::user()->role == 'admin')
                    <li class="nav-header">ADMIN MENU</li>

                    <li class="nav-item">
                        <a href="{{ route('admin.dashboard') }}"
                            class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-tachometer-alt"></i>
                            <p>Dashboard Admin</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('admin.polis.index') }}"
                            class="nav-link {{ request()->routeIs('admin.polis.*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-hospital"></i>
                            <p>Manajemen Poli</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('admin.dokter.index') }}"
                            class="nav-link {{ request()->routeIs('admin.dokter.*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-user-md"></i>
                            <p>Manajemen Dokter</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('admin.pasien.index') }}"
                            class="nav-link {{ request()->routeIs('admin.pasien.*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-user-injured"></i>
                            <p>Manajemen Pasien</p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{ route('admin.obat.index') }}"
                            class="nav-link {{ request()->routeIs('admin.obat.*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-pills"></i>
                            <p>Manajemen Obat</p>
                        </a>
                    </li>
                @endif

                {{-- ROLE DOKTER --}}
                @if (Auth::user()->role == 'dokter')
                    <li class="nav-header">DOKTER MENU</li>
                    <li class="nav-item">
                        <a href="{{ route('dokter.dashboard') }}" class="nav-link">
                            <i class="nav-icon fas fa-user-md"></i>
                            <p>Dashboard Dokter</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('jadwal-periksa.index') }}"
                            class="nav-link {{ request()->routeIs('jadwal-periksa.*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-calendar-alt"></i>
                            <p>Jadwal Periksa</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('periksa-pasien.index') }}"
                            class="nav-link {{ request()->routeIs('periksa-pasien.*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-calendar-alt"></i>
                            <p>Periksa Pasien</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('dokter.riwayat-pasien.index') }}"
                            class="nav-link {{ request()->routeIs('dokter.riwayat-pasien.*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-history"></i>
                            <p>Riwayat Pasien</p>
                        </a>
                    </li>
                @endif

                {{-- ROLE PASIEN --}}
                @if (Auth::user()->role == 'pasien')
                    <li class="nav-header">PASIEN MENU</li>
                    <li class="nav-item">
                        <a href="{{ route('pasien.dashboard') }}" class="nav-link">
                            <i class="nav-icon fas fa-procedures"></i>
                            <p>Dashboard Pasien</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('pasien.daftar') }}"
                            class="nav-link {{ request()->routeIs('pasien.daftar') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-hospital-user"></i>
                            <p>Poli</p>
                        </a>
                    </li>
                @endif

                <li class="nav-item">
                    <form method="POST" action="{{ route('logout') }}" class="nav-link">
                        @csrf
                        <button type="submit" class="btn btn-sm btn-danger btn-block">
                            <i class="fas fa-sign-out-alt"></i> Logout
                        </button>
                    </form>
                </li>
            </ul>
        </nav>
    </div>
</aside>
