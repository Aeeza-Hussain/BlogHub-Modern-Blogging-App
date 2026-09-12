@extends('layouts.app')

@section('title', 'Join as Author — BlogHub')

@section('content')
<section class="py-5 bg-light-subtle">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-8 col-lg-6">
        <div class="bh-card p-4 p-md-5">
          <div class="text-center mb-4">
            <div class="bg-accent text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 50px; height: 50px; background-color: var(--bh-accent);">
              <i class="fas fa-user-plus fs-4"></i>
            </div>
            <h2 class="font-heading fw-bold">Create Author Account</h2>
            <p class="text-muted small">Join 200+ writers sharing stories with over 45,000+ active readers.</p>
          </div>

          <form action="{{ route('register') }}" method="POST" class="needs-validation" novalidate>
            @csrf
            <div class="mb-3">
              <label for="name" class="form-label font-mono small fw-semibold">Full Name</label>
              <input type="text" name="name" id="name" class="form-control" placeholder="Devon Lane" required>
              <div class="invalid-feedback">Please enter your full name.</div>
            </div>

            <div class="mb-3">
              <label for="email" class="form-label font-mono small fw-semibold">Email Address</label>
              <input type="email" name="email" id="email" class="form-control" placeholder="devon@example.com" required>
              <div class="invalid-feedback">Please enter a valid email address.</div>
            </div>

            <div class="row g-3 mb-3">
              <div class="col-md-6">
                <label for="register-password" class="form-label font-mono small fw-semibold">Password</label>
                <div class="input-group">
                  <input type="password" name="password" id="register-password" class="form-control" placeholder="••••••••" required minlength="6">
                  <button type="button" class="btn btn-outline-secondary password-toggle-btn" data-target="register-password">
                    <i class="fas fa-eye"></i>
                  </button>
                </div>
              </div>

              <div class="col-md-6">
                <label for="password_confirmation" class="form-label font-mono small fw-semibold">Confirm Password</label>
                <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" placeholder="••••••••" required>
              </div>
            </div>

            <!-- Password Strength Meter (SRS 7.10) -->
            <div class="mb-3">
              <div class="d-flex justify-content-between small font-mono mb-1">
                <span class="text-muted">Password Strength:</span>
                <span id="password-strength-text" class="fw-bold">Too Short</span>
              </div>
              <div class="progress" style="height: 6px;">
                <div id="password-strength-bar" class="progress-bar bg-danger" role="progressbar" style="width: 0%"></div>
              </div>
            </div>

            <div class="mb-4 form-check">
              <input type="checkbox" name="terms" class="form-check-input" id="termsCheck" required>
              <label class="form-check-label small text-muted" for="termsCheck">
                I agree to the <a href="{{ route('terms') }}" class="text-accent">Terms & Conditions</a> and <a href="{{ route('privacy') }}" class="text-accent">Privacy Policy</a>.
              </label>
              <div class="invalid-feedback">You must accept terms to register.</div>
            </div>

            <button type="submit" class="btn btn-bh-accent btn-lg w-100 mb-3">Create Account</button>

            <div class="text-center small text-muted">
              Already have an account? <a href="{{ route('login') }}" class="fw-bold text-accent text-decoration-none">Sign In</a>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</section>
@endsection
