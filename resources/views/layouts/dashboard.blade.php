<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'AVMS') — Apartment Visitors Management</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>

    <style>
        :root {
            --sidebar-width: 260px;
            --sidebar-bg: #0f1623;
            --sidebar-hover: #1a2437;
            --sidebar-active: #1d4ed8;
            --accent: #3b82f6;
            --accent-light: #dbeafe;
            --topbar-height: 65px;
        }
        * { box-sizing: border-box; }
        body {
            font-family: 'Inter', sans-serif;
            background: #f1f5f9;
            color: #1e293b;
            margin: 0;
        }

        /* ── SIDEBAR ── */
        #sidebar {
            position: fixed;
            top: 0; left: 0;
            width: var(--sidebar-width);
            height: 100vh;
            background: var(--sidebar-bg);
            overflow-y: auto;
            z-index: 1040;
            transition: transform .3s ease;
            display: flex;
            flex-direction: column;
        }
        #sidebar .sidebar-brand {
            padding: 20px 22px 16px;
            border-bottom: 1px solid rgba(255,255,255,.07);
        }
        #sidebar .brand-logo {
            display: flex;
            align-items: center;
            gap: 12px;
            text-decoration: none;
        }
        #sidebar .brand-icon {
            width: 40px; height: 40px;
            background: var(--accent);
            border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            font-size: 18px; color: #fff;
        }
        #sidebar .brand-text {
            line-height: 1.2;
        }
        #sidebar .brand-name {
            font-size: 13px; font-weight: 700;
            color: #fff; display: block;
        }
        #sidebar .brand-sub {
            font-size: 10px; color: rgba(255,255,255,.4);
        }
        #sidebar .nav-section-title {
            font-size: 10px;
            font-weight: 600;
            color: rgba(255,255,255,.3);
            letter-spacing: 1px;
            text-transform: uppercase;
            padding: 20px 22px 6px;
        }
        #sidebar .nav-link {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 10px 22px;
            color: rgba(255,255,255,.65);
            text-decoration: none;
            font-size: 13.5px;
            font-weight: 500;
            border-radius: 0;
            transition: all .2s;
            position: relative;
        }
        #sidebar .nav-link:hover {
            background: var(--sidebar-hover);
            color: #fff;
        }
        #sidebar .nav-link.active {
            background: rgba(59,130,246,.15);
            color: #fff;
            font-weight: 600;
        }
        #sidebar .nav-link.active::before {
            content: '';
            position: absolute;
            left: 0; top: 0; bottom: 0;
            width: 3px;
            background: var(--accent);
            border-radius: 0 2px 2px 0;
        }
        #sidebar .nav-link .nav-icon {
            width: 20px;
            font-size: 14px;
            text-align: center;
            flex-shrink: 0;
        }
        #sidebar .nav-badge {
            margin-left: auto;
            background: var(--accent);
            color: #fff;
            font-size: 10px;
            padding: 1px 6px;
            border-radius: 20px;
            font-weight: 600;
        }
        #sidebar .sidebar-footer {
            margin-top: auto;
            padding: 16px 22px;
            border-top: 1px solid rgba(255,255,255,.07);
        }
        #sidebar .user-info {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        #sidebar .user-avatar {
            width: 34px; height: 34px;
            background: var(--accent);
            border-radius: 8px;
            display: flex; align-items: center; justify-content: center;
            font-size: 14px; font-weight: 700;
            color: #fff; flex-shrink: 0;
        }
        #sidebar .user-name {
            font-size: 12.5px; font-weight: 600;
            color: #fff;
        }
        #sidebar .user-role {
            font-size: 10.5px; color: rgba(255,255,255,.4);
            text-transform: capitalize;
        }

        /* ── MAIN CONTENT ── */
        #main-content {
            margin-left: var(--sidebar-width);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            transition: margin .3s ease;
        }

        /* ── TOPBAR ── */
        #topbar {
            position: sticky;
            top: 0;
            height: var(--topbar-height);
            background: #fff;
            border-bottom: 1px solid #e2e8f0;
            display: flex;
            align-items: center;
            padding: 0 28px;
            gap: 16px;
            z-index: 1030;
            box-shadow: 0 1px 3px rgba(0,0,0,.05);
        }
        #topbar .page-title {
            font-size: 16px;
            font-weight: 700;
            color: #0f172a;
            margin: 0;
        }
        #topbar .topbar-actions {
            margin-left: auto;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        #topbar .btn-icon {
            width: 36px; height: 36px;
            border: none;
            background: #f1f5f9;
            border-radius: 8px;
            display: flex; align-items: center; justify-content: center;
            color: #64748b;
            cursor: pointer;
            transition: background .2s;
            text-decoration: none;
        }
        #topbar .btn-icon:hover { background: #e2e8f0; color: #0f172a; }
        #topbar .topbar-user {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 5px 12px 5px 5px;
            border-radius: 10px;
            cursor: pointer;
            text-decoration: none;
            color: inherit;
        }
        #topbar .topbar-user:hover { background: #f1f5f9; }
        #topbar .topbar-avatar {
            width: 34px; height: 34px;
            background: var(--accent);
            border-radius: 8px;
            display: flex; align-items: center; justify-content: center;
            color: #fff; font-size: 13px; font-weight: 700;
        }
        .sidebar-toggle {
            display: none;
            background: none;
            border: none;
            font-size: 20px;
            color: #64748b;
            cursor: pointer;
        }

        /* ── PAGE BODY ── */
        .page-body {
            padding: 28px;
            flex: 1;
        }

        /* ── CARDS ── */
        .stat-card {
            background: #fff;
            border-radius: 14px;
            padding: 22px 24px;
            border: 1px solid #e2e8f0;
            transition: box-shadow .2s, transform .2s;
        }
        .stat-card:hover {
            box-shadow: 0 8px 30px rgba(0,0,0,.08);
            transform: translateY(-2px);
        }
        .stat-icon {
            width: 48px; height: 48px;
            border-radius: 12px;
            display: flex; align-items: center; justify-content: center;
            font-size: 20px;
            flex-shrink: 0;
        }
        .stat-value { font-size: 28px; font-weight: 800; color: #0f172a; }
        .stat-label { font-size: 13px; color: #64748b; font-weight: 500; margin-top: 2px; }
        .stat-trend { font-size: 12px; font-weight: 600; margin-top: 6px; }

        .card-panel {
            background: #fff;
            border-radius: 14px;
            border: 1px solid #e2e8f0;
            overflow: hidden;
        }
        .card-panel .card-header-custom {
            padding: 16px 20px;
            border-bottom: 1px solid #f1f5f9;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .card-panel .card-title-custom {
            font-size: 14px;
            font-weight: 700;
            color: #0f172a;
            margin: 0;
        }

        /* ── TABLE ── */
        .table-modern { font-size: 13.5px; }
        .table-modern thead th {
            background: #f8fafc;
            font-weight: 600;
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: .5px;
            color: #64748b;
            border-bottom: 1px solid #e2e8f0;
            padding: 11px 14px;
        }
        .table-modern tbody td {
            padding: 12px 14px;
            vertical-align: middle;
            border-color: #f1f5f9;
            color: #334155;
        }
        .table-modern tbody tr:hover { background: #f8fafc; }

        /* ── BADGES ── */
        .badge-status {
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 0;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
        }
        .badge-status::before {
            font-size: 11px;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }
        .badge-active            { background: #dcfce7; }
        .badge-active::before    { content: '● Inside'; color: #16a34a; }
        .badge-completed         { background: #f1f5f9; }
        .badge-completed::before { content: '● Out';    color: #94a3b8; }
        .badge-pending           { background: #fef9c3; }
        .badge-pending::before   { content: '● Pending'; color: #b45309; }
        .badge-rejected          { background: #fee2e2; }
        .badge-rejected::before  { content: '● Rejected'; color: #dc2626; }
        .badge-occupied  { background: #dcfce7; color: #16a34a; font-size: 11px; }
        .badge-vacant    { background: #f1f5f9; color: #64748b; font-size: 11px; }

        /* ── FORMS ── */
        .form-label { font-size: 13px; font-weight: 600; color: #374151; margin-bottom: 5px; }
        .form-control, .form-select {
            font-size: 13.5px;
            border-radius: 8px;
            border-color: #d1d5db;
            padding: 9px 12px;
        }
        .form-control:focus, .form-select:focus {
            border-color: var(--accent);
            box-shadow: 0 0 0 3px rgba(59,130,246,.15);
        }

        /* ── BUTTONS ── */
        .btn { font-size: 13px; font-weight: 600; border-radius: 8px; }
        .btn-primary { background: var(--accent); border-color: var(--accent); }
        .btn-primary:hover { background: #2563eb; border-color: #2563eb; }
        .btn-sm { padding: 5px 12px; font-size: 12px; }

        /* ── ALERTS ── */
        .alert { border-radius: 10px; font-size: 13.5px; border: none; }
        .alert-success { background: #f0fdf4; color: #15803d; }
        .alert-danger   { background: #fef2f2; color: #dc2626; }
        .alert-warning  { background: #fffbeb; color: #d97706; }
        .alert-info     { background: #eff6ff; color: #2563eb; }

        /* ── VISITOR AVATAR ── */
        .visitor-avatar {
            width: 36px; height: 36px;
            border-radius: 8px;
            object-fit: cover;
        }
        .visitor-avatar-placeholder {
            width: 36px; height: 36px;
            border-radius: 8px;
            background: #e2e8f0;
            display: flex; align-items: center; justify-content: center;
            font-size: 14px; color: #94a3b8;
        }

        /* ── RESPONSIVE ── */
        @media (max-width: 991.98px) {
            #sidebar { transform: translateX(-100%); }
            #sidebar.show { transform: translateX(0); }
            #main-content { margin-left: 0; }
            .sidebar-toggle { display: block; }
            .page-body { padding: 16px; }
        }

        /* ── DARK MODE ── */
        [data-theme="dark"] {
            --sidebar-bg: #0d1117;
        }
        [data-theme="dark"] body {
            background: #0d1117;
            color: #e2e8f0;
        }
        [data-theme="dark"] #topbar,
        [data-theme="dark"] .stat-card,
        [data-theme="dark"] .card-panel {
            background: #161b22;
            border-color: #30363d;
            color: #e2e8f0;
        }
        [data-theme="dark"] .table-modern thead th { background: #21262d; color: #8b949e; border-color: #30363d; }
        [data-theme="dark"] .table-modern tbody td { border-color: #21262d; color: #c9d1d9; }
        [data-theme="dark"] .table-modern tbody tr:hover { background: #21262d; }
        [data-theme="dark"] .stat-value { color: #e2e8f0; }
        [data-theme="dark"] .page-title { color: #e2e8f0; }
        [data-theme="dark"] .form-control,
        [data-theme="dark"] .form-select { background: #21262d; border-color: #30363d; color: #e2e8f0; }
        [data-theme="dark"] .card-panel .card-header-custom { border-color: #21262d; }
        [data-theme="dark"] .card-title-custom { color: #e2e8f0; }
        [data-theme="dark"] #topbar .page-title { color: #e2e8f0; }
        [data-theme="dark"] .topbar-user { color: #e2e8f0; }
        [data-theme="dark"] .btn-icon { background: #21262d; color: #8b949e; }
        [data-theme="dark"] .btn-icon:hover { background: #30363d; color: #e2e8f0; }

        /* ── SIDEBAR OVERLAY ── */
        .sidebar-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,.4);
            z-index: 1039;
        }
        .sidebar-overlay.show { display: block; }

        /* Scrollbar */
        #sidebar::-webkit-scrollbar { width: 4px; }
        #sidebar::-webkit-scrollbar-track { background: transparent; }
        #sidebar::-webkit-scrollbar-thumb { background: rgba(255,255,255,.1); border-radius: 2px; }
    </style>
    @stack('styles')
</head>
<body>

<!-- Sidebar Overlay (mobile) -->
<div class="sidebar-overlay" id="sidebarOverlay"></div>

<!-- ═══════════ SIDEBAR ═══════════ -->
<nav id="sidebar">
    <div class="sidebar-brand">
        <a href="{{ auth()->user()->role === 'admin' ? route('admin.dashboard') : (auth()->user()->role === 'guard' ? route('guard.dashboard') : route('tenant.dashboard')) }}" class="brand-logo">
            <div class="brand-icon"><i class="fas fa-building"></i></div>
            <div class="brand-text">
                <span class="brand-name">AVMS</span>
                <span class="brand-sub">Visitor Management</span>
            </div>
        </a>
    </div>

    <div class="flex-fill">
        @if(auth()->user()->role === 'admin')
            @include('layouts.partials.sidebar-admin')
        @elseif(auth()->user()->role === 'guard')
            @include('layouts.partials.sidebar-guard')
        @else
            @include('layouts.partials.sidebar-tenant')
        @endif
    </div>

    <div class="sidebar-footer">
        <div class="user-info">
            <div class="user-avatar">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</div>
            <div>
                <div class="user-name">{{ Str::limit(auth()->user()->name, 18) }}</div>
                <div class="user-role">{{ ucfirst(auth()->user()->role) }}</div>
            </div>
        </div>
    </div>
</nav>

<!-- ═══════════ MAIN CONTENT ═══════════ -->
<div id="main-content">
    <!-- TOPBAR -->
    <div id="topbar">
        <button class="sidebar-toggle" id="sidebarToggle">
            <i class="fas fa-bars"></i>
        </button>
        <h1 class="page-title">@yield('page-title', 'Dashboard')</h1>

        <div class="topbar-actions">
            <!-- Dark Mode Toggle -->
            <button class="btn-icon" id="darkModeToggle" title="Toggle dark mode">
                <i class="fas fa-moon" id="darkModeIcon"></i>
            </button>

            <!-- Notifications -->
            @php $pendingCount = 0;
            if(auth()->user()->role === 'tenant' && auth()->user()->tenant) {
                $pendingCount = \App\Models\Visit::where('tenant_id', auth()->user()->tenant->id)->where('status','pending')->count();
            }
            @endphp
            @if($pendingCount > 0)
            <a href="{{ route('tenant.visits.index') }}" class="btn-icon position-relative" title="Pending approvals">
                <i class="fas fa-bell"></i>
                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="font-size:9px">{{ $pendingCount }}</span>
            </a>
            @endif

            <!-- User Dropdown -->
            <div class="dropdown">
                <a href="#" class="topbar-user dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false" style="text-decoration:none; color:inherit;">
                    <div class="topbar-avatar">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</div>
                    <div>
                        <div style="font-size:13px; font-weight:600; color:#0f172a">{{ Str::limit(auth()->user()->name, 16) }}</div>
                        <div style="font-size:11px; color:#64748b">{{ ucfirst(auth()->user()->role) }}</div>
                    </div>
                </a>
                <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0" style="border-radius:12px; min-width:180px; margin-top:8px;">
                    <li>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="dropdown-item text-danger">
                                <i class="fas fa-sign-out-alt me-2"></i>Logout
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
        </div>
    </div>

    <!-- PAGE BODY -->
    <div class="page-body">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
                <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
                <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @yield('content')
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Sidebar toggle (mobile)
    const sidebarToggle = document.getElementById('sidebarToggle');
    const sidebar       = document.getElementById('sidebar');
    const overlay       = document.getElementById('sidebarOverlay');

    sidebarToggle?.addEventListener('click', () => {
        sidebar.classList.toggle('show');
        overlay.classList.toggle('show');
    });
    overlay?.addEventListener('click', () => {
        sidebar.classList.remove('show');
        overlay.classList.remove('show');
    });

    // Dark mode
    const html      = document.documentElement;
    const dmToggle  = document.getElementById('darkModeToggle');
    const dmIcon    = document.getElementById('darkModeIcon');
    const savedTheme = localStorage.getItem('avms-theme') || 'light';
    if (savedTheme === 'dark') {
        html.setAttribute('data-theme', 'dark');
        dmIcon.classList.replace('fa-moon', 'fa-sun');
    }
    dmToggle?.addEventListener('click', () => {
        const isDark = html.getAttribute('data-theme') === 'dark';
        html.setAttribute('data-theme', isDark ? 'light' : 'dark');
        dmIcon.classList.toggle('fa-moon', isDark);
        dmIcon.classList.toggle('fa-sun', !isDark);
        localStorage.setItem('avms-theme', isDark ? 'light' : 'dark');
    });

    // Auto-dismiss alerts
    setTimeout(() => {
        document.querySelectorAll('.alert').forEach(a => {
            bootstrap.Alert.getOrCreateInstance(a)?.close();
        });
    }, 5000);
</script>
@stack('scripts')
</body>
</html>
