@extends('layouts.app')

@section('title', 'Write & Publish New Article — BlogHub')

@section('content')
<section class="py-5 bg-light-subtle">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-lg-8">
        <div class="bh-card p-4 p-md-5">
          <div class="d-flex align-items-center gap-2 mb-3">
            <span class="bh-badge bh-badge-coral"><i class="fas fa-edit"></i> Article Editor</span>
          </div>
          <h1 class="font-heading fw-bold display-6 mb-2">Create New Article</h1>
          <p class="text-muted mb-4">Publish long-form articles, stories, or technical tutorials to the BlogHub platform.</p>

          <form action="{{ route('blogs.store') }}" method="POST" class="needs-validation" novalidate>
            @csrf
            
            <div class="mb-4">
              <label for="title" class="form-label font-mono fw-semibold">Article Title</label>
              <input type="text" name="title" id="title" class="form-control form-control-lg" placeholder="e.g. Mastering Design Systems with Modern CSS" required>
              <div class="invalid-feedback">Article title is required.</div>
            </div>

            <div class="row g-3 mb-4">
              <div class="col-md-6">
                <label for="category_id" class="form-label font-mono fw-semibold">Category</label>
                <select name="category_id" id="category_id" class="form-select" required>
                  <option value="">Select Category</option>
                  @foreach($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                  @endforeach
                </select>
                <div class="invalid-feedback">Please select a category.</div>
              </div>

              <div class="col-md-6">
                <label for="author_id" class="form-label font-mono fw-semibold">Author</label>
                <select name="author_id" id="author_id" class="form-select" required>
                  <option value="">Select Author</option>
                  @foreach($authors as $author)
                    <option value="{{ $author->id }}">{{ $author->name }} ({{ $author->specialty }})</option>
                  @endforeach
                </select>
                <div class="invalid-feedback">Please select an author.</div>
              </div>
            </div>

            <div class="mb-4">
              <label for="featured_image" class="form-label font-mono fw-semibold">Featured Cover Image URL</label>
              <input type="url" name="featured_image" id="featured_image" class="form-control" placeholder="https://images.unsplash.com/photo-..." required>
              <div class="form-text small">Enter a valid Unsplash image URL or image direct link.</div>
            </div>

            <div class="mb-4">
              <label for="excerpt" class="form-label font-mono fw-semibold">Short Excerpt / Summary</label>
              <textarea name="excerpt" id="excerpt" class="form-control" rows="2" placeholder="Brief 1-2 sentence summary that appears on blog cards..." required></textarea>
              <div class="invalid-feedback">Short excerpt is required.</div>
            </div>

            <div class="mb-4">
              <label for="body" class="form-label font-mono fw-semibold">Full Article Body (HTML Supported)</label>
              <textarea name="body" id="body" class="form-control" rows="10" placeholder="<p>Write your detailed article body here...</p>" required></textarea>
              <div class="invalid-feedback">Article body content is required.</div>
            </div>

            <div class="row align-items-center">
              <div class="col-md-6 mb-3 mb-md-0">
                <label for="reading_time" class="form-label font-mono fw-semibold">Estimated Reading Time (Minutes)</label>
                <input type="number" name="reading_time" id="reading_time" class="form-control" value="5" min="1" max="60">
              </div>
              <div class="col-md-6 text-end">
                <button type="submit" class="btn btn-bh-accent btn-lg w-100 w-md-auto">
                  <i class="fas fa-paper-plane me-2"></i> Publish Article
                </button>
              </div>
            </div>

          </form>
        </div>
      </div>
    </div>
  </div>
</section>
@endsection
