@extends('layouts.app')

@section('title', 'Member Login — BlogHub')

@section('content')
<section class="py-5 bg-light-subtle">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-8 col-lg-5">
        <div class="bh-card p-4 p-md-5">
          <div class="text-center mb-4">
            <div class="bg-primary text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 50px; height: 50px;">
              <i class="fas fa-user-lock fs-4"></i>
            </div>
            <h2 class="font-heading fw-bold">Welcome Back</h2>
            <p class="text-muted small">Sign in to manage your articles, bookmarks, and author profile.</p>
          </div>

          <form action="{{ route('login') }}" method="POST" class="needs-validation" novalidate>
            @csrf
            <div class="mb-3">
              <label for="email" class="form-label font-mono small fw-semibold">Email or Username</label>
              <input type="email" name="email" id="email" class="form-control" placeholder="user@example.com" required>
              <div class="invalid-feedback">Please enter your email or username.</div>
            </div>

            <div class="mb-3">
              <div class="d-flex justify-content-between align-items-center mb-1">
                <label for="login-password" class="form-label font-mono small fw-semibold mb-0">Password</label>
                <a href="{{ route('forgot-password') }}" class="small text-accent text-decoration-none">Forgot password?</a>
              </div>
              <div class="input-group">
                <input type="password" name="password" id="login-password" class="form-control" placeholder="••••••••" required>
                <button type="button" class="btn btn-outline-secondary password-toggle-btn" data-target="login-password" aria-label="Toggle password visibility">
                  <i class="fas fa-eye"></i>
                </button>
              </div>
              <div class="invalid-feedback">Please enter your password.</div>
            </div>

            <div class="mb-4 form-check">
              <input type="checkbox" name="remember" class="form-check-input" id="rememberMe">
              <label class="form-check-input-label small text-muted" for="rememberMe">Remember me on this device</label>
            </div>

            <button type="submit" class="btn btn-bh-accent btn-lg w-100 mb-3">Sign In</button>

            <div class="text-center small text-muted">
              Don't have an account? <a href="{{ route('register') }}" class="fw-bold text-accent text-decoration-none">Register as Author</a>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</section>
@endsection
