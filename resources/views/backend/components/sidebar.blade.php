{{-- ============================================================
    BlogHub Dashboard Sidebar
    Single-file architecture: Admin (user_type=1) / Author (user_type=2)
    Organized with collapsible dropdown menus for seamless navigation
   ============================================================ --}}

<aside class="bh-sidebar" id="bhSidebar">

    @if((auth()->user()->user_type ?? 1) == 1)
    {{-- ==================== ADMIN SIDEBAR ==================== --}}

    <div class="bh-nav-label">Overview</div>

    <a href="{{ route('dashboard.index') }}"
       class="bh-nav-link {{ Route::currentRouteName() == 'dashboard.index' ? 'active' : '' }}">
        <i class="fa-solid fa-gauge-high nav-icon"></i>
        <span>Dashboard</span>
    </a>
    <a href="{{ route('dashboard.charts') }}"
       class="bh-nav-link {{ Route::currentRouteName() == 'dashboard.charts' ? 'active' : '' }}">
        <i class="fa-solid fa-chart-line nav-icon"></i>
        <span>Analytics &amp; Stats</span>
    </a>

    <div class="bh-nav-label">Management</div>

    {{-- 1. Articles & Content Dropdown --}}
    @php
        $isContentActive = request()->routeIs('dashboard.all-articles', 'dashboard.comments', 'blogs.create') || request()->is('dashboard/website/topics*');
    @endphp
    <div class="bh-nav-group {{ $isContentActive ? 'open' : '' }}">
        <button type="button" class="bh-nav-dropdown-toggle {{ $isContentActive ? 'active-parent' : '' }}" aria-expanded="{{ $isContentActive ? 'true' : 'false' }}">
            <i class="fa-solid fa-newspaper nav-icon"></i>
            <span class="nav-text">Content &amp; Articles</span>
            <i class="fa-solid fa-chevron-down nav-chevron"></i>
        </button>
        <div class="bh-nav-dropdown-menu" style="{{ $isContentActive ? 'display:flex;' : 'display:none;' }}">
            <a href="{{ route('dashboard.all-articles') }}"
               class="bh-nav-sublink {{ request()->routeIs('dashboard.all-articles') ? 'active' : '' }}">
                <span class="sublink-dot"></span>
                <span>All Articles</span>
            </a>
            <a href="{{ route('blogs.create') }}"
               class="bh-nav-sublink {{ request()->routeIs('blogs.create') ? 'active' : '' }}">
                <span class="sublink-dot"></span>
                <span>Write Article</span>
                <span class="sublink-badge" style="background:#16a34a; color:#fff;">+ New</span>
            </a>
            <a href="{{ route('dashboard.comments') }}"
               class="bh-nav-sublink {{ request()->routeIs('dashboard.comments') ? 'active' : '' }}">
                <span class="sublink-dot"></span>
                <span>Comments</span>
            </a>
            <a href="{{ route('dashboard.website.section', 'topics') }}"
               class="bh-nav-sublink {{ request()->is('dashboard/website/topics*') ? 'active' : '' }}">
                <span class="sublink-dot"></span>
                <span>Categories &amp; Topics</span>
            </a>
        </div>
    </div>

    {{-- 2. User Management Dropdown --}}
    @php
        $isPeopleActive = request()->routeIs('dashboard.users') || request()->is('dashboard/website/authors*');
    @endphp
    <div class="bh-nav-group {{ $isPeopleActive ? 'open' : '' }}">
        <button type="button" class="bh-nav-dropdown-toggle {{ $isPeopleActive ? 'active-parent' : '' }}" aria-expanded="{{ $isPeopleActive ? 'true' : 'false' }}">
            <i class="fa-solid fa-users nav-icon"></i>
            <span class="nav-text">Users &amp; Roles</span>
            <i class="fa-solid fa-chevron-down nav-chevron"></i>
        </button>
        <div class="bh-nav-dropdown-menu" style="{{ $isPeopleActive ? 'display:flex;' : 'display:none;' }}">
            <a href="{{ route('dashboard.users') }}"
               class="bh-nav-sublink {{ request()->routeIs('dashboard.users') ? 'active' : '' }}">
                <span class="sublink-dot"></span>
                <span>All Users</span>
            </a>
            <a href="{{ route('dashboard.website.section', 'authors') }}"
               class="bh-nav-sublink {{ request()->is('dashboard/website/authors*') ? 'active' : '' }}">
                <span class="sublink-dot"></span>
                <span>Featured Authors</span>
            </a>
        </div>
    </div>

    {{-- 3. Website Portions Dropdown --}}
    @php
        $isWebsiteActive = request()->is('dashboard/website*') && !request()->is('dashboard/website/topics*') && !request()->is('dashboard/website/authors*');
    @endphp
    <div class="bh-nav-group {{ $isWebsiteActive ? 'open' : '' }}">
        <button type="button" class="bh-nav-dropdown-toggle {{ $isWebsiteActive ? 'active-parent' : '' }}" aria-expanded="{{ $isWebsiteActive ? 'true' : 'false' }}">
            <i class="fa-solid fa-globe nav-icon"></i>
            <span class="nav-text">Website Layout</span>
            <i class="fa-solid fa-chevron-down nav-chevron"></i>
        </button>
        <div class="bh-nav-dropdown-menu" style="{{ $isWebsiteActive ? 'display:flex;' : 'display:none;' }}">
            <a href="{{ route('dashboard.website') }}"
               class="bh-nav-sublink {{ (request()->is('dashboard/website') && !request()->route('section')) || request()->is('dashboard/website/all') ? 'active' : '' }}">
                <span class="sublink-dot"></span>
                <span>All Portions</span>
            </a>
            <a href="{{ route('dashboard.website.section', 'discover') }}"
               class="bh-nav-sublink {{ request()->is('dashboard/website/discover*') ? 'active' : '' }}">
                <span class="sublink-dot"></span>
                <span>Hero / Discover</span>
                <span class="sublink-badge" style="background:var(--brand); color:#fff;">Hero</span>
            </a>
            <a href="{{ route('dashboard.website.section', 'trending') }}"
               class="bh-nav-sublink {{ request()->is('dashboard/website/trending*') ? 'active' : '' }}">
                <span class="sublink-dot"></span>
                <span>Trending Section</span>
            </a>
            <a href="{{ route('dashboard.website.section', 'latest-articles') }}"
               class="bh-nav-sublink {{ request()->is('dashboard/website/latest-articles*') ? 'active' : '' }}">
                <span class="sublink-dot"></span>
                <span>Latest Articles Section</span>
            </a>
        </div>
    </div>

    <div class="bh-nav-label">System</div>

    {{-- 4. Settings & System Dropdown --}}
    @php
        $isSystemActive = request()->routeIs('dashboard.notifications', 'dashboard.account', 'dashboard.settings', 'dashboard.help');
    @endphp
    <div class="bh-nav-group {{ $isSystemActive ? 'open' : '' }}">
        <button type="button" class="bh-nav-dropdown-toggle {{ $isSystemActive ? 'active-parent' : '' }}" aria-expanded="{{ $isSystemActive ? 'true' : 'false' }}">
            <i class="fa-solid fa-gear nav-icon"></i>
            <span class="nav-text">Settings &amp; Support</span>
            <i class="fa-solid fa-chevron-down nav-chevron"></i>
        </button>
        <div class="bh-nav-dropdown-menu" style="{{ $isSystemActive ? 'display:flex;' : 'display:none;' }}">
            <a href="{{ route('dashboard.notifications') }}"
               class="bh-nav-sublink {{ Route::currentRouteName() == 'dashboard.notifications' ? 'active' : '' }}">
                <span class="sublink-dot"></span>
                <span>Notifications</span>
            </a>
            <a href="{{ route('dashboard.account') }}"
               class="bh-nav-sublink {{ Route::currentRouteName() == 'dashboard.account' ? 'active' : '' }}">
                <span class="sublink-dot"></span>
                <span>Admin Profile</span>
            </a>
            <a href="{{ route('dashboard.settings') }}"
               class="bh-nav-sublink {{ Route::currentRouteName() == 'dashboard.settings' ? 'active' : '' }}">
                <span class="sublink-dot"></span>
                <span>Platform Settings</span>
            </a>
            <a href="{{ route('dashboard.help') }}"
               class="bh-nav-sublink {{ Route::currentRouteName() == 'dashboard.help' ? 'active' : '' }}">
                <span class="sublink-dot"></span>
                <span>Help &amp; Docs</span>
            </a>
        </div>
    </div>

    {{-- Sidebar Bottom Actions --}}
    <div style="margin-top:auto; padding-top:1.25rem; border-top:1px solid var(--border); display:flex; flex-direction:column; gap:4px;">
        <a href="{{ route('home') }}" target="_blank" class="bh-nav-link" style="color:var(--text-muted);">
            <i class="fa-solid fa-arrow-up-right-from-square nav-icon"></i>
            <span>Visit Live Site</span>
        </a>
        <a href="#" class="bh-nav-link" style="color:#dc2626;"
           onclick="event.preventDefault(); document.getElementById('sidebar-logout-form').submit();">
            <i class="fa-solid fa-right-from-bracket nav-icon"></i>
            <span>Sign Out</span>
        </a>
        <form id="sidebar-logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
    </div>

    @elseif(auth()->user()->user_type == 2)
    {{-- ==================== AUTHOR SIDEBAR ==================== --}}

    <div class="bh-nav-label">Creator Studio</div>

    <a href="{{ route('dashboard.index') }}"
       class="bh-nav-link {{ Route::currentRouteName() == 'dashboard.index' ? 'active' : '' }}">
        <i class="fa-solid fa-gauge-high nav-icon"></i>
        <span>Studio Dashboard</span>
    </a>
    <a href="{{ route('dashboard.charts') }}"
       class="bh-nav-link {{ Route::currentRouteName() == 'dashboard.charts' ? 'active' : '' }}">
        <i class="fa-solid fa-chart-line nav-icon"></i>
        <span>Performance &amp; Stats</span>
    </a>

    <div class="bh-nav-label">My Content</div>

    {{-- 1. Author Articles Dropdown --}}
    @php
        $isAuthorArticlesActive = request()->routeIs('dashboard.articles', 'blogs.create');
    @endphp
    <div class="bh-nav-group {{ $isAuthorArticlesActive ? 'open' : '' }}">
        <button type="button" class="bh-nav-dropdown-toggle {{ $isAuthorArticlesActive ? 'active-parent' : '' }}" aria-expanded="{{ $isAuthorArticlesActive ? 'true' : 'false' }}">
            <i class="fa-solid fa-newspaper nav-icon"></i>
            <span class="nav-text">Articles &amp; Stories</span>
            <i class="fa-solid fa-chevron-down nav-chevron"></i>
        </button>
        <div class="bh-nav-dropdown-menu" style="{{ $isAuthorArticlesActive ? 'display:flex;' : 'display:none;' }}">
            <a href="{{ route('dashboard.articles') }}"
               class="bh-nav-sublink {{ Route::currentRouteName() == 'dashboard.articles' ? 'active' : '' }}">
                <span class="sublink-dot"></span>
                <span>My Articles</span>
            </a>
            <a href="{{ route('blogs.create') }}"
               class="bh-nav-sublink {{ Route::currentRouteName() == 'blogs.create' ? 'active' : '' }}">
                <span class="sublink-dot"></span>
                <span>Write New Article</span>
                <span class="sublink-badge" style="background:#16a34a; color:#fff;">+ New</span>
            </a>
        </div>
    </div>

    <div class="bh-nav-label">Community</div>

    {{-- 2. Author Explore Dropdown --}}
    @php
        $isAuthorExploreActive = request()->routeIs('blogs.index', 'categories.index', 'authors.index');
    @endphp
    <div class="bh-nav-group {{ $isAuthorExploreActive ? 'open' : '' }}">
        <button type="button" class="bh-nav-dropdown-toggle {{ $isAuthorExploreActive ? 'active-parent' : '' }}" aria-expanded="{{ $isAuthorExploreActive ? 'true' : 'false' }}">
            <i class="fa-solid fa-compass nav-icon"></i>
            <span class="nav-text">Explore &amp; Network</span>
            <i class="fa-solid fa-chevron-down nav-chevron"></i>
        </button>
        <div class="bh-nav-dropdown-menu" style="{{ $isAuthorExploreActive ? 'display:flex;' : 'display:none;' }}">
            <a href="{{ route('blogs.index') }}" target="_blank" class="bh-nav-sublink">
                <span class="sublink-dot"></span>
                <span>Community Stories</span>
                <i class="fa-solid fa-arrow-up-right-from-square ms-auto" style="font-size:0.6rem; color:var(--text-light);"></i>
            </a>
            <a href="{{ route('categories.index') }}" target="_blank" class="bh-nav-sublink">
                <span class="sublink-dot"></span>
                <span>Explore Topics</span>
                <i class="fa-solid fa-arrow-up-right-from-square ms-auto" style="font-size:0.6rem; color:var(--text-light);"></i>
            </a>
            <a href="{{ route('authors.index') }}" target="_blank" class="bh-nav-sublink">
                <span class="sublink-dot"></span>
                <span>Meet Authors</span>
                <i class="fa-solid fa-arrow-up-right-from-square ms-auto" style="font-size:0.6rem; color:var(--text-light);"></i>
            </a>
        </div>
    </div>

    <div class="bh-nav-label">Account</div>

    {{-- 3. Author Account Dropdown --}}
    @php
        $isAuthorAccountActive = request()->routeIs('dashboard.notifications', 'dashboard.account', 'dashboard.settings', 'dashboard.help');
    @endphp
    <div class="bh-nav-group {{ $isAuthorAccountActive ? 'open' : '' }}">
        <button type="button" class="bh-nav-dropdown-toggle {{ $isAuthorAccountActive ? 'active-parent' : '' }}" aria-expanded="{{ $isAuthorAccountActive ? 'true' : 'false' }}">
            <i class="fa-solid fa-circle-user nav-icon"></i>
            <span class="nav-text">Account &amp; Support</span>
            <i class="fa-solid fa-chevron-down nav-chevron"></i>
        </button>
        <div class="bh-nav-dropdown-menu" style="{{ $isAuthorAccountActive ? 'display:flex;' : 'display:none;' }}">
            <a href="{{ route('dashboard.account') }}"
               class="bh-nav-sublink {{ Route::currentRouteName() == 'dashboard.account' ? 'active' : '' }}">
                <span class="sublink-dot"></span>
                <span>Author Profile</span>
            </a>
            <a href="{{ route('dashboard.notifications') }}"
               class="bh-nav-sublink {{ Route::currentRouteName() == 'dashboard.notifications' ? 'active' : '' }}">
                <span class="sublink-dot"></span>
                <span>Notifications</span>
            </a>
            <a href="{{ route('dashboard.settings') }}"
               class="bh-nav-sublink {{ Route::currentRouteName() == 'dashboard.settings' ? 'active' : '' }}">
                <span class="sublink-dot"></span>
                <span>Settings</span>
            </a>
            <a href="{{ route('dashboard.help') }}"
               class="bh-nav-sublink {{ Route::currentRouteName() == 'dashboard.help' ? 'active' : '' }}">
                <span class="sublink-dot"></span>
                <span>Guidelines &amp; Help</span>
            </a>
        </div>
    </div>

    {{-- Sidebar Bottom Actions --}}
    <div style="margin-top:auto; padding-top:1.25rem; border-top:1px solid var(--border); display:flex; flex-direction:column; gap:4px;">
        <a href="{{ route('home') }}" target="_blank" class="bh-nav-link" style="color:var(--text-muted);">
            <i class="fa-solid fa-arrow-up-right-from-square nav-icon"></i>
            <span>Visit Live Site</span>
        </a>
        <a href="#" class="bh-nav-link" style="color:#dc2626;"
           onclick="event.preventDefault(); document.getElementById('sidebar-logout-form').submit();">
            <i class="fa-solid fa-right-from-bracket nav-icon"></i>
            <span>Sign Out</span>
        </a>
        <form id="sidebar-logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
    </div>

    @endif

</aside>
