<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Recruitment System') — KMail Software</title>

    <!-- Bootstrap 5 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <!-- Google Fonts (Noto Sans Myanmar + Inter) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Noto+Sans+Myanmar:wght@400;500;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --sidebar-width: 260px;
            --primary: #1a56db;
            --primary-dark: #1648c6;
            --sidebar-bg: #1e2a3a;
            --sidebar-text: #c8d3e0;
            --sidebar-hover: rgba(255,255,255,0.07);
            --sidebar-active: rgba(26,86,219,0.25);
            --sidebar-active-border: #1a56db;
        }

        body {
            font-family: 'Inter', 'Noto Sans Myanmar', sans-serif;
            background-color: #f0f4f8;
            color: #1e293b;
        }

        /* ── Sidebar ────────────────── */
        #sidebar {
            width: var(--sidebar-width);
            min-height: 100vh;
            background: var(--sidebar-bg);
            position: fixed;
            top: 0; left: 0;
            z-index: 1000;
            display: flex;
            flex-direction: column;
            transition: transform .25s ease;
        }

        .sidebar-brand {
            padding: 1.25rem 1.5rem;
            border-bottom: 1px solid rgba(255,255,255,0.07);
        }

        .sidebar-brand .brand-name {
            font-size: .85rem;
            font-weight: 700;
            color: #fff;
            line-height: 1.2;
        }

        .sidebar-brand .brand-sub {
            font-size: .7rem;
            color: var(--sidebar-text);
        }

        .sidebar-nav { padding: .75rem 0; flex: 1; }

        .sidebar-section-title {
            font-size: .65rem;
            font-weight: 700;
            letter-spacing: .08em;
            text-transform: uppercase;
            color: rgba(200,211,224,.45);
            padding: .75rem 1.5rem .25rem;
        }

        .sidebar-nav .nav-link {
            display: flex;
            align-items: center;
            gap: .65rem;
            padding: .55rem 1.5rem;
            color: var(--sidebar-text);
            font-size: .875rem;
            border-left: 3px solid transparent;
            transition: background .15s, color .15s;
        }

        .sidebar-nav .nav-link:hover {
            background: var(--sidebar-hover);
            color: #fff;
        }

        .sidebar-nav .nav-link.active {
            background: var(--sidebar-active);
            border-left-color: var(--sidebar-active-border);
            color: #fff;
        }

        .sidebar-nav .nav-link i { font-size: 1rem; opacity: .8; }

        .sidebar-footer {
            padding: 1rem 1.5rem;
            border-top: 1px solid rgba(255,255,255,0.07);
            font-size: .8rem;
            color: var(--sidebar-text);
        }

        /* ── Main Content ─────────────── */
        #main {
            margin-left: var(--sidebar-width);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        #topbar {
            background: #fff;
            border-bottom: 1px solid #e2e8f0;
            padding: .75rem 1.5rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky;
            top: 0;
            z-index: 900;
        }

        .page-content { padding: 1.5rem; flex: 1; }

        /* ── Cards ───────────────────── */
        .card {
            border: 1px solid #e2e8f0;
            border-radius: .75rem;
            box-shadow: 0 1px 3px rgba(0,0,0,.05);
        }

        .card-header {
            background: #fff;
            border-bottom: 1px solid #e2e8f0;
            padding: 1rem 1.25rem;
            font-weight: 600;
            border-radius: .75rem .75rem 0 0 !important;
        }

        /* ── Stat Cards ──────────────── */
        .stat-card {
            border-radius: .75rem;
            padding: 1.25rem;
            color: #fff;
            position: relative;
            overflow: hidden;
        }

        .stat-card::after {
            content: '';
            position: absolute;
            top: -20px; right: -20px;
            width: 100px; height: 100px;
            border-radius: 50%;
            background: rgba(255,255,255,.08);
        }

        .stat-card .stat-value { font-size: 2rem; font-weight: 700; line-height: 1; }
        .stat-card .stat-label { font-size: .8rem; opacity: .85; margin-top: .35rem; }
        .stat-card .stat-icon { font-size: 2rem; opacity: .3; }

        /* ── Buttons ─────────────────── */
        .btn-primary { background: var(--primary); border-color: var(--primary); }
        .btn-primary:hover { background: var(--primary-dark); border-color: var(--primary-dark); }

        /* ── Badge overrides ─────────── */
        .badge { font-size: .72rem; padding: .35em .65em; border-radius: .4rem; }

        /* ── Table ───────────────────── */
        .table th {
            font-size: .78rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: .04em;
            color: #64748b;
            background: #f8fafc;
        }

        /* ── Quota bar ───────────────── */
        .quota-bar { height: 8px; border-radius: 4px; }

        /* ── Myanmar font helper ──────── */
        .myanmar { font-family: 'Noto Sans Myanmar', sans-serif; }

        @media (max-width: 768px) {
            #sidebar { transform: translateX(-100%); }
            #sidebar.show { transform: translateX(0); }
            #main { margin-left: 0; }
        }
    </style>

    @stack('styles')
