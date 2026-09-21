@extends('layouts.app')

@section('title', 'Reset Password — BlogHub')

@section('content')
<div class="bh-auth-wrapper">
  <div class="container">
    <div class="row justify-content-center align-items-center">
      <div class="col-12 col-sm-10 col-md-8 col-lg-5">
        
        <div class="bh-auth-card p-4 p-md-5">
          <div class="text-center mb-4">
            <div class="bh-auth-header-badge mb-3">
              <i class="fas fa-key fs-3"></i>
            </div>
            <h2 class="font-heading fw-bold fs-3 mb-1">Reset Password</h2>
            <p class="text-muted small mb-0">Enter your email address and we'll send you instructions to reset your password.</p>
          </div>

          <form action="#" method="POST" class="needs-validation" novalidate>
            @csrf
            <div class="mb-4">
              <label for="forgot-email" class="form-label font-mono small fw-semibold">Registered Email Address</label>
              <div class="input-group bh-auth-input-group">
                <span class="input-group-text pe-2">
                  <i class="fas fa-envelope"></i>
                </span>
                <input type="email" id="forgot-email" class="form-control" placeholder="user@example.com" required>
              </div>
              <div class="invalid-feedback">Please enter a valid email address.</div>
            </div>

            <!-- OTP Input Preview State -->
            <div class="mb-4 d-none" id="otp-group">
              <label class="form-label font-mono small fw-semibold text-center d-block">6-Digit OTP Verification Code</label>
              <div class="d-flex gap-2 justify-content-center">
                <input type="text" maxlength="1" class="form-control text-center font-mono fw-bold fs-4" style="width: 42px;">
                <input type="text" maxlength="1" class="form-control text-center font-mono fw-bold fs-4" style="width: 42px;">
                <input type="text" maxlength="1" class="form-control text-center font-mono fw-bold fs-4" style="width: 42px;">
                <input type="text" maxlength="1" class="form-control text-center font-mono fw-bold fs-4" style="width: 42px;">
                <input type="text" maxlength="1" class="form-control text-center font-mono fw-bold fs-4" style="width: 42px;">
                <input type="text" maxlength="1" class="form-control text-center font-mono fw-bold fs-4" style="width: 42px;">
              </div>
            </div>

            <button type="submit" class="btn btn-bh-accent btn-lg w-100 mb-3 font-mono fw-bold shadow-sm">Send Reset Link</button>

            <div class="text-center small text-muted pt-2 border-top">
              Remember your password? <a href="{{ route('login') }}" class="fw-bold text-accent text-decoration-none ms-1">Back to Sign In</a>
            </div>
          </form>
        </div>

      </div>
    </div>
  </div>
</div>
@endsection
