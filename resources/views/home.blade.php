@extends('layouts.app')

@section('title', 'BlogHub — Modern Blogging & Content Platform')

@section('content')

<!-- Hero & Search Header Section -->
<section class="py-5 bg-light-subtle border-bottom">
  <div class="container">
    <div class="row align-items-center justify-content-between g-4">
      <div class="col-lg-7">
        <span class="bh-badge bh-badge-coral mb-3">
          <i class="fas fa-sparkles me-1"></i> Premier Content Hub
        </span>
        <h1 class="font-heading fw-bold display-4 mb-3" style="line-height: 1.15;">
          Discover Thoughtful Stories & Expert Perspectives
        </h1>
        <p class="text-muted fs-5 mb-4 pe-lg-4">
          Explore curated articles on technology, design, science, business, and culture. Written by passionate creators and industry experts.
        </p>

        <!-- Search Bar -->
        <form action="{{ route('blogs.index') }}" method="GET" class="mb-4">
          <div class="input-group input-group-lg bh-card border-0 shadow-sm p-1">
            <span class="input-group-text bg-white border-0 ps-3">
              <i class="fas fa-search text-muted fs-5"></i>
            </span>
            <input type="text" name="search" class="form-control border-0 shadow-none ps-2" placeholder="Search articles, keywords, topics...">
            <button type="submit" class="btn btn-bh-accent px-4 rounded-3">
              Search
            </button>
          </div>
        </form>

        <!-- Quick Category Pills -->
        @if(isset($categories) && $categories->count() > 0)
          <div class="d-flex align-items-center gap-2 flex-wrap">
            <span class="small fw-semibold text-muted me-1 font-mono">Popular:</span>
            @foreach($categories->take(5) as $cat)
              <a href="{{ route('blogs.index', ['category' => $cat->slug]) }}" class="badge bg-white text-dark border px-3 py-2 text-decoration-none rounded-pill shadow-xs hover-accent">
                <i class="fas {{ $cat->icon }} text-coral me-1"></i> {{ $cat->name }}
              </a>
            @endforeach
          </div>
        @endif
      </div>

      <!-- Quick Platform Card / Graphic -->
      <div class="col-lg-5 d-none d-lg-block">
        <div class="bh-card p-4 bg-white shadow-md border-0 position-relative overflow-hidden">
          <div class="d-flex align-items-center gap-3 mb-3">
            <div class="bg-coral-subtle p-3 rounded-circle text-accent">
              <i class="fas fa-feather-alt fs-3"></i>
            </div>
            <div>
              <h5 class="font-heading fw-bold mb-0">Share Your Knowledge</h5>
              <small class="text-muted">Join 10,000+ creators on BlogHub</small>
            </div>
          </div>
          <p class="text-muted small mb-4">
            Publish your articles, connect with readers, and grow your audience with our powerful blogging platform tools.
          </p>
          <div class="d-flex gap-2">
            <a href="{{ route('blogs.create') }}" class="btn btn-bh-primary flex-grow-1">
              <i class="fas fa-pen-nib me-1"></i> Write Article
            </a>
            <a href="{{ route('blogs.index') }}" class="btn btn-bh-outline">
              Explore All
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Featured Hero Article Banner -->
@if(isset($heroArticle))
<section class="py-5">
  <div class="container">
    <div class="d-flex align-items-center justify-content-between mb-4">
      <div class="d-flex align-items-center gap-2">
        <span class="badge bg-accent-subtle text-accent rounded-circle p-2">
          <i class="fas fa-star"></i>
        </span>
        <h2 class="font-heading fw-bold fs-3 mb-0">Featured Story</h2>
      </div>
      <span class="text-muted small font-mono">Handpicked by editors</span>
    </div>

    <div class="bh-card overflow-hidden shadow-md border-0">
      <div class="row g-0 align-items-center">
        <div class="col-lg-7 position-relative">
          <div class="bh-card-img-wrapper" style="aspect-ratio: 16/10;">
            <img src="{{ $heroArticle->featured_image }}" alt="{{ $heroArticle->title }}" class="w-100 h-100 object-fit-cover">
          </div>
          <div class="position-absolute top-0 start-0 m-4">
            <span class="bh-badge bh-badge-coral shadow-sm fs-6">
              <i class="fas {{ $heroArticle->category->icon ?? 'fa-folder' }}"></i> {{ $heroArticle->category->name }}
            </span>
          </div>
        </div>
        <div class="col-lg-5 p-4 p-md-5 d-flex flex-column justify-content-between h-100">
          <div>
            <div class="d-flex align-items-center gap-2 text-muted small font-mono mb-3">
              <span><i class="far fa-calendar-alt me-1"></i> {{ $heroArticle->published_at ? $heroArticle->published_at->format('M d, Y') : now()->format('M d, Y') }}</span>
              <span>•</span>
              <span><i class="far fa-clock me-1"></i> {{ $heroArticle->reading_time }} min read</span>
            </div>

            <h3 class="font-heading fw-bold display-6 fs-3 mb-3">
              <a href="{{ route('blogs.show', $heroArticle->slug) }}" class="text-decoration-none text-reset hover-accent">
                {{ $heroArticle->title }}
              </a>
            </h3>

            <p class="text-muted fs-6 mb-4">
              {{ Str::limit($heroArticle->excerpt, 160) }}
            </p>
          </div>

          <div>
            <div class="d-flex align-items-center justify-content-between border-top pt-3">
              <a href="{{ route('authors.show', $heroArticle->author->slug) }}" class="d-flex align-items-center gap-3 text-decoration-none text-reset">
                <img src="{{ $heroArticle->author->avatar }}" alt="{{ $heroArticle->author->name }}" class="rounded-circle" style="width: 44px; height: 44px; object-fit: cover;">
                <div>
                  <h6 class="mb-0 fw-bold font-heading">{{ $heroArticle->author->name }}</h6>
                  <small class="text-muted font-mono">{{ $heroArticle->author->specialty }}</small>
                </div>
              </a>

              <a href="{{ route('blogs.show', $heroArticle->slug) }}" class="btn btn-bh-accent btn-sm rounded-pill px-4">
                Read Story <i class="fas fa-arrow-right ms-1"></i>
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
@endif

