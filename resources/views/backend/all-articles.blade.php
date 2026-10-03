@extends('backend.layouts.admin')

@section('title', 'Posts Management — BlogHub Admin')

@section('content')

{{-- Page Header --}}
<div class="bh-page-header">
    <div>
        <h1 class="bh-page-title"><i class="fa-solid fa-newspaper text-primary me-2"></i>Posts Management</h1>
        <p class="bh-page-sub">Comprehensive moderation for all articles. Review submissions, publish, move to draft, edit, and delete.</p>
    </div>
</div>

{{-- Summary Statistics Cards --}}
<div class="row g-3 mb-4">
    <div class="col-6 col-md-4 col-xl">
        <a href="{{ route('dashboard.all-articles') }}" class="bh-stat">
            <div class="bh-stat-icon" style="background:rgba(200,70,31,0.1); color:#C8461F;">
                <i class="fa-solid fa-newspaper"></i>
            </div>
            <div>
                <div class="bh-stat-num">{{ number_format($totalArticles) }}</div>
                <div class="bh-stat-label">Total Posts</div>
            </div>
        </a>
    </div>
    <div class="col-6 col-md-4 col-xl">
        <a href="{{ route('dashboard.all-articles', ['status' => 'approved']) }}" class="bh-stat">
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
        <a href="{{ route('dashboard.all-articles', ['status' => 'pending']) }}" class="bh-stat" style="{{ $pendingCount > 0 ? 'border:1.5px solid #f59e0b;' : '' }}">
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
        <a href="{{ route('dashboard.all-articles', ['status' => 'draft']) }}" class="bh-stat">
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
        <a href="{{ route('dashboard.all-articles', ['status' => 'rejected']) }}" class="bh-stat">
            <div class="bh-stat-icon" style="background:rgba(239,68,68,0.1); color:#ef4444;">
                <i class="fa-solid fa-circle-xmark"></i>
            </div>
            <div>
                <div class="bh-stat-num">{{ number_format($rejectedCount) }}</div>
                <div class="bh-stat-label">Rejected Posts</div>
            </div>
        </a>
    </div>
</div>

{{-- Filters Card --}}
<div class="bh-card mb-4">
    <div class="bh-card-body p-3">
        <form method="GET" action="{{ route('dashboard.all-articles') }}" class="row g-2 align-items-center">
            {{-- Search --}}
            <div class="col-12 col-md-3">
                <div class="input-group">
                    <span class="input-group-text bg-white border-end-0">
                        <i class="fa-solid fa-search text-muted"></i>
                    </span>
                    <input type="text" name="search" value="{{ request('search') }}"
                           class="form-control border-start-0 ps-0"
                           placeholder="Search posts by title, excerpt...">
                </div>
            </div>

            {{-- Status Filter --}}
            <div class="col-6 col-md-2">
                <select name="status" class="form-select">
                    <option value="">All Statuses</option>
                    <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Published ({{ $publishedCount }})</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending Review ({{ $pendingCount }})</option>
                    <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>Draft ({{ $draftCount }})</option>
                    <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected ({{ $rejectedCount }})</option>
                </select>
            </div>

            {{-- Category Filter --}}
            <div class="col-6 col-md-2">
                <select name="category" class="form-select">
                    <option value="">All Categories</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>
                            {{ $cat->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Author Filter --}}
            <div class="col-6 col-md-2">
                <select name="author" class="form-select">
                    <option value="">All Authors</option>
                    @foreach($authors as $authItem)
                        <option value="{{ $authItem->id }}" {{ request('author') == $authItem->id ? 'selected' : '' }}>
                            {{ $authItem->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Sort --}}
            <div class="col-6 col-md-1">
                <select name="sort" class="form-select">
                    <option value="newest" {{ request('sort','newest') == 'newest' ? 'selected' : '' }}>Newest</option>
                    <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Oldest</option>
                    <option value="popular" {{ request('sort') == 'popular' ? 'selected' : '' }}>Popular</option>
                </select>
            </div>

            {{-- Buttons --}}
            <div class="col-12 col-md-2 d-flex gap-2">
                <button type="submit" class="bh-btn bh-btn-primary w-100 justify-content-center">
                    <i class="fa-solid fa-filter me-1"></i> Filter
                </button>
                <a href="{{ route('dashboard.all-articles') }}" class="bh-btn bh-btn-ghost" title="Reset">
                    <i class="fa-solid fa-arrow-rotate-left"></i>
                </a>
            </div>
        </form>
    </div>
</div>

