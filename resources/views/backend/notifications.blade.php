@extends('backend.layouts.admin')

@section('title', 'Notifications — BlogHub')

@section('content')

{{-- Page Header --}}
<div class="bh-page-header">
    <div>
        <h1 class="bh-page-title">Notifications &amp; Inquiries</h1>
        <p class="bh-page-sub">Review author submissions, contact inquiries, and comments.</p>
    </div>
</div>

@if((auth()->user()->user_type ?? 1) == 1)
{{-- Pending Articles for Approval --}}
<div class="bh-card mb-4" style="{{ count($pendingArticles) > 0 ? 'border-color:#f59e0b;' : '' }}">
    <div class="bh-card-header" style="{{ count($pendingArticles) > 0 ? 'background:#fffbeb;' : '' }}">
        <div class="bh-card-title"><i class="fa-solid fa-clock-rotate-left me-2" style="color:#f59e0b;"></i> Pending Articles for Admin Approval</div>
        <span class="bh-badge" style="background:rgba(245,158,11,0.15); color:#d97706; padding:3px 8px; font-weight:700;">{{ count($pendingArticles) }}</span>
    </div>
    <div class="bh-card-body" style="padding:0;">
        @forelse($pendingArticles as $pArticle)
        <div style="padding:1rem 1.25rem; border-bottom:1px solid var(--border);">
            <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
                <div class="d-flex align-items-center gap-3">
                    <img src="{{ $pArticle->featured_image ?? 'https://ui-avatars.com/api/?name=' . urlencode($pArticle->title) . '&background=C8461F&color=fff' }}"
                         class="rounded" style="width:48px; height:36px; object-fit:cover; flex-shrink:0;">
                    <div>
                        <div class="fw-bold" style="font-size:0.9rem; color:var(--text-primary);">
                            {{ $pArticle->title }}
                        </div>
                        <div style="font-size:0.75rem; color:var(--text-muted); margin-top:2px;">
                            By <strong>{{ $pArticle->author->name ?? 'Author' }}</strong> &middot; Category: <span class="badge" style="background:rgba(200,70,31,0.1); color:#C8461F; font-size:0.7rem;">{{ $pArticle->category->name ?? 'General' }}</span> &middot; {{ $pArticle->created_at->diffForHumans() }}
                        </div>
                    </div>
                </div>
                <div class="d-flex align-items-center gap-2">
                    <a href="{{ route('blogs.show', $pArticle->slug) }}" target="_blank" class="bh-btn bh-btn-ghost bh-btn-sm">
                        <i class="fa-solid fa-eye me-1"></i> Preview
                    </a>
                    <form method="POST" action="{{ route('dashboard.articles.approve', $pArticle->id) }}" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-sm btn-success fw-semibold" style="font-size:0.78rem;">
                            <i class="fa-solid fa-check me-1"></i> Approve
                        </button>
                    </form>
                    <form method="POST" action="{{ route('dashboard.articles.reject', $pArticle->id) }}" class="d-inline" onsubmit="return confirm('Reject this article?')">
                        @csrf
                        <button type="submit" class="btn btn-sm btn-outline-danger" style="font-size:0.78rem;">
                            <i class="fa-solid fa-xmark me-1"></i> Reject
                        </button>
                    </form>
                </div>
            </div>
        </div>
        @empty
        <div style="padding:2rem; text-align:center; color:var(--text-light);">
            <i class="fa-solid fa-circle-check" style="font-size:1.5rem; color:#10b981; opacity:.5; display:block; margin-bottom:.5rem;"></i>
            All caught up! No pending article submissions awaiting review.
        </div>
        @endforelse
    </div>
</div>
@endif

{{-- Contact Submissions --}}
<div class="bh-card mb-4">
    <div class="bh-card-header">
        <div class="bh-card-title"><i class="fa-solid fa-envelope me-2" style="color:#2563eb;"></i> Contact Submissions</div>
        <span class="bh-badge" style="background:rgba(37,99,235,0.1); color:#2563eb; padding:3px 8px;">{{ count($messages) }}</span>
    </div>
    <div class="bh-card-body" style="padding:0;">
        @forelse($messages as $msg)
        <div style="padding:1rem 1.25rem; border-bottom:1px solid var(--border);">
            <div class="d-flex align-items-start gap-3">
                <div style="width:36px; height:36px; border-radius:8px; background:rgba(37,99,235,0.1); display:flex; align-items:center; justify-content:center; flex-shrink:0;">
                    <i class="fa-solid fa-envelope" style="color:#2563eb; font-size:0.82rem;"></i>
                </div>
                <div style="flex:1; min-width:0;">
                    <div class="d-flex align-items-center justify-content-between gap-2 mb-1">
                        <div style="font-weight:600; font-size:0.88rem; color:var(--text-primary);">{{ $msg->subject }}</div>
                        <span style="font-size:0.72rem; color:var(--text-light); white-space:nowrap;">{{ $msg->created_at->diffForHumans() }}</span>
                    </div>
                    <div style="font-size:0.78rem; color:var(--text-muted); margin-bottom:6px;">
                        <strong>{{ $msg->name }}</strong> &middot; {{ $msg->email }}
                    </div>
                    <div style="font-size:0.84rem; color:var(--text-primary); line-height:1.5;">{{ Str::limit($msg->message, 200) }}</div>
                </div>
            </div>
        </div>
        @empty
        <div style="padding:2.5rem; text-align:center; color:var(--text-light);">
            <i class="fa-solid fa-inbox" style="font-size:1.5rem; opacity:.3; display:block; margin-bottom:.5rem;"></i>
            No contact submissions yet.
        </div>
        @endforelse
    </div>
