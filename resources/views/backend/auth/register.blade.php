@extends('layouts.app')

@section('title', 'Create Account — BlogHub')

@section('content')
<div class="bh-auth-wrapper">
  <div class="container">
    <div class="row justify-content-center align-items-center">
      <div class="col-12 col-sm-10 col-md-8 col-lg-6">
        
        <div class="bh-auth-card p-4 p-md-5">
          <!-- Header Logo & Title -->
          <div class="text-center mb-4">
            <div class="bh-auth-header-badge mb-3">
              <i class="fas fa-user-plus fs-3"></i>
            </div>
            <h2 class="font-heading fw-bold fs-3 mb-1">Create an Account</h2>
            <p class="text-muted small mb-0">Join BlogHub to publish articles, bookmark stories, and connect with top authors</p>
          </div>

          <!-- Alert for Form Validation Errors -->
          @if ($errors->any())
            <div class="alert alert-danger border-0 shadow-sm mb-4 rounded-3" role="alert">
              <div class="d-flex align-items-center gap-2 mb-1 fw-semibold">
                <i class="fas fa-exclamation-triangle text-danger"></i>
                <span>Registration Error</span>
              </div>
              <ul class="mb-0 ps-3 small">
                @foreach ($errors->all() as $error)
                  <li>{{ $error }}</li>
                @endforeach
              </ul>
            </div>
          @endif

          <form method="POST" action="{{ route('register') }}" class="needs-validation" novalidate>
            @csrf

            <!-- Full Name Field -->
            <div class="mb-3">
              <label for="name" class="form-label font-mono small fw-semibold">Full Name</label>
              <div class="input-group bh-auth-input-group">
                <span class="input-group-text pe-2">
                  <i class="fas fa-user"></i>
                </span>
                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus placeholder="Aleeza Fatima">
              </div>
              @error('name')
                <div class="text-danger small mt-1"><i class="fas fa-info-circle me-1"></i>{{ $message }}</div>
              @enderror
            </div>

            <!-- Email Field -->
            <div class="mb-3">
              <label for="email" class="form-label font-mono small fw-semibold">Email Address</label>
              <div class="input-group bh-auth-input-group">
                <span class="input-group-text pe-2">
                  <i class="fas fa-envelope"></i>
                </span>
                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="name@example.com">
              </div>
              @error('email')
                <div class="text-danger small mt-1"><i class="fas fa-info-circle me-1"></i>{{ $message }}</div>
              @enderror
            </div>

            <!-- Password Field -->
            <div class="mb-3">
              <label for="password" class="form-label font-mono small fw-semibold">Password</label>
              <div class="input-group bh-auth-input-group">
                <span class="input-group-text pe-2">
                  <i class="fas fa-lock"></i>
                </span>
                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password" placeholder="At least 6 characters">
                <button type="button" class="btn btn-outline-secondary border-start-0" id="togglePassword" aria-label="Toggle password visibility">
                  <i class="fas fa-eye" id="toggleIcon"></i>
                </button>
              </div>
              @error('password')
                <div class="text-danger small mt-1"><i class="fas fa-info-circle me-1"></i>{{ $message }}</div>
              @enderror
            </div>

            <!-- Confirm Password Field -->
            <div class="mb-4">
              <label for="password-confirm" class="form-label font-mono small fw-semibold">Confirm Password</label>
              <div class="input-group bh-auth-input-group">
                <span class="input-group-text pe-2">
                  <i class="fas fa-check-double"></i>
                </span>
                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password" placeholder="Re-enter your password">
                <button type="button" class="btn btn-outline-secondary border-start-0" id="toggleConfirmPassword" aria-label="Toggle confirm password visibility">
                  <i class="fas fa-eye" id="toggleConfirmIcon"></i>
                </button>
              </div>
            </div>

            <!-- Submit Button -->
            <button type="submit" class="btn btn-bh-accent btn-lg w-100 py-2.5 font-mono fw-bold shadow-sm d-flex align-items-center justify-content-center gap-2">
              <span>Register Account</span>
              <i class="fas fa-user-check"></i>
            </button>
          </form>

          <!-- Sign In Prompt -->
          <div class="text-center mt-4 pt-3 border-top">
            <p class="small text-muted mb-0">
              Already have a BlogHub account? 
              <a href="{{ route('login') }}" class="fw-bold text-accent text-decoration-none ms-1">Sign In Instead</a>
            </p>
          </div>

        </div>

      </div>
    </div>
  </div>
</div>
@endsection

@push('scripts')
<script>
  document.addEventListener('DOMContentLoaded', function () {
    const toggleBtn = document.getElementById('togglePassword');
    const passInput = document.getElementById('password');
    const toggleIcon = document.getElementById('toggleIcon');

    const toggleConfirmBtn = document.getElementById('toggleConfirmPassword');
    const confirmInput = document.getElementById('password-confirm');
    const toggleConfirmIcon = document.getElementById('toggleConfirmIcon');

    if (toggleBtn && passInput && toggleIcon) {
      toggleBtn.addEventListener('click', function () {
        const type = passInput.getAttribute('type') === 'password' ? 'text' : 'password';
        passInput.setAttribute('type', type);
        toggleIcon.classList.toggle('fa-eye');
        toggleIcon.classList.toggle('fa-eye-slash');
      });
    }

    if (toggleConfirmBtn && confirmInput && toggleConfirmIcon) {
      toggleConfirmBtn.addEventListener('click', function () {
        const type = confirmInput.getAttribute('type') === 'password' ? 'text' : 'password';
        confirmInput.setAttribute('type', type);
        toggleConfirmIcon.classList.toggle('fa-eye');
        toggleConfirmIcon.classList.toggle('fa-eye-slash');
      });
    }
  });
</script>
@endpush
