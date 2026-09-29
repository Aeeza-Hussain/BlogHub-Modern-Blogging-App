@extends('backend.layouts.admin')

@section('title', 'Notifications — BlogHub')

@section('content')

{{-- Page Header --}}
<div class="bh-page-header">
    <div>
        <h1 class="bh-page-title">Notifications &amp; Inquiries</h1>
        <p class="bh-page-sub">Contact form submissions and recent user comments.</p>
    </div>
</div>

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
                </div>
            </div>
        </div>
        @empty
        <div style="padding:2.5rem; text-align:center; color:var(--text-light);">
            <i class="fa-solid fa-comments" style="font-size:1.5rem; opacity:.3; display:block; margin-bottom:.5rem;"></i>
            No recent comments.
        </div>
        @endforelse
    </div>
</div>

@endsection