{{-- Posts Table --}}
<div class="bh-card">
    <div class="bh-card-header">
        <h2 class="bh-card-title"><i class="fa-solid fa-list me-2" style="color:var(--brand);"></i> Articles List</h2>
        <span class="text-muted small">Showing {{ $articles->firstItem() ?? 0 }} - {{ $articles->lastItem() ?? 0 }} of {{ $articles->total() }} posts</span>
    </div>

    <div class="table-responsive">
        <table class="bh-table">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Author</th>
                    <th>Category</th>
                    <th>Status</th>
                    <th>Created Date</th>
                    <th>Published Date</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($articles as $article)
                <tr style="{{ $article->status === 'pending' ? 'background:rgba(245,158,11,0.04);' : '' }}">
                    <td>
                        <div class="d-flex align-items-center gap-3">
                            <img src="{{ $article->featured_image }}" alt="{{ $article->title }}"
                                 style="width:48px; height:38px; border-radius:6px; object-fit:cover; flex-shrink:0;">
                            <div>
                                <a href="{{ route('blogs.show', $article->slug) }}" target="_blank"
                                   class="fw-semibold text-dark text-decoration-none d-block text-truncate" style="max-width:240px;" title="{{ $article->title }}">
                                    {{ $article->title }}
                                </a>
                                <span class="text-muted small"><i class="fa-regular fa-eye me-1"></i>{{ number_format($article->views_count) }} views</span>
                                @if($article->status === 'rejected' && $article->rejection_reason)
                                <div class="text-danger small text-truncate" style="max-width:240px;">
                                    <i class="fa-solid fa-circle-exclamation me-1"></i>{{ $article->rejection_reason }}
                                </div>
                                @endif
                            </div>
                        </div>
                    </td>
                    <td>
                        <span class="fw-medium text-dark">{{ $article->author?->name ?? 'Author' }}</span>
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
                                <i class="fa-solid fa-clock me-1"></i> Pending Review
                            </span>
                        @elseif($article->status === 'draft')
                            <span class="bh-badge" style="background:#f3f4f6; color:#4b5563;">
                                <i class="fa-solid fa-file-pen me-1"></i> Draft
                            </span>
                        @elseif($article->status === 'rejected')
                            <span class="bh-badge" style="background:#fee2e2; color:#dc2626;">
                                <i class="fa-solid fa-circle-xmark me-1"></i> Rejected
                            </span>
                        @endif
                    </td>
                    <td class="text-muted small">
                        {{ $article->created_at->format('M d, Y') }}
                    </td>
                    <td class="text-muted small">
                        {{ $article->published_at ? $article->published_at->format('M d, Y') : '—' }}
                    </td>
                    <td class="text-end">
                        <div class="d-inline-flex align-items-center gap-1">
                            {{-- View Live --}}
                            <a href="{{ route('blogs.show', $article->slug) }}" target="_blank" class="bh-btn bh-btn-ghost bh-btn-icon bh-btn-sm" title="View live">
                                <i class="fa-solid fa-arrow-up-right-from-square"></i>
                            </a>

                            {{-- Edit --}}
                            <a href="{{ route('blogs.edit', $article->id) }}" class="bh-btn bh-btn-ghost bh-btn-icon bh-btn-sm" title="Edit post">
                                <i class="fa-solid fa-pen"></i>
                            </a>

                            {{-- Publish / Approve --}}
                            @if($article->status !== 'approved')
                            <form action="{{ route('dashboard.articles.approve', $article->id) }}" method="POST" class="d-inline"
                                  onsubmit="return confirm('Publish this article live on the website?');">
                                @csrf
                                <button type="submit" class="bh-btn bh-btn-sm" style="background:#dcfce7; color:#15803d;" title="Publish post">
                                    <i class="fa-solid fa-check me-1"></i> Publish
                                </button>
                            </form>
                            @endif

                            {{-- Unpublish / Move to Draft --}}
                            @if($article->status === 'approved')
                            <form action="{{ route('dashboard.articles.unpublish', $article->id) }}" method="POST" class="d-inline"
                                  onsubmit="return confirm('Unpublish this article and move to draft? It will no longer be visible publicly.');">
                                @csrf
                                <button type="submit" class="bh-btn bh-btn-ghost bh-btn-sm text-secondary" title="Unpublish to Draft">
                                    <i class="fa-solid fa-eye-slash me-1"></i> Unpublish
                                </button>
                            </form>
                            @endif

                            {{-- Reject button --}}
                            @if($article->status === 'pending')
                            <button type="button" class="bh-btn bh-btn-icon bh-btn-sm" style="background:#fee2e2; color:#dc2626;" title="Reject Post"
                                    onclick="openRejectModal({{ $article->id }}, '{{ addslashes($article->title) }}')">
                                <i class="fa-solid fa-xmark"></i>
                            </button>
                            @endif

                            {{-- Delete --}}
                            <form action="{{ route('dashboard.all-articles.delete', $article->id) }}" method="POST" class="d-inline"
                                  onsubmit="return confirm('Permanently delete this article?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bh-btn bh-btn-ghost bh-btn-icon bh-btn-sm text-danger" title="Delete post">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center py-5 text-muted">
                        <i class="fa-solid fa-newspaper fa-2x mb-2 d-block text-secondary"></i>
                        No posts found matching the selected filters.
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

{{-- Reject Article Modal --}}
<div class="modal fade" id="rejectArticleModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <form id="rejectForm" method="POST" class="modal-content">
            @csrf
            <div class="modal-header">
                <h5 class="modal-title text-danger"><i class="fa-solid fa-triangle-exclamation me-2"></i>Reject Post Submission</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p class="mb-3">You are rejecting: <strong id="rejectArticleTitle"></strong></p>
                <div class="mb-3">
                    <label class="form-label fw-semibold">Reason for Rejection (Visible to Author):</label>
                    <textarea name="reason" rows="3" class="form-control" placeholder="Provide helpful editorial feedback for the author..." required></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-danger btn-sm"><i class="fa-solid fa-xmark me-1"></i>Reject Post</button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
function openRejectModal(id, title) {
    const form = document.getElementById('rejectForm');
    form.action = `/dashboard/articles/${id}/reject`;
    document.getElementById('rejectArticleTitle').innerText = title;
    new bootstrap.Modal(document.getElementById('rejectArticleModal')).show();
}
</script>
@endpush

@endsection
