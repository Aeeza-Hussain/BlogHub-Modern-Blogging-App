@extends('layouts.app')

@section('title', 'About Us — BlogHub')

@section('content')
<!-- Hero Story -->
<section class="py-5 bg-light-subtle border-bottom">
  <div class="container text-center max-w-800 mx-auto">
    <span class="bh-badge bh-badge-coral mb-3">Our Platform Story</span>
    <h1 class="font-heading fw-bold display-4 mb-3">Independent Journalism & Editorial Quality.</h1>
    <p class="lead text-muted mb-0">
      BlogHub was founded with a singular mission: to provide independent writers, domain experts, and storytellers a modern stage designed for deep-form reading and visual excellence.
    </p>
  </div>
</section>

<!-- Mission & Vision Cards -->
<section class="py-5">
  <div class="container">
    <div class="row g-4 mb-5">
      <div class="col-md-6">
        <div class="bh-card p-5 h-100">
          <div class="bg-primary text-white rounded-circle d-inline-flex p-3 mb-3">
            <i class="fas fa-bullseye fs-3"></i>
          </div>
          <h3 class="font-heading fw-bold mb-3">Our Mission</h3>
          <p class="text-muted">
            To democratize high-grade digital publishing by offering readers insightful, curated content without algorithmic clutter or invasive banner noise.
          </p>
        </div>
      </div>

      <div class="col-md-6">
        <div class="bh-card p-5 h-100">
          <div class="bg-accent text-white rounded-circle d-inline-flex p-3 mb-3" style="background-color: var(--bh-accent);">
            <i class="fas fa-eye fs-3"></i>
          </div>
          <h3 class="font-heading fw-bold mb-3">Our Vision</h3>
          <p class="text-muted">
            To build a global community where technology, creative design, business strategies, and human stories intersect through thoughtful, long-form discourse.
          </p>
        </div>
      </div>
    </div>

    <!-- Meet Team Strip -->
    <div class="text-center mb-5">
      <h2 class="font-heading fw-bold">Editorial Team</h2>
      <p class="text-muted">Leading content curation and technical excellence at BlogHub</p>
    </div>

    <div class="row g-4">
      @foreach($team as $member)
        <div class="col-md-6 col-lg-3">
          <div class="bh-card p-4 text-center">
            <img src="{{ $member->avatar }}" alt="{{ $member->name }}" class="rounded-circle mb-3 shadow-sm" style="width: 80px; height: 80px; object-fit: cover;">
            <h5 class="font-heading fw-bold mb-1">{{ $member->name }}</h5>
            <span class="small font-mono text-muted d-block mb-2">{{ $member->specialty }}</span>
            <p class="small text-muted mb-0">{{ Str::limit($member->bio, 70) }}</p>
          </div>
        </div>
      @endforeach
    </div>
  </div>
</section>
@endsection
