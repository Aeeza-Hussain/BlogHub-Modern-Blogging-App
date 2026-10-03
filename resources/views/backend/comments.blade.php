@extends('backend.layouts.admin')

@section('title', auth()->user()->isAdmin() ? 'Comments Moderation — BlogHub Admin' : 'Story Comments — Creator Studio')

@section('content')

{{-- Page Header --}}
<div class="bh-page-header">
    <div>
        <h1 class="bh-page-title">
            <i class="fa-solid fa-comments text-primary me-2"></i>
            {{ auth()->user()->isAdmin() ? 'Platform Comments Moderation' : 'My Story Comments' }}
        </h1>
        <p class="bh-page-sub">
            @if(auth()->user()->isAdmin())
                Review, approve, hide, and manage reader feedback across all articles on BlogHub.
            @else
                Review and moderate readers' comments left on your published articles.
            @endif
        </p>
    </div>
</div>

{{-- Stats Row --}}
<div class="row g-3 mb-4">
    <div class="col-6 col-md-4">
        <a href="{{ route('dashboard.comments') }}" class="bh-stat">
            <div class="bh-stat-icon" style="background:rgba(59,130,246,0.1); color:#3b82f6;">
                <i class="fa-solid fa-comments"></i>
            </div>
            <div>
                <div class="bh-stat-num">{{ number_format($totalComments) }}</div>
                <div class="bh-stat-label">Total Comments</div>
            </div>
        </a>
    </div>
    <div class="col-6 col-md-4">
        <a href="{{ route('dashboard.comments', ['status' => 'pending']) }}" class="bh-stat" style="{{ $pendingComments > 0 ? 'border:1.5px solid #f59e0b;' : '' }}">
            <div class="bh-stat-icon" style="background:rgba(245,158,11,0.1); color:#f59e0b;">
                <i class="fa-solid fa-clock-rotate-left"></i>
            </div>
            <div>
                <div class="bh-stat-num" style="{{ $pendingComments > 0 ? 'color:#b45309;' : '' }}">{{ number_format($pendingComments) }}</div>
                <div class="bh-stat-label">Pending Approval</div>
            </div>
        </a>
    </div>
    <div class="col-12 col-md-4">
        <a href="{{ route('dashboard.comments', ['status' => 'approved']) }}" class="bh-stat">
            <div class="bh-stat-icon" style="background:rgba(16,185,129,0.1); color:#10b981;">
                <i class="fa-solid fa-circle-check"></i>
            </div>
            <div>
                <div class="bh-stat-num">{{ number_format($approvedComments) }}</div>
                <div class="bh-stat-label">Approved &amp; Live</div>
            </div>
        </a>
    </div>
</div>

{{-- Search & Filters --}}
<div class="bh-card mb-4">
    <div class="bh-card-body p-3">
        <form method="GET" action="{{ route('dashboard.comments') }}" class="row g-2 align-items-center">
            <div class="col-12 col-md-6">
                <div class="input-group">
                    <span class="input-group-text bg-white border-end-0">
                        <i class="fa-solid fa-search text-muted"></i>
                    </span>
                    <input type="text" name="search" value="{{ request('search') }}"
                           class="form-control border-start-0 ps-0"
                           placeholder="Search by commenter, message text, or story title...">
                </div>
            </div>
            <div class="col-6 col-md-4">
                <select name="status" class="form-select">
                    <option value="">All Comments</option>
                    <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending Approval ({{ $pendingComments }})</option>
                    <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Approved ({{ $approvedComments }})</option>
                </select>
            </div>
            <div class="col-6 col-md-2 d-flex gap-2">
                <button type="submit" class="bh-btn bh-btn-primary w-100 justify-content-center">
                    <i class="fa-solid fa-filter me-1"></i> Filter
                </button>
                <a href="{{ route('dashboard.comments') }}" class="bh-btn bh-btn-ghost" title="Reset">
                    <i class="fa-solid fa-arrow-rotate-left"></i>
                </a>
            </div>
        </form>
    </div>
</div>

