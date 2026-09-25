@extends('layouts.app')

@section('title', 'Authors Directory — BlogHub')

@section('content')
<section class="py-5 bg-light-subtle">
  <div class="container">
    <div class="d-flex flex-column flex-md-row align-items-md-center justify-content-between mb-4 gap-3">
      <div>
        <h1 class="font-heading fw-bold display-5 mb-1">Meet Our Authors</h1>
        <p class="text-muted mb-0">Discover industry leaders, journalists, researchers, and technical writers.</p>
      </div>
      
      <!-- Search Authors -->
      <form action="{{ route('authors.index') }}" method="GET" class="d-flex gap-2">
        <input type="text" name="search" class="form-control" placeholder="Search author or specialty..." value="{{ request('search') }}">
        <button type="submit" class="btn btn-bh-primary"><i class="fas fa-search"></i></button>
      </form>
    </div>

    <div class="row g-4 mb-4">
      @foreach($authors as $author)
        <div class="col-md-6 col-lg-3">
          <x-author-card :author="$author" />
        </div>
      @endforeach
    </div>

    <div class="d-flex justify-content-center">
      {{ $authors->links('components.pagination') }}
    </div>
  </div>
</section>
@endsection
