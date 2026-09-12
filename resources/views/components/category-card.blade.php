@props(['category'])

<a href="{{ route('blogs.index', ['category' => $category->slug]) }}" class="text-decoration-none text-reset">
  <div class="bh-card p-4 h-100 d-flex flex-column align-items-start transition-all">
    <div class="rounded-3 p-3 mb-3 d-flex align-items-center justify-content-center text-white" style="background-color: {{ $category->color }}; width: 48px; height: 48px;">
      <i class="fas {{ $category->icon }} fs-4"></i>
    </div>
    
    <div class="d-flex align-items-center justify-content-between w-100 mb-2">
      <h5 class="font-heading fw-bold mb-0">{{ $category->name }}</h5>
      <span class="badge bg-secondary rounded-pill font-mono">{{ $category->articles_count ?? $category->articles->count() }} articles</span>
    </div>

    <p class="text-muted small mb-0">
      {{ Str::limit($category->description, 90) }}
    </p>
  </div>
</a>