</head>
<body>

{{-- ─── Sidebar ──────────────────────────────────── --}}
<nav id="sidebar">
    <div class="sidebar-brand">
        <div class="d-flex align-items-center gap-2 mb-1">
            <div style="background:#1a56db;border-radius:6px;width:32px;height:32px;display:flex;align-items:center;justify-content:center;">
                <i class="bi bi-people-fill text-white" style="font-size:.9rem;"></i>
            </div>
            <div>
                <div class="brand-name">Recruitment System</div>
                <div class="brand-sub myanmar">KMail Software</div>
            </div>
        </div>
    </div>

    <div class="sidebar-nav">
        <span class="sidebar-section-title">Main</span>
        <a href="{{ route('dashboard') }}"
           class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
            <i class="bi bi-grid-1x2-fill"></i>
            <span>Dashboard</span>
        </a>

        <span class="sidebar-section-title mt-2">Jobs / အလုပ်</span>
        <a href="{{ route('job-orders.index') }}"
           class="nav-link {{ request()->routeIs('job-orders.*') ? 'active' : '' }}">
            <i class="bi bi-briefcase-fill"></i>
            <span>Job Orders <span class="myanmar">/ အလုပ်ခေါ်စာများ</span></span>
        </a>

        <span class="sidebar-section-title mt-2">People / လူများ</span>
        <a href="{{ route('candidates.index') }}"
           class="nav-link {{ request()->routeIs('candidates.*') ? 'active' : '' }}">
            <i class="bi bi-person-lines-fill"></i>
            <span>Candidates <span class="myanmar">/ လျှောက်ထားသူများ</span></span>
        </a>

        <span class="sidebar-section-title mt-2">Finance / ငွေကြေး</span>
        <a href="{{ route('deposits.index') }}"
           class="nav-link {{ request()->routeIs('deposits.*') ? 'active' : '' }}">
            <i class="bi bi-cash-coin"></i>
            <span>Deposits <span class="myanmar">/ အပ်ငွေများ</span></span>
        </a>
        <a href="{{ route('deposits.index', ['status' => 'pending']) }}"
           class="nav-link">
            <i class="bi bi-hourglass-split"></i>
            <span>Pending Payments</span>
        </a>
    </div>

    <div class="sidebar-footer">
        <div class="d-flex align-items-center gap-2">
            <div style="width:32px;height:32px;background:#2d3f54;border-radius:50%;display:flex;align-items:center;justify-content:center;">
                <i class="bi bi-person text-light" style="font-size:.8rem;"></i>
            </div>
            <div style="overflow:hidden;">
                <div style="font-size:.8rem;color:#e2e8f0;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">
                    {{ auth()->user()->name ?? 'Admin' }}
                </div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn btn-link p-0"
                        style="font-size:.7rem;color:#94a3b8;text-decoration:none;">
                        <i class="bi bi-box-arrow-right me-1"></i>Logout
                    </button>
                </form>
            </div>
        </div>
    </div>
</nav>

{{-- ─── Main ─────────────────────────────────────── --}}
<div id="main">
    <div id="topbar">
        <div class="d-flex align-items-center gap-3">
            <button class="btn btn-sm btn-outline-secondary d-md-none" id="sidebarToggle">
                <i class="bi bi-list"></i>
            </button>
            <h6 class="mb-0 fw-semibold">@yield('page-title', 'Dashboard')</h6>
        </div>
        <div class="d-flex align-items-center gap-2">
            @if(auth()->user())
                <span class="badge bg-primary-subtle text-primary">
                    {{ ucfirst(str_replace('_', ' ', auth()->user()->role)) }}
                </span>
            @endif
        </div>
    </div>

    <div class="page-content">
        {{-- Flash messages --}}
        @foreach(['success' => 'success', 'error' => 'danger', 'info' => 'info', 'warning' => 'warning'] as $type => $class)
            @if(session($type))
                <div class="alert alert-{{ $class }} alert-dismissible fade show mb-3" role="alert">
                    <i class="bi bi-{{ $type === 'success' ? 'check-circle' : ($type === 'error' ? 'x-circle' : 'info-circle') }}-fill me-2"></i>
                    {{ session($type) }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
        @endforeach

        @if($errors->any())
            <div class="alert alert-danger alert-dismissible fade show mb-3">
                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                <strong>Please fix the following errors:</strong>
                <ul class="mb-0 mt-1">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @yield('content')
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.getElementById('sidebarToggle')?.addEventListener('click', () => {
        document.getElementById('sidebar').classList.toggle('show');
    });
</script>
@stack('scripts')
</body>
</html>