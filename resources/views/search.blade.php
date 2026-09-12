@extends('layouts.app')

@section('title', 'Search Results — BlogHub')

@section('content')
<section class="py-5 bg-light-subtle">
  <div class="container">
    <div class="mb-4">
      <h1 class="font-heading fw-bold display-5">
        @if(!empty($query))
          Search Results for "<span class="text-accent" style="color: var(--bh-accent);">{{ $query }}</span>"
        @else
          Search Articles
        @endif
      </h1>
      <p class="text-muted">
        @if($articles->count() > 0)
          Found {{ $articles->total() }} matching article(s).
        @else
          No results found for your search query.
        @endif
      </p>
    </div>

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
      <div class="bh-card p-5 text-center my-4">
        <i class="fas fa-search display-3 text-muted mb-3"></i>
        <h3 class="font-heading fw-bold mb-2">No matching articles found</h3>
        <p class="text-muted mb-4">Try searching for a different keyword or explore popular categories below.</p>
        
        <h5 class="font-heading fw-bold mb-3">Suggested Categories</h5>
        <div class="d-flex flex-wrap justify-content-center gap-2">
          @foreach($suggestedCategories as $cat)
            <a href="{{ route('blogs.index', ['category' => $cat->slug]) }}" class="bh-badge bh-badge-coral text-decoration-none">
              <i class="fas {{ $cat->icon }}"></i> {{ $cat->name }}
            </a>
          @endforeach
        </div>
      </div>
    @endif
  </div>
</section>
@endsection
