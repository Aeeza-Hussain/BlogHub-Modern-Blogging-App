@extends('layouts.app')

@section('title', 'BlogHub — Modern Blogging & Content Platform')

@section('content')

<!-- 1. Hero Section (SRS 7.1) -->
<section class="py-5">
  <div class="container">
    <div class="bh-hero position-relative overflow-hidden">
      <div class="row align-items-center g-4">
        <div class="col-lg-7">
          <span class="bh-badge bh-badge-coral mb-3">
            <i class="fas fa-sparkles"></i> Welcome to BlogHub Capstone
          </span>
          <h1 class="display-4 font-heading fw-bold text-dark mb-3">
            Discover Stories, Ideas & Expert Insights.
          </h1>
          <p class="lead text-muted mb-4 pe-lg-4">
            A modern, multi-category publishing platform where visionary authors share deep dives on Technology, Design, Business, Culture, and Travel.
          </p>
          <div class="d-flex flex-wrap gap-3">
            <a href="{{ route('blogs.index') }}" class="btn btn-bh-accent btn-lg shadow-sm">
              <i class="fas fa-compass me-2"></i> Explore Blogs
            </a>
            <a href="{{ route('register') }}" class="btn btn-bh-outline btn-lg">
              <i class="fas fa-pen-nib me-2"></i> Become an Author
            </a>
          </div>
        </div>
        <div class="col-lg-5 text-center">
          <div class="position-relative">
            <img src="https://images.unsplash.com/photo-1499750310107-5fef28a66643?auto=format&fit=crop&w=800&q=80" alt="BlogHub Workspace" class="img-fluid rounded-4 shadow-lg border border-3 border-white">
            <div class="position-absolute bottom-0 start-0 m-3 bg-white p-3 rounded-3 shadow text-start border d-none d-sm-block" style="max-width: 220px;">
              <div class="d-flex align-items-center gap-2 mb-1">
                <i class="fas fa-fire text-danger"></i>
                <span class="fw-bold small font-heading">Trending Platform</span>
              </div>
              <span class="small text-muted">Over 45,000+ active readers weekly</span>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- 2. Featured Articles Grid (SRS 7.1) -->
<section class="py-5 bg-light-subtle">
  <div class="container">
    <div class="d-flex align-items-end justify-content-between mb-4">
      <div>
        <span class="bh-badge bh-badge-navy mb-2">Editorial Pick</span>
        <h2 class="font-heading fw-bold mb-0">Featured Articles</h2>
      </div>
      <a href="{{ route('blogs.index') }}" class="btn btn-sm btn-bh-outline">View All <i class="fas fa-arrow-right ms-1"></i></a>
    </div>

    <div class="row g-4">
      @foreach($featuredArticles as $article)
        <div class="col-md-6 col-lg-4">
          <x-blog-card :article="$article" />
        </div>
      @endforeach
    </div>
  </div>
</section>

<!-- 3. Trending Posts & Latest Posts Grid (SRS 7.1) -->
<section class="py-5">
  <div class="container">
    <div class="row g-4">
      <!-- Latest Posts Column (8 Cols) -->
      <div class="col-lg-8">
        <div class="d-flex align-items-center justify-content-between mb-4">
          <h2 class="font-heading fw-bold mb-0">Latest Articles</h2>
          <a href="{{ route('blogs.create') }}" class="btn btn-sm btn-bh-primary">
            <i class="fas fa-plus me-1"></i> Write Article
          </a>
        </div>

        <div class="row g-4 mb-4">
          @foreach($latestArticles as $article)
            <div class="col-md-6">
              <x-blog-card :article="$article" />
            </div>
          @endforeach
        </div>

        <div class="d-flex justify-content-center">
          {{ $latestArticles->links('components.pagination') }}
        </div>
      </div>

      <!-- Trending Side Column (4 Cols) -->
      <div class="col-lg-4">
        <div class="bh-card p-4 sticky-top" style="top: 90px;">
          <div class="d-flex align-items-center gap-2 mb-3 pb-2 border-bottom">
            <i class="fas fa-chart-line text-danger fs-5"></i>
            <h4 class="font-heading fw-bold mb-0">Trending Now</h4>
          </div>

          <div class="d-flex flex-column gap-3">
            @foreach($trendingArticles as $index => $trending)
              <div class="d-flex gap-3 align-items-start pb-3 {{ !$loop->last ? 'border-bottom' : '' }}">
                <span class="font-heading display-6 fw-bold text-muted lh-1" style="min-width: 30px;">0{{ $index + 1 }}</span>
                <div>
                  <a href="{{ route('blogs.index', ['category' => $trending->category->slug]) }}" class="bh-badge bh-badge-coral p-1 px-2 mb-1" style="font-size: 0.65rem;">
                    {{ $trending->category->name }}
                  </a>
                  <h6 class="font-heading fw-bold mb-1" style="font-size: 0.95rem;">
                    <a href="{{ route('blogs.show', $trending->slug) }}" class="text-decoration-none text-reset">
                      {{ Str::limit($trending->title, 55) }}
                    </a>
                  </h6>
                  <div class="small text-muted font-mono" style="font-size: 0.75rem;">
                    <span>{{ $trending->author->name }}</span> • <span>{{ $trending->reading_time }}m read</span>
                  </div>
                </div>
              </div>
            @endforeach
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- 4. Popular Categories Pills (SRS 7.1) -->
<section class="py-5 bg-light-subtle">
  <div class="container">
    <div class="text-center mb-5">
      <span class="bh-badge bh-badge-coral mb-2">Explore Topics</span>
      <h2 class="font-heading fw-bold">Popular Categories</h2>
      <p class="text-muted">Browse articles organized across 10+ curated categories</p>
    </div>

    <div class="row g-3">
      @foreach($categories as $category)
        <div class="col-md-4 col-lg-3">
          <x-category-card :category="$category" />
        </div>
      @endforeach
    </div>
  </div>
