<style>
/* ========================================================
   BlogHub Decent & Professional Sidebar Styles
   ======================================================== */
.app-sidepanel {
    background: #ffffff !important;
    border-right: 1px solid #e2e8f0 !important;
    box-shadow: 2px 0 16px rgba(0, 0, 0, 0.04) !important;
    z-index: 1040 !important;
    font-family: inherit;
}

.app-sidepanel .sidepanel-inner {
    background: #ffffff !important;
    color: #475569;
    width: 250px !important;
    display: flex;
    flex-direction: column;
    height: 100vh;
    overflow: hidden;
}

/* Sidebar Brand Header */
.sidebar-brand-box {
    padding: 1.25rem 1.25rem 1rem 1.25rem;
    border-bottom: 1px solid #f1f5f9;
    background: #ffffff;
}

.sidebar-logo-icon {
    width: 38px;
    height: 38px;
    background: linear-gradient(135deg, #C8461F 0%, #EA580C 100%);
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #ffffff;
    font-size: 1.15rem;
    box-shadow: 0 4px 12px rgba(200, 70, 31, 0.25);
    transition: transform 0.25s ease;
}

.sidebar-logo-icon:hover {
    transform: rotate(-6deg) scale(1.05);
}

.sidebar-brand-title {
    font-size: 1.22rem;
    font-weight: 800;
    color: #0f172a;
    letter-spacing: -0.3px;
    line-height: 1.2;
}

.sidebar-brand-badge {
    font-size: 0.65rem;
    font-weight: 700;
    padding: 2px 6px;
    border-radius: 4px;
    background: rgba(200, 70, 31, 0.1);
    color: #C8461F;
    border: 1px solid rgba(200, 70, 31, 0.2);
    letter-spacing: 0.5px;
    text-transform: uppercase;
}

.sidebar-brand-badge.badge-author {
    background: rgba(37, 99, 235, 0.1);
    color: #2563EB;
    border: 1px solid rgba(37, 99, 235, 0.25);
}

/* Navigation Scroll Area */
.sidebar-nav-container {
    flex: 1 1 auto;
    overflow-y: auto;
    padding: 0.85rem 0.75rem;
    scrollbar-width: thin;
    scrollbar-color: rgba(0, 0, 0, 0.1) transparent;
}

.sidebar-nav-container::-webkit-scrollbar {
    width: 4px;
}
.sidebar-nav-container::-webkit-scrollbar-thumb {
    background: rgba(0, 0, 0, 0.1);
    border-radius: 4px;
}

/* Section Divider Headers */
.sidebar-section-header {
    font-size: 0.68rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.8px;
    color: #94a3b8;
    padding: 0.75rem 0.65rem 0.35rem 0.65rem;
    margin-top: 0.4rem;
}

/* Nav Link Items */
.sidebar-link {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 0.6rem 0.75rem;
    margin-bottom: 0.25rem;
    border-radius: 9px;
    color: #475569 !important;
    text-decoration: none !important;
    font-size: 0.875rem;
    font-weight: 500;
    transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
    position: relative;
    border: 1px solid transparent;
}

.sidebar-link:hover {
    color: #C8461F !important;
    background: #fff5f2;
    border-color: rgba(200, 70, 31, 0.12);
    transform: translateX(2px);
}

.sidebar-link.active {
    color: #C8461F !important;
    background: #fff1ed !important;
    border: 1px solid rgba(200, 70, 31, 0.25) !important;
    font-weight: 600;
    box-shadow: 0 2px 6px rgba(200, 70, 31, 0.08);
}

.sidebar-link.active::before {
    content: "";
    position: absolute;
    left: -1px;
    top: 6px;
    bottom: 6px;
    width: 3.5px;
    border-radius: 4px;
    background: #C8461F;
}

/* Icon Box inside Links */
.sidebar-icon-wrap {
    width: 30px;
    height: 30px;
    border-radius: 7px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    margin-right: 0.75rem;
    background: #f1f5f9;
    color: #64748b;
    transition: all 0.2s ease;
    font-size: 0.95rem;
    flex-shrink: 0;
}

.sidebar-link:hover .sidebar-icon-wrap {
    color: #C8461F;
    background: #ffe6de;
}

.sidebar-link.active .sidebar-icon-wrap {
    background: #C8461F !important;
    color: #ffffff !important;
    box-shadow: 0 2px 6px rgba(200, 70, 31, 0.25);
}

/* Submenu Styling */
.sidebar-submenu {
    padding-left: 1.15rem;
    margin-top: 0.25rem;
    margin-bottom: 0.5rem;
    border-left: 1.5px dashed #e2e8f0;
    margin-left: 1.35rem;
}

.sidebar-sublink {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 0.45rem 0.65rem;
    margin-bottom: 0.15rem;
    border-radius: 6px;
    color: #64748b !important;
    text-decoration: none !important;
    font-size: 0.8125rem;
    font-weight: 500;
    transition: all 0.18s ease;
    position: relative;
}

.sidebar-sublink:hover {
    color: #C8461F !important;
    background: #fff5f2;
    transform: translateX(3px);
}

.sidebar-sublink.active {
    color: #C8461F !important;
    font-weight: 600;
    background: #fff1ed;
}

.sidebar-sublink.active i {
    color: #C8461F !important;
}

/* Chevron indicator */
.sidebar-chevron {
    font-size: 0.75rem;
    transition: transform 0.25s ease;
    color: #94a3b8;
}

.submenu-toggle[aria-expanded="true"] .sidebar-chevron {
    transform: rotate(180deg);
    color: #C8461F;
}

/* Sidebar Footer / User Profile Area */
.sidebar-footer-box {
    padding: 0.9rem 1rem;
    border-top: 1px solid #f1f5f9;
    background: #f8fafc;
}

.sidebar-user-card {
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.sidebar-user-avatar {
    width: 38px;
    height: 38px;
    border-radius: 50%;
    object-fit: cover;
    border: 2px solid rgba(200, 70, 31, 0.35);
    flex-shrink: 0;
}

.sidebar-user-name {
    font-size: 0.85rem;
    font-weight: 600;
    color: #0f172a;
    line-height: 1.2;
}

.sidebar-user-role {
    font-size: 0.7rem;
    color: #64748b;
}

.status-online-dot {
    width: 7px;
    height: 7px;
    background: #10b981;
    border-radius: 50%;
    display: inline-block;
    box-shadow: 0 0 6px #10b981;
    margin-right: 4px;
}
</style>

<div id="app-sidepanel" class="app-sidepanel"> 
    <div id="sidepanel-drop" class="sidepanel-drop"></div>
    <div class="sidepanel-inner d-flex flex-column">
        <!-- Close button for Mobile screen -->
        <a href="#" id="sidepanel-close" class="sidepanel-close d-xl-none" aria-label="Close sidebar">
            <i class="fa-solid fa-xmark text-dark"></i>
        </a>

        <!-- Sidebar Brand / Logo Header -->
        <div class="sidebar-brand-box d-flex align-items-center justify-content-between">
            <a href="{{ route('dashboard.index') }}" class="d-flex align-items-center gap-2.5 text-decoration-none">
                <div class="sidebar-logo-icon">
                    <i class="fa-solid fa-feather-pointed"></i>
                </div>
                <div>
                    <div class="sidebar-brand-title font-heading">
                        Blog<span style="color: #C8461F;">Hub</span>
                    </div>
                    <div class="d-flex align-items-center gap-1.5 mt-0.5">
                        <span class="status-online-dot"></span>
                        @if((auth()->user()->user_type ?? 1) == 1)
                            <span class="sidebar-brand-badge">ADMIN PORTAL</span>
                        @else
                            <span class="sidebar-brand-badge badge-author">AUTHOR STUDIO</span>
                        @endif
                    </div>
                </div>
            </a>
        </div>
        
        <!-- Navigation Menu Container -->
        <nav id="app-nav-main" class="sidebar-nav-container">
            <ul class="list-unstyled mb-0" id="menu-accordion">

            @if((auth()->user()->user_type ?? 1) == 1)
                {{-- for admin --}}

                <!-- 1. CORE SECTION -->
                <li class="sidebar-section-header">
                    Core Dashboard
                </li>

                <!-- Overview -->
                <li>
                    <a class="sidebar-link {{ Route::currentRouteName() == 'dashboard.index' ? 'active' : '' }}" href="{{ route('dashboard.index') }}">
                        <div class="d-flex align-items-center">
                            <span class="sidebar-icon-wrap">
                                <i class="fa-solid fa-chart-pie"></i>
                            </span>
                            <span>Overview</span>
                        </div>
                    </a>
                </li>

                <!-- Articles -->
                <li>
                    <a class="sidebar-link {{ Route::currentRouteName() == 'dashboard.articles' ? 'active' : '' }}" href="{{ route('dashboard.articles') }}">
                        <div class="d-flex align-items-center">
                            <span class="sidebar-icon-wrap">
                                <i class="fa-solid fa-newspaper"></i>
                            </span>
                            <span>All Articles</span>
                        </div>
                        <span class="badge bg-light text-secondary border small px-1.5 py-0.5 rounded font-mono" style="font-size: 0.7rem;">Manage</span>
                    </a>
                </li>

                <!-- Write / Create Article -->
                <li>
                    <a class="sidebar-link {{ Route::currentRouteName() == 'blogs.create' ? 'active' : '' }}" href="{{ route('blogs.create') }}">
                        <div class="d-flex align-items-center">
                            <span class="sidebar-icon-wrap" style="color: #C8461F;">
                                <i class="fa-solid fa-pen-nib"></i>
                            </span>
                            <span>Write Article</span>
                        </div>
                        <span class="badge bg-danger bg-opacity-10 text-danger small px-1.5 py-0.5 rounded font-mono" style="font-size: 0.65rem;">+ New</span>
                    </a>
                </li>

                <!-- Analytics / Charts -->
                <li>
                    <a class="sidebar-link {{ Route::currentRouteName() == 'dashboard.charts' ? 'active' : '' }}" href="{{ route('dashboard.charts') }}">
                        <div class="d-flex align-items-center">
                            <span class="sidebar-icon-wrap">
                                <i class="fa-solid fa-chart-line"></i>
                            </span>
                            <span>Analytics &amp; Stats</span>
                        </div>
                    </a>
                </li>

                <!-- 2. WEBSITE & HOMEPAGE MANAGER -->
                <li class="sidebar-section-header mt-3">
                    Website &amp; Portions
                </li>

                <!-- Website Home Portions Dropdown -->
                <li class="has-submenu">
                    <a class="sidebar-link submenu-toggle {{ request()->routeIs('dashboard.website*') ? 'active' : '' }}" 
                       href="#" 
                       data-bs-toggle="collapse" 
                       data-bs-target="#submenu-website" 
                       aria-expanded="{{ request()->routeIs('dashboard.website*') ? 'true' : 'false' }}">
                        <div class="d-flex align-items-center">
                            <span class="sidebar-icon-wrap" style="color: #0284c7;">
                                <i class="fa-solid fa-globe"></i>
                            </span>
                            <span>Website Portions</span>
                        </div>
                        <div class="d-flex align-items-center gap-1.5">
                            <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 small px-1 py-0 rounded font-mono" style="font-size: 0.65rem;">5 Sections</span>
                            <i class="fa-solid fa-chevron-down sidebar-chevron"></i>
                        </div>
                    </a>
                    <div id="submenu-website" class="collapse {{ request()->routeIs('dashboard.website*') ? 'show' : '' }}" data-bs-parent="#menu-accordion">
                        <div class="sidebar-submenu">
                            <!-- All Portions -->
                            <a class="sidebar-sublink {{ (request()->is('dashboard/website') && !request()->route('section')) || request()->is('dashboard/website/all') ? 'active' : '' }}" 
                               href="{{ route('dashboard.website') }}">
                                <span class="d-flex align-items-center">
                                    <i class="fa-solid fa-layer-group me-2 text-primary" style="width: 14px;"></i> All Portions
                                </span>
                            </a>

                            <!-- 1. Discover Stories -->
                            <a class="sidebar-sublink {{ request()->is('dashboard/website/discover') ? 'active' : '' }}" 
                               href="{{ route('dashboard.website.section', 'discover') }}">
                                <span class="d-flex align-items-center">
                                    <i class="fa-solid fa-wand-magic-sparkles me-2 text-warning" style="width: 14px;"></i> 1. Discover Stories
                                </span>
                                <span class="badge bg-warning bg-opacity-15 text-warning border border-warning border-opacity-25 px-1" style="font-size: 0.6rem;">Hero</span>
                            </a>

                            <!-- 2. Trending Now -->
                            <a class="sidebar-sublink {{ request()->is('dashboard/website/trending') ? 'active' : '' }}" 
                               href="{{ route('dashboard.website.section', 'trending') }}">
                                <span class="d-flex align-items-center">
                                    <i class="fa-solid fa-fire me-2 text-danger" style="width: 14px;"></i> 2. Trending Now
                                </span>
                                <span class="badge bg-danger bg-opacity-15 text-danger border border-danger border-opacity-25 px-1" style="font-size: 0.6rem;">Hot</span>
                            </a>

                            <!-- 3. Explore Topics -->
                            <a class="sidebar-sublink {{ request()->is('dashboard/website/topics') ? 'active' : '' }}" 
                               href="{{ route('dashboard.website.section', 'topics') }}">
                                <span class="d-flex align-items-center">
                                    <i class="fa-solid fa-shapes me-2 text-success" style="width: 14px;"></i> 3. Explore Topics
                                </span>
                            </a>

                            <!-- 4. Latest Articles -->
                            <a class="sidebar-sublink {{ request()->is('dashboard/website/latest-articles') ? 'active' : '' }}" 
                               href="{{ route('dashboard.website.section', 'latest-articles') }}">
                                <span class="d-flex align-items-center">
                                    <i class="fa-solid fa-newspaper me-2 text-info" style="width: 14px;"></i> 4. Latest Articles
                                </span>
                            </a>

                            <!-- 5. Meet Our Authors -->
                            <a class="sidebar-sublink {{ request()->is('dashboard/website/authors') ? 'active' : '' }}" 
                               href="{{ route('dashboard.website.section', 'authors') }}">
                                <span class="d-flex align-items-center">
                                    <i class="fa-solid fa-users me-2 text-secondary" style="width: 14px;"></i> 5. Meet Our Authors
                                </span>
                            </a>
                        </div>
                    </div>
                </li>

                <!-- 3. SYSTEM & SETTINGS -->
                <li class="sidebar-section-header mt-3">
                    Management &amp; Settings
                </li>

                <!-- Account & Settings Dropdown -->
                <li class="has-submenu">
                    <a class="sidebar-link submenu-toggle {{ in_array(Route::currentRouteName(), ['dashboard.notifications', 'dashboard.account', 'dashboard.settings']) ? 'active' : '' }}" 
                       href="#" 
                       data-bs-toggle="collapse" 
                       data-bs-target="#submenu-account" 
                       aria-expanded="{{ in_array(Route::currentRouteName(), ['dashboard.notifications', 'dashboard.account', 'dashboard.settings']) ? 'true' : 'false' }}">
                        <div class="d-flex align-items-center">
                            <span class="sidebar-icon-wrap">
                                <i class="fa-solid fa-gear"></i>
                            </span>
                            <span>System Settings</span>
                        </div>
                        <i class="fa-solid fa-chevron-down sidebar-chevron"></i>
                    </a>
                    <div id="submenu-account" class="collapse {{ in_array(Route::currentRouteName(), ['dashboard.notifications', 'dashboard.account', 'dashboard.settings']) ? 'show' : '' }}" data-bs-parent="#menu-accordion">
                        <div class="sidebar-submenu">
                            <a class="sidebar-sublink {{ Route::currentRouteName() == 'dashboard.notifications' ? 'active' : '' }}" href="{{ route('dashboard.notifications') }}">
                                <span class="d-flex align-items-center">
                                    <i class="fa-solid fa-bell me-2 text-warning" style="width: 14px;"></i> Notifications
                                </span>
                            </a>
                            <a class="sidebar-sublink {{ Route::currentRouteName() == 'dashboard.account' ? 'active' : '' }}" href="{{ route('dashboard.account') }}">
                                <span class="d-flex align-items-center">
                                    <i class="fa-solid fa-user me-2 text-info" style="width: 14px;"></i> Account Profile
                                </span>
                            </a>
                            <a class="sidebar-sublink {{ Route::currentRouteName() == 'dashboard.settings' ? 'active' : '' }}" href="{{ route('dashboard.settings') }}">
                                <span class="d-flex align-items-center">
                                    <i class="fa-solid fa-sliders me-2 text-primary" style="width: 14px;"></i> Preferences
                                </span>
                            </a>
                        </div>
                    </div>
                </li>

                <!-- Help & Docs -->
                <li>
                    <a class="sidebar-link {{ Route::currentRouteName() == 'dashboard.help' ? 'active' : '' }}" href="{{ route('dashboard.help') }}">
                        <div class="d-flex align-items-center">
                            <span class="sidebar-icon-wrap">
                                <i class="fa-solid fa-circle-question"></i>
                            </span>
                            <span>Help &amp; Documentation</span>
                        </div>
                    </a>
                </li>

            @else
                {{-- for author (user_type == 2) --}}

                <!-- 1. CREATOR WORKSPACE -->
                <li class="sidebar-section-header">
                    Creator Studio
                </li>

                <!-- Dashboard Overview -->
                <li>
                    <a class="sidebar-link {{ Route::currentRouteName() == 'dashboard.index' ? 'active' : '' }}" href="{{ route('dashboard.index') }}">
                        <div class="d-flex align-items-center">
                            <span class="sidebar-icon-wrap">
                                <i class="fa-solid fa-chart-pie"></i>
                            </span>
                            <span>Author Dashboard</span>
                        </div>
                    </a>
                </li>

                <!-- Write / New Post -->
                <li>
                    <a class="sidebar-link {{ Route::currentRouteName() == 'blogs.create' ? 'active' : '' }}" href="{{ route('blogs.create') }}">
                        <div class="d-flex align-items-center">
                            <span class="sidebar-icon-wrap" style="color: #C8461F; background: #fff1ed;">
                                <i class="fa-solid fa-pen-nib"></i>
                            </span>
                            <span>Write Article</span>
                        </div>
                        <span class="badge bg-danger bg-opacity-10 text-danger small px-1.5 py-0.5 rounded font-mono" style="font-size: 0.65rem;">+ New</span>
                    </a>
                </li>

                <!-- My Articles -->
                <li>
                    <a class="sidebar-link {{ Route::currentRouteName() == 'dashboard.articles' ? 'active' : '' }}" href="{{ route('dashboard.articles') }}">
                        <div class="d-flex align-items-center">
                            <span class="sidebar-icon-wrap">
                                <i class="fa-solid fa-newspaper"></i>
                            </span>
                            <span>My Articles</span>
                        </div>
                        <span class="badge bg-light text-secondary border small px-1.5 py-0.5 rounded font-mono" style="font-size: 0.7rem;">My Posts</span>
                    </a>
                </li>

                <!-- Article Performance / Analytics -->
                <li>
                    <a class="sidebar-link {{ Route::currentRouteName() == 'dashboard.charts' ? 'active' : '' }}" href="{{ route('dashboard.charts') }}">
                        <div class="d-flex align-items-center">
                            <span class="sidebar-icon-wrap">
                                <i class="fa-solid fa-chart-line"></i>
                            </span>
                            <span>Performance &amp; Stats</span>
                        </div>
                        <span class="badge bg-success bg-opacity-10 text-success small px-1.5 py-0.5 rounded font-mono" style="font-size: 0.65rem;">Stats</span>
                    </a>
                </li>

                <!-- 2. EXPLORE & COMMUNITY -->
                <li class="sidebar-section-header mt-3">
                    Explore &amp; Community
                </li>

                <!-- Community Stories -->
                <li>
                    <a class="sidebar-link" href="{{ route('blogs.index') }}" target="_blank">
                        <div class="d-flex align-items-center">
                            <span class="sidebar-icon-wrap" style="color: #0284c7;">
                                <i class="fa-solid fa-book-open-reader"></i>
                            </span>
                            <span>Community Stories</span>
                        </div>
                        <i class="fa-solid fa-arrow-up-right-from-square small text-muted" style="font-size: 0.7rem;"></i>
                    </a>
                </li>

                <!-- Explore Categories -->
                <li>
                    <a class="sidebar-link" href="{{ route('categories.index') }}" target="_blank">
                        <div class="d-flex align-items-center">
                            <span class="sidebar-icon-wrap" style="color: #10b981;">
                                <i class="fa-solid fa-shapes"></i>
                            </span>
                            <span>Explore Topics</span>
                        </div>
                        <i class="fa-solid fa-arrow-up-right-from-square small text-muted" style="font-size: 0.7rem;"></i>
                    </a>
                </li>

                <!-- Fellow Authors -->
                <li>
                    <a class="sidebar-link" href="{{ route('authors.index') }}" target="_blank">
                        <div class="d-flex align-items-center">
                            <span class="sidebar-icon-wrap" style="color: #8b5cf6;">
                                <i class="fa-solid fa-users"></i>
                            </span>
                            <span>Meet Authors</span>
                        </div>
                        <i class="fa-solid fa-arrow-up-right-from-square small text-muted" style="font-size: 0.7rem;"></i>
                    </a>
                </li>

                <!-- 3. ACCOUNT & SUPPORT -->
                <li class="sidebar-section-header mt-3">
                    Account &amp; Support
                </li>

                <!-- Notifications -->
                <li>
                    <a class="sidebar-link {{ Route::currentRouteName() == 'dashboard.notifications' ? 'active' : '' }}" href="{{ route('dashboard.notifications') }}">
                        <div class="d-flex align-items-center">
                            <span class="sidebar-icon-wrap">
                                <i class="fa-solid fa-bell text-warning"></i>
                            </span>
                            <span>Notifications</span>
                        </div>
                    </a>
                </li>

                <!-- Account / Profile -->
                <li>
                    <a class="sidebar-link {{ Route::currentRouteName() == 'dashboard.account' ? 'active' : '' }}" href="{{ route('dashboard.account') }}">
                        <div class="d-flex align-items-center">
                            <span class="sidebar-icon-wrap">
                                <i class="fa-solid fa-user-pen text-info"></i>
                            </span>
                            <span>Author Profile</span>
                        </div>
                    </a>
                </li>

                <!-- Author Guidelines -->
                <li>
                    <a class="sidebar-link {{ Route::currentRouteName() == 'dashboard.help' ? 'active' : '' }}" href="{{ route('dashboard.help') }}">
                        <div class="d-flex align-items-center">
                            <span class="sidebar-icon-wrap">
                                <i class="fa-solid fa-circle-question"></i>
                            </span>
                            <span>Author Guidelines</span>
                        </div>
                    </a>
                </li>

            @endif

            </ul>
        </nav>
        
        <!-- Sidebar Bottom: Admin User & Quick Live Site Action -->
        <div class="sidebar-footer-box">
            <div class="sidebar-user-card mb-2.5">
                <img src="{{ auth()->user()->avatar_url ?? 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=100' }}" 
                     alt="User Avatar" 
                     class="sidebar-user-avatar">
                <div class="overflow-hidden flex-grow-1">
                    <div class="sidebar-user-name text-truncate">
                        {{ auth()->user()->name ?? 'User' }}
                    </div>
                    <div class="sidebar-user-role text-truncate">
                        @if((auth()->user()->user_type ?? 1) == 1)
                            <span class="badge bg-success bg-opacity-10 text-success p-0" style="font-size: 0.65rem;">Super Admin</span>
                        @else
                            <span class="badge bg-primary bg-opacity-10 text-primary p-0" style="font-size: 0.65rem;">Author / Creator</span>
                        @endif
                    </div>
                </div>
            </div>

            <div class="d-grid gap-1.5">
                <a class="btn btn-sm w-100 text-white fw-semibold d-flex align-items-center justify-content-center gap-1.5 shadow-xs" 
                   style="background: linear-gradient(135deg, #c8461f 0%, #ea580c 100%); font-size: 0.78rem; border-radius: 7px; padding: 6px 10px;" 
                   href="{{ route('home') }}" target="_blank">
                    <i class="fa-solid fa-arrow-up-right-from-square"></i>
                    <span>Visit Live Site</span>
                </a>
            </div>
        </div>
    </div>
</div>
