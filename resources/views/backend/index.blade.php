@extends('backend.layouts.admin')

@section('title', auth()->user()->isAdmin() ? 'Admin Dashboard — BlogHub' : 'Creator Studio Dashboard — BlogHub')

@section('content')

@if(auth()->user()->isAdmin())
{{-- ============================================================
     1. ADMIN DASHBOARD OVERVIEW
     ============================================================ --}}

{{-- Page Header --}}
<div class="bh-page-header">
    <div>
        <h1 class="bh-page-title"><i class="fa-solid fa-gauge-high text-primary me-2"></i>Platform Admin Dashboard</h1>
        <p class="bh-page-sub">Welcome back, {{ auth()->user()->name }}. Here is the complete overview of the BlogHub platform.</p>
    </div>
    <div class="d-flex align-items-center gap-2">
        <a href="{{ route('dashboard.all-articles') }}" class="bh-btn bh-btn-ghost bh-btn-sm">
            <i class="fa-solid fa-newspaper me-1"></i> Manage Posts
        </a>
        <a href="{{ route('dashboard.users') }}" class="bh-btn bh-btn-primary bh-btn-sm">
            <i class="fa-solid fa-users me-1"></i> Manage Users
        </a>
    </div>
</div>

{{-- Pending Approvals Alert Banner --}}
@if(isset($pendingArticlesCount) && $pendingArticlesCount > 0)
<div class="card border-0 mb-4 shadow-sm" style="background:linear-gradient(135deg, #fffbeb, #fef3c7); border-left:4px solid #f59e0b !important; border-radius:10px;">
    <div class="card-body py-3 px-4 d-flex align-items-center justify-content-between flex-wrap gap-3">
        <div class="d-flex align-items-center gap-3">
            <div style="width:42px; height:42px; border-radius:10px; background:#fde68a; display:flex; align-items:center; justify-content:center; color:#b45309; font-size:1.2rem; flex-shrink:0;">
                <i class="fa-solid fa-clock-rotate-left"></i>
            </div>
            <div>
                <div class="fw-bold" style="color:#92400e; font-size:0.95rem;">
                    {{ $pendingArticlesCount }} Article{{ $pendingArticlesCount > 1 ? 's' : '' }} Awaiting Editorial Approval
                </div>
                <div class="small" style="color:#b45309;">
                    Author submissions require administrator review before publishing live on the website.
                </div>
            </div>
        </div>
        <a href="{{ route('dashboard.all-articles', ['status' => 'pending']) }}" class="btn btn-sm btn-warning fw-semibold px-3 py-2 shadow-sm" style="color:#78350f; border-radius:8px;">
            <i class="fa-solid fa-list-check me-1"></i> Review Submissions ({{ $pendingArticlesCount }})
        </a>
    </div>
</div>
@endif

{{-- 9 Comprehensive Admin Summary Cards --}}
<div class="row g-3 mb-4">
    {{-- 1. Total Users --}}
    <div class="col-6 col-md-4 col-xl">
        <a href="{{ route('dashboard.users') }}" class="bh-stat">
            <div class="bh-stat-icon" style="background:rgba(59,130,246,0.1); color:#3b82f6;">
                <i class="fa-solid fa-users"></i>
            </div>
            <div>
                <div class="bh-stat-num">{{ number_format($totalUsers) }}</div>
                <div class="bh-stat-label">Total Users</div>
            </div>
        </a>
    </div>

    {{-- 2. Total Authors --}}
    <div class="col-6 col-md-4 col-xl">
        <a href="{{ route('dashboard.authors') }}" class="bh-stat">
            <div class="bh-stat-icon" style="background:rgba(168,85,247,0.1); color:#a855f7;">
                <i class="fa-solid fa-feather"></i>
            </div>
            <div>
                <div class="bh-stat-num">{{ number_format($totalAuthors) }}</div>
                <div class="bh-stat-label">Total Authors</div>
            </div>
        </a>
    </div>

    {{-- 3. Total Posts --}}
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

    {{-- 4. Published Posts --}}
    <div class="col-6 col-md-4 col-xl">
        <a href="{{ route('dashboard.all-articles', ['status' => 'approved']) }}" class="bh-stat">
            <div class="bh-stat-icon" style="background:rgba(16,185,129,0.1); color:#10b981;">
                <i class="fa-solid fa-circle-check"></i>
            </div>
            <div>
                <div class="bh-stat-num">{{ number_format($publishedArticles) }}</div>
                <div class="bh-stat-label">Published Posts</div>
            </div>
        </a>
    </div>

    {{-- 5. Draft Posts --}}
    <div class="col-6 col-md-4 col-xl">
        <a href="{{ route('dashboard.all-articles', ['status' => 'draft']) }}" class="bh-stat">
            <div class="bh-stat-icon" style="background:rgba(107,114,128,0.1); color:#6b7280;">
                <i class="fa-solid fa-file-pen"></i>
            </div>
            <div>
                <div class="bh-stat-num">{{ number_format($draftArticles) }}</div>
                <div class="bh-stat-label">Draft Posts</div>
            </div>
        </a>
    </div>
