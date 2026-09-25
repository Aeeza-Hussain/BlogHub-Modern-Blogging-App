@extends('layouts.app')

@section('title', '404 — Page Not Found | BlogHub')

@section('content')
<section class="py-5 my-auto">
  <div class="container text-center max-w-700 mx-auto">
    <div class="bh-card p-5 shadow-sm">
      <div class="display-1 font-heading fw-bold text-accent mb-2" style="color: var(--bh-accent); font-size: 6rem;">404</div>
      <h2 class="font-heading fw-bold mb-3">Oops! Story Not Found</h2>
      <p class="text-muted mb-4 pe-md-4 ps-md-4">
        The page or article you are looking for might have been moved, renamed, or is temporarily unavailable. Let's get you back on track!
      </p>

      <!-- Search Bar -->
      <form action="{{ route('search') }}" method="GET" class="mb-4 max-w-500 mx-auto">
        <div class="input-group">
          <input type="text" name="q" class="form-control" placeholder="Search for articles, topics, or authors...">
          <button type="submit" class="btn btn-bh-accent"><i class="fas fa-search"></i> Search</button>
        </div>
      </form>

      <div class="d-flex flex-wrap justify-content-center gap-3">
        <a href="{{ route('home') }}" class="btn btn-bh-primary">
          <i class="fas fa-home me-2"></i> Return to Home
        </a>
        <a href="{{ route('blogs.index') }}" class="btn btn-bh-outline">
          <i class="fas fa-compass me-2"></i> Browse Articles
        </a>
      </div>
    </div>
  </div>
</section>
@endsection
