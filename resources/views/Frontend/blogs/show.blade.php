@extends('layouts.app')

@section('title', $article->title . ' — BlogHub')
@section('meta_description', $article->excerpt)

@section('content')
<article class="py-5">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-lg-9">
        
        <!-- Category & Breadcrumb -->
        <div class="d-flex align-items-center gap-2 mb-3">
          <a href="{{ route('blogs.index', ['category' => $article->category->slug]) }}" class="bh-badge bh-badge-coral text-decoration-none">
            <i class="fas {{ $article->category->icon }}"></i> {{ $article->category->name }}
          </a>
          <span class="text-muted">•</span>
          <span class="small font-mono text-muted"><i class="far fa-clock me-1"></i> {{ $article->reading_time }} min read</span>
        </div>

        <!-- Article Title -->
        <h1 class="display-4 font-heading fw-bold text-dark mb-4 lh-tight">
          {{ $article->title }}
        </h1>

        <!-- Author Byline Bar (SRS 7.3) -->
        <div class="bh-card p-3 mb-4 d-flex flex-wrap align-items-center justify-content-between gap-3">
          <a href="{{ route('authors.show', $article->author->slug) }}" class="d-flex align-items-center gap-3 text-decoration-none text-reset">
            <img src="{{ $article->author->avatar }}" alt="{{ $article->author->name }}" class="rounded-circle shadow-sm" style="width: 50px; height: 50px; object-fit: cover;">
            <div>
              <h6 class="font-heading fw-bold mb-0 fs-6">{{ $article->author->name }}</h6>
              <span class="small text-muted font-mono">{{ $article->author->tagline }}</span>
            </div>
          </a>

          <div class="d-flex align-items-center gap-2">
            <!-- Like Button -->
            <form action="{{ route('blogs.like', $article->id) }}" method="POST" class="d-inline">
              @csrf
              <button type="submit" class="btn btn-outline-danger btn-sm rounded-pill btn-like-toggle">
                <i class="far fa-heart me-1"></i> <span class="like-count">{{ $article->likes_count }}</span>
              </button>
            </form>

            <!-- Copy Link Toast Button (SRS 7.3) -->
            <button type="button" class="btn btn-outline-secondary btn-sm rounded-pill btn-copy-link" title="Copy article link">
              <i class="fas fa-link me-1"></i> Copy Link
            </button>
          </div>
        </div>

        <!-- Featured Banner Image -->
        <div class="mb-5 rounded-4 overflow-hidden shadow-sm" style="max-height: 480px;">
          <img src="{{ $article->featured_image }}" alt="{{ $article->title }}" class="w-100 h-100 object-fit-cover">
        </div>

        <!-- Article Content Body -->
        <div class="article-body fs-5 mb-5 lh-lg">
          {!! $article->body !!}
        </div>

        <!-- Social Share Bar (SRS 7.3) -->
        <div class="border-top border-bottom py-3 my-4 d-flex align-items-center justify-content-between">
          <span class="font-heading fw-bold small text-muted text-uppercase font-mono">Share Article</span>
          <div class="d-flex gap-2">
            <a href="https://twitter.com/intent/tweet?text={{ urlencode($article->title) }}&url={{ urlencode(request()->url()) }}" target="_blank" class="btn btn-sm btn-outline-primary rounded-circle" style="width:36px; height:36px;" aria-label="Twitter"><i class="fab fa-twitter"></i></a>
            <a href="https://www.linkedin.com/shareArticle?mini=true&url={{ urlencode(request()->url()) }}&title={{ urlencode($article->title) }}" target="_blank" class="btn btn-sm btn-outline-primary rounded-circle" style="width:36px; height:36px;" aria-label="LinkedIn"><i class="fab fa-linkedin-in"></i></a>
            <button class="btn btn-sm btn-outline-secondary rounded-circle btn-copy-link" style="width:36px; height:36px;" aria-label="Copy link"><i class="fas fa-link"></i></button>
          </div>
        </div>

        <!-- Comments Section (SRS 7.3) -->
        <section class="mt-5">
          <h3 class="font-heading fw-bold mb-4">Comments ({{ $article->comments->count() }})</h3>

          <!-- Add Comment Form -->
          <div class="bh-card p-4 mb-4">
            <h5 class="font-heading fw-bold mb-3">Leave a Reply</h5>
            <form action="{{ route('blogs.comments.store', $article->id) }}" method="POST" class="needs-validation" novalidate>
              @csrf
              <div class="row g-3">
                <div class="col-md-6">
                  <label class="form-label small font-mono">Your Name</label>
                  <input type="text" name="user_name" class="form-control" placeholder="John Doe" required>
                  <div class="invalid-feedback">Please enter your name.</div>
                </div>
                <div class="col-12">
                  <label class="form-label small font-mono">Comment Message</label>
                  <textarea name="content" class="form-control" rows="3" placeholder="Share your thoughts on this article..." required></textarea>
                  <div class="invalid-feedback">Please enter a comment message.</div>
                </div>
                <div class="col-12">
                  <button type="submit" class="btn btn-bh-accent">Submit Comment</button>
                </div>
              </div>
            </form>
          </div>

          <!-- Existing Comments List -->
          <div class="d-flex flex-column gap-3">
            @foreach($article->comments as $comment)
              <div class="bh-card p-3">
                <div class="d-flex align-items-center gap-3 mb-2">
                  <img src="{{ $comment->user_avatar ?? 'https://i.pravatar.cc/150?u='.$comment->id }}" alt="{{ $comment->user_name }}" class="rounded-circle" style="width: 40px; height: 40px;">
                  <div>
                    <h6 class="font-heading fw-bold mb-0">{{ $comment->user_name }}</h6>
                    <span class="small text-muted font-mono" style="font-size: 0.75rem;">{{ $comment->created_at ? $comment->created_at->diffForHumans() : 'Just now' }}</span>
                  </div>
                </div>
                <p class="mb-0 text-muted small ps-5">{{ $comment->content }}</p>
              </div>
            @endforeach
          </div>
        </section>

      </div>
    </div>
  </div>
</section>

<!-- Related Articles Section (SRS 7.3) -->
@if($relatedArticles->count() > 0)
<section class="py-5 bg-light-subtle">
  <div class="container">
    <h3 class="font-heading fw-bold mb-4 text-center">Related Articles</h3>
    <div class="row g-4">
      @foreach($relatedArticles as $related)
        <div class="col-md-4">
          <x-blog-card :article="$related" />
        </div>
      @endforeach
    </div>
  </div>
</section>
@endif

@endsection