</div>

<div class="row g-3 mb-4">
    {{-- 6. Pending Posts --}}
    <div class="col-6 col-md-3">
        <a href="{{ route('dashboard.all-articles', ['status' => 'pending']) }}" class="bh-stat" style="{{ $pendingArticlesCount > 0 ? 'border:1.5px solid #f59e0b;' : '' }}">
            <div class="bh-stat-icon" style="background:rgba(245,158,11,0.1); color:#f59e0b;">
                <i class="fa-solid fa-clock-rotate-left"></i>
            </div>
            <div>
                <div class="bh-stat-num" style="{{ $pendingArticlesCount > 0 ? 'color:#b45309;' : '' }}">{{ number_format($pendingArticlesCount) }}</div>
                <div class="bh-stat-label">Pending Review</div>
            </div>
        </a>
    </div>

    {{-- 7. Total Comments --}}
    <div class="col-6 col-md-3">
        <a href="{{ route('dashboard.comments') }}" class="bh-stat">
            <div class="bh-stat-icon" style="background:rgba(14,165,233,0.1); color:#0ea5e9;">
                <i class="fa-solid fa-comments"></i>
            </div>
            <div>
                <div class="bh-stat-num">{{ number_format($totalComments) }}</div>
                <div class="bh-stat-label">Total Comments</div>
            </div>
        </a>
    </div>

    {{-- 8. Pending Comments --}}
    <div class="col-6 col-md-3">
        <a href="{{ route('dashboard.comments', ['status' => 'pending']) }}" class="bh-stat" style="{{ $pendingCommentsCount > 0 ? 'border:1.5px solid #f59e0b;' : '' }}">
            <div class="bh-stat-icon" style="background:rgba(249,115,22,0.1); color:#f97316;">
                <i class="fa-solid fa-comment-dots"></i>
            </div>
            <div>
                <div class="bh-stat-num" style="{{ $pendingCommentsCount > 0 ? 'color:#c2410c;' : '' }}">{{ number_format($pendingCommentsCount) }}</div>
                <div class="bh-stat-label">Pending Comments</div>
            </div>
        </a>
    </div>

    {{-- 9. Total Categories --}}
    <div class="col-6 col-md-3">
        <a href="{{ route('dashboard.categories') }}" class="bh-stat">
            <div class="bh-stat-icon" style="background:rgba(99,102,241,0.1); color:#6366f1;">
                <i class="fa-solid fa-tags"></i>
            </div>
            <div>
                <div class="bh-stat-num">{{ number_format($totalCategories) }}</div>
                <div class="bh-stat-label">Categories</div>
            </div>
        </a>
    </div>
</div>

