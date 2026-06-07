<nav class="sidebar p-3 border-end d-none d-lg-block">
    <ul class="nav flex-column">
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('dashboard') ? 'active fw-bold' : '' }}" href="{{ route('dashboard') }}">
                <i class="fas fa-tachometer-alt"></i> Dashboard
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('pengemasan.*') && !request()->routeIs('pengemasan.create', 'pengemasan.edit') ? 'active fw-bold' : '' }}" href="{{ route('pengemasan.index') }}">
                <i class="fas fa-boxes"></i> Data Pengemasan
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('stok.index') ? 'active fw-bold' : '' }}" href="{{ route('stok.index') }}">
                <i class="fas fa-warehouse"></i> Stok Produk
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('stok.bahanBaku') ? 'active fw-bold' : '' }}" href="{{ route('stok.bahanBaku') }}">
                <i class="fas fa-cubes"></i> Stok Bahan Baku
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link {{ request()->routeIs('history.*') ? 'active fw-bold' : '' }}" href="{{ route('history.pengemasan') }}">
                <i class="fas fa-history"></i> Riwayat
            </a>
        </li>
        @if(auth()->user()->role == 'admin' || auth()->user()->role == 'pemilik')
            <hr>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('produk.*') ? 'active fw-bold' : '' }}" href="{{ route('produk.index') }}">
                    <i class="fas fa-cube"></i> Master Produk
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('bahan-baku.*') ? 'active fw-bold' : '' }}" href="{{ route('bahan-baku.index') }}">
                    <i class="fas fa-flask"></i> Bahan Baku
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('kemasan.*') ? 'active fw-bold' : '' }}" href="{{ route('kemasan.index') }}">
                    <i class="fas fa-tag"></i> Kelola Kemasan
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('pengguna.*') ? 'active fw-bold' : '' }}" href="{{ route('pengguna.index') }}">
                    <i class="fas fa-users-cog"></i> Kelola Pengguna
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('laporan.*') ? 'active fw-bold' : '' }}" href="{{ route('laporan.index') }}">
                    <i class="fas fa-chart-bar"></i> Laporan
                </a>
            </li>
        @endif
    </ul>
</nav>
