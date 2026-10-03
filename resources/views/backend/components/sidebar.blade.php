{{-- ============================================================
    BlogHub Dashboard Sidebar
    Clean, responsive role-based sidebar matching specifications:
    - Admin: Dashboard, Users, Authors, Posts, Categories, Comments, Analytics / Reports, Profile, Settings, Logout
    - Author: Dashboard, My Posts, Create Post, Comments, Analytics, My Profile, Logout
   ============================================================ --}}

<aside class="bh-sidebar" id="bhSidebar">

    @if((auth()->user()->user_type ?? 1) == 1)
    {{-- ==================== 1. ADMIN SIDEBAR ==================== --}}

    <div class="bh-nav-label">Core Platform</div>

    {{-- Dashboard --}}
    <a href="{{ route('dashboard.index') }}"
       class="bh-nav-link {{ Route::currentRouteName() == 'dashboard.index' ? 'active' : '' }}">
        <i class="fa-solid fa-gauge-high nav-icon"></i>
        <span>Dashboard</span>
    </a>

    {{-- Users --}}
    <a href="{{ route('dashboard.users') }}"
       class="bh-nav-link {{ Route::currentRouteName() == 'dashboard.users' ? 'active' : '' }}">
        <i class="fa-solid fa-users nav-icon"></i>
        <span>Users</span>
        @php $adminTotalUsers = \App\Models\User::count(); @endphp
        <span class="nav-badge" style="background:#e5e7eb; color:#374151;">{{ $adminTotalUsers }}</span>
    </a>

    {{-- Authors --}}
    <a href="{{ route('dashboard.authors') }}"
       class="bh-nav-link {{ Route::currentRouteName() == 'dashboard.authors' ? 'active' : '' }}">
        <i class="fa-solid fa-feather nav-icon"></i>
        <span>Authors</span>
        @php $adminTotalAuthors = \App\Models\Author::count(); @endphp
        <span class="nav-badge" style="background:#e5e7eb; color:#374151;">{{ $adminTotalAuthors }}</span>
    </a>

    {{-- Posts --}}
    @php
        $adminPendingArticles = \App\Models\Article::pending()->count();
        $isPostsActive = Route::currentRouteName() == 'dashboard.all-articles';
    @endphp
    <a href="{{ route('dashboard.all-articles') }}"
       class="bh-nav-link {{ $isPostsActive ? 'active' : '' }}">
        <i class="fa-solid fa-newspaper nav-icon"></i>
        <span>Posts</span>
        @if($adminPendingArticles > 0)
        <span class="nav-badge" style="background:#f59e0b; color:#fff;" title="{{ $adminPendingArticles }} pending review">{{ $adminPendingArticles }}</span>
        @endif
    </a>

    {{-- Categories --}}
    <a href="{{ route('dashboard.categories') }}"
       class="bh-nav-link {{ Route::currentRouteName() == 'dashboard.categories' ? 'active' : '' }}">
        <i class="fa-solid fa-tags nav-icon"></i>
        <span>Categories</span>
    </a>

    {{-- Comments --}}
    @php
        $adminPendingComments = \App\Models\Comment::where('is_approved', false)->count();
        $isCommentsActive = Route::currentRouteName() == 'dashboard.comments';
    @endphp
    <a href="{{ route('dashboard.comments') }}"
       class="bh-nav-link {{ $isCommentsActive ? 'active' : '' }}">
        <i class="fa-solid fa-comments nav-icon"></i>
        <span>Comments</span>
        @if($adminPendingComments > 0)
        <span class="nav-badge" style="background:#f59e0b; color:#fff;" title="{{ $adminPendingComments }} pending">{{ $adminPendingComments }}</span>
        @endif
    </a>

    <div class="bh-nav-label">Insights &amp; System</div>

    {{-- Analytics / Reports --}}
    <a href="{{ route('dashboard.charts') }}"
       class="bh-nav-link {{ Route::currentRouteName() == 'dashboard.charts' ? 'active' : '' }}">
        <i class="fa-solid fa-chart-line nav-icon"></i>
        <span>Analytics / Reports</span>
    </a>

    {{-- Profile --}}
    <a href="{{ route('dashboard.account') }}"
       class="bh-nav-link {{ Route::currentRouteName() == 'dashboard.account' ? 'active' : '' }}">
        <i class="fa-solid fa-user-shield nav-icon"></i>
        <span>Profile</span>
    </a>

    {{-- Settings --}}
    <a href="{{ route('dashboard.settings') }}"
       class="bh-nav-link {{ Route::currentRouteName() == 'dashboard.settings' ? 'active' : '' }}">
        <i class="fa-solid fa-gear nav-icon"></i>
        <span>Settings</span>
    </a>

    {{-- Sidebar Bottom: Live Site & Logout --}}
    <div style="margin-top:auto; padding-top:1.25rem; border-top:1px solid var(--border); display:flex; flex-direction:column; gap:4px;">
        <a href="{{ route('home') }}" target="_blank" class="bh-nav-link" style="color:var(--text-muted);">
            <i class="fa-solid fa-arrow-up-right-from-square nav-icon"></i>
            <span>Visit Live Site</span>
        </a>
        <a href="#" class="bh-nav-link" style="color:#dc2626;"
           onclick="event.preventDefault(); document.getElementById('sidebar-logout-form').submit();">
            <i class="fa-solid fa-right-from-bracket nav-icon"></i>
            <span>Logout</span>
        </a>
        <form id="sidebar-logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
    </div>

    @else
    {{-- ==================== 2. AUTHOR SIDEBAR ==================== --}}

    <div class="bh-nav-label">Creator Studio</div>

    {{-- Dashboard --}}
    <a href="{{ route('dashboard.index') }}"
       class="bh-nav-link {{ Route::currentRouteName() == 'dashboard.index' ? 'active' : '' }}">
        <i class="fa-solid fa-gauge-high nav-icon"></i>
        <span>Dashboard</span>
    </a>

    {{-- My Posts --}}
    @php
        $authorProfileId = auth()->user()->author?->id;
        $authorPendingCount = $authorProfileId ? \App\Models\Article::where('author_id', $authorProfileId)->pending()->count() : 0;
        $authorCommentsPending = $authorProfileId ? \App\Models\Comment::whereHas('article', function($q) use ($authorProfileId) {
            $q->where('author_id', $authorProfileId);
        })->where('is_approved', false)->count() : 0;
    @endphp
    <a href="{{ route('dashboard.articles') }}"
       class="bh-nav-link {{ Route::currentRouteName() == 'dashboard.articles' ? 'active' : '' }}">
        <i class="fa-solid fa-newspaper nav-icon"></i>
        <span>My Posts</span>
        @if($authorPendingCount > 0)
        <span class="nav-badge" style="background:#f59e0b; color:#fff;" title="{{ $authorPendingCount }} pending review">{{ $authorPendingCount }}</span>
        @endif
    </a>

    {{-- Create Post --}}
    <a href="{{ route('blogs.create') }}"
       class="bh-nav-link {{ Route::currentRouteName() == 'blogs.create' ? 'active' : '' }}" style="color:var(--brand); font-weight:600;">
        <i class="fa-solid fa-circle-plus nav-icon"></i>
        <span>Create Post</span>
        <span class="nav-badge" style="background:var(--brand); color:#fff;">+ New</span>
    </a>

    {{-- Comments --}}
    <a href="{{ route('dashboard.comments') }}"
       class="bh-nav-link {{ Route::currentRouteName() == 'dashboard.comments' ? 'active' : '' }}">
        <i class="fa-solid fa-comments nav-icon"></i>
        <span>Comments</span>
        @if($authorCommentsPending > 0)
        <span class="nav-badge" style="background:#f59e0b; color:#fff;" title="{{ $authorCommentsPending }} pending approval">{{ $authorCommentsPending }}</span>
        @endif
    </a>

    {{-- Analytics --}}
    <a href="{{ route('dashboard.charts') }}"
       class="bh-nav-link {{ Route::currentRouteName() == 'dashboard.charts' ? 'active' : '' }}">
        <i class="fa-solid fa-chart-line nav-icon"></i>
        <span>Analytics</span>
    </a>

    {{-- My Profile --}}
    <a href="{{ route('dashboard.account') }}"
       class="bh-nav-link {{ Route::currentRouteName() == 'dashboard.account' ? 'active' : '' }}">
        <i class="fa-solid fa-circle-user nav-icon"></i>
        <span>My Profile</span>
    </a>

    {{-- Sidebar Bottom: Live Site & Logout --}}
    <div style="margin-top:auto; padding-top:1.25rem; border-top:1px solid var(--border); display:flex; flex-direction:column; gap:4px;">
        <a href="{{ route('home') }}" target="_blank" class="bh-nav-link" style="color:var(--text-muted);">
            <i class="fa-solid fa-arrow-up-right-from-square nav-icon"></i>
            <span>Visit Live Site</span>
        </a>
        <a href="#" class="bh-nav-link" style="color:#dc2626;"
           onclick="event.preventDefault(); document.getElementById('sidebar-logout-form').submit();">
            <i class="fa-solid fa-right-from-bracket nav-icon"></i>
            <span>Logout</span>
        </a>
        <form id="sidebar-logout-form" action="{{ route('logout') }}" method="POST" class="d-none">@csrf</form>
    </div>

    @endif

</aside>