{{-- Main Content Grid: Recent Posts & Recent Activity --}}
<div class="row g-4">
    {{-- Recent Posts Table --}}
    <div class="col-12 col-xl-8">
        <div class="bh-card">
            <div class="bh-card-header">
                <div>
                    <h2 class="bh-card-title"><i class="fa-solid fa-newspaper me-2" style="color:var(--brand);"></i> Recent Posts</h2>
                    <span class="text-muted small">Latest content submissions across the platform</span>
                </div>
                <a href="{{ route('dashboard.all-articles') }}" class="bh-btn bh-btn-ghost bh-btn-sm">
                    View All ({{ $totalArticles }})
                </a>
            </div>

            <div class="table-responsive">
                <table class="bh-table">
                    <thead>
                        <tr>
                            <th>Post Title</th>
                            <th>Author</th>
                            <th>Category</th>
                            <th>Status</th>
                            <th>Date</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentArticles as $article)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <img src="{{ $article->featured_image }}" alt="{{ $article->title }}"
                                         style="width:36px; height:36px; border-radius:6px; object-fit:cover; flex-shrink:0;">
                                    <div>
                                        <a href="{{ route('blogs.show', $article->slug) }}" target="_blank"
                                           class="fw-semibold text-decoration-none text-dark d-block text-truncate" style="max-width:220px;" title="{{ $article->title }}">
                                            {{ $article->title }}
                                        </a>
                                        <span class="text-muted small"><i class="fa-regular fa-eye me-1"></i>{{ number_format($article->views_count) }} views</span>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <span class="small fw-medium">{{ $article->author?->name ?? 'Author' }}</span>
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
                                        <i class="fa-solid fa-clock me-1"></i> Pending
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
                            <td class="text-end">
                                <div class="d-inline-flex align-items-center gap-1">
                                    {{-- View --}}
                                    <a href="{{ route('blogs.show', $article->slug) }}" target="_blank" class="bh-btn bh-btn-ghost bh-btn-icon bh-btn-sm" title="View live">
                                        <i class="fa-solid fa-arrow-up-right-from-square"></i>
                                    </a>

                                    {{-- Edit --}}
                                    <a href="{{ route('blogs.edit', $article->id) }}" class="bh-btn bh-btn-ghost bh-btn-icon bh-btn-sm" title="Edit post">
                                        <i class="fa-solid fa-pen"></i>
                                    </a>

                                    {{-- Approve if pending/rejected/draft --}}
                                    @if($article->status !== 'approved')
                                    <form action="{{ route('dashboard.articles.approve', $article->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Approve and publish this article?');">
                                        @csrf
                                        <button type="submit" class="bh-btn bh-btn-icon bh-btn-sm" style="background:#dcfce7; color:#15803d;" title="Approve & Publish">
                                            <i class="fa-solid fa-check"></i>
                                        </button>
                                    </form>
                                    @endif

                                    {{-- Reject button (modal trigger) --}}
                                    @if($article->status === 'pending')
                                    <button type="button" class="bh-btn bh-btn-icon bh-btn-sm" style="background:#fee2e2; color:#dc2626;" title="Reject Post"
                                            onclick="openRejectModal({{ $article->id }}, '{{ addslashes($article->title) }}')">
                                        <i class="fa-solid fa-xmark"></i>
                                    </button>
                                    @endif

                                    {{-- Delete --}}
                                    <form action="{{ route('dashboard.all-articles.delete', $article->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to permanently delete this article?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="bh-btn bh-btn-ghost bh-btn-icon bh-btn-sm text-danger" title="Delete">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-4 text-muted">
                                <i class="fa-solid fa-inbox fa-2x mb-2 d-block text-secondary"></i>
                                No posts created yet.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Recent Platform Activity Feed --}}
    <div class="col-12 col-xl-4">
        <div class="bh-card" style="height:100%;">
            <div class="bh-card-header">
                <div>
                    <h2 class="bh-card-title"><i class="fa-solid fa-bolt me-2" style="color:#eab308;"></i> Recent Activity</h2>
                    <span class="text-muted small">Live timeline of platform actions</span>
                </div>
            </div>
            <div class="bh-card-body p-3">
                <div class="d-flex flex-column gap-3">
                    @forelse($recentActivities as $act)
                    <div class="d-flex align-items-start gap-3 p-2 rounded" style="background:#fafafa;">
                        <div style="width:34px; height:34px; border-radius:8px; background:{{ $act['color'] }}1a; color:{{ $act['color'] }}; display:flex; align-items:center; justify-content:center; flex-shrink:0;">
                            <i class="fa-solid {{ $act['icon'] }}"></i>
                        </div>
                        <div class="flex-grow-1" style="min-width:0;">
                            <div class="d-flex align-items-center justify-content-between">
                                <div class="fw-semibold small text-dark">{{ $act['title'] }}</div>
                                <span class="text-muted" style="font-size:0.7rem;">{{ $act['time']->diffForHumans() }}</span>
                            </div>
                            <div class="text-muted small text-truncate" style="font-size:0.78rem;">
                                {{ $act['description'] }}
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-4 text-muted">
                        No recent activity recorded.
                    </div>
                    @endforelse
                </div>

                <div class="mt-4 pt-3 border-top">
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <span class="small fw-semibold text-muted text-uppercase" style="letter-spacing:0.05em;">Quick Management</span>
                    </div>
                    <div class="d-grid gap-2">
                        <a href="{{ route('dashboard.authors') }}" class="bh-btn bh-btn-ghost bh-btn-sm justify-content-start">
                            <i class="fa-solid fa-feather text-primary me-2"></i> Manage Authors &amp; Staff
                        </a>
                        <a href="{{ route('dashboard.categories') }}" class="bh-btn bh-btn-ghost bh-btn-sm justify-content-start">
                            <i class="fa-solid fa-tags text-success me-2"></i> Manage Categories
                        </a>
                        <a href="{{ route('dashboard.settings') }}" class="bh-btn bh-btn-ghost bh-btn-sm justify-content-start">
                            <i class="fa-solid fa-gear text-secondary me-2"></i> Platform Settings
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
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

