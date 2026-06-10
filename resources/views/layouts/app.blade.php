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
            --sidebar-bg: #0f1419;
            --sidebar-hover: #1c2333;
            --sidebar-active: #3b82f6;
            --sidebar-text: #8b949e;
            --sidebar-text-active: #ffffff;
            --primary: #2563eb;
            --primary-dark: #1d4ed8;
            --primary-light: #60a5fa;
            --accent: #f59e0b;
            --accent-light: #fbbf24;
            --success: #059669;
            --success-light: #34d399;
            --warning: #d97706;
            --danger: #dc2626;
            --danger-light: #f87171;
            --info: #0284c7;
            --bg-body: #f1f5f9;
            --card-shadow: 0 1px 3px rgba(0,0,0,.06);
            --card-shadow-hover: 0 8px 30px rgba(0,0,0,.1);
            --transition-fast: all .15s cubic-bezier(.4,0,.2,1);
            --transition-base: all .25s cubic-bezier(.4,0,.2,1);
            --transition-smooth: all .35s cubic-bezier(.4,0,.2,1);
        }

        * {
            box-sizing: border-box;
        }

        body {
            background: var(--bg-body);
            background-image: radial-gradient(ellipse at 20% 50%, rgba(37,99,235,.03) 0%, transparent 50%),
                              radial-gradient(ellipse at 80% 20%, rgba(5,150,105,.03) 0%, transparent 50%);
            font-family: 'Inter', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            padding-top: 56px;
            color: #1f2937;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }

        ::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }
        ::-webkit-scrollbar-track {
            background: transparent;
        }
        ::-webkit-scrollbar-thumb {
            background: #d1d5db;
            border-radius: 3px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #9ca3af;
        }

        /* ─── Navbar ─── */
        .navbar {
            background: linear-gradient(135deg, #1e3a5f 0%, #2563eb 50%, #1d4ed8 100%) !important;
            backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(255,255,255,.08);
            box-shadow: 0 2px 20px rgba(37,99,235,.25);
        }
        .navbar-brand {
            font-weight: 700;
            letter-spacing: 0.5px;
        }

        /* ─── Sidebar ─── */
        .sidebar {
            width: var(--sidebar-width);
            min-width: var(--sidebar-width);
            background: linear-gradient(180deg, #0f1419 0%, #161d2b 100%) !important;
            height: calc(100vh - 56px);
            position: sticky;
            top: 56px;
            overflow-y: auto;
            overflow-x: hidden;
            z-index: 100;
            border-right: 1px solid rgba(255,255,255,.04);
            scrollbar-width: thin;
            scrollbar-color: #2a3040 transparent;
        }
        .sidebar::-webkit-scrollbar {
            width: 4px;
        }
        .sidebar::-webkit-scrollbar-thumb {
            background: #2a3040;
            border-radius: 2px;
        }
        .sidebar hr {
            margin: 12px 16px;
            border-color: rgba(255,255,255,.06);
            opacity: .6;
        }
        .sidebar .nav-link {
            color: var(--sidebar-text);
            border-radius: 8px;
            margin: 2px 8px;
            padding: 10px 14px;
            font-size: 14px;
            transition: var(--transition-base);
            position: relative;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .sidebar .nav-link i {
            width: 20px;
            text-align: center;
            font-size: 15px;
            flex-shrink: 0;
            transition: var(--transition-base);
        }
        .sidebar .nav-link:hover {
            background: var(--sidebar-hover);
            color: #e6edf3;
            transform: translateX(3px);
        }
        .sidebar .nav-link:hover i {
            color: var(--primary-light);
        }
        .sidebar .nav-link.active {
            background: linear-gradient(135deg, rgba(37,99,235,.2) 0%, rgba(37,99,235,.08) 100%);
            color: var(--sidebar-text-active) !important;
            font-weight: 500;
            box-shadow: inset 3px 0 0 var(--sidebar-active);
        }
        .sidebar .nav-link.active i {
            color: var(--primary-light);
        }

        /* ─── Offcanvas (mobile sidebar) ─── */
        .offcanvas .nav-link {
            color: #495057;
            border-radius: 8px;
            margin: 2px 0;
            padding: 10px 14px;
            font-size: 14px;
            transition: var(--transition-base);
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .offcanvas .nav-link:hover {
            background: #e9ecef;
            color: var(--primary);
            transform: translateX(3px);
        }
        .offcanvas .nav-link.active {
            background: var(--primary);
            color: #fff !important;
            font-weight: 600;
        }
        .offcanvas .nav-link i {
            width: 20px;
            text-align: center;
        }
        .offcanvas hr {
            margin: 12px 0;
            border-color: rgba(0,0,0,.06);
        }

        /* ─── Page Header ─── */
        .page-header {
            position: relative;
            margin-bottom: 1.5rem;
        }
        .page-header h4 {
            font-weight: 700;
            background: linear-gradient(135deg, #1e3a5f, var(--primary));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        .page-header::after {
            content: '';
            display: block;
            width: 50px;
            height: 3px;
            background: linear-gradient(90deg, var(--primary), var(--accent));
            border-radius: 2px;
            margin-top: 6px;
        }
        .page-header small {
            -webkit-text-fill-color: #6b7280;
        }

        /* ─── Main Content ─── */
        .main-content {
            flex: 1;
            min-width: 0;
            padding: 24px;
            max-width: 100%;
            animation: fadeInUp .4s ease both;
        }

        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(12px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* ─── Cards ─── */
        .card {
            border: none;
            border-radius: 14px;
            box-shadow: var(--card-shadow);
            transition: var(--transition-smooth);
            background: #ffffff;
            position: relative;
            overflow: hidden;
        }
        .card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: linear-gradient(90deg, var(--primary), var(--primary-light));
            transform: scaleX(0);
            transform-origin: left;
            transition: transform .4s cubic-bezier(.4,0,.2,1);
            z-index: 1;
        }
        .card:hover {
            transform: translateY(-3px);
            box-shadow: var(--card-shadow-hover);
        }
        .card:hover::before {
            transform: scaleX(1);
        }
        .card-header {
            background: transparent;
            border-bottom: 1px solid rgba(0, 0, 0, .05);
            font-weight: 600;
            padding: 16px 20px;
            color: #1f2937;
        }
        .card-header i {
            color: var(--primary);
        }
        .card-body {
            padding: 20px;
        }
        .card-footer {
            background: transparent;
            border-top: 1px solid rgba(0, 0, 0, .05);
            padding: 12px 20px;
        }

        /* ─── KPI Cards ─── */
        .kpi-card {
            border-radius: 16px;
            padding: 20px;
            transition: var(--transition-smooth);
            position: relative;
            overflow: hidden;
            cursor: default;
            border: 1px solid rgba(0,0,0,.04);
        }
        .kpi-card::after {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 100%;
            height: 100%;
            background: radial-gradient(circle, rgba(255,255,255,.12) 0%, transparent 70%);
            opacity: 0;
            transition: opacity .4s ease;
            pointer-events: none;
        }
        .kpi-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 40px rgba(0, 0, 0, .12) !important;
        }
        .kpi-card:hover::after {
            opacity: 1;
        }
        .kpi-card .kpi-icon {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 22px;
            transition: var(--transition-base);
            box-shadow: 0 2px 8px rgba(0,0,0,.06);
        }
        .kpi-card:hover .kpi-icon {
            transform: scale(1.1) rotate(-3deg);
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

        /* ─── Tables ─── */
        .table {
            margin-bottom: 0;
        }
        .table th {
            font-weight: 600;
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: .5px;
            color: #6b7280;
            border-bottom: 2px solid rgba(0,0,0,.05);
            white-space: nowrap;
            padding: 12px 16px;
            background: rgba(37,99,235,.03);
        }
        .table td {
            vertical-align: middle;
            font-size: 14px;
            padding: 12px 16px;
            border-bottom: 1px solid rgba(0,0,0,.04);
        }
        .table> :not(:first-child) {
            border-top: none;
        }
        .table-hover tbody tr {
            transition: var(--transition-fast);
        }
        .table-hover tbody tr:hover {
            background-color: rgba(37, 99, 235, .04);
            transform: scale(1.002);
            box-shadow: 0 2px 8px rgba(0,0,0,.03);
        }
        .table-hover tbody tr:last-child td {
            border-bottom: none;
        }
        .table .btn-group {
            white-space: nowrap;
        }
        .table-actions {
            white-space: nowrap;
        }

        /* ─── Buttons ─── */
        .btn {
            border-radius: 8px;
            font-weight: 500;
            font-size: 14px;
            padding: 8px 18px;
            transition: var(--transition-base);
            position: relative;
            overflow: hidden;
        }
        .btn::after {
            content: '';
            position: absolute;
            inset: 0;
            background: radial-gradient(circle at var(--mx, 50%) var(--my, 50%), rgba(255,255,255,.25), transparent 60%);
            opacity: 0;
            transition: opacity .3s;
            pointer-events: none;
        }
        .btn:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 14px rgba(37, 99, 235, .3);
        }
        .btn:hover::after {
            opacity: 1;
        }
        .btn:active {
            transform: translateY(0) scale(.97);
        }
        .btn.loading {
            pointer-events: none;
            opacity: .85;
        }
        .btn-sm {
            border-radius: 6px;
            padding: 5px 12px;
            font-size: 12px;
        }
        .btn-sm:hover {
            transform: translateY(-1px);
        }
        .btn-outline-secondary:hover {
            box-shadow: 0 4px 14px rgba(108, 117, 125, .2);
        }
        .btn-success:hover {
            box-shadow: 0 4px 14px rgba(5, 150, 105, .3);
        }
        .btn-warning:hover {
            box-shadow: 0 4px 14px rgba(217, 119, 6, .3);
        }
        .btn-danger:hover {
            box-shadow: 0 4px 14px rgba(220, 38, 38, .3);
        }
        .btn-info:hover {
            box-shadow: 0 4px 14px rgba(2, 132, 199, .25);
        }
        .btn-primary {
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            border: none;
        }
        .btn-primary:hover {
            background: linear-gradient(135deg, var(--primary-dark), #1e3a8a);
        }
        .btn-success {
            background: linear-gradient(135deg, var(--success), #047857);
            border: none;
        }
        .btn-success:hover {
            background: linear-gradient(135deg, #047857, #065f46);
        }
        .btn-danger {
            background: linear-gradient(135deg, var(--danger), #b91c1c);
            border: none;
        }
        .btn-danger:hover {
            background: linear-gradient(135deg, #b91c1c, #991b1b);
        }
        .btn-warning {
            color: #fff;
            background: linear-gradient(135deg, var(--warning), #b45309);
            border: none;
        }
        .btn-warning:hover {
            background: linear-gradient(135deg, #b45309, #92400e);
            color: #fff;
        }

        /* ─── Forms ─── */
        .form-control,
        .form-select {
            border-radius: 10px;
            border-color: #e5e7eb;
            padding: 10px 14px;
            font-size: 14px;
            transition: var(--transition-base);
            background: #fafafa;
        }
        .form-control:hover,
        .form-select:hover {
            border-color: #d1d5db;
            background: #fff;
        }
        .form-control:focus,
        .form-select:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(37, 99, 235, .12);
            background: #fff;
        }
        .form-control:focus:hover,
        .form-select:focus:hover {
            border-color: var(--primary);
        }
        .form-label {
            font-weight: 500;
            font-size: 13px;
            color: #374151;
            margin-bottom: 6px;
        }
        .input-group-text {
            border-radius: 10px;
            background: #f3f4f6;
            border-color: #e5e7eb;
        }
        .invalid-feedback {
            font-size: 12px;
            margin-top: 4px;
        }

        /* ─── Pagination ─── */
        .page-link {
            border-radius: 8px !important;
            margin: 0 2px;
            border: none;
            color: #374151;
            font-weight: 500;
            font-size: 13px;
            padding: 8px 14px;
            transition: var(--transition-fast);
        }
        .page-link:hover {
            background: #e5e7eb;
            color: var(--primary);
            transform: translateY(-1px);
        }
        .page-item.active .page-link {
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            box-shadow: 0 2px 8px rgba(37, 99, 235, .3);
            color: #fff;
        }
        .page-item.disabled .page-link {
            background: transparent;
            color: #d1d5db;
        }
        .pagination {
            gap: 2px;
        }

        /* ─── Badges ─── */
        .badge {
            font-weight: 500;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 11px;
            letter-spacing: .2px;
            transition: var(--transition-fast);
            display: inline-flex;
            align-items: center;
            gap: 4px;
        }
        .badge.bg-secondary { background: #6b7280 !important; }
        .badge.bg-warning { background: var(--warning) !important; color: #fff !important; }
        .badge.bg-success { background: var(--success) !important; }
        .badge.bg-danger { background: var(--danger) !important; }
        .badge.bg-info { background: #e0f2fe !important; color: #0369a1 !important; }
        .badge.bg-primary { background: var(--primary) !important; }
        .badge.bg-light { background: #f3f4f6 !important; color: #374151 !important; border: 1px solid #e5e7eb; }

        /* ─── Alerts ─── */
        .alert {
            border: none;
            border-radius: 12px;
            padding: 14px 18px;
            font-size: 14px;
        }
        .alert-success {
            background: linear-gradient(135deg, #ecfdf5, #d1fae5);
            color: #065f46;
            border-left: 4px solid var(--success);
        }
        .alert-danger {
            background: linear-gradient(135deg, #fef2f2, #fecaca);
            color: #991b1b;
            border-left: 4px solid var(--danger);
        }
        .alert .btn-close {
            font-size: 12px;
        }

        /* ─── Progress ─── */
        .progress {
            border-radius: 10px;
            background: #e5e7eb;
            overflow: hidden;
            box-shadow: inset 0 1px 3px rgba(0,0,0,.06);
        }
        .progress-bar {
            background-image: linear-gradient(135deg, var(--primary), var(--primary-light));
            transition: width .6s cubic-bezier(.4,0,.2,1);
        }
        .progress-bar.bg-success {
            background-image: linear-gradient(135deg, var(--success), var(--success-light)) !important;
        }

        /* ─── Modal ─── */
        .modal-content {
            border: none;
            border-radius: 18px;
            box-shadow: 0 20px 60px rgba(0,0,0,.15);
            overflow: hidden;
        }
        .modal-header {
            border-bottom: 1px solid rgba(0, 0, 0, .06);
            padding: 18px 20px;
        }
        .modal-body {
            padding: 20px;
        }
        .modal-footer {
            border-top: 1px solid rgba(0, 0, 0, .06);
            padding: 14px 20px;
        }
        .modal.fade .modal-dialog {
            transform: scale(.95) translateY(-20px);
            transition: transform .25s cubic-bezier(.4,0,.2,1), opacity .25s ease;
        }
        .modal.show .modal-dialog {
            transform: scale(1) translateY(0);
        }

        /* ─── Password Toggle ─── */
        .password-toggle {
            cursor: pointer;
            border: none;
            background: transparent;
            padding: 0 12px;
            color: #6c757d;
            transition: var(--transition-fast);
        }
        .password-toggle:hover {
            color: var(--primary);
            transform: scale(1.1);
        }
        .password-toggle:focus {
            outline: none;
        }

        /* ─── Loading Overlay ─── */
        .loading-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(255, 255, 255, .75);
            backdrop-filter: blur(4px);
            z-index: 9999;
            align-items: center;
            justify-content: center;
            animation: fadeIn .2s ease;
        }
        .loading-overlay.show {
            display: flex;
        }
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        .loading-spinner {
            width: 44px;
            height: 44px;
            border: 4px solid #e5e7eb;
            border-top-color: var(--primary);
            border-radius: 50%;
            animation: spin .7s linear infinite;
        }
        @keyframes spin {
            to { transform: rotate(360deg); }
        }
        @keyframes cardFadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* ─── Utility: link hover ─── */
        a:not(.btn):not(.nav-link):not(.page-link):not(.dropdown-item) {
            transition: var(--transition-fast);
        }
        a:not(.btn):not(.nav-link):not(.page-link):not(.dropdown-item):hover {
            color: var(--primary-dark);
        }

        /* ─── Responsive ─── */
        @media (max-width: 1199.98px) {
            .container-fluid {
                padding-left: 16px !important;
                padding-right: 16px !important;
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
            .kpi-card .kpi-icon {
                width: 42px;
                height: 42px;
                font-size: 20px;
            }
            .card-body {
                padding: 16px;
            }
            .card-header {
                padding: 14px 16px;
                font-size: 14px;
            }
            .table th {
                font-size: 10px;
                padding: 10px 12px;
            }
            .table td {
                font-size: 13px;
                padding: 10px 12px;
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
                font-size: 13px;
            }
            .btn {
                font-size: 13px;
                padding: 7px 14px;
            }
        }

        * {
            box-sizing: border-box;
        }

        body {
            background: var(--bg-body);
            font-family: 'Inter', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            padding-top: 56px;
            color: #1f2937;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }

        ::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }
        ::-webkit-scrollbar-track {
            background: transparent;
        }
        ::-webkit-scrollbar-thumb {
            background: #d1d5db;
            border-radius: 3px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #9ca3af;
        }

        /* ─── Navbar ─── */
        .navbar {
            background: linear-gradient(135deg, #0d6efd 0%, #0a58ca 100%) !important;
            backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(255,255,255,.08);
        }
        .navbar-brand {
            font-weight: 700;
            letter-spacing: 0.5px;
        }

        /* ─── Sidebar ─── */
        .sidebar {
            width: var(--sidebar-width);
            min-width: var(--sidebar-width);
            background: var(--sidebar-bg) !important;
            height: calc(100vh - 56px);
            position: sticky;
            top: 56px;
            overflow-y: auto;
            overflow-x: hidden;
            z-index: 100;
            border-right: 1px solid rgba(255,255,255,.04);
            scrollbar-width: thin;
            scrollbar-color: #2a3040 transparent;
        }
        .sidebar::-webkit-scrollbar {
            width: 4px;
        }
        .sidebar::-webkit-scrollbar-thumb {
            background: #2a3040;
            border-radius: 2px;
        }
        .sidebar hr {
            margin: 12px 16px;
            border-color: rgba(255,255,255,.06);
            opacity: .6;
        }
        .sidebar .nav-link {
            color: var(--sidebar-text);
            border-radius: 8px;
            margin: 2px 8px;
            padding: 10px 14px;
            font-size: 14px;
            transition: var(--transition-base);
            position: relative;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .sidebar .nav-link i {
            width: 20px;
            text-align: center;
            font-size: 15px;
            flex-shrink: 0;
            transition: var(--transition-base);
        }
        .sidebar .nav-link:hover {
            background: var(--sidebar-hover);
            color: #e6edf3;
            transform: translateX(3px);
        }
        .sidebar .nav-link:hover i {
            color: #58a6ff;
        }
        .sidebar .nav-link.active {
            background: linear-gradient(135deg, rgba(13,110,253,.2) 0%, rgba(13,110,253,.08) 100%);
            color: var(--sidebar-text-active) !important;
            font-weight: 500;
            box-shadow: inset 3px 0 0 var(--sidebar-active);
        }
        .sidebar .nav-link.active i {
            color: #58a6ff;
        }

        /* ─── Offcanvas (mobile sidebar) ─── */
        .offcanvas .nav-link {
            color: #495057;
            border-radius: 8px;
            margin: 2px 0;
            padding: 10px 14px;
            font-size: 14px;
            transition: var(--transition-base);
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .offcanvas .nav-link:hover {
            background: #e9ecef;
            color: #0d6efd;
            transform: translateX(3px);
        }
        .offcanvas .nav-link.active {
            background: #0d6efd;
            color: #fff !important;
            font-weight: 600;
        }
        .offcanvas .nav-link i {
            width: 20px;
            text-align: center;
        }
        .offcanvas hr {
            margin: 12px 0;
            border-color: rgba(0,0,0,.06);
        }

        /* ─── Main Content ─── */
        .main-content {
            flex: 1;
            min-width: 0;
            padding: 24px;
            max-width: 100%;
            animation: fadeInUp .4s ease both;
        }

        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(12px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* ─── Cards ─── */
        .card {
            border: none;
            border-radius: 14px;
            box-shadow: var(--card-shadow);
            transition: var(--transition-smooth);
            background: #ffffff;
            position: relative;
            overflow: hidden;
        }
        .card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 0;
            background: linear-gradient(90deg, var(--primary), var(--info));
            transition: height .3s ease;
            opacity: 0;
        }
        .card:hover {
            transform: translateY(-2px);
            box-shadow: var(--card-shadow-hover);
        }
        .card-header {
            background: transparent;
            border-bottom: 1px solid rgba(0, 0, 0, .05);
            font-weight: 600;
            padding: 16px 20px;
            color: #1f2937;
        }
        .card-body {
            padding: 20px;
        }
        .card-footer {
            background: transparent;
            border-top: 1px solid rgba(0, 0, 0, .05);
            padding: 12px 20px;
        }

        /* ─── KPI Cards ─── */
        .kpi-card {
            border-radius: 16px;
            padding: 20px;
            transition: var(--transition-smooth);
            position: relative;
            overflow: hidden;
            cursor: default;
        }
        .kpi-card::after {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 100%;
            height: 100%;
            background: radial-gradient(circle, rgba(255,255,255,.08) 0%, transparent 70%);
            opacity: 0;
            transition: opacity .4s ease;
            pointer-events: none;
        }
        .kpi-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 40px rgba(0, 0, 0, .15) !important;
        }
        .kpi-card:hover::after {
            opacity: 1;
        }
        .kpi-card .kpi-icon {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 22px;
            transition: var(--transition-base);
        }
        .kpi-card:hover .kpi-icon {
            transform: scale(1.1) rotate(-3deg);
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

        /* ─── Tables ─── */
        .table {
            margin-bottom: 0;
        }
        .table th {
            font-weight: 600;
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: .5px;
            color: #6b7280;
            border-bottom: 2px solid rgba(0,0,0,.05);
            white-space: nowrap;
            padding: 12px 16px;
            background: rgba(0,0,0,.02);
        }
        .table td {
            vertical-align: middle;
            font-size: 14px;
            padding: 12px 16px;
            border-bottom: 1px solid rgba(0,0,0,.04);
        }
        .table> :not(:first-child) {
            border-top: none;
        }
        .table-hover tbody tr {
            transition: var(--transition-fast);
        }
        .table-hover tbody tr:hover {
            background-color: rgba(13, 110, 253, .04);
            transform: scale(1.002);
            box-shadow: 0 2px 8px rgba(0,0,0,.03);
        }
        .table-hover tbody tr:last-child td {
            border-bottom: none;
        }
        .table .btn-group {
            white-space: nowrap;
        }
        .table-actions {
            white-space: nowrap;
        }

        /* ─── Buttons ─── */
        .btn {
            border-radius: 8px;
            font-weight: 500;
            font-size: 14px;
            padding: 8px 18px;
            transition: var(--transition-base);
            position: relative;
            overflow: hidden;
        }
        .btn::after {
            content: '';
            position: absolute;
            inset: 0;
            background: radial-gradient(circle at var(--mx, 50%) var(--my, 50%), rgba(255,255,255,.3), transparent 60%);
            opacity: 0;
            transition: opacity .3s;
            pointer-events: none;
        }
        .btn:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 14px rgba(13, 110, 253, .25);
        }
        .btn:hover::after {
            opacity: 1;
        }
        .btn:active {
            transform: translateY(0) scale(.97);
        }
        .btn.loading {
            pointer-events: none;
            opacity: .8;
        }
        .btn-sm {
            border-radius: 6px;
            padding: 5px 12px;
            font-size: 12px;
        }
        .btn-sm:hover {
            transform: translateY(-1px);
        }
        .btn-outline-secondary:hover {
            box-shadow: 0 4px 14px rgba(108, 117, 125, .2);
        }
        .btn-success:hover {
            box-shadow: 0 4px 14px rgba(16, 185, 129, .3);
        }
        .btn-warning:hover {
            box-shadow: 0 4px 14px rgba(245, 158, 11, .3);
        }
        .btn-danger:hover {
            box-shadow: 0 4px 14px rgba(239, 68, 68, .3);
        }
        .btn-info:hover {
            box-shadow: 0 4px 14px rgba(6, 182, 212, .25);
        }

        /* ─── Forms ─── */
        .form-control,
        .form-select {
            border-radius: 10px;
            border-color: #e5e7eb;
            padding: 10px 14px;
            font-size: 14px;
            transition: var(--transition-base);
            background: #fafafa;
        }
        .form-control:hover,
        .form-select:hover {
            border-color: #d1d5db;
            background: #fff;
        }
        .form-control:focus,
        .form-select:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(13, 110, 253, .12);
            background: #fff;
        }
        .form-control:focus:hover,
        .form-select:focus:hover {
            border-color: var(--primary);
        }
        .form-label {
            font-weight: 500;
            font-size: 13px;
            color: #374151;
            margin-bottom: 6px;
        }
        .input-group-text {
            border-radius: 10px;
            background: #f3f4f6;
            border-color: #e5e7eb;
        }
        .invalid-feedback {
            font-size: 12px;
            margin-top: 4px;
        }

        /* ─── Pagination ─── */
        .page-link {
            border-radius: 8px !important;
            margin: 0 2px;
            border: none;
            color: #374151;
            font-weight: 500;
            font-size: 13px;
            padding: 8px 14px;
            transition: var(--transition-fast);
        }
        .page-link:hover {
            background: #e5e7eb;
            color: var(--primary);
            transform: translateY(-1px);
        }
        .page-item.active .page-link {
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            box-shadow: 0 2px 8px rgba(13, 110, 253, .3);
            color: #fff;
        }
        .page-item.disabled .page-link {
            background: transparent;
            color: #d1d5db;
        }
        .pagination {
            gap: 2px;
        }

        /* ─── Badges ─── */
        .badge {
            font-weight: 500;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 11px;
            letter-spacing: .2px;
            transition: var(--transition-fast);
            display: inline-flex;
            align-items: center;
            gap: 4px;
        }
        .badge.bg-secondary { background: #6b7280 !important; }
        .badge.bg-warning { background: var(--warning) !important; }
        .badge.bg-success { background: var(--success) !important; }
        .badge.bg-danger { background: var(--danger) !important; }
        .badge.bg-info { background: #e0f2fe !important; color: #0369a1 !important; }
        .badge.bg-primary { background: var(--primary) !important; }

        /* ─── Alerts ─── */
        .alert {
            border: none;
            border-radius: 12px;
            padding: 14px 18px;
            font-size: 14px;
        }
        .alert-success {
            background: linear-gradient(135deg, #ecfdf5, #d1fae5);
            color: #065f46;
        }
        .alert-danger {
            background: linear-gradient(135deg, #fef2f2, #fecaca);
            color: #991b1b;
        }
        .alert .btn-close {
            font-size: 12px;
        }

        /* ─── Progress ─── */
        .progress {
            border-radius: 10px;
            background: #e5e7eb;
            overflow: hidden;
        }

        /* ─── Modal ─── */
        .modal-content {
            border: none;
            border-radius: 18px;
            box-shadow: 0 20px 60px rgba(0,0,0,.15);
            overflow: hidden;
        }
        .modal-header {
            border-bottom: 1px solid rgba(0, 0, 0, .06);
            padding: 18px 20px;
        }
        .modal-body {
            padding: 20px;
        }
        .modal-footer {
            border-top: 1px solid rgba(0, 0, 0, .06);
            padding: 14px 20px;
        }
        .modal.fade .modal-dialog {
            transform: scale(.95) translateY(-20px);
            transition: transform .25s cubic-bezier(.4,0,.2,1), opacity .25s ease;
        }
        .modal.show .modal-dialog {
            transform: scale(1) translateY(0);
        }

        /* ─── Password Toggle ─── */
        .password-toggle {
            cursor: pointer;
            border: none;
            background: transparent;
            padding: 0 12px;
            color: #6c757d;
            transition: var(--transition-fast);
        }
        .password-toggle:hover {
            color: var(--primary);
            transform: scale(1.1);
        }
        .password-toggle:focus {
            outline: none;
        }

        /* ─── Loading Overlay ─── */
        .loading-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(255, 255, 255, .75);
            backdrop-filter: blur(4px);
            z-index: 9999;
            align-items: center;
            justify-content: center;
            animation: fadeIn .2s ease;
        }
        .loading-overlay.show {
            display: flex;
        }
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        .loading-spinner {
            width: 44px;
            height: 44px;
            border: 4px solid #e5e7eb;
            border-top-color: var(--primary);
            border-radius: 50%;
            animation: spin .7s linear infinite;
        }
        @keyframes spin {
            to { transform: rotate(360deg); }
        }
        @keyframes cardFadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .card-visible {
            animation: cardFadeIn .5s ease both !important;
        }
        .btn-ripple {
            position: absolute;
            border-radius: 50%;
            background: rgba(255,255,255,.4);
            pointer-events: none;
            animation: rippleAnim .6s ease-out forwards;
        }
        @keyframes rippleAnim {
            from { transform: scale(0); opacity: .5; }
            to { transform: scale(2.5); opacity: 0; }
        }
        .loading-overlay .text-muted {
            font-size: 13px;
            letter-spacing: .3px;
            animation: pulse 1.5s ease infinite;
        }
        @keyframes pulse {
            0%, 100% { opacity: .6; }
            50% { opacity: 1; }
        }

        /* ─── Utility: link hover ─── */
        a:not(.btn):not(.nav-link):not(.page-link):not(.dropdown-item) {
            transition: var(--transition-fast);
        }
        a:not(.btn):not(.nav-link):not(.page-link):not(.dropdown-item):hover {
            color: var(--primary-dark);
        }

        /* ─── Responsive ─── */
        @media (max-width: 1199.98px) {
            .container-fluid {
                padding-left: 16px !important;
                padding-right: 16px !important;
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
            .kpi-card .kpi-icon {
                width: 42px;
                height: 42px;
                font-size: 20px;
            }
            .card-body {
                padding: 16px;
            }
            .card-header {
                padding: 14px 16px;
                font-size: 14px;
            }
            .table th {
                font-size: 10px;
                padding: 10px 12px;
            }
            .table td {
                font-size: 13px;
                padding: 10px 12px;
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
                font-size: 13px;
            }
            .btn {
                font-size: 13px;
                padding: 7px 14px;
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
                if ($form.length && !$form[0].checkValidity()) return;
                $(this).html('<span class="spinner-border spinner-border-sm me-1"></span> Memproses...')
                       .addClass('loading');
            });

            $('.btn').on('mousemove', function(e) {
                var rect = this.getBoundingClientRect();
                var x = ((e.clientX - rect.left) / rect.width) * 100;
                var y = ((e.clientY - rect.top) / rect.height) * 100;
                this.style.setProperty('--mx', x + '%');
                this.style.setProperty('--my', y + '%');
            });

            setTimeout(function() {
                $('#flash-messages .alert').fadeOut(500);
            }, 5000);
        });
    </script>
    @yield('scripts')
</body>

</html>