</section>

<!-- 5. Featured Authors Strip (SRS 7.1) -->
<section class="py-5">
  <div class="container">
    <div class="d-flex align-items-end justify-content-between mb-4">
      <div>
        <span class="bh-badge bh-badge-navy mb-2">Meet Our Writers</span>
        <h2 class="font-heading fw-bold mb-0">Featured Authors</h2>
      </div>
      <a href="{{ route('authors.index') }}" class="btn btn-sm btn-bh-outline">View Directory <i class="fas fa-arrow-right ms-1"></i></a>
    </div>

    <div class="row g-4">
      @foreach($authors as $author)
        <div class="col-md-6 col-lg-4">
          <x-author-card :author="$author" />
        </div>
      @endforeach
    </div>
  </div>
</section>

<!-- 6. Animated Statistics Band (SRS 7.1) -->
<section class="py-5 bg-primary text-white">
  <div class="container">
    <div class="row g-4 text-center">
      <div class="col-6 col-md-3 border-end border-secondary">
        <h2 class="display-4 font-heading fw-bold text-accent stat-counter mb-1" data-target="{{ $stats['total_articles'] }}">0</h2>
        <span class="font-mono text-light-50 small">Total Articles</span>
      </div>
      <div class="col-6 col-md-3 border-end border-secondary">
        <h2 class="display-4 font-heading fw-bold text-white stat-counter mb-1" data-target="{{ $stats['total_authors'] }}">0</h2>
        <span class="font-mono text-light-50 small">Expert Authors</span>
      </div>
      <div class="col-6 col-md-3 border-end border-secondary">
        <h2 class="display-4 font-heading fw-bold text-accent stat-counter mb-1" data-target="{{ $stats['total_readers'] }}">0</h2>
        <span class="font-mono text-light-50 small">Monthly Readers</span>
      </div>
      <div class="col-6 col-md-3">
        <h2 class="display-4 font-heading fw-bold text-white stat-counter mb-1" data-target="{{ $stats['total_categories'] }}">0</h2>
        <span class="font-mono text-light-50 small">Topic Categories</span>
      </div>
    </div>
  </div>
</section>

<!-- 7. Testimonials Carousel (SRS 7.1) -->
<section class="py-5">
  <div class="container">
    <div class="text-center mb-5">
      <span class="bh-badge bh-badge-secondary mb-2">Community Voices</span>
      <h2 class="font-heading fw-bold">What Readers Say</h2>
    </div>

    <div id="testimonialCarousel" class="carousel slide" data-bs-ride="carousel">
      <div class="carousel-inner">
        <div class="carousel-item active">
          <div class="bh-card p-5 mx-auto text-center shadow-sm" style="max-width: 750px;">
            <div class="text-warning mb-3">
              <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
            </div>
            <p class="fs-5 font-heading italic text-dark mb-4">"BlogHub has transformed how I read technical articles. The typography, clean layouts, and depth of content are unmatched."</p>
            <div class="d-flex align-items-center justify-content-center gap-3">
              <img src="https://i.pravatar.cc/150?img=32" alt="Reader" class="rounded-circle" style="width: 48px; height: 48px;">
              <div class="text-start">
                <h6 class="mb-0 fw-bold font-heading">Sarah Jenkins</h6>
                <span class="small text-muted font-mono">Senior Lead Engineer</span>
              </div>
            </div>
          </div>
        </div>

        <div class="carousel-item">
          <div class="bh-card p-5 mx-auto text-center shadow-sm" style="max-width: 750px;">
            <div class="text-warning mb-3">
              <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
            </div>
            <p class="fs-5 font-heading italic text-dark mb-4">"As a design writer, publishing on BlogHub gives my work the aesthetic presentation it truly deserves. Outstanding UX."</p>
            <div class="d-flex align-items-center justify-content-center gap-3">
              <img src="https://i.pravatar.cc/150?img=47" alt="Reader" class="rounded-circle" style="width: 48px; height: 48px;">
              <div class="text-start">
                <h6 class="mb-0 fw-bold font-heading">Michael Vance</h6>
                <span class="small text-muted font-mono">Product Design Director</span>
              </div>
            </div>
          </div>
        </div>
      </div>

      <button class="carousel-control-prev" type="button" data-bs-target="#testimonialCarousel" data-bs-slide="prev">
        <span class="carousel-control-prev-icon bg-dark rounded-circle p-3" aria-hidden="true"></span>
      </button>
      <button class="carousel-control-next" type="button" data-bs-target="#testimonialCarousel" data-bs-slide="next">
        <span class="carousel-control-next-icon bg-dark rounded-circle p-3" aria-hidden="true"></span>
      </button>
    </div>
  </div>
</section>

@endsection