<!-- Trending Stories Section -->
@if(isset($trendingArticles) && $trendingArticles->count() > 0)
<section class="py-5 bg-light-subtle border-top border-bottom">
  <div class="container">
    <div class="d-flex align-items-center justify-content-between mb-4">
      <div>
        <h2 class="font-heading fw-bold fs-3 mb-1">
          <i class="fas fa-fire text-danger me-2"></i>Trending Now
        </h2>
        <p class="text-muted small mb-0">Most read and discussed articles this week</p>
      </div>
      <a href="{{ route('blogs.index', ['sort' => 'popular']) }}" class="btn btn-sm btn-bh-outline">
        View Popular <i class="fas fa-arrow-right ms-1"></i>
      </a>
    </div>

    <div class="row g-4">
      @foreach($trendingArticles as $article)
        <div class="col-md-6 col-lg-3">
          <x-blog-card :article="$article" />
        </div>
      @endforeach
    </div>
  </div>
</section>
@endif

<!-- Category Showcase Section -->
@if(isset($categories) && $categories->count() > 0)
<section class="py-5">
  <div class="container">
    <div class="d-flex align-items-center justify-content-between mb-4">
      <div>
        <h2 class="font-heading fw-bold fs-3 mb-1">Explore Topics</h2>
        <p class="text-muted small mb-0">Browse stories grouped by subjects of interest</p>
      </div>
      <a href="{{ route('categories.index') }}" class="btn btn-sm btn-bh-outline">
        All Categories <i class="fas fa-arrow-right ms-1"></i>
      </a>
    </div>

    <div class="row g-4">
      @foreach($categories->take(6) as $cat)
        <div class="col-md-6 col-lg-4">
          <x-category-card :category="$cat" />
        </div>
      @endforeach
    </div>
  </div>
</section>
@endif

