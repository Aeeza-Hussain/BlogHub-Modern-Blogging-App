@extends('layouts.app')

@section('title', 'Sign In — BlogHub')

@section('content')
<div class="bh-auth-wrapper">
  <div class="container">
    <div class="row justify-content-center align-items-center">
      <div class="col-12 col-sm-10 col-md-8 col-lg-5">
        
        <div class="bh-auth-card p-4 p-md-5">
          <!-- Header Logo & Title -->
          <div class="text-center mb-4">
            <div class="bh-auth-header-badge mb-3">
              <i class="fas fa-feather-alt fs-3"></i>
            </div>
            <h2 class="font-heading fw-bold fs-3 mb-1">Welcome Back</h2>
            <p class="text-muted small mb-0">Sign in to your BlogHub account to continue</p>
          </div>

          <!-- Alert for Form Validation Errors -->
          @if ($errors->any())
            <div class="alert alert-danger border-0 shadow-sm mb-4 rounded-3" role="alert">
              <div class="d-flex align-items-center gap-2 mb-1 fw-semibold">
                <i class="fas fa-exclamation-triangle text-danger"></i>
                <span>Authentication Error</span>
              </div>
              <ul class="mb-0 ps-3 small">
                @foreach ($errors->all() as $error)
                  <li>{{ $error }}</li>
                @endforeach
              </ul>
            </div>
          @endif

          <form method="POST" action="{{ route('login') }}" class="needs-validation" novalidate>
            @csrf

            <!-- Email Field -->
            <div class="mb-3">
              <label for="email" class="form-label font-mono small fw-semibold">Email Address</label>
              <div class="input-group bh-auth-input-group">
                <span class="input-group-text pe-2">
                  <i class="fas fa-envelope"></i>
                </span>
                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="name@example.com">
              </div>
              @error('email')
                <div class="text-danger small mt-1"><i class="fas fa-info-circle me-1"></i>{{ $message }}</div>
              @enderror
            </div>

            <!-- Password Field -->
            <div class="mb-3">
              <div class="d-flex justify-content-between align-items-center mb-1">
                <label for="password" class="form-label font-mono small fw-semibold mb-0">Password</label>
                @if (Route::has('forgot-password'))
                  <a href="{{ route('forgot-password') }}" class="small text-accent text-decoration-none fw-medium">Forgot Password?</a>
                @endif
              </div>
              <div class="input-group bh-auth-input-group">
                <span class="input-group-text pe-2">
                  <i class="fas fa-lock"></i>
                </span>
                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="••••••••">
                <button type="button" class="btn btn-outline-secondary border-start-0" id="togglePassword" aria-label="Toggle password visibility">
                  <i class="fas fa-eye" id="toggleIcon"></i>
                </button>
              </div>
              @error('password')
                <div class="text-danger small mt-1"><i class="fas fa-info-circle me-1"></i>{{ $message }}</div>
              @enderror
            </div>

            <!-- Remember Me Checkbox -->
            <div class="mb-4 form-check">
              <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember', true) ? 'checked' : '' }}>
              <label class="form-check-label small text-muted" for="remember">
                Keep me signed in on this device
              </label>
            </div>

            <!-- Submit Button -->
            <button type="submit" class="btn btn-bh-accent btn-lg w-100 py-2.5 font-mono fw-bold shadow-sm d-flex align-items-center justify-content-center gap-2">
              <span>Sign In</span>
              <i class="fas fa-arrow-right"></i>
            </button>
          </form>

          <!-- Register Prompt -->
          <div class="text-center mt-4 pt-3 border-top">
            <p class="small text-muted mb-0">
              Don't have an account yet? 
              <a href="{{ route('register') }}" class="fw-bold text-accent text-decoration-none ms-1">Create an Account</a>
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

    if (toggleBtn && passInput && toggleIcon) {
      toggleBtn.addEventListener('click', function () {
        const type = passInput.getAttribute('type') === 'password' ? 'text' : 'password';
        passInput.setAttribute('type', type);
        toggleIcon.classList.toggle('fa-eye');
        toggleIcon.classList.toggle('fa-eye-slash');
      });
    }
  });
</script>
@endpush