</div>

{{-- Recent Comments --}}
<div class="bh-card">
    <div class="bh-card-header">
        <div class="bh-card-title"><i class="fa-solid fa-comments me-2" style="color:#10b981;"></i> Recent Comments</div>
        <span class="bh-badge" style="background:rgba(16,185,129,0.1); color:#10b981; padding:3px 8px;">{{ count($comments) }}</span>
    </div>
    <div class="bh-card-body" style="padding:0;">
        @forelse($comments as $comment)
        <div style="padding:1rem 1.25rem; border-bottom:1px solid var(--border);">
            <div class="d-flex align-items-start gap-3">
                <img src="{{ $comment->user_avatar ?? 'https://ui-avatars.com/api/?name=' . urlencode($comment->user_name) . '&background=64748b&color=fff&bold=true' }}"
                     class="rounded-circle" style="width:36px; height:36px; object-fit:cover; flex-shrink:0;">
                <div style="flex:1; min-width:0;">
                    <div class="d-flex align-items-center justify-content-between gap-2 mb-1">
                        <div>
                            <span style="font-weight:600; font-size:0.85rem; color:var(--text-primary);">{{ $comment->user_name }}</span>
                            <span style="font-size:0.75rem; color:var(--text-light); margin-left:6px;">commented on</span>
                            @if($comment->article)
                            <a href="{{ route('blogs.show', $comment->article->slug) }}" target="_blank"
                               style="font-size:0.78rem; color:var(--brand); font-weight:500; text-decoration:none;">
                                {{ Str::limit($comment->article->title, 40) }}
                            </a>
                            @endif
                        </div>
                        <span style="font-size:0.72rem; color:var(--text-light); white-space:nowrap;">{{ $comment->created_at->diffForHumans() }}</span>
                    </div>
                    <div style="font-size:0.84rem; color:var(--text-muted); line-height:1.5; margin-top:4px;">"{{ Str::limit($comment->content, 200) }}"</div>
                    @if(!$comment->is_approved)
                        <div class="mt-2 d-flex align-items-center gap-2">
                            <span class="badge rounded-pill" style="background:#fef3c7; color:#b45309; font-size:0.72rem; padding:4px 9px;">
                                <i class="fa-solid fa-clock me-1"></i> Pending Approval
                            </span>
                            <form method="POST" action="{{ route('dashboard.comments.approve', $comment->id) }}" class="d-inline">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-success py-0 px-2" style="font-size:0.75rem;">
                                    <i class="fa-solid fa-check me-1"></i> Approve
                                </button>
                            </form>
                            <form method="POST" action="{{ route('dashboard.comments.delete', $comment->id) }}" class="d-inline" onsubmit="return confirm('Delete this comment?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger py-0 px-2" style="font-size:0.75rem;">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        @empty
        <div style="padding:2.5rem; text-align:center; color:var(--text-light);">
            <i class="fa-solid fa-comments" style="font-size:1.5rem; opacity:.3; display:block; margin-bottom:.5rem;"></i>
            No comments yet.
        </div>
        @endforelse
    </div>
</div>

{{-- Newsletter Subscribers --}}
<div class="bh-card mt-4">
    <div class="bh-card-header">
        <div class="bh-card-title"><i class="fa-solid fa-paper-plane me-2" style="color:var(--bh-accent, #c8461f);"></i> Newsletter Subscribers</div>
        <span class="bh-badge" style="background:rgba(200,70,31,0.1); color:var(--bh-accent, #c8461f); padding:3px 8px;">{{ count($subscribers) }}</span>
    </div>
    <div class="bh-card-body" style="padding:0;">
        @forelse($subscribers as $sub)
        <div style="padding:0.85rem 1.25rem; border-bottom:1px solid var(--border);">
            <div class="d-flex align-items-center justify-content-between gap-3">
                <div class="d-flex align-items-center gap-2">
                    <i class="fa-regular fa-envelope" style="color:var(--bh-accent, #c8461f); font-size:0.85rem;"></i>
                    <span style="font-weight:600; font-size:0.88rem; color:var(--text-primary);">{{ $sub->email }}</span>
                </div>
                <span style="font-size:0.75rem; color:var(--text-light);">{{ $sub->created_at->diffForHumans() }}</span>
            </div>
        </div>
        @empty
        <div style="padding:2.5rem; text-align:center; color:var(--text-light);">
            <i class="fa-solid fa-paper-plane" style="font-size:1.5rem; opacity:.3; display:block; margin-bottom:.5rem;"></i>
            No subscribers yet.
        </div>
        @endforelse
    </div>
</div>

@endsection
