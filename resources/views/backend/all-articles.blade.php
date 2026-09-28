@extends('layouts.admin')

@section('title', 'All Articles — BlogHub Admin')

@section('content')
<div class="container-xl">

    {{-- Page Header --}}
    <div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-2">
        <div>
            <h1 class="h3 fw-bold mb-1" style="color:#0f172a;">
                <i class="fa-solid fa-newspaper me-2" style="color:#C8461F;"></i> All Articles
            </h1>
            <p class="text-muted small mb-0">Review, search, and moderate every article on the platform.</p>
        </div>
        <a href="{{ route('blogs.create') }}" class="btn btn-sm btn-primary">
            <i class="fa-solid fa-plus me-1"></i> New Article
        </a>
    </div>

    {{-- Stats Row --}}
    <div class="row g-3 mb-4">
        <div class="col-6 col-md-4">
            <div class="card border-0 shadow-sm text-center py-3">
                <div class="fs-2 fw-bold" style="color:#C8461F;">{{ $totalArticles }}</div>
                <div class="text-muted small">Total Articles</div>
            </div>
        </div>
        <div class="col-6 col-md-4">
            <div class="card border-0 shadow-sm text-center py-3">
                <div class="fs-2 fw-bold text-primary">{{ number_format($totalViews) }}</div>
                <div class="text-muted small">Total Views</div>
            </div>
        </div>
        <div class="col-6 col-md-4">
            <div class="card border-0 shadow-sm text-center py-3">
                <div class="fs-2 fw-bold text-success">{{ number_format($totalLikes) }}</div>
                <div class="text-muted small">Total Likes</div>
            </div>
        </div>
    </div>

    {{-- Filters --}}
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body py-3">
            <form method="GET" action="{{ route('dashboard.all-articles') }}" class="row g-2 align-items-center">
                <div class="col-12 col-md-5">
                    <div class="input-group">
                        <span class="input-group-text bg-white border-end-0">
                            <i class="fa-solid fa-search text-muted"></i>
                        </span>
                        <input type="text" name="search" value="{{ request('search') }}"
                            class="form-control border-start-0 ps-0"
                            placeholder="Search by title or excerpt...">
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <select name="category" class="form-select">
                        <option value="">All Categories</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>
                                {{ $cat->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-6 col-md-2">
                    <select name="sort" class="form-select">
                        <option value="newest" {{ request('sort','newest') == 'newest' ? 'selected' : '' }}>Newest</option>
                        <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Oldest</option>
                        <option value="popular" {{ request('sort') == 'popular' ? 'selected' : '' }}>Most Viewed</option>
                    </select>
                </div>
                <div class="col-12 col-md-2 d-flex gap-2">
                    <button type="submit" class="btn btn-primary w-100">Filter</button>
                    <a href="{{ route('dashboard.all-articles') }}" class="btn btn-outline-secondary w-100">Reset</a>
                </div>
            </form>
        </div>
    </div>

    {{-- Articles Table --}}
    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead style="background:#f8fafc; border-bottom:2px solid #e2e8f0;">
                        <tr>
                            <th class="py-3 ps-4" style="font-size:0.78rem;text-transform:uppercase;letter-spacing:.05em;color:#64748b;">Article</th>
                            <th class="py-3" style="font-size:0.78rem;text-transform:uppercase;letter-spacing:.05em;color:#64748b;">Author</th>
                            <th class="py-3" style="font-size:0.78rem;text-transform:uppercase;letter-spacing:.05em;color:#64748b;">Category</th>
                            <th class="py-3 text-center" style="font-size:0.78rem;text-transform:uppercase;letter-spacing:.05em;color:#64748b;">Views</th>
                            <th class="py-3 text-center" style="font-size:0.78rem;text-transform:uppercase;letter-spacing:.05em;color:#64748b;">Likes</th>
                            <th class="py-3" style="font-size:0.78rem;text-transform:uppercase;letter-spacing:.05em;color:#64748b;">Date</th>
                            <th class="py-3 pe-4" style="font-size:0.78rem;text-transform:uppercase;letter-spacing:.05em;color:#64748b;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($articles as $article)
                        <tr>
                            <td class="ps-4" style="max-width:300px;">
                                <div class="d-flex align-items-center gap-3">
                                    <img src="{{ $article->featured_image ?? 'https://ui-avatars.com/api/?name=' . urlencode($article->title) . '&background=C8461F&color=fff' }}"
                                        alt="{{ $article->title }}"
                                        class="rounded"
                                        style="width:52px; height:40px; object-fit:cover; flex-shrink:0;">
                                    <div>
                                        <div class="fw-semibold text-truncate" style="max-width:220px; font-size:0.88rem; color:#0f172a;">
                                            {{ $article->title }}
                                        </div>
                                        <div class="text-muted text-truncate" style="max-width:220px; font-size:0.75rem;">
                                            {{ Str::limit($article->excerpt, 60) }}
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <img src="{{ $article->author->avatar ?? 'https://ui-avatars.com/api/?name=' . urlencode($article->author->name ?? 'A') . '&background=C8461F&color=fff' }}"
                                        class="rounded-circle" style="width:28px; height:28px; object-fit:cover;">
                                    <span style="font-size:0.82rem;">{{ $article->author->name ?? '—' }}</span>
                                </div>
                            </td>
                            <td>
                                <span class="badge" style="background:rgba(200,70,31,0.1); color:#C8461F; font-weight:600; font-size:0.72rem;">
                                    {{ $article->category->name ?? '—' }}
                                </span>
                            </td>
                            <td class="text-center">
                                <span class="text-muted small">
                                    <i class="fa-solid fa-eye me-1 opacity-50"></i>{{ number_format($article->views_count) }}
                                </span>
                            </td>
                            <td class="text-center">
                                <span class="text-muted small">
                                    <i class="fa-solid fa-heart me-1 opacity-50 text-danger"></i>{{ number_format($article->likes_count) }}
                                </span>
                            </td>
                            <td class="text-muted small">{{ $article->created_at->format('M d, Y') }}</td>
                            <td class="pe-4">
                                <div class="d-flex gap-2">
                                    <a href="{{ route('blogs.show', $article->slug) }}" target="_blank"
                                        class="btn btn-sm btn-outline-secondary" title="View" style="padding:3px 8px;">
                                        <i class="fa-solid fa-eye"></i>
                                    </a>
                                    <a href="{{ route('blogs.edit', $article->id) }}"
                                        class="btn btn-sm btn-outline-primary" title="Edit" style="padding:3px 8px;">
                                        <i class="fa-solid fa-pen"></i>
                                    </a>
                                    <form method="POST" action="{{ route('dashboard.all-articles.delete', $article->id) }}"
                                        onsubmit="return confirm('Delete this article permanently?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete" style="padding:3px 8px;">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="text-center py-5 text-muted">
                                <i class="fa-solid fa-newspaper fa-2x mb-2 d-block opacity-25"></i>
                                No articles found.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        @if($articles->hasPages())
        <div class="card-footer bg-white border-top d-flex justify-content-between align-items-center py-3 px-4">
            <div class="text-muted small">
                Showing {{ $articles->firstItem() }}–{{ $articles->lastItem() }} of {{ $articles->total() }} articles
            </div>
            {{ $articles->links() }}
        </div>
        @endif
    </div>

</div>
@endsection
