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

          @if($errors->any())
            <div class="alert alert-danger border-0 shadow-sm mb-4" role="alert">
              <h6 class="font-heading fw-bold mb-2"><i class="fas fa-exclamation-circle me-2"></i>Please fix the following:</h6>
              <ul class="mb-0 small ps-3">
                @foreach($errors->all() as $error)
                  <li>{{ $error }}</li>
                @endforeach
              </ul>
            </div>
          @endif

          <form action="{{ route('blogs.store') }}" method="POST" class="needs-validation" novalidate>
            @csrf

            <div class="mb-4">
              <label for="title" class="form-label font-mono fw-semibold">Article Title</label>
              <input type="text" name="title" id="title" value="{{ old('title') }}" class="form-control form-control-lg @error('title') is-invalid @enderror" placeholder="e.g. Mastering Design Systems with Modern CSS" required>
              @error('title') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
              <div class="invalid-feedback">Article title is required.</div>
            </div>

            <div class="row g-3 mb-4">
              <div class="col-md-6">
                <label for="category_id" class="form-label font-mono fw-semibold">Category</label>
                <select name="category_id" id="category_id" class="form-select @error('category_id') is-invalid @enderror" required>
                  <option value="">Select Category</option>
                  @foreach($categories as $category)
                    <option value="{{ $category->id }}" @selected(old('category_id', $category->id) == $category->id)>
                      {{ $category->name }}
                    </option>
                  @endforeach
                </select>
                @error('category_id') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                <div class="invalid-feedback">Please select a category.</div>
              </div>

              <div class="col-md-6">
                <label for="author_id" class="form-label font-mono fw-semibold">Author</label>
                @if(auth()->user()->isAdmin())
                  {{-- Admins can publish on behalf of any author --}}
                  <select name="author_id" id="author_id" class="form-select @error('author_id') is-invalid @enderror">
                    <option value="">{{ $author->name }} (publishing as yourself)</option>
                    @foreach($authors as $option)
                      <option value="{{ $option->id }}" @selected(old('author_id') == $option->id)>
                        {{ $option->name }} ({{ $option->specialty }})
                      </option>
                    @endforeach
                  </select>
                  @error('author_id') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
                @else
                  {{-- Authors always publish under their own byline; chosen automatically --}}
                  <div class="form-control d-flex align-items-center gap-2 bg-body-secondary" style="height: auto; padding-top: 0.5rem; padding-bottom: 0.5rem;">
                    <img src="{{ $author->avatar }}" alt="{{ $author->name }}" class="rounded-circle" style="width: 28px; height: 28px; object-fit: cover;">
                    <div class="lh-sm">
                      <span class="d-block fw-semibold small">{{ $author->name }}</span>
                      <span class="d-block text-muted font-mono" style="font-size: 0.72rem;">{{ $author->specialty }}</span>
                    </div>
                  </div>
                @endif
                <div class="form-text small">Your public author profile. You can update it from your account settings.</div>
              </div>
            </div>

            <div class="mb-4">
              <label for="featured_image" class="form-label font-mono fw-semibold">Featured Cover Image URL</label>
              <input type="url" name="featured_image" id="featured_image" value="{{ old('featured_image') }}" class="form-control @error('featured_image') is-invalid @enderror" placeholder="https://images.unsplash.com/photo-...">
              @error('featured_image') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
              <div class="form-text small">Optional. Leave blank to use a default cover image.</div>
            </div>

            <div class="mb-4">
              <label for="excerpt" class="form-label font-mono fw-semibold">Short Excerpt / Summary</label>
              <textarea name="excerpt" id="excerpt" rows="2" maxlength="500" class="form-control @error('excerpt') is-invalid @enderror" placeholder="Brief 1-2 sentence summary that appears on blog cards..." required>{{ old('excerpt') }}</textarea>
              @error('excerpt') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
              <div class="invalid-feedback">Short excerpt is required.</div>
            </div>

            <div class="mb-4">
              <label for="body" class="form-label font-mono fw-semibold">Full Article Body (HTML Supported)</label>
              <textarea name="body" id="body" rows="10" class="form-control @error('body') is-invalid @enderror" placeholder="<p>Write your detailed article body here...</p>" required>{{ old('body') }}</textarea>
              @error('body') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
              <div class="invalid-feedback">Article body content is required.</div>
            </div>

            <div class="row align-items-center">
              <div class="col-md-6 mb-3 mb-md-0">
                <label for="reading_time" class="form-label font-mono fw-semibold">Estimated Reading Time (Minutes)</label>
                <input type="number" name="reading_time" id="reading_time" value="{{ old('reading_time', 5) }}" class="form-control @error('reading_time') is-invalid @enderror" min="1" max="60">
                @error('reading_time') <div class="invalid-feedback d-block">{{ $message }}</div> @enderror
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
