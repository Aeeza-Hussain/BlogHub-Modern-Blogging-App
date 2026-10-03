@extends('layouts.app')

@section('title', $article->title . ' — BlogHub')
@section('meta_description', $article->excerpt)

@section('content')
<article class="py-5">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-lg-9">
        
        @if(!$article->isApproved())
        <div class="alert alert-warning mb-4 shadow-sm border-0 d-flex align-items-center justify-content-between flex-wrap gap-2 p-3 rounded-3" style="background:#fffbeb; border-left:4px solid #f59e0b !important;">
          <div class="d-flex align-items-center gap-2">
            <i class="fas fa-eye text-warning fs-5"></i>
            <div>
              <strong class="text-dark">Preview Mode</strong>
              <div class="small text-muted">
                @if($article->isPending())
                  This article is currently <strong>Pending Admin Review</strong> and is not yet visible to the public.
                @else
                  This article has been <strong>Rejected</strong> by admin. {{ $article->rejection_reason ? 'Reason: ' . $article->rejection_reason : '' }}
                @endif
              </div>
            </div>
          </div>
          @if(auth()->check() && auth()->user()->isAdmin())
            <form method="POST" action="{{ route('dashboard.articles.approve', $article->id) }}" class="d-inline">
              @csrf
              <button type="submit" class="btn btn-sm btn-success fw-bold">
                <i class="fas fa-check me-1"></i> Approve &amp; Publish Now
              </button>
            </form>
          @endif
        </div>
        @endif

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
          <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-4">
            <h3 class="font-heading fw-bold mb-0">
              <i class="far fa-comments me-2" style="color:var(--bh-accent, #C8461F);"></i> Comments ({{ $article->comments->count() }})
            </h3>
            <span class="small text-muted font-mono"><i class="fas fa-shield-halved me-1 text-warning"></i> Moderated by the author</span>
          </div>

          </div>

          @if(!setting('enable_comments', true))
            {{-- Comments Disabled Platform-Wide --}}
            <div class="bh-card p-4 mb-4 text-center shadow-sm">
              <i class="fas fa-comment-slash fa-2x mb-2 text-muted opacity-50"></i>
              <h6 class="font-heading fw-bold mb-1">Comments Closed</h6>
              <p class="text-muted small mb-0">Discussions and comments are currently disabled across the platform.</p>
            </div>
          @else
            @if(auth()->check() || !setting('require_auth_comments', true))
              <!-- Comment Submission Form -->
              <div class="bh-card p-4 mb-4 shadow-sm">
                <div class="d-flex align-items-center gap-3 mb-3">
                  @auth
                    <img src="{{ auth()->user()->avatar_url }}" alt="{{ auth()->user()->name }}" class="rounded-circle shadow-sm" style="width: 42px; height: 42px; object-fit: cover;">
                    <div>
                      <h6 class="font-heading fw-bold mb-0">{{ auth()->user()->name }}</h6>
                      <span class="small text-muted font-mono">Commenting as verified user &middot; {{ auth()->user()->email }}</span>
                    </div>
                  @else
                    <div class="bg-secondary text-white rounded-circle d-flex align-items-center justify-content-center shadow-sm" style="width: 42px; height: 42px;">
                      <i class="fas fa-user"></i>
                    </div>
                    <div>
                      <h6 class="font-heading fw-bold mb-0">Guest Contributor</h6>
                      <span class="small text-muted font-mono">Join the conversation</span>
                    </div>
                  @endauth
                </div>

                <form action="{{ route('blogs.comments.store', $article->id) }}" method="POST" class="needs-validation" novalidate>
                  @csrf

                  @guest
                    <div class="mb-3">
                      <label class="form-label small fw-semibold">Your Name <span class="text-danger">*</span></label>
                      <input type="text" name="user_name" class="form-control form-control-sm" placeholder="e.g. Alex Morgan" required maxlength="80">
                    </div>
                  @endguest

                  <div class="mb-3">
                    <textarea name="content" class="form-control" rows="3" placeholder="Share your perspective on this article..." required minlength="2"></textarea>
                    <div class="invalid-feedback">Please enter a comment message before submitting.</div>
                  </div>
                  <div class="d-flex align-items-center justify-content-between flex-wrap gap-2">
                    <span class="small text-muted font-mono">
                      @if(setting('enable_comment_moderation', false))
                        <i class="fas fa-shield-halved me-1 text-warning"></i> Comment will appear once approved by the author
                      @else
                        <i class="fas fa-check-circle me-1 text-success"></i> Instant publishing active
                      @endif
                    </span>
                    <button type="submit" class="btn btn-bh-accent px-4 fw-semibold">
                      <i class="fas fa-paper-plane me-1"></i> Submit Comment
                    </button>
                  </div>
                </form>
              </div>
            @else
              <!-- Guest Prompt: Must Register / Login to Comment -->
              <div class="bh-card p-4 mb-4 text-center shadow-sm" style="background:linear-gradient(135deg, rgba(200,70,31,0.03), rgba(200,70,31,0.08)); border: 1.5px dashed rgba(200,70,31,0.3); border-radius: 12px;">
                <div class="mb-2">
                  <i class="fas fa-user-lock fs-2" style="color:var(--bh-accent, #C8461F);"></i>
                </div>
                <h5 class="font-heading fw-bold mb-1">Sign in to leave a comment</h5>
                <p class="text-muted small mb-3" style="max-width: 440px; margin: 0 auto;">
                  You must have an account to comment. Please log in with your account or register a new one to join the conversation.
                </p>
                <div class="d-flex align-items-center justify-content-center gap-2">
                  <a href="{{ route('login') }}" class="btn btn-bh-accent btn-sm px-3 fw-semibold">
                    <i class="fas fa-sign-in-alt me-1"></i> Log In
                  </a>
                  @if(setting('enable_public_registration', true))
                    <a href="{{ route('register') }}" class="btn btn-outline-dark btn-sm px-3 fw-semibold">
                      <i class="fas fa-user-plus me-1"></i> Register Free
                    </a>
                  @endif
                </div>
              </div>
            @endif

            <!-- Comments Thread (Top-level & Nested Replies) -->
            @php
              $displayComments = $article->rootComments ?? $article->comments;
            @endphp
            <div class="d-flex flex-column gap-3">
              @forelse($displayComments as $comment)
                <div class="bh-card p-3 shadow-sm" id="comment-{{ $comment->id }}">
                  <div class="d-flex align-items-center justify-content-between mb-2">
                    <div class="d-flex align-items-center gap-3">
                      <img src="{{ $comment->user_avatar ?? 'https://ui-avatars.com/api/?name='.urlencode($comment->user_name).'&background=C8461F&color=fff' }}"
                           alt="{{ $comment->user_name }}" class="rounded-circle" style="width: 40px; height: 40px; object-fit: cover;">
                      <div>
                        <h6 class="font-heading fw-bold mb-0">
                          {{ $comment->user_name }}
                          @if($comment->user_id && $article->author && $article->author->user_id === $comment->user_id)
                            <span class="badge" style="background:var(--bh-accent, #C8461F); color:#fff; font-size: 0.65rem;">Author</span>
                          @endif
                        </h6>
                        <span class="small text-muted font-mono" style="font-size: 0.75rem;">
                          {{ $comment->created_at ? $comment->created_at->diffForHumans() : 'Just now' }}
                        </span>
                      </div>
                    </div>

                    @if(setting('enable_comment_replies', true))
                      <button class="btn btn-sm btn-link text-decoration-none p-0 small fw-semibold"
                              type="button" data-bs-toggle="collapse" data-bs-target="#reply-form-{{ $comment->id }}"
                              aria-expanded="false" style="color:var(--bh-accent, #C8461F); font-size:0.8rem;">
                        <i class="fas fa-reply me-1"></i> Reply
                      </button>
                    @endif
                  </div>

                  <p class="mb-0 text-dark small ps-5" style="white-space: pre-line; line-height: 1.6;">{{ $comment->content }}</p>

                  {{-- Inline Reply Form --}}
                  @if(setting('enable_comment_replies', true))
                    <div class="collapse mt-3 ps-5" id="reply-form-{{ $comment->id }}">
                      @if(auth()->check() || !setting('require_auth_comments', true))
                        <form action="{{ route('blogs.comments.store', $article->id) }}" method="POST" class="p-3 rounded-3 bg-light-subtle border">
                          @csrf
                          <input type="hidden" name="parent_id" value="{{ $comment->id }}">
                          @guest
                            <div class="mb-2">
                              <input type="text" name="user_name" class="form-control form-control-sm" placeholder="Your Name" required>
                            </div>
                          @endguest
                          <div class="mb-2">
                            <textarea name="content" rows="2" class="form-control form-control-sm" placeholder="Write your reply to {{ $comment->user_name }}..." required></textarea>
                          </div>
                          <div class="d-flex justify-content-end gap-2">
                            <button type="button" class="btn btn-sm btn-light border" data-bs-toggle="collapse" data-bs-target="#reply-form-{{ $comment->id }}">Cancel</button>
                            <button type="submit" class="btn btn-sm btn-bh-accent fw-semibold">
                              <i class="fas fa-reply me-1"></i> Post Reply
                            </button>
                          </div>
                        </form>
                      @else
                        <div class="alert alert-light border small mb-0 py-2">
                          <a href="{{ route('login') }}" class="fw-bold text-accent">Sign in</a> to reply to this comment.
                        </div>
                      @endif
                    </div>
                  @endif

                  {{-- Nested Replies Display --}}
                  @if(setting('enable_comment_replies', true) && $comment->approvedReplies && $comment->approvedReplies->count() > 0)
                    <div class="d-flex flex-column gap-2 mt-3 ps-5 border-start border-2 ms-4" style="border-color: rgba(200,70,31,0.2) !important;">
                      @foreach($comment->approvedReplies as $reply)
                        <div class="p-2 rounded-2 bg-light-subtle">
                          <div class="d-flex align-items-center gap-2 mb-1">
                            <img src="{{ $reply->user_avatar ?? 'https://ui-avatars.com/api/?name='.urlencode($reply->user_name).'&background=C8461F&color=fff' }}"
                                 alt="{{ $reply->user_name }}" class="rounded-circle" style="width: 26px; height: 26px; object-fit: cover;">
                            <span class="fw-semibold small">{{ $reply->user_name }}</span>
                            @if($reply->user_id && $article->author && $article->author->user_id === $reply->user_id)
                              <span class="badge" style="background:var(--bh-accent, #C8461F); color:#fff; font-size: 0.6rem;">Author</span>
                            @endif
                            <span class="text-muted font-mono ms-auto" style="font-size: 0.7rem;">
                              {{ $reply->created_at ? $reply->created_at->diffForHumans() : 'Just now' }}
                            </span>
                          </div>
                          <p class="mb-0 text-dark small ps-4" style="font-size:0.85rem;">{{ $reply->content }}</p>
                        </div>
                      @endforeach
                    </div>
                  @endif
                </div>
              @empty
                <div class="text-center py-4 text-muted bh-card">
                  <i class="far fa-comment-dots fa-2x mb-2 d-block opacity-25"></i>
                  <p class="small mb-0">No approved comments yet. Be the first to share your thoughts!</p>
                </div>
              @endforelse
            </div>
          @endif
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
