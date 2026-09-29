{{-- ============================================================
    BlogHub Dashboard Sidebar
    Single-file architecture: Admin (user_type=1) / Author (user_type=2)
   ============================================================ --}}

<aside class="bh-sidebar" id="bhSidebar">

    @if((auth()->user()->user_type ?? 1) == 1)
    {{-- ==================== ADMIN SIDEBAR ==================== --}}

    <div class="bh-nav-label">Overview</div>

    <a href="{{ route('dashboard.index') }}"
       class="bh-nav-link {{ Route::currentRouteName() == 'dashboard.index' ? 'active' : '' }}">
        <i class="fa-solid fa-grid-2 nav-icon"></i> Dashboard
    </a>
    <a href="{{ route('dashboard.charts') }}"
       class="bh-nav-link {{ Route::currentRouteName() == 'dashboard.charts' ? 'active' : '' }}">
        <i class="fa-solid fa-chart-line nav-icon"></i> Analytics &amp; Stats
    </a>

    <div class="bh-nav-label">Content</div>

    <a href="{{ route('dashboard.all-articles') }}"
       class="bh-nav-link {{ request()->routeIs('dashboard.all-articles') ? 'active' : '' }}">
        <i class="fa-solid fa-newspaper nav-icon"></i> All Articles
    </a>
    <a href="{{ route('dashboard.comments') }}"
       class="bh-nav-link {{ request()->routeIs('dashboard.comments') ? 'active' : '' }}">
        <i class="fa-solid fa-comments nav-icon"></i> Comments
    </a>
    <a href="{{ route('dashboard.website.section', 'topics') }}"
       class="bh-nav-link {{ request()->is('dashboard/website/topics') ? 'active' : '' }}">
        <i class="fa-solid fa-shapes nav-icon"></i> Categories
    </a>

    <div class="bh-nav-label">People</div>

    <a href="{{ route('dashboard.users') }}"
       class="bh-nav-link {{ request()->routeIs('dashboard.users') ? 'active' : '' }}">
        <i class="fa-solid fa-users nav-icon"></i> Users
    </a>
    <a href="{{ route('dashboard.website.section', 'authors') }}"
       class="bh-nav-link {{ request()->is('dashboard/website/authors') ? 'active' : '' }}">
        <i class="fa-solid fa-user-pen nav-icon"></i> Authors
    </a>

    <div class="bh-nav-label">Website</div>

    <a href="{{ route('dashboard.website') }}"
       class="bh-nav-link {{ (request()->is('dashboard/website') && !request()->route('section')) || request()->is('dashboard/website/all') ? 'active' : '' }}">
        <i class="fa-solid fa-globe nav-icon"></i> All Sections
    </a>
    <a href="{{ route('dashboard.website.section', 'discover') }}"
       class="bh-nav-link {{ request()->is('dashboard/website/discover') ? 'active' : '' }}">
        <i class="fa-solid fa-wand-magic-sparkles nav-icon"></i> Hero / Discover
        <span class="nav-badge">Hero</span>
    </a>
    <a href="{{ route('dashboard.website.section', 'trending') }}"
       class="bh-nav-link {{ request()->is('dashboard/website/trending') ? 'active' : '' }}">
        <i class="fa-solid fa-fire nav-icon"></i> Trending
    </a>
    <a href="{{ route('dashboard.website.section', 'latest-articles') }}"
       class="bh-nav-link {{ request()->is('dashboard/website/latest-articles') ? 'active' : '' }}">
        <i class="fa-solid fa-clock nav-icon"></i> Latest Articles
    </a>

    <div class="bh-nav-label">System</div>

    <a href="{{ route('dashboard.notifications') }}"
       class="bh-nav-link {{ Route::currentRouteName() == 'dashboard.notifications' ? 'active' : '' }}">
        <i class="fa-solid fa-bell nav-icon"></i> Notifications
    </a>
    <a href="{{ route('dashboard.account') }}"
       class="bh-nav-link {{ Route::currentRouteName() == 'dashboard.account' ? 'active' : '' }}">
        <i class="fa-solid fa-user-circle nav-icon"></i> Account
    </a>
    <a href="{{ route('dashboard.settings') }}"
       class="bh-nav-link {{ Route::currentRouteName() == 'dashboard.settings' ? 'active' : '' }}">
        <i class="fa-solid fa-gear nav-icon"></i> Settings
    </a>
    <a href="{{ route('dashboard.help') }}"
       class="bh-nav-link {{ Route::currentRouteName() == 'dashboard.help' ? 'active' : '' }}">
        <i class="fa-solid fa-circle-question nav-icon"></i> Help &amp; Docs
    </a>

    {{-- Logout --}}
    <div style="margin-top:auto; padding-top:1rem; border-top:1px solid var(--border); margin-top: 1.5rem;">
        <a href="#" class="bh-nav-link" style="color:#dc2626;"
           onclick="event.preventDefault(); document.getElementById('sidebar-logout-form').submit();">
            <i class="fa-solid fa-right-from-bracket nav-icon"></i> Sign Out
        </a>
        <form id="sidebar-logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
    </div>


    @elseif(auth()->user()->user_type == 2)
    {{-- ==================== AUTHOR SIDEBAR ==================== --}}

    <div class="bh-nav-label">Creator Studio</div>

    <a href="{{ route('dashboard.index') }}"
       class="bh-nav-link {{ Route::currentRouteName() == 'dashboard.index' ? 'active' : '' }}">
        <i class="fa-solid fa-chart-pie nav-icon"></i> Dashboard
    </a>
    <a href="{{ route('blogs.create') }}"
       class="bh-nav-link {{ Route::currentRouteName() == 'blogs.create' ? 'active' : '' }}">
        <i class="fa-solid fa-pen-nib nav-icon"></i> Write Article
        <span class="nav-badge" style="background:#16a34a;">New</span>
    </a>
    <a href="{{ route('dashboard.articles') }}"
       class="bh-nav-link {{ Route::currentRouteName() == 'dashboard.articles' ? 'active' : '' }}">
        <i class="fa-solid fa-newspaper nav-icon"></i> My Articles
    </a>
    <a href="{{ route('dashboard.charts') }}"
       class="bh-nav-link {{ Route::currentRouteName() == 'dashboard.charts' ? 'active' : '' }}">
        <i class="fa-solid fa-chart-line nav-icon"></i> Performance
    </a>

    <div class="bh-nav-label">Explore</div>

    <a href="{{ route('blogs.index') }}" target="_blank" class="bh-nav-link">
        <i class="fa-solid fa-book-open-reader nav-icon"></i> Community Stories
        <i class="fa-solid fa-arrow-up-right-from-square" style="font-size:0.6rem;margin-left:auto;color:var(--text-light);"></i>
    </a>
    <a href="{{ route('categories.index') }}" target="_blank" class="bh-nav-link">
        <i class="fa-solid fa-shapes nav-icon"></i> Explore Topics
        <i class="fa-solid fa-arrow-up-right-from-square" style="font-size:0.6rem;margin-left:auto;color:var(--text-light);"></i>
    </a>

    <div class="bh-nav-label">Account</div>

    <a href="{{ route('dashboard.notifications') }}"
       class="bh-nav-link {{ Route::currentRouteName() == 'dashboard.notifications' ? 'active' : '' }}">
        <i class="fa-solid fa-bell nav-icon"></i> Notifications
    </a>
    <a href="{{ route('dashboard.account') }}"
       class="bh-nav-link {{ Route::currentRouteName() == 'dashboard.account' ? 'active' : '' }}">
        <i class="fa-solid fa-user-pen nav-icon"></i> Profile
    </a>
    <a href="{{ route('dashboard.settings') }}"
       class="bh-nav-link {{ Route::currentRouteName() == 'dashboard.settings' ? 'active' : '' }}">
        <i class="fa-solid fa-gear nav-icon"></i> Settings
    </a>
    <a href="{{ route('dashboard.help') }}"
       class="bh-nav-link {{ Route::currentRouteName() == 'dashboard.help' ? 'active' : '' }}">
        <i class="fa-solid fa-circle-question nav-icon"></i> Guidelines
    </a>

    {{-- Logout --}}
    <div style="margin-top:auto; padding-top:1rem; border-top:1px solid var(--border); margin-top: 1.5rem;">
        <a href="#" class="bh-nav-link" style="color:#dc2626;"
           onclick="event.preventDefault(); document.getElementById('sidebar-logout-form').submit();">
            <i class="fa-solid fa-right-from-bracket nav-icon"></i> Sign Out
        </a>
        <form id="sidebar-logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
    </div>

    @endif

</aside>
