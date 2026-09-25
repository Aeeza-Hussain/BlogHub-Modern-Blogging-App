<nav class="navbar navbar-expand-lg bh-navbar sticky-top">
  <div class="container">
    <!-- Brand Logo -->
    <a class="navbar-brand d-flex align-items-center gap-2" href="{{ route('home') }}">
      <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 38px; height: 38px;">
        <i class="fas fa-feather-alt"></i>
      </div>
      <span class="font-heading fw-bold fs-4 text-white">Blog<span class="text-accent" style="color: var(--bh-accent);">Hub</span></span>
    </a>

    @if(request()->routeIs('login', 'register') || request()->is('login', 'register'))
      <!-- Simplified Navbar for Auth Pages -->
      <div class="d-flex align-items-center gap-2 gap-sm-3">
        @if(request()->routeIs('login') || request()->is('login'))
          <a href="{{ route('register') }}" class="btn btn-sm btn-bh-accent fw-semibold">Create Account</a>
        @else
          <a href="{{ route('login') }}" class="btn btn-sm btn-outline-light fw-semibold">Sign In</a>
        @endif
        <button id="dark-mode-toggle" class="btn btn-sm btn-outline-light rounded-circle" style="width: 36px; height: 36px;" aria-label="Toggle dark mode">
          <i class="fas fa-moon"></i>
        </button>
      </div>
    @else
      <!-- Mobile Offcanvas Toggler -->
      <button class="navbar-toggler text-white border-0" type="button" data-bs-toggle="offcanvas" data-bs-target="#bhNavbarOffcanvas" aria-controls="bhNavbarOffcanvas" aria-label="Toggle navigation">
        <i class="fas fa-bars fs-4"></i>
      </button>

      <!-- Navbar Items Desktop & Offcanvas -->
      <div class="offcanvas offcanvas-end text-bg-dark" tabindex="-1" id="bhNavbarOffcanvas" aria-labelledby="bhNavbarLabel">
        <div class="offcanvas-header border-bottom border-secondary">
          <h5 class="offcanvas-title font-heading" id="bhNavbarLabel">BlogHub</h5>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        
        <div class="offcanvas-body align-items-center">
          <!-- Links -->
          <ul class="navbar-nav me-auto mb-2 mb-lg-0">
            <li class="nav-item">
              <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">Home</a>
            </li>
            <li class="nav-item">
              <a class="nav-link {{ request()->routeIs('blogs.*') ? 'active' : '' }}" href="{{ route('blogs.index') }}">Blogs</a>
            </li>
            <li class="nav-item">
              <a class="nav-link {{ request()->routeIs('categories.*') ? 'active' : '' }}" href="{{ route('categories.index') }}">Categories</a>
            </li>
            <li class="nav-item">
              <a class="nav-link {{ request()->routeIs('authors.*') ? 'active' : '' }}" href="{{ route('authors.index') }}">Authors</a>
            </li>
            <li class="nav-item">
              <a class="nav-link {{ request()->routeIs('about') ? 'active' : '' }}" href="{{ route('about') }}">About</a>
            </li>
            <li class="nav-item">
              <a class="nav-link {{ request()->routeIs('contact') ? 'active' : '' }}" href="{{ route('contact') }}">Contact</a>
            </li>
          </ul>

          <!-- Search Bar with Live Suggestions -->
          <div class="position-relative me-lg-3 my-2 my-lg-0" style="min-width: 220px;">
            <form action="{{ route('search') }}" method="GET" class="d-flex align-items-center position-relative">
              <input type="text" name="q" id="nav-search-input" class="form-control form-control-sm bg-dark-subtle text-white border-secondary pe-4" placeholder="Search articles..." value="{{ request('q') }}" autocomplete="off">
              <button type="submit" class="btn btn-sm text-white position-absolute end-0 me-1 border-0" aria-label="Search">
                <i class="fas fa-search"></i>
              </button>
            </form>
            <div id="nav-search-suggestions" class="position-absolute start-0 end-0 mt-1 d-none" style="z-index: 1060;"></div>
          </div>

          <!-- Right Action Items: Auth & Dark Mode Toggle -->
          <div class="d-flex align-items-center gap-2 mt-3 mt-lg-0">
            <button id="dark-mode-toggle" class="btn btn-sm btn-outline-light rounded-circle" style="width: 36px; height: 36px;" aria-label="Toggle dark mode">
              <i class="fas fa-moon"></i>
            </button>

            @auth
              <div class="dropdown">
                <button class="btn btn-sm btn-outline-light dropdown-toggle d-flex align-items-center gap-2 px-3" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                  <i class="fas fa-user-circle fs-6"></i>
                  <span>{{ Auth::user()->name }}</span>
                </button>
                <ul class="dropdown-menu dropdown-menu-end dropdown-menu-dark shadow">
                  <li>
                    <a class="dropdown-item" href="{{ route('dashboard.index') }}">
                      <i class="fas fa-tachometer-alt me-2 text-accent"></i> Dashboard
                    </a>
                  </li>
                  <li>
                    <a class="dropdown-item" href="{{ route('blogs.create') }}">
                      <i class="fas fa-pen-nib me-2 text-accent"></i> Create Article
                    </a>
                  </li>
                  <li><hr class="dropdown-divider"></li>
                  <li>
                    <form action="{{ route('logout') }}" method="POST" class="d-inline">
                      @csrf
                      <button type="submit" class="dropdown-item text-danger">
                        <i class="fas fa-sign-out-alt me-2"></i> Logout
                      </button>
                    </form>
                  </li>
                </ul>
              </div>
            @else
              <a href="{{ route('login') }}" class="btn btn-sm btn-outline-light px-3">Login</a>
              <a href="{{ route('register') }}" class="btn btn-sm btn-bh-accent px-3">Register</a>
            @endauth
          </div>

        </div>
      </div>
    @endif

  </div>
</nav>
