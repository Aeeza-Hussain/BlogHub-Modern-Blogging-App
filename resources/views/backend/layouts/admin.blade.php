<!DOCTYPE html>
<html lang="en">
<head>
    <title>@yield('title', 'BlogHub Admin')</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- FontAwesome -->
    <script defer src="{{ asset('backend/assets/plugins/fontawesome/js/all.min.js') }}"></script>

    <!-- Bootstrap -->
    <link rel="stylesheet" href="{{ asset('backend/assets/plugins/bootstrap/css/bootstrap.min.css') }}">

    <style>
        :root {
            --brand:        #C8461F;
            --brand-dark:   #a3360f;
            --brand-light:  rgba(200,70,31,0.08);
            --sidebar-w:    256px;
            --header-h:     60px;
            --bg:           #f4f6f9;
            --surface:      #ffffff;
            --border:       #e5e9f0;
            --text-primary: #111827;
            --text-muted:   #6b7280;
            --text-light:   #9ca3af;
            --radius:       10px;
            --shadow:       0 1px 3px rgba(0,0,0,0.07), 0 1px 2px rgba(0,0,0,0.04);
            --shadow-md:    0 4px 16px rgba(0,0,0,0.08);
        }

        * { box-sizing: border-box; }
        body {
            font-family: 'Inter', sans-serif;
            background: var(--bg);
            color: var(--text-primary);
            margin: 0;
            font-size: 14px;
        }

        /* ===== TOPBAR ===== */
        .bh-topbar {
            position: fixed;
            top: 0; left: 0; right: 0;
            height: var(--header-h);
            background: var(--surface);
            border-bottom: 1px solid var(--border);
            z-index: 1040;
            display: flex;
            align-items: center;
            padding: 0 1.25rem 0 0;
            box-shadow: var(--shadow);
        }

        .bh-brand {
            width: var(--sidebar-w);
            flex-shrink: 0;
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 0 1.25rem;
            text-decoration: none;
        }
        .bh-brand-icon {
            width: 34px; height: 34px;
            background: linear-gradient(135deg, var(--brand), #ea580c);
            border-radius: 8px;
            display: flex; align-items: center; justify-content: center;
            color: #fff; font-size: 0.9rem;
            box-shadow: 0 3px 8px rgba(200,70,31,0.3);
            flex-shrink: 0;
        }
        .bh-brand-name {
            font-size: 1.05rem; font-weight: 800;
            color: var(--text-primary); letter-spacing: -0.3px;
        }
        .bh-brand-name span { color: var(--brand); }

        .bh-topbar-center { flex: 1; padding: 0 1rem; }
        .bh-search-form { position: relative; max-width: 340px; }
        .bh-search-form input {
            background: var(--bg);
            border: 1px solid var(--border);
            border-radius: 8px;
            padding: 7px 14px 7px 36px;
            font-size: 0.84rem;
            width: 100%;
            outline: none;
            color: var(--text-primary);
            transition: border-color .2s;
        }
        .bh-search-form input:focus { border-color: var(--brand); background: #fff; }
        .bh-search-form .search-icon {
            position: absolute; left: 11px; top: 50%; transform: translateY(-50%);
            color: var(--text-muted); font-size: 0.78rem;
        }

        .bh-topbar-actions { display: flex; align-items: center; gap: 6px; }

        .bh-icon-btn {
            width: 36px; height: 36px;
            border-radius: 8px;
            border: none; background: transparent;
            color: var(--text-muted);
            display: flex; align-items: center; justify-content: center;
            cursor: pointer; transition: background .2s, color .2s;
            position: relative; text-decoration: none;
            font-size: 0.92rem;
        }
        .bh-icon-btn:hover { background: var(--bg); color: var(--text-primary); }
        .bh-notif-dot {
            position: absolute; top: 6px; right: 6px;
            width: 7px; height: 7px;
            background: var(--brand); border-radius: 50%;
            border: 1.5px solid #fff;
        }

        .bh-user-btn {
            display: flex; align-items: center; gap: 8px;
            padding: 4px 10px 4px 4px;
            border-radius: 8px;
            border: 1px solid var(--border);
            background: transparent; cursor: pointer;
            transition: background .2s;
            text-decoration: none; color: inherit;
        }
        .bh-user-btn:hover { background: var(--bg); }
        .bh-user-btn img {
            width: 30px; height: 30px;
            border-radius: 50%; object-fit: cover;
        }
        .bh-user-name { font-size: 0.82rem; font-weight: 600; color: var(--text-primary); }
        .bh-user-role { font-size: 0.7rem; color: var(--text-muted); }

        .bh-mobile-toggle {
            display: none; background: none; border: none;
            font-size: 1.1rem; color: var(--text-primary);
            cursor: pointer; padding: 6px; margin-right: 4px;
        }

        /* ===== SIDEBAR ===== */
        .bh-sidebar {
            position: fixed;
            top: var(--header-h); left: 0; bottom: 0;
            width: var(--sidebar-w);
            background: var(--surface);
            border-right: 1px solid var(--border);
            overflow-y: auto;
            z-index: 1030;
            display: flex; flex-direction: column;
            padding: 0.75rem 0.75rem 1.5rem;
            scrollbar-width: thin;
            scrollbar-color: var(--border) transparent;
            transition: transform .25s ease;
        }
        .bh-sidebar::-webkit-scrollbar { width: 4px; }
        .bh-sidebar::-webkit-scrollbar-thumb { background: var(--border); border-radius: 2px; }

        .bh-nav-label {
            font-size: 0.66rem; font-weight: 700; letter-spacing: .08em;
            text-transform: uppercase; color: var(--text-light);
            padding: 1.1rem 0.5rem 0.35rem;
        }

        .bh-nav-link {
            display: flex; align-items: center; gap: 9px;
            padding: 8px 10px;
            border-radius: 7px;
            color: var(--text-muted);
            text-decoration: none;
            font-size: 0.84rem; font-weight: 500;
            transition: background .15s, color .15s;
            margin-bottom: 1px;
        }
        .bh-nav-link:hover { background: var(--bg); color: var(--text-primary); }
        .bh-nav-link.active {
            background: var(--brand-light);
            color: var(--brand);
            font-weight: 600;
        }
        .bh-nav-link .nav-icon {
            width: 18px; text-align: center; font-size: 0.82rem; flex-shrink: 0;
        }
        .bh-nav-link .nav-badge {
            margin-left: auto;
            font-size: 0.62rem; font-weight: 700;
            background: var(--brand); color: #fff;
            padding: 1px 6px; border-radius: 10px;
        }

        /* ===== SIDEBAR DROPDOWNS ===== */
        .bh-nav-group {
            margin-bottom: 2px;
        }
        .bh-nav-dropdown-toggle {
            display: flex;
            align-items: center;
            gap: 9px;
            width: 100%;
            padding: 8px 10px;
            border-radius: 7px;
            color: var(--text-muted);
            background: transparent;
            border: none;
            cursor: pointer;
            font-size: 0.84rem;
            font-weight: 500;
            text-align: left;
            transition: background .15s, color .15s;
        }
        .bh-nav-dropdown-toggle:hover {
            background: var(--bg);
            color: var(--text-primary);
        }
        .bh-nav-dropdown-toggle.active-parent {
            color: var(--brand);
            font-weight: 600;
            background: rgba(200,70,31,0.05);
        }
        .bh-nav-dropdown-toggle .nav-icon {
            width: 18px;
            text-align: center;
            font-size: 0.82rem;
            flex-shrink: 0;
        }
        .bh-nav-dropdown-toggle .nav-text {
            flex: 1;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        .bh-nav-dropdown-toggle .nav-chevron {
            font-size: 0.65rem;
            color: var(--text-light);
            margin-left: auto;
            transition: transform .25s ease, color .15s;
        }
        .bh-nav-group.open > .bh-nav-dropdown-toggle .nav-chevron {
            transform: rotate(180deg);
            color: var(--brand);
        }
        .bh-nav-group.open > .bh-nav-dropdown-toggle {
            color: var(--text-primary);
            font-weight: 600;
        }

        .bh-nav-dropdown-menu {
            display: none;
            flex-direction: column;
            gap: 2px;
            padding: 4px 0 6px 10px;
            margin: 2px 0 4px 17px;
            border-left: 1.5px solid var(--border);
        }
        .bh-nav-group.open > .bh-nav-dropdown-menu {
            display: flex;
        }

        .bh-nav-sublink {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 6px 10px;
            border-radius: 6px;
            color: var(--text-muted);
            text-decoration: none;
            font-size: 0.81rem;
            font-weight: 500;
            transition: background .15s, color .15s;
        }
        .bh-nav-sublink:hover {
            background: var(--bg);
            color: var(--text-primary);
        }
        .bh-nav-sublink.active {
            background: var(--brand-light);
            color: var(--brand);
            font-weight: 600;
        }
        .bh-nav-sublink .sublink-dot {
            width: 5px;
            height: 5px;
            border-radius: 50%;
            background: var(--text-light);
            flex-shrink: 0;
            transition: background .15s, transform .15s;
        }
        .bh-nav-sublink:hover .sublink-dot {
            background: var(--brand);
            transform: scale(1.2);
        }
        .bh-nav-sublink.active .sublink-dot {
            background: var(--brand);
            transform: scale(1.3);
        }
        .bh-nav-sublink .sublink-badge {
            margin-left: auto;
            font-size: 0.6rem;
            font-weight: 700;
            padding: 1px 6px;
            border-radius: 10px;
        }

        /* ===== MAIN CONTENT ===== */
        .bh-main {
            margin-left: var(--sidebar-w);
            margin-top: var(--header-h);
            padding: 1.75rem;
            min-height: calc(100vh - var(--header-h));
        }

        /* ===== PAGE HEADER ===== */
        .bh-page-header {
            display: flex; align-items: center;
            justify-content: space-between;
            margin-bottom: 1.5rem; gap: 1rem;
            flex-wrap: wrap;
        }
        .bh-page-title { font-size: 1.35rem; font-weight: 700; color: var(--text-primary); margin: 0; }
        .bh-page-sub  { font-size: 0.8rem; color: var(--text-muted); margin: 2px 0 0; }

        /* ===== CARDS ===== */
        .bh-card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            box-shadow: var(--shadow);
        }
        .bh-card-header {
            display: flex; align-items: center; justify-content: space-between;
            padding: 1rem 1.25rem;
            border-bottom: 1px solid var(--border);
        }
        .bh-card-title { font-size: 0.88rem; font-weight: 700; color: var(--text-primary); margin: 0; }
        .bh-card-body { padding: 1.25rem; }

        /* ===== STAT CARDS ===== */
        .bh-stat {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            padding: 1.25rem;
            display: flex; align-items: center; gap: 1rem;
            box-shadow: var(--shadow);
            transition: box-shadow .2s, transform .2s;
            text-decoration: none; color: inherit;
        }
        .bh-stat:hover { box-shadow: var(--shadow-md); transform: translateY(-2px); }
        .bh-stat-icon {
            width: 46px; height: 46px; border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.1rem; flex-shrink: 0;
        }
        .bh-stat-num { font-size: 1.55rem; font-weight: 800; line-height: 1; color: var(--text-primary); }
        .bh-stat-label { font-size: 0.75rem; color: var(--text-muted); margin-top: 3px; }

        /* ===== ALERTS ===== */
        .bh-alert {
            display: flex; align-items: center; gap: 10px;
            padding: 12px 14px;
            border-radius: var(--radius);
            font-size: 0.84rem; margin-bottom: 1.25rem;
        }
        .bh-alert-success { background: #f0fdf4; border: 1px solid #bbf7d0; color: #15803d; }
        .bh-alert-error   { background: #fef2f2; border: 1px solid #fecaca; color: #dc2626; }

        /* ===== TABLES ===== */
        .bh-table { width: 100%; border-collapse: collapse; }
        .bh-table th {
            font-size: 0.71rem; font-weight: 700; text-transform: uppercase;
            letter-spacing: .05em; color: var(--text-muted);
            padding: 10px 14px; background: #f8fafc;
            border-bottom: 1px solid var(--border);
            white-space: nowrap;
        }
        .bh-table td {
            padding: 11px 14px;
            border-bottom: 1px solid var(--border);
            font-size: 0.84rem; vertical-align: middle;
        }
        .bh-table tbody tr:last-child td { border-bottom: none; }
        .bh-table tbody tr:hover { background: #fafbfc; }

        /* ===== BUTTONS ===== */
        .bh-btn {
            display: inline-flex; align-items: center; gap: 6px;
            padding: 7px 14px; border-radius: 7px;
            font-size: 0.82rem; font-weight: 600;
            border: none; cursor: pointer; transition: all .15s;
            text-decoration: none;
        }
        .bh-btn-primary { background: var(--brand); color: #fff; }
        .bh-btn-primary:hover { background: var(--brand-dark); color: #fff; }
        .bh-btn-ghost {
            background: transparent; color: var(--text-muted);
            border: 1px solid var(--border);
        }
        .bh-btn-ghost:hover { background: var(--bg); color: var(--text-primary); }
        .bh-btn-sm { padding: 5px 10px; font-size: 0.78rem; }
        .bh-btn-icon {
            width: 30px; height: 30px; padding: 0;
            border-radius: 6px; justify-content: center;
        }

        /* ===== BADGE ===== */
        .bh-badge {
            display: inline-flex; align-items: center;
            padding: 2px 8px; border-radius: 20px;
            font-size: 0.7rem; font-weight: 600;
        }

        /* ===== FOOTER ===== */
        .bh-footer {
            text-align: center;
            padding: 1rem;
            font-size: 0.75rem;
            color: var(--text-light);
            border-top: 1px solid var(--border);
            margin-top: 2rem;
        }

        /* ===== DROPDOWN ===== */
        .bh-dropdown { position: relative; }
        .bh-dropdown-menu {
            position: absolute; right: 0; top: calc(100% + 6px);
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            box-shadow: var(--shadow-md);
            min-width: 200px; z-index: 1060;
            overflow: hidden;
            display: none;
        }
        .bh-dropdown-menu.show { display: block; }
        .bh-dropdown-item {
            display: flex; align-items: center; gap: 9px;
            padding: 9px 14px;
            font-size: 0.82rem; color: var(--text-primary);
            text-decoration: none; cursor: pointer;
            border: none; background: transparent; width: 100%;
            transition: background .15s;
        }
        .bh-dropdown-item:hover { background: var(--bg); }
        .bh-dropdown-item.text-danger { color: #dc2626; }
        .bh-dropdown-divider { border-top: 1px solid var(--border); margin: 4px 0; }

        /* ===== RESPONSIVE ===== */
        @media (max-width: 991px) {
            .bh-sidebar { transform: translateX(-100%); }
            .bh-sidebar.open { transform: translateX(0); }
            .bh-main { margin-left: 0; }
            .bh-brand { display: none; }
            .bh-mobile-toggle { display: block; }
            .bh-page-title { font-size: 1.1rem; }
        }
        @media (max-width: 575px) {
            .bh-main { padding: 1rem; }
            .bh-topbar-center { display: none; }
        }

        /* OVERLAY for mobile sidebar */
        .bh-overlay {
            display: none; position: fixed; inset: 0;
            background: rgba(0,0,0,0.35); z-index: 1025;
        }
        .bh-overlay.show { display: block; }
    </style>

    @yield('styles')
</head>
<body>

{{-- ====== TOPBAR ====== --}}
<header class="bh-topbar">
    {{-- Brand --}}
    <a class="bh-brand" href="{{ route('dashboard.index') }}">
        <div class="bh-brand-icon"><i class="fa-solid fa-feather-alt"></i></div>
        <div class="bh-brand-name">Blog<span>Hub</span></div>
    </a>

    {{-- Mobile toggle --}}
    <button class="bh-mobile-toggle" id="sidebarToggle" aria-label="Toggle sidebar">
        <i class="fa-solid fa-bars"></i>
    </button>

    {{-- Search --}}
    <div class="bh-topbar-center">
        <form class="bh-search-form" action="{{ route('dashboard.all-articles') }}" method="GET">
            <i class="fa-solid fa-search search-icon"></i>
            <input type="text" name="search" placeholder="Search articles..." value="{{ request('search') }}">
        </form>
    </div>

    {{-- Actions --}}
    <div class="bh-topbar-actions">
        {{-- Quick Create Dropdown --}}
        <div class="bh-dropdown">
            <button class="bh-btn bh-btn-primary bh-btn-sm" id="topbarCreateBtn" type="button" style="border-radius:8px;">
                <i class="fa-solid fa-plus"></i> <span class="d-none d-sm-inline">Create</span>
                <i class="fa-solid fa-chevron-down ms-1" style="font-size:0.6rem; opacity:0.8;"></i>
            </button>
            <div class="bh-dropdown-menu" id="topbarCreateMenu" style="min-width: 190px;">
                <a href="{{ route('blogs.create') }}" class="bh-dropdown-item">
                    <i class="fa-solid fa-pen-nib text-primary" style="width:16px;"></i> Write Article
                </a>
                @if((auth()->user()->user_type ?? 1) == 1)
                <a href="{{ route('dashboard.website.section', 'topics') }}" class="bh-dropdown-item">
                    <i class="fa-solid fa-shapes text-success" style="width:16px;"></i> Manage Topics
                </a>
                <a href="{{ route('dashboard.website.section', 'authors') }}" class="bh-dropdown-item">
                    <i class="fa-solid fa-user-pen text-info" style="width:16px;"></i> Manage Authors
                </a>
                @endif
                <div class="bh-dropdown-divider"></div>
                <a href="{{ route('home') }}" target="_blank" class="bh-dropdown-item">
                    <i class="fa-solid fa-arrow-up-right-from-square text-muted" style="width:16px;"></i> Visit Website
                </a>
            </div>
        </div>

        {{-- View Site --}}
        <a href="{{ route('home') }}" target="_blank" class="bh-icon-btn" title="View website">
            <i class="fa-solid fa-globe"></i>
        </a>

        {{-- Notifications --}}
        <a href="{{ route('dashboard.notifications') }}" class="bh-icon-btn" title="Notifications">
            <i class="fa-solid fa-bell"></i>
            <span class="bh-notif-dot"></span>
        </a>

        {{-- User dropdown --}}
        <div class="bh-dropdown">
            <button class="bh-user-btn" id="userDropdownBtn" type="button">
                <img src="{{ auth()->user()->image ? asset('storage/' . auth()->user()->image) : 'https://ui-avatars.com/api/?name=' . urlencode(auth()->user()->name) . '&background=C8461F&color=ffffff&bold=true' }}"
                    alt="{{ auth()->user()->name }}">
                <div>
                    <div class="bh-user-name">{{ Str::limit(auth()->user()->name, 18) }}</div>
                    <div class="bh-user-role">
                        @if(auth()->user()->user_type == 1) Admin @else Author @endif
                    </div>
                </div>
                <i class="fa-solid fa-chevron-down ms-1" style="font-size:0.65rem; color:var(--text-light);"></i>
            </button>
            <div class="bh-dropdown-menu" id="userDropdownMenu">
                <a href="{{ route('dashboard.account') }}" class="bh-dropdown-item">
                    <i class="fa-solid fa-user" style="width:14px;"></i> My Account
                </a>
                <a href="{{ route('dashboard.settings') }}" class="bh-dropdown-item">
                    <i class="fa-solid fa-gear" style="width:14px;"></i> Settings
                </a>
                <div class="bh-dropdown-divider"></div>
                <button class="bh-dropdown-item text-danger"
                    onclick="document.getElementById('topbar-logout-form').submit()">
                    <i class="fa-solid fa-right-from-bracket" style="width:14px;"></i> Sign Out
                </button>
                <form id="topbar-logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
            </div>
        </div>
    </div>
</header>

{{-- Overlay --}}
<div class="bh-overlay" id="sidebarOverlay"></div>

{{-- ====== SIDEBAR ====== --}}
@include('backend.components.sidebar')

{{-- ====== MAIN ====== --}}
<main class="bh-main">

    {{-- Flash messages --}}
    @if(session('success'))
    <div class="bh-alert bh-alert-success">
        <i class="fa-solid fa-circle-check"></i>
        {{ session('success') }}
    </div>
    @endif
    @if(session('error'))
    <div class="bh-alert bh-alert-error">
        <i class="fa-solid fa-triangle-exclamation"></i>
        {{ session('error') }}
    </div>
    @endif

    @yield('content')

    <footer class="bh-footer">
        &copy; {{ date('Y') }} BlogHub.
        @if((auth()->user()->user_type ?? 1) == 1) Admin Panel @else Author Studio @endif
        &mdash; Built with Laravel &amp; Bootstrap
    </footer>
</main>

{{-- ====== JS ====== --}}
<script src="{{ asset('backend/assets/plugins/popper.min.js') }}"></script>
<script src="{{ asset('backend/assets/plugins/bootstrap/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('backend/assets/plugins/chart.js/chart.min.js') }}"></script>

<script>
// Sidebar collapsible dropdowns
document.querySelectorAll('.bh-nav-dropdown-toggle').forEach(btn => {
    btn.addEventListener('click', function(e) {
        e.preventDefault();
        const parent = this.closest('.bh-nav-group');
        if (!parent) return;

        const isOpen = parent.classList.contains('open');
        const menu = parent.querySelector('.bh-nav-dropdown-menu');

        if (isOpen) {
            parent.classList.remove('open');
            this.setAttribute('aria-expanded', 'false');
            if (menu) menu.style.display = 'none';
        } else {
            parent.classList.add('open');
            this.setAttribute('aria-expanded', 'true');
            if (menu) menu.style.display = 'flex';
        }
    });
});

// Generic dropdowns (User menu, Create menu)
document.querySelectorAll('.bh-dropdown').forEach(dropdown => {
    const btn = dropdown.querySelector('button');
    const menu = dropdown.querySelector('.bh-dropdown-menu');
    if (btn && menu) {
        btn.addEventListener('click', (e) => {
            e.stopPropagation();
            const wasOpen = menu.classList.contains('show');
            document.querySelectorAll('.bh-dropdown-menu.show').forEach(m => m.classList.remove('show'));
            if (!wasOpen) {
                menu.classList.add('show');
            }
        });
    }
});
document.addEventListener('click', () => {
    document.querySelectorAll('.bh-dropdown-menu.show').forEach(m => m.classList.remove('show'));
});

// Mobile sidebar
const sidebarToggle  = document.getElementById('sidebarToggle');
const sidebar        = document.getElementById('bhSidebar');
const overlay        = document.getElementById('sidebarOverlay');
if (sidebarToggle && sidebar) {
    sidebarToggle.addEventListener('click', () => {
        sidebar.classList.toggle('open');
        overlay.classList.toggle('show');
    });
    overlay.addEventListener('click', () => {
        sidebar.classList.remove('open');
        overlay.classList.remove('show');
    });
}

// Auto-dismiss alerts
setTimeout(() => {
    document.querySelectorAll('.bh-alert').forEach(el => {
        el.style.transition = 'opacity .4s';
        el.style.opacity = '0';
        setTimeout(() => el.remove(), 400);
    });
}, 4000);
</script>

@yield('scripts')
</body>
</html>