@else
{{-- ============================================================
     2. AUTHOR DASHBOARD OVERVIEW (Creator Studio)
     ============================================================ --}}

{{-- Author Page Header --}}
<div class="bh-page-header">
    <div>
        <h1 class="bh-page-title"><i class="fa-solid fa-feather-alt text-primary me-2"></i>Creator Studio Dashboard</h1>
        <p class="bh-page-sub">Welcome back, {{ auth()->user()->name }}. Track your stories, views, and readers' engagement.</p>
    </div>
    <div class="d-flex align-items-center gap-2">
        <a href="{{ route('blogs.create') }}" class="bh-btn bh-btn-primary">
            <i class="fa-solid fa-pen-nib me-1"></i> Write New Story
        </a>
    </div>
</div>

{{-- 7 Comprehensive Author Summary Cards --}}
<div class="row g-3 mb-4">
    {{-- 1. My Total Posts --}}
    <div class="col-6 col-md-4 col-xl">
        <a href="{{ route('dashboard.articles') }}" class="bh-stat">
            <div class="bh-stat-icon" style="background:rgba(200,70,31,0.1); color:#C8461F;">
                <i class="fa-solid fa-newspaper"></i>
            </div>
            <div>
                <div class="bh-stat-num">{{ number_format($myTotalArticles) }}</div>
                <div class="bh-stat-label">My Total Posts</div>
            </div>
        </a>
    </div>

    {{-- 2. Published Posts --}}
    <div class="col-6 col-md-4 col-xl">
        <a href="{{ route('dashboard.articles', ['status' => 'approved']) }}" class="bh-stat">
            <div class="bh-stat-icon" style="background:rgba(16,185,129,0.1); color:#10b981;">
                <i class="fa-solid fa-circle-check"></i>
            </div>
            <div>
                <div class="bh-stat-num">{{ number_format($myPublished) }}</div>
                <div class="bh-stat-label">Published Posts</div>
            </div>
        </a>
    </div>

    {{-- 3. Draft Posts --}}
    <div class="col-6 col-md-4 col-xl">
        <a href="{{ route('dashboard.articles', ['status' => 'draft']) }}" class="bh-stat">
            <div class="bh-stat-icon" style="background:rgba(107,114,128,0.1); color:#6b7280;">
                <i class="fa-solid fa-file-pen"></i>
            </div>
            <div>
                <div class="bh-stat-num">{{ number_format($myDraft) }}</div>
                <div class="bh-stat-label">Draft Posts</div>
            </div>
        </a>
    </div>

    {{-- 4. Pending Posts --}}
    <div class="col-6 col-md-4 col-xl">
        <a href="{{ route('dashboard.articles', ['status' => 'pending']) }}" class="bh-stat" style="{{ $myPending > 0 ? 'border:1.5px solid #f59e0b;' : '' }}">
            <div class="bh-stat-icon" style="background:rgba(245,158,11,0.1); color:#f59e0b;">
                <i class="fa-solid fa-clock-rotate-left"></i>
            </div>
            <div>
                <div class="bh-stat-num" style="{{ $myPending > 0 ? 'color:#b45309;' : '' }}">{{ number_format($myPending) }}</div>
                <div class="bh-stat-label">Pending Review</div>
            </div>
        </a>
    </div>

    {{-- 5. Rejected Posts --}}
    <div class="col-6 col-md-4 col-xl">
        <a href="{{ route('dashboard.articles', ['status' => 'rejected']) }}" class="bh-stat" style="{{ $myRejected > 0 ? 'border:1.5px solid #ef4444;' : '' }}">
            <div class="bh-stat-icon" style="background:rgba(239,68,68,0.1); color:#ef4444;">
                <i class="fa-solid fa-circle-exclamation"></i>
            </div>
            <div>
                <div class="bh-stat-num" style="{{ $myRejected > 0 ? 'color:#dc2626;' : '' }}">{{ number_format($myRejected) }}</div>
                <div class="bh-stat-label">Needs Revision</div>
            </div>
        </a>
    </div>
