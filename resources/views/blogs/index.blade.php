@extends('layouts.app')

@section('title', 'All Articles — BlogHub')

@section('content')
<section class="py-5 bg-light-subtle">
  <div class="container">
    <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between mb-4 gap-3">
      <div>
        <h1 class="font-heading fw-bold display-5 mb-1">Explore All Articles</h1>
        <p class="text-muted mb-0">Filter articles by topic, author, or search query.</p>
      </div>
      <a href="{{ route('blogs.create') }}" class="btn btn-bh-accent shadow-sm align-self-start align-self-md-auto">
        <i class="fas fa-plus me-1"></i> New Article
      </a>
    </div>

    <!-- Filter & Search Controls Bar (SRS 7.2) -->
    <div class="bh-card p-3 mb-4">
      <form action="{{ route('blogs.index') }}" method="GET" class="row g-3 align-items-center">
        <!-- Live Search Input -->
        <div class="col-lg-4 col-md-6">
          <div class="input-group">
            <span class="input-group-text bg-white border-end-0"><i class="fas fa-search text-muted"></i></span>
            <input type="text" name="search" class="form-control border-start-0 ps-0" placeholder="Filter articles by title or keyword..." value="{{ request('search') }}">
          </div>
        </div>

        <!-- Category Dropdown -->
        <div class="col-lg-3 col-md-6">
          <select name="category" class="form-select" onchange="this.form.submit()">
            <option value="">All Categories</option>
            @foreach($categories as $cat)
              <option value="{{ $cat->slug }}" {{ request('category') == $cat->slug ? 'selected' : '' }}>
                {{ $cat->name }} ({{ $cat->articles_count }})
              </option>
            @endforeach
          </select>
        </div>

        <!-- Sort Order -->
        <div class="col-lg-3 col-md-6">
          <select name="sort" class="form-select" onchange="this.form.submit()">
            <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Sort by: Newest First</option>
            <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Sort by: Oldest First</option>
            <option value="popular" {{ request('sort') == 'popular' ? 'selected' : '' }}>Sort by: Most Popular</option>
          </select>
        </div>

        <!-- Grid/List Layout Switcher (SRS 7.2) -->
        <div class="col-lg-2 col-md-6 text-end">
          <div class="btn-group" role="group" aria-label="Layout toggle">
            <button type="button" id="view-grid-btn" class="btn btn-outline-secondary active" title="Grid View">
              <i class="fas fa-th-large"></i>
            </button>
            <button type="button" id="view-list-btn" class="btn btn-outline-secondary" title="List View">
              <i class="fas fa-list"></i>
            </button>
          </div>
          @if(request()->anyFilled(['search', 'category', 'author', 'sort']))
            <a href="{{ route('blogs.index') }}" class="btn btn-sm btn-link text-danger text-decoration-none ms-2" title="Clear filters">
              <i class="fas fa-times"></i>
            </a>
          @endif
        </div>
      </form>
    </div>

    <!-- Articles Output Grid/List -->
    @if($articles->count() > 0)
      <div id="articles-container" class="row g-4 mb-4 view-grid">
        @foreach($articles as $article)
          <div class="col-md-6 col-lg-4 blog-card-col">
            <x-blog-card :article="$article" />
          </div>
        @endforeach
      </div>

      <!-- Pagination (SRS 7.2) -->
      <div class="d-flex justify-content-center">
        {{ $articles->links('components.pagination') }}
      </div>
    @else
      <!-- Empty State Fallback (SRS 7.2) -->
      <div class="bh-card p-5 text-center my-5">
        <div class="bg-light-subtle rounded-circle d-inline-flex p-4 mb-3 text-muted">
          <i class="fas fa-search-minus display-4"></i>
        </div>
        <h3 class="font-heading fw-bold">No articles match your filters</h3>
        <p class="text-muted">Try adjusting your search criteria or category filter.</p>
        <a href="{{ route('blogs.index') }}" class="btn btn-bh-primary mt-2">
          <i class="fas fa-redo me-1"></i> Reset All Filters
        </a>
      </div>
    @endif

  </div>
</section>
@endsection
