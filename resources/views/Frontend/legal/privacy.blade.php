@extends('layouts.app')

@section('title', 'Privacy Policy — BlogHub')

@section('content')
<section class="py-5">
  <div class="container">
    <div class="row g-4">
      <!-- Sticky Table of Contents (SRS 7.11) -->
      <div class="col-lg-3">
        <div class="bh-card p-3 sticky-top" style="top: 90px;">
          <h6 class="font-heading fw-bold mb-3 border-bottom pb-2">Table of Contents</h6>
          <nav class="nav nav-pills flex-column small font-mono">
            <a class="nav-link text-muted" href="#sec-1">1. Information We Collect</a>
            <a class="nav-link text-muted" href="#sec-2">2. How We Use Data</a>
            <a class="nav-link text-muted" href="#sec-3">3. Cookies & Analytics</a>
            <a class="nav-link text-muted" href="#sec-4">4. Data Protection & Rights</a>
          </nav>
        </div>
      </div>

      <!-- Legal Content Body -->
      <div class="col-lg-9">
        <div class="bh-card p-4 p-md-5">
          <span class="bh-badge bh-badge-navy mb-2">Legal Transparency</span>
          <h1 class="font-heading fw-bold display-5 mb-2">Privacy Policy</h1>
          <p class="text-muted font-mono small mb-4">Last Updated: September 12, 2026</p>

          <div id="sec-1" class="mb-5">
            <h3 class="font-heading fw-bold mb-3">1. Information We Collect</h3>
            <p class="text-muted">We collect personal information that you voluntarily provide to us when registering an author account, subscribing to our newsletter, or submitting contact forms. This may include your full name, email address, bio details, and profile images.</p>
          </div>

          <div id="sec-2" class="mb-5">
            <h3 class="font-heading fw-bold mb-3">2. How We Use Your Data</h3>
            <p class="text-muted">Your data is utilized solely for authenticating your account, rendering your author bylines across published articles, delivering newsletter digests, and improving site performance and security.</p>
          </div>

          <div id="sec-3" class="mb-5">
            <h3 class="font-heading fw-bold mb-3">3. Cookies & Analytics</h3>
            <p class="text-muted">We use local storage and essential session cookies to remember your visual preferences (such as Dark Mode selection) and maintain secure session states during your visit.</p>
          </div>

          <div id="sec-4" class="mb-4">
            <h3 class="font-heading fw-bold mb-3">4. Data Protection & Rights</h3>
            <p class="text-muted">You have the full right to inspect, update, or request erasure of your profile data at any time by contacting our support team at privacy@bloghub.com.</p>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
@endsection