</div>

<div class="row g-3 mb-4">
    {{-- 6. Total Views --}}
    <div class="col-6 col-md-6">
        <div class="bh-stat">
            <div class="bh-stat-icon" style="background:rgba(37,99,235,0.1); color:#2563EB;">
                <i class="fa-solid fa-eye"></i>
            </div>
            <div>
                <div class="bh-stat-num">{{ number_format($myTotalViews) }}</div>
                <div class="bh-stat-label">Total Views on My Posts</div>
            </div>
        </div>
    </div>

    {{-- 7. Total Comments --}}
    <div class="col-6 col-md-6">
        <a href="{{ route('dashboard.comments') }}" class="bh-stat">
            <div class="bh-stat-icon" style="background:rgba(16,185,129,0.1); color:#10b981;">
                <i class="fa-solid fa-comments"></i>
            </div>
            <div>
                <div class="bh-stat-num">{{ number_format($myTotalComments) }}</div>
                <div class="bh-stat-label">Comments on My Articles</div>
            </div>
        </a>
    </div>
</div>

{{-- Author Main Section: My Recent Stories & Interaction --}}
<div class="row g-4">
    {{-- Recent Stories Table --}}
    <div class="col-12 col-xl-8">
        <div class="bh-card">
            <div class="bh-card-header">
                <div>
                    <h2 class="bh-card-title"><i class="fa-solid fa-book-open me-2" style="color:var(--brand);"></i> My Recent Stories</h2>
                    <span class="text-muted small">Manage your articles and monitor review status</span>
                </div>
                <a href="{{ route('dashboard.articles') }}" class="bh-btn bh-btn-ghost bh-btn-sm">
                    View All ({{ $myTotalArticles }})
                </a>
            </div>

            <div class="table-responsive">
                <table class="bh-table">
                    <thead>
                        <tr>
                            <th>Story Title</th>
                            <th>Category</th>
                            <th>Status</th>
                            <th>Views</th>
                            <th>Date</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($myRecentArticles as $article)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <img src="{{ $article->featured_image }}" alt="{{ $article->title }}"
                                         style="width:36px; height:36px; border-radius:6px; object-fit:cover; flex-shrink:0;">
                                    <div>
                                        <a href="{{ route('blogs.edit', $article->id) }}" class="fw-semibold text-decoration-none text-dark d-block text-truncate" style="max-width:230px;" title="{{ $article->title }}">
                                            {{ $article->title }}
                                        </a>
                                        @if($article->status === 'rejected' && $article->rejection_reason)
                                        <span class="text-danger small d-block text-truncate" style="max-width:230px;">
                                            <i class="fa-solid fa-circle-exclamation me-1"></i>{{ $article->rejection_reason }}
                                        </span>
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
                            <td class="text-muted small">
                                <i class="fa-regular fa-eye me-1"></i>{{ number_format($article->views_count) }}
                            </td>
                            <td class="text-muted small">
                                {{ $article->created_at->format('M d, Y') }}
                            </td>
                            <td class="text-end">
                                <div class="d-inline-flex align-items-center gap-1">
                                    @if($article->status === 'approved')
                                    <a href="{{ route('blogs.show', $article->slug) }}" target="_blank" class="bh-btn bh-btn-ghost bh-btn-icon bh-btn-sm" title="View live story">
                                        <i class="fa-solid fa-arrow-up-right-from-square"></i>
                                    </a>
                                    @endif

                                    <a href="{{ route('blogs.edit', $article->id) }}" class="bh-btn bh-btn-ghost bh-btn-icon bh-btn-sm" title="Edit story">
                                        <i class="fa-solid fa-pen"></i>
                                    </a>

                                    @if(in_array($article->status, ['draft', 'rejected']))
                                    <form action="{{ route('dashboard.articles.submit-review', $article->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Submit this story for administrator approval?');">
                                        @csrf
                                        <button type="submit" class="bh-btn bh-btn-sm" style="background:#dbeafe; color:#1d4ed8;" title="Submit for Review">
                                            <i class="fa-solid fa-paper-plane me-1"></i> Submit
                                        </button>
                                    </form>
                                    @endif

                                    <form action="{{ route('dashboard.articles.delete', $article->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this story?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="bh-btn bh-btn-ghost bh-btn-icon bh-btn-sm text-danger" title="Delete">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-5 text-muted">
                                <i class="fa-solid fa-pen-nib fa-2x mb-2 d-block text-secondary"></i>
                                You haven't written any stories yet.
                                <div class="mt-2">
                                    <a href="{{ route('blogs.create') }}" class="bh-btn bh-btn-primary bh-btn-sm">
                                        <i class="fa-solid fa-plus me-1"></i> Write Your First Article
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Author Reader Comments & Studio Links --}}
    <div class="col-12 col-xl-4">
        <div class="bh-card mb-4">
            <div class="bh-card-header">
                <div>
                    <h2 class="bh-card-title"><i class="fa-solid fa-comments me-2" style="color:var(--brand);"></i> Reader Feedback</h2>
                    <span class="text-muted small">Latest comments on your published stories</span>
                </div>
            </div>
            <div class="bh-card-body p-3">
                <div class="d-flex flex-column gap-3">
                    @forelse($myRecentComments as $c)
                    <div class="p-2 rounded" style="background:#fafafa; border:1px solid var(--border);">
                        <div class="d-flex align-items-center justify-content-between mb-1">
                            <span class="fw-semibold small text-dark">{{ $c->user_name }}</span>
                            <span class="text-muted" style="font-size:0.7rem;">{{ $c->created_at->diffForHumans() }}</span>
                        </div>
                        <div class="text-muted small mb-2" style="font-size:0.8rem;">
                            "{{ Str::limit($c->content, 90) }}"
                        </div>
                        <div class="d-flex align-items-center justify-content-between">
                            <span class="text-truncate small text-secondary" style="max-width:160px; font-size:0.72rem;">
                                On: {{ $c->article?->title ?? 'Story' }}
                            </span>
                            @if(!$c->is_approved)
                            <form action="{{ route('dashboard.comments.approve', $c->id) }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-outline-success py-0 px-2" style="font-size:0.72rem;">
                                    <i class="fa-solid fa-check"></i> Approve
                                </button>
                            </form>
                            @else
                            <span class="badge bg-success-subtle text-success" style="font-size:0.65rem;">Approved</span>
                            @endif
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-4 text-muted small">
                        No comments on your stories yet.
                    </div>
                    @endforelse
                </div>
            </div>
        </div>

        {{-- Author Shortcuts --}}
        <div class="bh-card">
            <div class="bh-card-header">
                <h2 class="bh-card-title"><i class="fa-solid fa-compass me-2" style="color:var(--brand);"></i> Author Quick Tools</h2>
            </div>
            <div class="bh-card-body p-3">
                <div class="d-grid gap-2">
                    <a href="{{ route('dashboard.charts') }}" class="bh-btn bh-btn-ghost bh-btn-sm justify-content-start">
                        <i class="fa-solid fa-chart-line text-primary me-2"></i> View My Story Analytics
                    </a>
                    <a href="{{ route('dashboard.account') }}" class="bh-btn bh-btn-ghost bh-btn-sm justify-content-start">
                        <i class="fa-solid fa-circle-user text-success me-2"></i> Edit Author Profile &amp; Bio
                    </a>
                    <a href="{{ route('home') }}" target="_blank" class="bh-btn bh-btn-ghost bh-btn-sm justify-content-start">
                        <i class="fa-solid fa-globe text-secondary me-2"></i> Visit Live BlogHub
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

@endif

@endsection
