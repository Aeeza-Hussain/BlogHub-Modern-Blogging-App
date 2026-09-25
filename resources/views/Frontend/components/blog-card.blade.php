@props(['article'])

<article class="bh-card h-100 d-flex flex-column">
  <!-- Card Header Image & Badges -->
  <div class="bh-card-img-wrapper">
    <img src="{{ $article->featured_image }}" alt="{{ $article->title }}" loading="lazy">
    <div class="position-absolute top-0 start-0 m-3">
      <span class="bh-badge bh-badge-coral shadow-sm">
        <i class="fas {{ $article->category->icon ?? 'fa-folder' }}"></i> {{ $article->category->name }}
      </span>
    </div>
    <button type="button" class="btn btn-sm btn-light rounded-circle position-absolute top-0 end-0 m-3 shadow-sm btn-bookmark-toggle" aria-label="Save bookmark">
      <i class="far fa-bookmark"></i>
    </button>
  </div>

  <!-- Card Body -->
  <div class="card-body p-4 d-flex flex-column flex-grow-1">
    <div class="d-flex align-items-center gap-2 mb-2 small text-muted font-mono">
      <span><i class="far fa-calendar-alt me-1"></i> {{ $article->published_at ? $article->published_at->format('M d, Y') : now()->format('M d, Y') }}</span>
      <span>•</span>
      <span><i class="far fa-clock me-1"></i> {{ $article->reading_time }} min read</span>
    </div>

    <h5 class="card-title font-heading fw-bold fs-5 mb-2">
      <a href="{{ route('blogs.show', $article->slug) }}" class="text-decoration-none text-reset hover-accent">
        {{ Str::limit($article->title, 65) }}
      </a>
    </h5>

    <p class="card-text text-muted small mb-4 flex-grow-1">
      {{ Str::limit($article->excerpt, 110) }}
    </p>

    <!-- Author & Stats Footer -->
    <div class="border-top pt-3 mt-auto d-flex align-items-center justify-content-between">
      <a href="{{ route('authors.show', $article->author->slug) }}" class="d-flex align-items-center gap-2 text-decoration-none text-reset">
        <img src="{{ $article->author->avatar }}" alt="{{ $article->author->name }}" class="rounded-circle" style="width: 34px; height: 34px; object-fit: cover;">
        <div>
          <h6 class="mb-0 small fw-bold font-heading">{{ $article->author->name }}</h6>
          <span class="text-muted font-mono" style="font-size: 0.72rem;">{{ $article->author->specialty }}</span>
        </div>
      </a>

      <div class="d-flex align-items-center gap-3 text-muted small font-mono">
        <button type="button" class="btn btn-link text-decoration-none p-0 text-muted btn-like-toggle" aria-label="Like article">
          <i class="far fa-heart"></i> <span class="like-count" style="font-size: 0.8rem;">{{ $article->likes_count }}</span>
        </button>
        <span><i class="far fa-eye"></i> <span style="font-size: 0.8rem;">{{ $article->views_count }}</span></span>
      </div>
    </div>
  </div>
</article>
