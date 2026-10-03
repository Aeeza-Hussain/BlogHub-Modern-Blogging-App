@extends('backend.layouts.admin')

@section('title', 'My Posts — Creator Studio')

@section('content')

{{-- Page Header --}}
<div class="bh-page-header">
    <div>
        <h1 class="bh-page-title"><i class="fa-solid fa-newspaper text-primary me-2"></i>My Posts</h1>
        <p class="bh-page-sub">Manage, write, revise, and track performance of your stories and articles.</p>
    </div>
    <div>
        <a href="{{ route('blogs.create') }}" class="bh-btn bh-btn-primary">
            <i class="fa-solid fa-plus me-1"></i> Create New Post
        </a>
    </div>
</div>

{{-- Stats Summary --}}
<div class="row g-3 mb-4">
    <div class="col-6 col-md-4 col-xl">
        <a href="{{ route('dashboard.articles') }}" class="bh-stat">
            <div class="bh-stat-icon" style="background:rgba(200,70,31,0.1); color:#C8461F;">
                <i class="fa-solid fa-newspaper"></i>
            </div>
            <div>
                <div class="bh-stat-num">{{ number_format($totalMyArticles) }}</div>
                <div class="bh-stat-label">Total Posts</div>
            </div>
        </a>
    </div>
    <div class="col-6 col-md-4 col-xl">
        <a href="{{ route('dashboard.articles', ['status' => 'approved']) }}" class="bh-stat">
            <div class="bh-stat-icon" style="background:rgba(16,185,129,0.1); color:#10b981;">
                <i class="fa-solid fa-circle-check"></i>
            </div>
            <div>
                <div class="bh-stat-num">{{ number_format($publishedCount) }}</div>
                <div class="bh-stat-label">Published Posts</div>
            </div>
        </a>
    </div>
    <div class="col-6 col-md-4 col-xl">
        <a href="{{ route('dashboard.articles', ['status' => 'pending']) }}" class="bh-stat" style="{{ $pendingCount > 0 ? 'border:1.5px solid #f59e0b;' : '' }}">
            <div class="bh-stat-icon" style="background:rgba(245,158,11,0.1); color:#f59e0b;">
                <i class="fa-solid fa-clock-rotate-left"></i>
            </div>
            <div>
                <div class="bh-stat-num" style="{{ $pendingCount > 0 ? 'color:#b45309;' : '' }}">{{ number_format($pendingCount) }}</div>
                <div class="bh-stat-label">Pending Review</div>
            </div>
        </a>
    </div>
    <div class="col-6 col-md-4 col-xl">
        <a href="{{ route('dashboard.articles', ['status' => 'draft']) }}" class="bh-stat">
            <div class="bh-stat-icon" style="background:rgba(107,114,128,0.1); color:#6b7280;">
                <i class="fa-solid fa-file-pen"></i>
            </div>
            <div>
                <div class="bh-stat-num">{{ number_format($draftCount) }}</div>
                <div class="bh-stat-label">Draft Posts</div>
            </div>
        </a>
    </div>
    <div class="col-6 col-md-4 col-xl">
        <a href="{{ route('dashboard.articles', ['status' => 'rejected']) }}" class="bh-stat" style="{{ $rejectedCount > 0 ? 'border:1.5px solid #ef4444;' : '' }}">
            <div class="bh-stat-icon" style="background:rgba(239,68,68,0.1); color:#ef4444;">
                <i class="fa-solid fa-circle-xmark"></i>
            </div>
            <div>
                <div class="bh-stat-num" style="{{ $rejectedCount > 0 ? 'color:#dc2626;' : '' }}">{{ number_format($rejectedCount) }}</div>
                <div class="bh-stat-label">Needs Revision</div>
            </div>
        </a>
    </div>
</div>

{{-- Filters Card --}}
<div class="bh-card mb-4">
    <div class="bh-card-body p-3">
        <form method="GET" action="{{ route('dashboard.articles') }}" class="row g-2 align-items-center">
            <div class="col-12 col-md-4">
                <div class="input-group">
                    <span class="input-group-text bg-white border-end-0">
                        <i class="fa-solid fa-search text-muted"></i>
                    </span>
                    <input type="text" name="search" value="{{ request('search') }}"
                           class="form-control border-start-0 ps-0"
                           placeholder="Search your posts by title or summary...">
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
                <select name="status" class="form-select">
                    <option value="">All Statuses</option>
                    <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Published ({{ $publishedCount }})</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>In Review ({{ $pendingCount }})</option>
                    <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>Draft ({{ $draftCount }})</option>
                    <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Needs Revision ({{ $rejectedCount }})</option>
                </select>
            </div>
            <div class="col-6 col-md-1">
                <select name="sort" class="form-select">
                    <option value="newest" {{ request('sort','newest') == 'newest' ? 'selected' : '' }}>New</option>
                    <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Old</option>
                    <option value="popular" {{ request('sort') == 'popular' ? 'selected' : '' }}>Top</option>
                </select>
            </div>
            <div class="col-6 col-md-2 d-flex gap-2">
                <button type="submit" class="bh-btn bh-btn-primary w-100 justify-content-center">
                    <i class="fa-solid fa-filter me-1"></i> Filter
                </button>
                <a href="{{ route('dashboard.articles') }}" class="bh-btn bh-btn-ghost" title="Reset">
                    <i class="fa-solid fa-arrow-rotate-left"></i>
                </a>
            </div>
        </form>
    </div>
</div>

