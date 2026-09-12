@extends('layouts.app')

@section('title', $author->name . ' — Author Profile | BlogHub')

@section('content')
<section class="py-5">
  <div class="container">
    <!-- Cover Image Banner & Overlapping Avatar (SRS 7.6) -->
    <div class="bh-card mb-5 overflow-hidden">
      <div style="height: 220px; background-image: url('{{ $author->cover_image }}'); background-size: cover; background-position: center;" class="position-relative"></div>
      <div class="p-4 p-md-5 pt-0 position-relative">
        <div class="d-flex flex-column flex-md-row align-items-md-end justify-content-between gap-3 mt-n5 mb-4">
          <div class="d-flex align-items-md-end gap-3 flex-column flex-md-row text-center text-md-start">
            <img src="{{ $author->avatar }}" alt="{{ $author->name }}" class="rounded-circle border border-4 border-white shadow-lg bg-white" style="width: 130px; height: 130px; object-fit: cover; margin-top: -65px;">
            <div>
              <h1 class="font-heading fw-bold mb-1">{{ $author->name }}</h1>
              <span class="bh-badge bh-badge-coral">{{ $author->specialty }}</span>
            </div>
          </div>
          <div class="d-flex gap-2">
            <button type="button" class="btn btn-bh-accent px-4 btn-follow-toggle" onclick="this.classList.toggle('btn-success'); this.textContent = this.textContent === 'Follow' ? 'Following' : 'Follow';">Follow</button>
            <button type="button" class="btn btn-bh-outline btn-copy-link"><i class="fas fa-share-alt me-1"></i> Share</button>
          </div>
        </div>

        <p class="lead text-muted mb-4">{{ $author->bio }}</p>

        <!-- Stats Row (SRS 7.6) -->
        <div class="row g-3 text-center border-top border-bottom py-3 font-mono">
          <div class="col-4">
            <h4 class="fw-bold mb-0 text-primary">{{ $author->articles_count }}</h4>
            <span class="small text-muted">Articles</span>
          </div>
          <div class="col-4 border-start border-end">
            <h4 class="fw-bold mb-0 text-primary">{{ number_format($author->followers_count) }}</h4>
            <span class="small text-muted">Followers</span>
          </div>
          <div class="col-4">
            <h4 class="fw-bold mb-0 text-primary">{{ number_format($author->following_count) }}</h4>
            <span class="small text-muted">Following</span>
          </div>
        </div>
      </div>
    </div>

    <!-- Author's Published Articles -->
    <div class="mb-4">
      <h3 class="font-heading fw-bold mb-4">Articles by {{ $author->name }}</h3>
      @if($articles->count() > 0)
        <div class="row g-4 mb-4">
          @foreach($articles as $article)
            <div class="col-md-6 col-lg-4">
              <x-blog-card :article="$article" />
            </div>
          @endforeach
        </div>
        <div class="d-flex justify-content-center">
          {{ $articles->links('components.pagination') }}
        </div>
      @else
        <p class="text-muted">No published articles yet.</p>
      @endif
    </div>

  </div>
</section>
@endsection
