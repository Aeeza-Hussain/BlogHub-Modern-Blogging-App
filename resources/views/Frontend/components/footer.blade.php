<footer class="bh-footer-wrapper mt-auto">
  <!-- Top Gradient Accent Bar -->
  <div class="bh-footer-accent-bar"></div>
  
  <!-- Subtle Glowing Background Element -->
  <div class="bh-footer-brand-glow"></div>

  <!-- Feature Highlights Band -->
  <div class="bh-footer-feature-band d-none d-md-block">
    <div class="container">
      <div class="row text-center text-lg-start g-3 justify-content-between">
        <div class="col-auto">
          <div class="bh-footer-feature-item">
            <i class="fas fa-bolt"></i>
            <span>High Performance & Speed</span>
          </div>
        </div>
        <div class="col-auto">
          <div class="bh-footer-feature-item">
            <i class="fas fa-shield-alt"></i>
            <span>Secure Content Architecture</span>
          </div>
        </div>
        <div class="col-auto">
          <div class="bh-footer-feature-item">
            <i class="fas fa-moon"></i>
            <span>Light & Dark Mode Enabled</span>
          </div>
        </div>
        <div class="col-auto">
          <div class="bh-footer-feature-item">
            <i class="fas fa-feather-alt"></i>
            <span>Independent Author Platform</span>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Main Footer Content -->
  <div class="container pt-5 pb-4">
    <div class="row g-4 justify-content-between">
      
      <!-- Col 1: Brand Info & Bio -->
      <div class="col-lg-4 col-md-6">
        <a href="{{ route('home') }}" class="d-inline-flex align-items-center gap-2 mb-3 text-decoration-none">
          @if(setting('site_logo'))
            <img src="{{ asset('storage/' . setting('site_logo')) }}" alt="{{ setting('site_name', 'BlogHub') }}" style="max-height: 40px; width: auto; object-fit: contain;">
          @else
            <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center shadow-sm" style="width: 40px; height: 40px;">
              <i class="fas fa-feather-alt fs-5"></i>
            </div>
          @endif
          <span class="font-heading fw-bold fs-3 text-white">{{ setting('site_name', 'BlogHub') }}</span>
          <span class="badge bg-danger rounded-pill ms-1 font-mono" style="font-size: 0.65rem; background-color: var(--bh-accent) !important;">V2.0</span>
        </a>
        <p class="small text-muted mb-4 lh-lg" style="color: #94A3B8 !important;">
          {{ setting('site_description', 'BlogHub is a next-generation blogging and digital publishing platform built for storytellers, researchers, and technical writers to publish high-impact articles across multiple categories.') }}
        </p>

        <!-- Social Icons with Hover Animations -->
        <div class="d-flex align-items-center gap-2">
          @if(setting('social_twitter'))
            <a href="{{ setting('social_twitter') }}" target="_blank" rel="noopener noreferrer" class="bh-social-icon" aria-label="Twitter" title="Twitter / X"><i class="fab fa-x-twitter"></i></a>
          @endif
          @if(setting('social_github'))
            <a href="{{ setting('social_github') }}" target="_blank" rel="noopener noreferrer" class="bh-social-icon" aria-label="GitHub" title="GitHub"><i class="fab fa-github"></i></a>
          @endif
          @if(setting('social_linkedin'))
            <a href="{{ setting('social_linkedin') }}" target="_blank" rel="noopener noreferrer" class="bh-social-icon" aria-label="LinkedIn" title="LinkedIn"><i class="fab fa-linkedin-in"></i></a>
          @endif
          @if(setting('social_instagram'))
            <a href="{{ setting('social_instagram') }}" target="_blank" rel="noopener noreferrer" class="bh-social-icon" aria-label="Instagram" title="Instagram"><i class="fab fa-instagram"></i></a>
          @endif
          @if(setting('social_youtube'))
            <a href="{{ setting('social_youtube') }}" target="_blank" rel="noopener noreferrer" class="bh-social-icon" aria-label="YouTube" title="YouTube"><i class="fab fa-youtube"></i></a>
          @endif
          @if(setting('social_facebook'))
            <a href="{{ setting('social_facebook') }}" target="_blank" rel="noopener noreferrer" class="bh-social-icon" aria-label="Facebook" title="Facebook"><i class="fab fa-facebook-f"></i></a>
          @endif
        </div>
      </div>

      <!-- Col 2: Navigation Links -->
      <div class="col-lg-2 col-md-6 col-6">
        <h6 class="bh-footer-heading">Navigation</h6>
        <ul class="list-unstyled bh-footer-links d-flex flex-column gap-2 mb-0">
          <li><a href="{{ route('home') }}"><i class="fas fa-chevron-right text-accent me-1" style="font-size: 0.7rem;"></i> Home</a></li>
          <li><a href="{{ route('blogs.index') }}"><i class="fas fa-chevron-right text-accent me-1" style="font-size: 0.7rem;"></i> All Articles</a></li>
          <li><a href="{{ route('categories.index') }}"><i class="fas fa-chevron-right text-accent me-1" style="font-size: 0.7rem;"></i> Categories</a></li>
          <li><a href="{{ route('authors.index') }}"><i class="fas fa-chevron-right text-accent me-1" style="font-size: 0.7rem;"></i> Authors Directory</a></li>
          <li><a href="{{ route('about') }}"><i class="fas fa-chevron-right text-accent me-1" style="font-size: 0.7rem;"></i> About Us</a></li>
          <li><a href="{{ route('contact') }}"><i class="fas fa-chevron-right text-accent me-1" style="font-size: 0.7rem;"></i> Contact Support</a></li>
        </ul>
      </div>

      <!-- Col 3: Resources & Account -->
      <div class="col-lg-2 col-md-6 col-6">
        <h6 class="bh-footer-heading">Resources</h6>
        <ul class="list-unstyled bh-footer-links d-flex flex-column gap-2 mb-0">
          <li><a href="{{ route('blogs.create') }}"><i class="fas fa-pen text-accent me-1" style="font-size: 0.7rem;"></i> Write Article</a></li>
          <li><a href="{{ route('login') }}"><i class="fas fa-user-lock text-accent me-1" style="font-size: 0.7rem;"></i> Member Login</a></li>
          @if(setting('enable_public_registration', true))
            <li><a href="{{ route('register') }}"><i class="fas fa-user-plus text-accent me-1" style="font-size: 0.7rem;"></i> Join as Author</a></li>
          @endif
          <li><a href="{{ route('privacy') }}"><i class="fas fa-shield-alt text-accent me-1" style="font-size: 0.7rem;"></i> Privacy Policy</a></li>
          <li><a href="{{ route('terms') }}"><i class="fas fa-file-contract text-accent me-1" style="font-size: 0.7rem;"></i> Terms of Service</a></li>
        </ul>
      </div>

      <!-- Col 4: Newsletter Box (Glassmorphic) -->
      <div class="col-lg-4 col-md-6">
        <div class="bh-newsletter-card">
          <h6 class="text-white font-heading fw-bold mb-2">Subscribe to Newsletter</h6>
          <p class="small text-muted mb-3" style="color: #94A3B8 !important;">Get hand-curated weekly digests, trending tech topics, and author spotlights straight to your inbox.</p>
          
          <form id="bh-newsletter-form" action="{{ route('newsletter.subscribe') }}" method="POST" novalidate>
            @csrf
            <div id="bh-newsletter-alert" class="d-none alert py-2 px-3 small mb-2 border-0 rounded-3" role="alert"></div>

            <div class="position-relative mb-2">
              <i class="fas fa-envelope text-muted position-absolute top-50 start-0 translate-middle-y ms-3"></i>
              <input type="email" id="bh-newsletter-email" name="email" class="form-control form-control-sm" placeholder="yourname@domain.com" required autocomplete="email">
              <div class="invalid-feedback small">Please enter a valid email address.</div>
            </div>
            <button id="bh-newsletter-btn" class="btn btn-sm btn-bh-accent w-100 fw-bold py-2" type="submit">
              <span class="btn-text"><i class="fas fa-paper-plane me-1"></i> Subscribe Now</span>
              <span class="btn-spinner d-none"><span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span> Subscribing...</span>
            </button>
          </form>

          <span class="small font-mono text-muted d-block mt-2" style="font-size: 0.72rem;">
            <i class="fas fa-lock me-1"></i> We respect your privacy. Unsubscribe anytime.
          </span>
        </div>
      </div>

    </div>

    <!-- Bottom Copyright & Legal Line -->
    <div class="border-top border-secondary border-opacity-25 pt-4 mt-5 d-flex flex-column flex-md-row align-items-center justify-content-between gap-3 text-center text-md-start small">
      <div>
        <p class="mb-0 text-muted">&copy; {{ date('Y') }} <strong class="text-white">{{ setting('site_name', 'BlogHub') }}</strong>. All rights reserved.</p>
      </div>

      <div class="d-flex align-items-center gap-3 font-mono">
        <a href="{{ route('privacy') }}" class="text-muted text-decoration-none hover-white">Privacy</a>
        <span class="text-muted">•</span>
        <a href="{{ route('terms') }}" class="text-muted text-decoration-none hover-white">Terms</a>
        <span class="text-muted">•</span>
        <a href="{{ route('contact') }}" class="text-muted text-decoration-none hover-white">Contact</a>
      </div>
    </div>
  </div>
</footer>