{{-- Articles Table --}}
<div class="bh-card">
    <div class="bh-card-header">
        <h2 class="bh-card-title"><i class="fa-solid fa-list me-2" style="color:var(--brand);"></i> My Articles List</h2>
        <span class="text-muted small">Showing {{ $articles->firstItem() ?? 0 }} - {{ $articles->lastItem() ?? 0 }} of {{ $articles->total() }} stories</span>
    </div>

    <div class="table-responsive">
        <table class="bh-table">
            <thead>
                <tr>
                    <th>Post Title</th>
                    <th>Category</th>
                    <th>Status</th>
                    <th>Views</th>
                    <th>Comments</th>
                    <th>Created Date</th>
                    <th>Updated Date</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($articles as $article)
                <tr style="{{ $article->status === 'pending' ? 'background:rgba(245,158,11,0.03);' : '' }}">
                    <td>
                        <div class="d-flex align-items-center gap-3">
                            <img src="{{ $article->featured_image }}" alt="{{ $article->title }}"
                                 style="width:48px; height:36px; border-radius:6px; object-fit:cover; flex-shrink:0;">
                            <div>
                                <a href="{{ route('blogs.edit', $article->id) }}" class="fw-semibold text-dark text-decoration-none d-block text-truncate" style="max-width:220px;" title="{{ $article->title }}">
                                    {{ $article->title }}
                                </a>
                                <span class="text-muted small"><i class="fa-solid fa-clock me-1"></i>{{ $article->reading_time ?? 5 }} min read</span>
                                @if($article->status === 'rejected' && $article->rejection_reason)
                                <div class="text-danger small mt-1 text-truncate" style="max-width:220px;" title="{{ $article->rejection_reason }}">
                                    <i class="fa-solid fa-triangle-exclamation me-1"></i><strong>Admin feedback:</strong> {{ $article->rejection_reason }}
                                </div>
                                @endif
                            </div>
                        </div>
                    </td>
                    <td>
                        <span class="badge bg-light text-dark border">
                            {{ $article->category?->name ?? 'General' }}
                        </span>
                    </td>
                    <td>
                        @if($article->status === 'approved')
                            <span class="bh-badge" style="background:#dcfce7; color:#15803d;">
                                <i class="fa-solid fa-circle-check me-1"></i> Published
                            </span>
                        @elseif($article->status === 'pending')
                            <span class="bh-badge" style="background:#fef3c7; color:#b45309;">
                                <i class="fa-solid fa-clock me-1"></i> In Review
                            </span>
                        @elseif($article->status === 'draft')
                            <span class="bh-badge" style="background:#f3f4f6; color:#4b5563;">
                                <i class="fa-solid fa-file-pen me-1"></i> Draft
                            </span>
                        @elseif($article->status === 'rejected')
                            <span class="bh-badge" style="background:#fee2e2; color:#dc2626;">
                                <i class="fa-solid fa-circle-xmark me-1"></i> Needs Revision
                            </span>
                        @endif
                    </td>
                    <td>
                        <span class="small fw-semibold text-muted">
                            <i class="fa-regular fa-eye me-1 text-primary"></i>{{ number_format($article->views_count) }}
                        </span>
                    </td>
                    <td>
                        <span class="small fw-semibold text-muted">
                            <i class="fa-regular fa-comments me-1 text-success"></i>{{ $article->allComments()->count() }}
                        </span>
                    </td>
                    <td class="text-muted small">
                        {{ $article->created_at->format('M d, Y') }}
                    </td>
                    <td class="text-muted small">
                        {{ $article->updated_at->format('M d, Y') }}
                    </td>
                    <td class="text-end">
                        <div class="d-inline-flex align-items-center gap-1">
                            {{-- View if published --}}
                            @if($article->status === 'approved')
                            <a href="{{ route('blogs.show', $article->slug) }}" target="_blank" class="bh-btn bh-btn-ghost bh-btn-icon bh-btn-sm" title="View Published Story">
                                <i class="fa-solid fa-arrow-up-right-from-square"></i>
                            </a>
                            @endif

                            {{-- Edit --}}
                            <a href="{{ route('blogs.edit', $article->id) }}" class="bh-btn bh-btn-ghost bh-btn-icon bh-btn-sm" title="Edit Story">
                                <i class="fa-solid fa-pen"></i>
                            </a>

                            {{-- Submit for Review if draft or rejected --}}
                            @if(in_array($article->status, ['draft', 'rejected']))
                            <form action="{{ route('dashboard.articles.submit-review', $article->id) }}" method="POST" class="d-inline"
                                  onsubmit="return confirm('Submit this story for administrator editorial review?');">
                                @csrf
                                <button type="submit" class="bh-btn bh-btn-sm" style="background:#dbeafe; color:#1d4ed8;" title="Submit for Review">
                                    <i class="fa-solid fa-paper-plane me-1"></i> Submit
                                </button>
                            </form>
                            @endif

                            {{-- Delete --}}
                            <form action="{{ route('dashboard.articles.delete', $article->id) }}" method="POST" class="d-inline"
                                  onsubmit="return confirm('Are you sure you want to delete this story?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bh-btn bh-btn-ghost bh-btn-icon bh-btn-sm text-danger" title="Delete Story">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="text-center py-5 text-muted">
                        <i class="fa-solid fa-pen-nib fa-2x mb-2 d-block text-secondary"></i>
                        No stories found matching your filter criteria.
                        <div class="mt-2">
                            <a href="{{ route('blogs.create') }}" class="bh-btn bh-btn-primary bh-btn-sm">
                                <i class="fa-solid fa-plus me-1"></i> Create New Post
                            </a>
                        </div>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($articles->hasPages())
    <div class="bh-card-body border-top p-3 d-flex justify-content-end">
        {{ $articles->links() }}
    </div>
    @endif
</div>

@endsection
