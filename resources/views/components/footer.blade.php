<footer class="bh-footer mt-auto">
  <div class="container">
    <div class="row g-4 pb-4">
      <!-- Col 1: Brand Info -->
      <div class="col-lg-4 col-md-6">
        <a href="{{ route('home') }}" class="d-flex align-items-center gap-2 mb-3 text-decoration-none">
          <div class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 36px; height: 36px;">
            <i class="fas fa-feather-alt"></i>
          </div>
          <span class="font-heading fw-bold fs-4 text-white">Blog<span style="color: var(--bh-accent);">Hub</span></span>
        </a>
        <p class="small text-muted mb-3">
          BlogHub is a modern publishing & content management platform delivering high-quality articles across Technology, Design, Travel, Business, and Culture.
        </p>
        <div class="d-flex gap-2">
          <a href="#" class="btn btn-sm btn-outline-light rounded-circle" style="width:34px; height:34px;" aria-label="Twitter"><i class="fab fa-twitter"></i></a>
          <a href="#" class="btn btn-sm btn-outline-light rounded-circle" style="width:34px; height:34px;" aria-label="GitHub"><i class="fab fa-github"></i></a>
          <a href="#" class="btn btn-sm btn-outline-light rounded-circle" style="width:34px; height:34px;" aria-label="LinkedIn"><i class="fab fa-linkedin-in"></i></a>
          <a href="#" class="btn btn-sm btn-outline-light rounded-circle" style="width:34px; height:34px;" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
        </div>
      </div>

      <!-- Col 2: Quick Links -->
      <div class="col-lg-2 col-md-6 col-6">
        <h6 class="text-white font-heading mb-3">Quick Links</h6>
        <ul class="list-unstyled small d-flex flex-column gap-2">
          <li><a href="{{ route('home') }}">Home</a></li>
          <li><a href="{{ route('blogs.index') }}">All Articles</a></li>
          <li><a href="{{ route('categories.index') }}">Categories</a></li>
          <li><a href="{{ route('authors.index') }}">Authors Directory</a></li>
          <li><a href="{{ route('about') }}">About Us</a></li>
          <li><a href="{{ route('contact') }}">Contact Support</a></li>
        </ul>
      </div>

      <!-- Col 3: Legal & Auth -->
      <div class="col-lg-2 col-md-6 col-6">
        <h6 class="text-white font-heading mb-3">Resources</h6>
        <ul class="list-unstyled small d-flex flex-column gap-2">
          <li><a href="{{ route('privacy') }}">Privacy Policy</a></li>
          <li><a href="{{ route('terms') }}">Terms & Conditions</a></li>
          <li><a href="{{ route('login') }}">Member Login</a></li>
          <li><a href="{{ route('register') }}">Join as Author</a></li>
          <li><a href="{{ route('forgot-password') }}">Reset Password</a></li>
        </ul>
      </div>

      <!-- Col 4: Newsletter -->
      <div class="col-lg-4 col-md-6">
        <h6 class="text-white font-heading mb-3">Weekly Newsletter</h6>
        <p class="small text-muted mb-3">Subscribe to get our weekly digest of top stories and industry insights directly in your inbox.</p>
        <form class="needs-validation" data-ajax="true" novalidate>
          <div class="input-group mb-2">
            <input type="email" class="form-control form-control-sm bg-dark text-white border-secondary" placeholder="Enter your email" required>
            <button class="btn btn-sm btn-bh-accent px-3" type="submit">Subscribe</button>
          </div>
          <div class="invalid-feedback small">Please enter a valid email address.</div>
        </form>
      </div>
    </div>

    <!-- Bottom Line -->
    <div class="border-top border-secondary pt-3 text-center small text-muted">
      <p class="mb-0">&copy; {{ date('Y') }} BlogHub Pvt. Ltd. All rights reserved. Built for Capstone Evaluation.</p>
    </div>
  </div>
</footer>