{{-- Comments Table --}}
<div class="bh-card">
    <div class="bh-card-header">
        <h2 class="bh-card-title"><i class="fa-solid fa-list me-2" style="color:var(--brand);"></i> Comments List</h2>
        <span class="text-muted small">Showing {{ $comments->firstItem() ?? 0 }} - {{ $comments->lastItem() ?? 0 }} of {{ $comments->total() }} comments</span>
    </div>

    <div class="table-responsive">
        <table class="bh-table">
            <thead>
                <tr>
                    <th>Commenter</th>
                    <th>Comment</th>
                    <th>Related Post</th>
                    <th>Date</th>
                    <th>Status</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($comments as $comment)
                <tr style="{{ !$comment->is_approved ? 'background:rgba(245,158,11,0.04);' : '' }}">
                    <td>
                        <div class="d-flex align-items-center gap-2">
                            <img src="{{ $comment->user_avatar ?? 'https://ui-avatars.com/api/?name=' . urlencode($comment->user_name) . '&background=64748b&color=fff&bold=true' }}"
                                 alt="{{ $comment->user_name }}"
                                 style="width:34px; height:34px; border-radius:50%; object-fit:cover; flex-shrink:0;">
                            <div>
                                <span class="fw-semibold text-dark">{{ $comment->user_name }}</span>
                                @if($comment->user)
                                <div class="text-muted small">{{ $comment->user->email }}</div>
                                @endif
                            </div>
                        </div>
                    </td>
                    <td style="max-width:280px;">
                        <div class="text-dark small line-clamp-2" style="line-height:1.5;">
                            {{ $comment->content }}
                        </div>
                    </td>
                    <td style="max-width:220px;">
                        @if($comment->article)
                        <a href="{{ route('blogs.show', $comment->article->slug) }}" target="_blank"
                           class="text-decoration-none fw-semibold text-truncate d-block small" style="color:var(--brand);">
                            {{ $comment->article->title }}
                            <i class="fa-solid fa-arrow-up-right-from-square ms-1" style="font-size:0.65rem;"></i>
                        </a>
                        @else
                        <span class="text-muted small">Article no longer available</span>
                        @endif
                    </td>
                    <td class="text-muted small" style="white-space:nowrap;">
                        {{ $comment->created_at->format('M d, Y') }}
                    </td>
                    <td>
                        @if($comment->is_approved)
                            <span class="bh-badge" style="background:#dcfce7; color:#15803d;">
                                <i class="fa-solid fa-circle-check me-1"></i> Live
                            </span>
                        @else
                            <span class="bh-badge" style="background:#fef3c7; color:#b45309;">
                                <i class="fa-solid fa-clock me-1"></i> Pending
                            </span>
                        @endif
                    </td>
                    <td class="text-end">
                        <div class="d-inline-flex align-items-center gap-1">
                            @if(!$comment->is_approved)
                            {{-- Approve --}}
                            <form method="POST" action="{{ route('dashboard.comments.approve', $comment->id) }}" class="d-inline">
                                @csrf
                                <button type="submit" class="bh-btn bh-btn-sm" style="background:#dcfce7; color:#15803d;" title="Approve comment">
                                    <i class="fa-solid fa-check me-1"></i> Approve
                                </button>
                            </form>
                            @else
                            {{-- Hide / Unapprove --}}
                            <form method="POST" action="{{ route('dashboard.comments.hide', $comment->id) }}" class="d-inline"
                                  onsubmit="return confirm('Hide this comment from the website?');">
                                @csrf
                                <button type="submit" class="bh-btn bh-btn-ghost bh-btn-sm text-warning" title="Hide comment">
                                    <i class="fa-solid fa-eye-slash me-1"></i> Hide
                                </button>
                            </form>
                            @endif

                            {{-- Delete --}}
                            <form method="POST" action="{{ route('dashboard.comments.delete', $comment->id) }}" class="d-inline"
                                  onsubmit="return confirm('Permanently delete this comment?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bh-btn bh-btn-ghost bh-btn-icon bh-btn-sm text-danger" title="Delete comment">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center py-5 text-muted">
                        <i class="fa-solid fa-comments fa-2x mb-2 d-block text-secondary"></i>
                        No comments found.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($comments->hasPages())
    <div class="bh-card-body border-top p-3 d-flex justify-content-end">
        {{ $comments->links() }}
    </div>
    @endif
</div>

@endsection