<!-- Latest Articles Grid -->
@if(isset($latestArticles) && $latestArticles->count() > 0)
<section class="py-5 bg-light-subtle border-top">
  <div class="container">
    <div class="d-flex align-items-center justify-content-between mb-4">
      <div>
        <h2 class="font-heading fw-bold fs-3 mb-1">Latest Articles</h2>
        <p class="text-muted small mb-0">Fresh perspectives and insights freshly published</p>
      </div>
      <a href="{{ route('blogs.index') }}" class="btn btn-bh-accent btn-sm">
        Explore All Articles <i class="fas fa-arrow-right ms-1"></i>
      </a>
    </div>

    <div class="row g-4 mb-4">
      @foreach($latestArticles as $article)
        <div class="col-md-6 col-lg-4">
          <x-blog-card :article="$article" />
        </div>
      @endforeach
    </div>

    <div class="text-center mt-4">
      <a href="{{ route('blogs.index') }}" class="btn btn-bh-outline btn-lg px-5">
        <i class="fas fa-th me-2"></i> Browse Complete Archive
      </a>
    </div>
  </div>
</section>
@endif

<!-- Featured Authors Section -->
@if(isset($featuredAuthors) && $featuredAuthors->count() > 0)
<section class="py-5">
  <div class="container">
    <div class="d-flex align-items-center justify-content-between mb-4">
      <div>
        <h2 class="font-heading fw-bold fs-3 mb-1">Meet Our Authors</h2>
        <p class="text-muted small mb-0">Industry experts and top content contributors</p>
      </div>
      <a href="{{ route('authors.index') }}" class="btn btn-sm btn-bh-outline">
        All Authors <i class="fas fa-arrow-right ms-1"></i>
      </a>
    </div>

    <div class="row g-4">
      @foreach($featuredAuthors as $author)
        <div class="col-md-6 col-lg-3">
          <x-author-card :author="$author" />
        </div>
      @endforeach
    </div>
  </div>
</section>
@endif

<!-- Platform Stats Counter -->
@if(isset($stats))
<section class="py-5 bg-primary text-white position-relative overflow-hidden" style="background: linear-gradient(135deg, #1F2A44 0%, #0F172A 100%);">
  <div class="container position-relative z-1">
    <div class="row text-center g-4">
      <div class="col-6 col-md-3">
        <h3 class="display-5 font-heading fw-bold text-coral mb-1">{{ number_format($stats['total_articles']) }}</h3>
        <p class="text-white-50 font-mono mb-0 small">Published Articles</p>
      </div>
      <div class="col-6 col-md-3">
        <h3 class="display-5 font-heading fw-bold text-coral mb-1">{{ number_format($stats['total_views']) }}</h3>
        <p class="text-white-50 font-mono mb-0 small">Total Reads</p>
      </div>
      <div class="col-6 col-md-3">
        <h3 class="display-5 font-heading fw-bold text-coral mb-1">{{ number_format($stats['total_authors']) }}</h3>
        <p class="text-white-50 font-mono mb-0 small">Active Creators</p>
      </div>
      <div class="col-6 col-md-3">
        <h3 class="display-5 font-heading fw-bold text-coral mb-1">{{ number_format($stats['total_categories']) }}</h3>
        <p class="text-white-50 font-mono mb-0 small">Topic Categories</p>
      </div>
    </div>
  </div>
</section>
@endif

<!-- Newsletter Section -->
<section class="py-5">
  <div class="container">
    <div class="bh-card bg-dark text-white p-5 rounded-4 shadow-lg position-relative overflow-hidden" style="background: linear-gradient(135deg, #1E293B 0%, #0F172A 100%);">
      <div class="row align-items-center g-4">
        <div class="col-lg-7">
          <span class="badge bg-danger mb-2 font-mono">Weekly Digest</span>
          <h2 class="font-heading fw-bold display-6 mb-2">Get the latest articles directly in your inbox</h2>
          <p class="text-muted mb-0 fs-6">No spam ever. Unsubscribe at any time with one click.</p>
        </div>
        <div class="col-lg-5">
          <form onsubmit="event.preventDefault(); alert('Thank you for subscribing!');" class="d-flex gap-2">
            <input type="email" class="form-control form-control-lg bg-secondary border-0 text-white" placeholder="Enter your email address" required>
            <button type="submit" class="btn btn-bh-accent btn-lg px-4 shrink-0">
              Subscribe
            </button>
          </form>
        </div>
      </div>
    </div>
  </div>
</section>

@endsection

