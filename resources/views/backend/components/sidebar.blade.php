<!-- Professional Dashboard Sidebar Component -->
<style>
/* ========================================================
   BlogHub Premium Professional Sidebar Styles
   ======================================================== */
.app-sidepanel {
    background: #0d121d !important;
    border-right: 1px solid rgba(255, 255, 255, 0.07) !important;
    box-shadow: 4px 0 24px rgba(0, 0, 0, 0.25) !important;
    z-index: 1040 !important;
    font-family: inherit;
}

.app-sidepanel .sidepanel-inner {
    background: #0d121d !important;
    color: #94a3b8;
    width: 250px !important;
    display: flex;
    flex-direction: column;
    height: 100vh;
    overflow: hidden;
}

/* Sidebar Brand Header */
.sidebar-brand-box {
    padding: 1.25rem 1.25rem 1rem 1.25rem;
    border-bottom: 1px solid rgba(255, 255, 255, 0.06);
    background: linear-gradient(180deg, rgba(255,255,255,0.02) 0%, rgba(255,255,255,0) 100%);
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
    box-shadow: 0 4px 12px rgba(200, 70, 31, 0.35);
    transition: transform 0.25s ease;
}

.sidebar-logo-icon:hover {
    transform: rotate(-6deg) scale(1.05);
}

.sidebar-brand-title {
    font-size: 1.25rem;
    font-weight: 800;
    color: #ffffff;
    letter-spacing: -0.3px;
    line-height: 1.2;
}

.sidebar-brand-badge {
    font-size: 0.65rem;
    font-weight: 700;
    padding: 2px 6px;
    border-radius: 4px;
    background: rgba(200, 70, 31, 0.2);
    color: #ff7a50;
    border: 1px solid rgba(200, 70, 31, 0.3);
    letter-spacing: 0.5px;
    text-transform: uppercase;
}

/* Navigation Scroll Area */
.sidebar-nav-container {
    flex: 1 1 auto;
    overflow-y: auto;
    padding: 1rem 0.85rem;
    scrollbar-width: thin;
    scrollbar-color: rgba(255, 255, 255, 0.1) transparent;
}

.sidebar-nav-container::-webkit-scrollbar {
    width: 4px;
}
.sidebar-nav-container::-webkit-scrollbar-thumb {
    background: rgba(255, 255, 255, 0.12);
    border-radius: 4px;
}

/* Section Divider Headers */
.sidebar-section-header {
    font-size: 0.68rem;
    font-weight: 700;
    text-transform: uppercase;
    letter-spacing: 0.8px;
    color: #64748b;
    padding: 0.75rem 0.65rem 0.35rem 0.65rem;
    margin-top: 0.5rem;
}

/* Nav Link Items */
.sidebar-link {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 0.65rem 0.85rem;
    margin-bottom: 0.25rem;
    border-radius: 9px;
    color: #94a3b8 !important;
    text-decoration: none !important;
    font-size: 0.875rem;
    font-weight: 500;
    transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
    position: relative;
    border: 1px solid transparent;
}

.sidebar-link:hover {
    color: #f8fafc !important;
    background: rgba(255, 255, 255, 0.05);
    border-color: rgba(255, 255, 255, 0.06);
    transform: translateX(2px);
}

.sidebar-link.active {
    color: #ffffff !important;
    background: linear-gradient(90deg, rgba(200, 70, 31, 0.22) 0%, rgba(200, 70, 31, 0.08) 100%) !important;
    border: 1px solid rgba(200, 70, 31, 0.38) !important;
    font-weight: 600;
    box-shadow: 0 2px 8px rgba(200, 70, 31, 0.15);
}

.sidebar-link.active::before {
    content: "";
    position: absolute;
    left: -1px;
    top: 6px;
    bottom: 6px;
    width: 3.5px;
    border-radius: 4px;
    background: #ea580c;
    box-shadow: 0 0 10px #ea580c;
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
    background: rgba(255, 255, 255, 0.04);
    color: #94a3b8;
    transition: all 0.2s ease;
    font-size: 0.95rem;
    flex-shrink: 0;
}

.sidebar-link:hover .sidebar-icon-wrap {
    color: #f1f5f9;
    background: rgba(255, 255, 255, 0.09);
}

.sidebar-link.active .sidebar-icon-wrap {
    background: #c8461f !important;
    color: #ffffff !important;
    box-shadow: 0 2px 8px rgba(200, 70, 31, 0.4);
}

/* Submenu Styling */
.sidebar-submenu {
    padding-left: 1.25rem;
    margin-top: 0.25rem;
    margin-bottom: 0.5rem;
    border-left: 1px dashed rgba(255, 255, 255, 0.12);
    margin-left: 1.45rem;
}

.sidebar-sublink {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 0.45rem 0.65rem;
    margin-bottom: 0.15rem;
    border-radius: 6px;
    color: #94a3b8 !important;
    text-decoration: none !important;
    font-size: 0.8125rem;
    transition: all 0.18s ease;
    position: relative;
}

.sidebar-sublink:hover {
    color: #ffffff !important;
    background: rgba(255, 255, 255, 0.04);
    transform: translateX(3px);
}

.sidebar-sublink.active {
    color: #ff8c66 !important;
    font-weight: 600;
    background: rgba(200, 70, 31, 0.12);
}

