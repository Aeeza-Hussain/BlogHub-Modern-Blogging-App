<div id="app-sidepanel" class="app-sidepanel"> 
    <div id="sidepanel-drop" class="sidepanel-drop"></div>
    <div class="sidepanel-inner d-flex flex-column">
        <a href="#" id="sidepanel-close" class="sidepanel-close d-xl-none">&times;</a>
        <div class="app-branding">
            <a class="app-logo" href="{{ route('dashboard.index') }}">
                <span class="logo-text fw-bold text-primary fs-4">Blog<span class="text-dark">Hub</span></span>
            </a>
        </div><!--//app-branding-->  
        
        <nav id="app-nav-main" class="app-nav app-nav-main flex-grow-1">
            <ul class="app-menu list-unstyled accordion" id="menu-accordion">
                <li class="nav-item">
                    <a class="nav-link {{ Route::currentRouteName() == 'dashboard.index' ? 'active' : '' }}" href="{{ route('dashboard.index') }}">
                        <span class="nav-icon"><i class="fa-solid fa-chart-pie fs-5"></i></span>
                        <span class="nav-link-text">Overview</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ Route::currentRouteName() == 'dashboard.articles' ? 'active' : '' }}" href="{{ route('dashboard.articles') }}">
                        <span class="nav-icon"><i class="fa-solid fa-newspaper fs-5"></i></span>
                        <span class="nav-link-text">Articles</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('blogs.create') }}">
                        <span class="nav-icon"><i class="fa-solid fa-pen-to-square fs-5"></i></span>
                        <span class="nav-link-text">Create Article</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ Route::currentRouteName() == 'dashboard.charts' ? 'active' : '' }}" href="{{ route('dashboard.charts') }}">
                        <span class="nav-icon"><i class="fa-solid fa-chart-line fs-5"></i></span>
                        <span class="nav-link-text">Analytics</span>
                    </a>
                </li>
                <!-- Website Home Portions Dropdown -->
                <li class="nav-item has-submenu">
                    <a class="nav-link submenu-toggle {{ request()->routeIs('dashboard.website*') ? 'active' : '' }}" href="#" data-bs-toggle="collapse" data-bs-target="#submenu-website" aria-expanded="{{ request()->routeIs('dashboard.website*') ? 'true' : 'false' }}">
                        <span class="nav-icon"><i class="fa-solid fa-globe fs-5"></i></span>
                        <span class="nav-link-text">Website</span>
                        <span class="submenu-arrow"><i class="fa-solid fa-chevron-down"></i></span>
                    </a>
                    <div id="submenu-website" class="collapse submenu {{ request()->routeIs('dashboard.website*') ? 'show' : '' }}" data-bs-parent="#menu-accordion">
                        <ul class="submenu-list list-unstyled">
                            <li class="submenu-item">
                                <a class="submenu-link {{ (request()->is('dashboard/website') && !request()->route('section')) || request()->is('dashboard/website/all') ? 'active' : '' }}" href="{{ route('dashboard.website') }}">
                                    <i class="fa-solid fa-layer-group me-2 text-primary"></i> All Portions
                                </a>
                            </li>
                            <li class="submenu-item">
                                <a class="submenu-link {{ request()->is('dashboard/website/discover') ? 'active' : '' }}" href="{{ route('dashboard.website.section', 'discover') }}">
                                    <i class="fa-solid fa-wand-magic-sparkles me-2 text-warning"></i> Discover Stories
                                </a>
                            </li>
                            <li class="submenu-item">
                                <a class="submenu-link {{ request()->is('dashboard/website/trending') ? 'active' : '' }}" href="{{ route('dashboard.website.section', 'trending') }}">
                                    <i class="fa-solid fa-fire me-2 text-danger"></i> Trending Now
                                </a>
                            </li>
                            <li class="submenu-item">
                                <a class="submenu-link {{ request()->is('dashboard/website/topics') ? 'active' : '' }}" href="{{ route('dashboard.website.section', 'topics') }}">
                                    <i class="fa-solid fa-shapes me-2 text-success"></i> Explore Topics
                                </a>
                            </li>
                            <li class="submenu-item">
                                <a class="submenu-link {{ request()->is('dashboard/website/latest-articles') ? 'active' : '' }}" href="{{ route('dashboard.website.section', 'latest-articles') }}">
                                    <i class="fa-solid fa-newspaper me-2 text-info"></i> Latest Articles
                                </a>
                            </li>
                            <li class="submenu-item">
                                <a class="submenu-link {{ request()->is('dashboard/website/authors') ? 'active' : '' }}" href="{{ route('dashboard.website.section', 'authors') }}">
                                    <i class="fa-solid fa-users me-2 text-secondary"></i> Meet Our Authors
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item has-submenu">
                    <a class="nav-link submenu-toggle {{ in_array(Route::currentRouteName(), ['dashboard.notifications', 'dashboard.account', 'dashboard.settings']) ? 'active' : '' }}" href="#" data-bs-toggle="collapse" data-bs-target="#submenu-1" aria-expanded="{{ in_array(Route::currentRouteName(), ['dashboard.notifications', 'dashboard.account', 'dashboard.settings']) ? 'true' : 'false' }}">
                        <span class="nav-icon"><i class="fa-solid fa-folder-open fs-5"></i></span>
                        <span class="nav-link-text">Account & Pages</span>
                        <span class="submenu-arrow"><i class="fa-solid fa-chevron-down"></i></span>
                    </a>
                    <div id="submenu-1" class="collapse submenu {{ in_array(Route::currentRouteName(), ['dashboard.notifications', 'dashboard.account', 'dashboard.settings']) ? 'show' : '' }}" data-bs-parent="#menu-accordion">
                        <ul class="submenu-list list-unstyled">
                            <li class="submenu-item"><a class="submenu-link {{ Route::currentRouteName() == 'dashboard.notifications' ? 'active' : '' }}" href="{{ route('dashboard.notifications') }}">Notifications</a></li>
                            <li class="submenu-item"><a class="submenu-link {{ Route::currentRouteName() == 'dashboard.account' ? 'active' : '' }}" href="{{ route('dashboard.account') }}">Account</a></li>
                            <li class="submenu-item"><a class="submenu-link {{ Route::currentRouteName() == 'dashboard.settings' ? 'active' : '' }}" href="{{ route('dashboard.settings') }}">Settings</a></li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ Route::currentRouteName() == 'dashboard.help' ? 'active' : '' }}" href="{{ route('dashboard.help') }}">
                        <span class="nav-icon"><i class="fa-solid fa-circle-question fs-5"></i></span>
                        <span class="nav-link-text">Help & Docs</span>
                    </a>
                </li>
            </ul>
        </nav>
        
        <div class="app-sidepanel-footer p-3 text-center border-top">
            <a class="btn btn-outline-primary w-100 btn-sm" href="{{ route('home') }}"><i class="fa-solid fa-house me-1"></i> Back to Main Site</a>
        </div>
    </div>
</div>
