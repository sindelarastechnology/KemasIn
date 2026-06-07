<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/png" href="{{ asset('images/fav.png') }}">
    <title>@yield('title', 'UMKM Kemasan')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        :root {
            --sidebar-width: 250px;
        }

        body {
            background: #f4f6f9;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            padding-top: 56px;
        }

        .navbar-brand {
            font-weight: 700;
            letter-spacing: 0.5px;
        }

        .sidebar {
            width: var(--sidebar-width);
            min-width: var(--sidebar-width);
            background: #fff !important;
            height: calc(100vh - 56px);
            position: sticky;
            top: 56px;
            overflow-y: auto;
            z-index: 100;
        }

        .sidebar .nav-link {
            color: #495057;
            border-radius: 8px;
            margin: 2px 0;
            padding: 10px 14px;
            font-size: 14px;
            transition: all 0.15s;
        }

        .sidebar .nav-link:hover {
            background: #e9ecef;
            color: #0d6efd;
        }

        .sidebar .nav-link.active {
            background: #0d6efd;
            color: #fff !important;
            font-weight: 600;
        }

        .sidebar .nav-link i,
        .offcanvas .nav-link i {
            width: 20px;
            text-align: center;
            margin-right: 8px;
        }

        .offcanvas .nav-link {
            color: #495057;
            border-radius: 8px;
            margin: 2px 0;
            padding: 10px 14px;
            font-size: 14px;
            transition: all 0.15s;
        }

        .offcanvas .nav-link:hover {
            background: #e9ecef;
            color: #0d6efd;
        }

        .offcanvas .nav-link.active {
            background: #0d6efd;
            color: #fff !important;
            font-weight: 600;
        }

        .offcanvas hr {
            margin: 12px 0;
        }

        .table .btn-group {
            white-space: nowrap;
        }

        .sidebar hr {
            margin: 12px 0;
        }

        .main-content {
            flex: 1;
            min-width: 0;
            padding: 24px;
            max-width: 100%;
        }

        .card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, .06);
        }

        .card-header {
            background: transparent;
            border-bottom: 1px solid rgba(0, 0, 0, .06);
            font-weight: 600;
            padding: 16px 20px;
        }

        .card-body {
            padding: 20px;
        }

        .kpi-card {
            border-radius: 16px;
            padding: 20px;
            transition: all 0.2s;
        }

        .kpi-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 24px rgba(0, 0, 0, .12) !important;
        }

        .kpi-card .kpi-icon {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 22px;
        }

        .kpi-card .kpi-value {
            font-size: 28px;
            font-weight: 700;
            line-height: 1.2;
        }

        .kpi-card .kpi-label {
            font-size: 13px;
            opacity: .85;
        }

        .kpi-card .kpi-trend {
            font-size: 12px;
            font-weight: 600;
        }

        .table th {
            font-weight: 600;
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: .3px;
            color: #6c757d;
            border-bottom-width: 1px;
            white-space: nowrap;
        }

        .table td {
            vertical-align: middle;
            font-size: 14px;
        }

        .table> :not(:first-child) {
            border-top: none;
        }

        .table-hover tbody tr:hover {
            background-color: rgba(13, 110, 253, .04);
        }

        .table-actions {
            white-space: nowrap;
        }

        .btn {
            border-radius: 8px;
            font-weight: 500;
        }

        .btn-sm {
            border-radius: 6px;
        }

        .form-control,
        .form-select {
            border-radius: 8px;
            border-color: #dee2e6;
            padding: 10px 14px;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: #86b7fe;
            box-shadow: 0 0 0 3px rgba(13, 110, 253, .15);
        }

        .input-group-text {
            border-radius: 8px;
        }

        .page-link {
            border-radius: 8px !important;
            margin: 0 2px;
            border: none;
            color: #495057;
        }

        .page-item.active .page-link {
            background: #0d6efd;
        }

        .page-item.disabled .page-link {
            background: transparent;
        }

        .pagination {
            gap: 2px;
        }

        .badge {
            font-weight: 500;
            padding: 4px 10px;
            border-radius: 6px;
        }

        .alert {
            border: none;
            border-radius: 10px;
        }

        .progress {
            border-radius: 10px;
        }

        .modal-content {
            border: none;
            border-radius: 16px;
        }

        .modal-header {
            border-bottom: 1px solid rgba(0, 0, 0, .06);
        }

        .modal-footer {
            border-top: 1px solid rgba(0, 0, 0, .06);
        }

        .password-toggle {
            cursor: pointer;
            border: none;
            background: transparent;
            padding: 0 12px;
            color: #6c757d;
        }

        .password-toggle:hover {
            color: #0d6efd;
        }

        .password-toggle:focus {
            outline: none;
        }

        .loading-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(255, 255, 255, .7);
            z-index: 9999;
            align-items: center;
            justify-content: center;
        }

        .loading-overlay.show {
            display: flex;
        }

        .loading-spinner {
            width: 40px;
            height: 40px;
            border: 4px solid #e9ecef;
            border-top-color: #0d6efd;
            border-radius: 50%;
            animation: spin .6s linear infinite;
        }

        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }

        @media (max-width: 991.98px) {
            .main-content {
                padding: 16px;
            }

            .kpi-card .kpi-value {
                font-size: 22px;
            }

            .kpi-card {
                padding: 16px;
            }

            .card-body {
                padding: 16px;
            }

            .card-header {
                padding: 14px 16px;
            }

            .table th {
                font-size: 11px;
            }

            .table td {
                font-size: 13px;
            }
        }

        @media (max-width: 575.98px) {
            .main-content {
                padding: 12px;
            }

            .kpi-card {
                padding: 14px;
            }

            .kpi-card .kpi-icon {
                width: 40px;
                height: 40px;
                font-size: 18px;
            }

            .kpi-card .kpi-value {
                font-size: 20px;
            }

            .card-body {
                padding: 12px;
            }

            .card-header {
                padding: 12px 14px;
                font-size: 14px;
            }
        }
    </style>
    @yield('styles')
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow-sm fixed-top">
        <div class="container-fluid">
            <button class="navbar-toggler d-lg-none me-2" type="button" data-bs-toggle="offcanvas"
                data-bs-target="#sidebarOffcanvas" aria-label="Toggle menu">
                <span class="navbar-toggler-icon"></span>
            </button>
            <a class="navbar-brand d-flex align-items-center gap-2" href="{{ route('dashboard') }}">
                <img src="{{ asset('images/logo.png') }}" alt="Logo" height="30">
                {{-- <span class="d-none d-sm-inline">SI Kemasan UMKM</span><span class="d-sm-none">SI UMKM</span> --}}
            </a>
            @auth
                <div class="d-flex align-items-center gap-2">
                    <span class="text-white d-none d-md-inline small">
                        <i class="fas fa-user-circle"></i> {{ auth()->user()->nama_lengkap }}
                    </span>
                    <span class="badge bg-light text-primary d-none d-sm-inline">
                        {{ ucfirst(auth()->user()->role) }}
                    </span>
                    <form action="{{ route('logout') }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-light btn-sm">
                            <i class="fas fa-sign-out-alt"></i>
                        </button>
                    </form>
                </div>
            @endauth
        </div>
    </nav>

    <div class="d-flex">
        {{-- Desktop sidebar --}}
        @include('layouts.sidebar')

        {{-- Mobile offcanvas sidebar --}}
        <div class="offcanvas offcanvas-start d-lg-none" tabindex="-1" id="sidebarOffcanvas">
            <div class="offcanvas-header border-bottom">
                <h5 class="offcanvas-title"><i class="fas fa-bars me-2"></i>Menu</h5>
                <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
            </div>
            <div class="offcanvas-body p-0">
                <nav class="p-3">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('dashboard') ? 'active fw-bold' : '' }}"
                                href="{{ route('dashboard') }}" onclick="closeOffcanvas()">
                                <i class="fas fa-tachometer-alt"></i> Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('pengemasan.*') && !request()->routeIs('pengemasan.create', 'pengemasan.edit') ? 'active fw-bold' : '' }}"
                                href="{{ route('pengemasan.index') }}" onclick="closeOffcanvas()">
                                <i class="fas fa-boxes"></i> Data Pengemasan
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('stok.index') ? 'active fw-bold' : '' }}"
                                href="{{ route('stok.index') }}" onclick="closeOffcanvas()">
                                <i class="fas fa-warehouse"></i> Stok Produk
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('stok.bahanBaku') ? 'active fw-bold' : '' }}"
                                href="{{ route('stok.bahanBaku') }}" onclick="closeOffcanvas()">
                                <i class="fas fa-cubes"></i> Stok Bahan Baku
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link {{ request()->routeIs('history.*') ? 'active fw-bold' : '' }}"
                                href="{{ route('history.pengemasan') }}" onclick="closeOffcanvas()">
                                <i class="fas fa-history"></i> Riwayat
                            </a>
                        </li>
                        @if (auth()->user()->role == 'admin' || auth()->user()->role == 'pemilik')
                            <hr>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('produk.*') ? 'active fw-bold' : '' }}"
                                    href="{{ route('produk.index') }}" onclick="closeOffcanvas()">
                                    <i class="fas fa-cube"></i> Master Produk
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('bahan-baku.*') ? 'active fw-bold' : '' }}"
                                    href="{{ route('bahan-baku.index') }}" onclick="closeOffcanvas()">
                                    <i class="fas fa-flask"></i> Bahan Baku
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('kemasan.*') ? 'active fw-bold' : '' }}"
                                    href="{{ route('kemasan.index') }}" onclick="closeOffcanvas()">
                                    <i class="fas fa-tag"></i> Kelola Kemasan
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('pengguna.*') ? 'active fw-bold' : '' }}"
                                    href="{{ route('pengguna.index') }}" onclick="closeOffcanvas()">
                                    <i class="fas fa-users-cog"></i> Kelola Pengguna
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link {{ request()->routeIs('laporan.*') ? 'active fw-bold' : '' }}"
                                    href="{{ route('laporan.index') }}" onclick="closeOffcanvas()">
                                    <i class="fas fa-chart-bar"></i> Laporan
                                </a>
                            </li>
                        @endif
                    </ul>
                </nav>
            </div>
        </div>

        <main class="main-content">
            <div id="flash-messages">
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
                        <i class="fas fa-check-circle me-1"></i> {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif
                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
                        <i class="fas fa-exclamation-circle me-1"></i> {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif
            </div>
            @yield('content')
        </main>
    </div>

    <div class="loading-overlay" id="loadingOverlay">
        <div class="text-center">
            <div class="loading-spinner mx-auto mb-2"></div>
            <div class="text-muted small">Memproses...</div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        function closeOffcanvas() {
            var offcanvas = document.getElementById('sidebarOffcanvas');
            var bsOffcanvas = bootstrap.Offcanvas.getInstance(offcanvas);
            if (bsOffcanvas) bsOffcanvas.hide();
        }
        $(function() {
            $('.btn-submit-loading').on('click', function(e) {
                var $form = $(this).closest('form');
                if ($form.length && $form[0].checkValidity && !$form[0].checkValidity()) return;
                $(this).prop('disabled', true).html(
                    '<span class="spinner-border spinner-border-sm me-1"></span> Memproses...');
                $form.length && $form.on('submit', function() {
                    return true;
                });
            });
            $('form[data-loading]').on('submit', function() {
                var btn = $(this).find('[type="submit"]');
                btn.prop('disabled', true).html(
                    '<span class="spinner-border spinner-border-sm me-1"></span> Memproses...');
            });
            setTimeout(function() {
                $('#flash-messages .alert').fadeOut(500);
            }, 5000);
        });
    </script>
    @yield('scripts')
</body>

</html>