.sidebar-sublink.active i {
    color: #ff8c66 !important;
}

/* Chevron indicator */
.sidebar-chevron {
    font-size: 0.75rem;
    transition: transform 0.25s ease;
    color: #64748b;
}

.submenu-toggle[aria-expanded="true"] .sidebar-chevron {
    transform: rotate(180deg);
    color: #f8fafc;
}

/* Sidebar Footer / User Profile Area */
.sidebar-footer-box {
    padding: 0.9rem 1rem;
    border-top: 1px solid rgba(255, 255, 255, 0.08);
    background: rgba(15, 23, 42, 0.85);
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
    border: 2px solid rgba(200, 70, 31, 0.5);
    flex-shrink: 0;
}

.sidebar-user-name {
    font-size: 0.85rem;
    font-weight: 600;
    color: #ffffff;
    line-height: 1.2;
}

.sidebar-user-role {
    font-size: 0.7rem;
    color: #64748b;
}

.status-online-dot {
    width: 8px;
    height: 8px;
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
            <i class="fa-solid fa-xmark"></i>
        </a>

        <!-- Sidebar Brand / Logo Header -->
        <div class="sidebar-brand-box d-flex align-items-center justify-content-between">
            <a href="{{ route('dashboard.index') }}" class="d-flex align-items-center gap-2.5 text-decoration-none">
                <div class="sidebar-logo-icon">
                    <i class="fa-solid fa-feather-pointed"></i>
                </div>
                <div>
                    <div class="sidebar-brand-title font-heading">
                        Blog<span style="color: #ff6838;">Hub</span>
                    </div>
                    <div class="d-flex align-items-center gap-1.5 mt-0.5">
                        <span class="status-online-dot"></span>
                        <span class="sidebar-brand-badge">ADMIN PORTAL</span>
                    </div>
                </div>
            </a>
        </div>
        
        <!-- Navigation Menu Container -->
        <nav id="app-nav-main" class="sidebar-nav-container">
            <ul class="list-unstyled mb-0" id="menu-accordion">

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
                        <span class="badge bg-secondary bg-opacity-25 text-light small px-1.5 py-0.5 rounded font-mono" style="font-size: 0.7rem;">Manage</span>
                    </a>
                </li>

                <!-- Write / Create Article -->
                <li>
                    <a class="sidebar-link {{ Route::currentRouteName() == 'blogs.create' ? 'active' : '' }}" href="{{ route('blogs.create') }}">
                        <div class="d-flex align-items-center">
                            <span class="sidebar-icon-wrap" style="color: #ff7a50;">
                                <i class="fa-solid fa-pen-nib"></i>
                            </span>
                            <span>Write Article</span>
                        </div>
                        <span class="badge bg-danger bg-opacity-25 text-coral small px-1.5 py-0.5 rounded font-mono" style="font-size: 0.65rem; color: #ff7a50 !important;">+ New</span>
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
                            <span class="sidebar-icon-wrap" style="color: #38bdf8;">
                                <i class="fa-solid fa-globe"></i>
                            </span>
                            <span>Website Portions</span>
                        </div>
                        <div class="d-flex align-items-center gap-1.5">
                            <span class="badge bg-success bg-opacity-20 text-success small px-1 py-0 rounded font-mono" style="font-size: 0.65rem;">5 Sections</span>
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
                                <span class="badge bg-warning bg-opacity-20 text-warning px-1" style="font-size: 0.6rem;">Hero</span>
                            </a>

                            <!-- 2. Trending Now -->
                            <a class="sidebar-sublink {{ request()->is('dashboard/website/trending') ? 'active' : '' }}" 
                               href="{{ route('dashboard.website.section', 'trending') }}">
                                <span class="d-flex align-items-center">
                                    <i class="fa-solid fa-fire me-2 text-danger" style="width: 14px;"></i> 2. Trending Now
                                </span>
                                <span class="badge bg-danger bg-opacity-20 text-danger px-1" style="font-size: 0.6rem;">Hot</span>
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
            </ul>
        </nav>
        
        <!-- Sidebar Bottom: Admin User & Quick Live Site Action -->
        <div class="sidebar-footer-box">
            <div class="sidebar-user-card mb-2.5">
                <img src="{{ auth()->user()->avatar_url ?? 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=100' }}" 
                     alt="Admin Avatar" 
                     class="sidebar-user-avatar">
                <div class="overflow-hidden flex-grow-1">
                    <div class="sidebar-user-name text-truncate">
                        {{ auth()->user()->name ?? 'Administrator' }}
                    </div>
                    <div class="sidebar-user-role text-truncate">
                        <span class="badge bg-success bg-opacity-20 text-success p-0" style="font-size: 0.65rem;">Super Admin</span>
                    </div>
                </div>
            </div>

            <div class="d-grid gap-1.5">
                <a class="btn btn-sm w-100 text-white fw-semibold d-flex align-items-center justify-content-center gap-1.5" 
                   style="background: linear-gradient(135deg, #c8461f 0%, #ea580c 100%); font-size: 0.78rem; border-radius: 7px; padding: 6px 10px;" 
                   href="{{ route('home') }}" target="_blank">
                    <i class="fa-solid fa-arrow-up-right-from-square"></i>
                    <span>Visit Live Site</span>
                </a>
            </div>
        </div>
    </div>
</div>
