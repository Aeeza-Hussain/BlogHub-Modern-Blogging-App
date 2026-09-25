@props(['author'])

<div class="bh-card p-4 text-center h-100 d-flex flex-column align-items-center">
  <div class="position-relative mb-3">
    <img src="{{ $author->avatar }}" alt="{{ $author->name }}" class="rounded-circle shadow-sm" style="width: 90px; height: 90px; object-fit: cover;">
  </div>

  <h5 class="font-heading fw-bold mb-1">
    <a href="{{ route('authors.show', $author->slug) }}" class="text-decoration-none text-reset">
      {{ $author->name }}
    </a>
  </h5>
  
  <span class="bh-badge bh-badge-coral mb-2" style="font-size: 0.7rem;">
    {{ $author->specialty }}
  </span>

  <p class="text-muted small mb-3 flex-grow-1">
    {{ Str::limit($author->tagline, 80) }}
  </p>

  <div class="d-flex align-items-center justify-content-center gap-3 w-100 py-2 border-top border-bottom my-3 small text-muted font-mono">
    <div>
      <span class="fw-bold text-dark d-block">{{ $author->articles_count ?? $author->articles->count() }}</span>
      <span style="font-size: 0.75rem;">Articles</span>
    </div>
    <div class="border-start ps-3">
      <span class="fw-bold text-dark d-block">{{ number_format($author->followers_count) }}</span>
      <span style="font-size: 0.75rem;">Followers</span>
    </div>
  </div>

  <div class="d-flex gap-2 w-100 mt-auto">
    <a href="{{ route('authors.show', $author->slug) }}" class="btn btn-sm btn-bh-outline flex-grow-1">Profile</a>
    <button type="button" class="btn btn-sm btn-bh-primary px-3 btn-follow-toggle" onclick="this.classList.toggle('btn-success'); this.textContent = this.textContent === 'Follow' ? 'Following' : 'Follow';">Follow</button>
  </div>
</div>
