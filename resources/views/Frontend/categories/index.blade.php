@extends('layouts.app')

@section('title', 'Categories Directory — BlogHub')

@section('content')
<section class="py-5 bg-light-subtle">
  <div class="container">
    <div class="text-center max-w-700 mx-auto mb-5">
      <span class="bh-badge bh-badge-coral mb-2">Explore Topics</span>
      <h1 class="font-heading fw-bold display-5">Browse All Categories</h1>
      <p class="text-muted">Discover articles structured across 10+ core subjects and industry domains.</p>
    </div>

    <div class="row g-4">
      @foreach($categories as $category)
        <div class="col-md-6 col-lg-4">
          <x-category-card :category="$category" />
        </div>
      @endforeach
    </div>
  </div>
</section>
@endsection
