@extends('layouts.app')

@section('title', 'Reset Password — BlogHub')

@section('content')
<section class="py-5 bg-light-subtle">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-8 col-lg-5">
        <div class="bh-card p-4 p-md-5">
          <div class="text-center mb-4">
            <div class="bg-secondary text-white rounded-circle d-inline-flex align-items-center justify-content-center mb-3" style="width: 50px; height: 50px;">
              <i class="fas fa-key fs-4"></i>
            </div>
            <h2 class="font-heading fw-bold">Reset Password</h2>
            <p class="text-muted small">Enter your email address and we'll send you instructions to reset your password.</p>
          </div>

          <form action="#" method="POST" class="needs-validation" data-ajax="true" novalidate>
            @csrf
            <div class="mb-4">
              <label for="forgot-email" class="form-label font-mono small fw-semibold">Registered Email Address</label>
              <input type="email" id="forgot-email" class="form-control" placeholder="user@example.com" required>
              <div class="invalid-feedback">Please enter a valid email address.</div>
            </div>

            <!-- OTP Input Preview State (SRS 7.10) -->
            <div class="mb-4 d-none" id="otp-group">
              <label class="form-label font-mono small fw-semibold text-center d-block">6-Digit OTP Verification Code</label>
              <div class="d-flex gap-2 justify-content-center">
                <input type="text" maxlength="1" class="form-control text-center font-mono fw-bold fs-4" style="width: 45px;">
                <input type="text" maxlength="1" class="form-control text-center font-mono fw-bold fs-4" style="width: 45px;">
                <input type="text" maxlength="1" class="form-control text-center font-mono fw-bold fs-4" style="width: 45px;">
                <input type="text" maxlength="1" class="form-control text-center font-mono fw-bold fs-4" style="width: 45px;">
                <input type="text" maxlength="1" class="form-control text-center font-mono fw-bold fs-4" style="width: 45px;">
                <input type="text" maxlength="1" class="form-control text-center font-mono fw-bold fs-4" style="width: 45px;">
              </div>
            </div>

            <button type="submit" class="btn btn-bh-accent btn-lg w-100 mb-3">Send Reset Link</button>

            <div class="text-center small text-muted">
              Remember your password? <a href="{{ route('login') }}" class="fw-bold text-accent text-decoration-none">Back to Login</a>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</section>
@endsection
