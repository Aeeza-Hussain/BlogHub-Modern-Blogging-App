@extends('layouts.app')

@section('title', 'Terms & Conditions — BlogHub')

@section('content')
<section class="py-5">
  <div class="container">
    <div class="row g-4">
      <div class="col-lg-3">
        <div class="bh-card p-3 sticky-top" style="top: 90px;">
          <h6 class="font-heading fw-bold mb-3 border-bottom pb-2">Table of Contents</h6>
          <nav class="nav nav-pills flex-column small font-mono">
            <a class="nav-link text-muted" href="#terms-1">1. Acceptance of Terms</a>
            <a class="nav-link text-muted" href="#terms-2">2. Author Guidelines</a>
            <a class="nav-link text-muted" href="#terms-3">3. Intellectual Property</a>
          </nav>
        </div>
      </div>

      <div class="col-lg-9">
        <div class="bh-card p-4 p-md-5">
          <span class="bh-badge bh-badge-coral mb-2">Platform Agreement</span>
          <h1 class="font-heading fw-bold display-5 mb-2">Terms & Conditions</h1>
          <p class="text-muted font-mono small mb-4">Last Updated: September 12, 2026</p>

          <div id="terms-1" class="mb-5">
            <h3 class="font-heading fw-bold mb-3">1. Acceptance of Terms</h3>
            <p class="text-muted">By accessing or using BlogHub, you agree to be bound by these Terms & Conditions. If you disagree with any part of these terms, you may not access our services.</p>
          </div>

          <div id="terms-2" class="mb-5">
            <h3 class="font-heading fw-bold mb-3">2. Author Guidelines & Conduct</h3>
            <p class="text-muted">Authors are solely responsible for the content they publish. Articles containing plagiarism, hate speech, illegal material, or misleading information will be removed immediately.</p>
          </div>

          <div id="terms-3" class="mb-4">
            <h3 class="font-heading fw-bold mb-3">3. Intellectual Property Rights</h3>
            <p class="text-muted">Authors retain full ownership of their original written works while granting BlogHub a non-exclusive license to display, index, and promote their articles on our public platform.</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
@endsection
