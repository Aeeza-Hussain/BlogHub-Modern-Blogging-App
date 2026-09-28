@extends('layouts.admin')

@section('title', 'Comments Management — BlogHub Admin')

@section('content')
<div class="container-xl">

    {{-- Page Header --}}
    <div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-2">
        <div>
            <h1 class="h3 fw-bold mb-1" style="color:#0f172a;">
                <i class="fa-solid fa-comments me-2" style="color:#C8461F;"></i> Comments Management
            </h1>
            <p class="text-muted small mb-0">Review and moderate all reader comments across the platform.</p>
        </div>
        <div class="badge py-2 px-3" style="background:rgba(200,70,31,0.1); color:#C8461F; font-size:0.88rem;">
            <i class="fa-solid fa-comment-dots me-1"></i> {{ $totalComments }} Total Comments
        </div>
    </div>

    {{-- Search --}}
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body py-3">
            <form method="GET" action="{{ route('dashboard.comments') }}" class="row g-2 align-items-center">
                <div class="col-12 col-md-8">
                    <div class="input-group">
                        <span class="input-group-text bg-white border-end-0">
                            <i class="fa-solid fa-search text-muted"></i>
                        </span>
                        <input type="text" name="search" value="{{ request('search') }}"
                            class="form-control border-start-0 ps-0"
                            placeholder="Search by commenter name or content...">
                    </div>
                </div>
                <div class="col-12 col-md-4 d-flex gap-2">
                    <button type="submit" class="btn btn-primary w-100">Search</button>
                    <a href="{{ route('dashboard.comments') }}" class="btn btn-outline-secondary w-100">Reset</a>
                </div>
            </form>
        </div>
    </div>

    {{-- Comments Table --}}
    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead style="background:#f8fafc; border-bottom:2px solid #e2e8f0;">
                        <tr>
                            <th class="py-3 ps-4" style="font-size:0.78rem;text-transform:uppercase;letter-spacing:.05em;color:#64748b;">Commenter</th>
                            <th class="py-3" style="font-size:0.78rem;text-transform:uppercase;letter-spacing:.05em;color:#64748b;">Comment</th>
                            <th class="py-3" style="font-size:0.78rem;text-transform:uppercase;letter-spacing:.05em;color:#64748b;">Article</th>
                            <th class="py-3" style="font-size:0.78rem;text-transform:uppercase;letter-spacing:.05em;color:#64748b;">Date</th>
                            <th class="py-3 pe-4" style="font-size:0.78rem;text-transform:uppercase;letter-spacing:.05em;color:#64748b;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($comments as $comment)
                        <tr>
                            <td class="ps-4">
                                <div class="d-flex align-items-center gap-2">
                                    <img src="{{ $comment->user_avatar ?? 'https://ui-avatars.com/api/?name=' . urlencode($comment->user_name) . '&background=64748b&color=fff&bold=true' }}"
                                        alt="{{ $comment->user_name }}"
                                        class="rounded-circle"
                                        style="width:36px; height:36px; object-fit:cover;">
                                    <div class="fw-semibold" style="font-size:0.85rem; color:#0f172a;">
                                        {{ $comment->user_name }}
                                    </div>
                                </div>
                            </td>
                            <td style="max-width:320px;">
                                <div class="text-muted" style="font-size:0.85rem; line-height:1.5;">
                                    {{ Str::limit($comment->content, 120) }}
                                </div>
                            </td>
                            <td style="max-width:200px;">
                                @if($comment->article)
                                    <a href="{{ route('blogs.show', $comment->article->slug) }}" target="_blank"
                                        class="text-decoration-none fw-semibold"
                                        style="font-size:0.82rem; color:#C8461F;">
                                        {{ Str::limit($comment->article->title, 50) }}
                                        <i class="fa-solid fa-arrow-up-right-from-square ms-1" style="font-size:0.65rem;"></i>
                                    </a>
                                @else
                                    <span class="text-muted small">Article deleted</span>
                                @endif
                            </td>
                            <td class="text-muted small">{{ $comment->created_at->format('M d, Y') }}</td>
                            <td class="pe-4">
                                <form method="POST" action="{{ route('dashboard.comments.delete', $comment->id) }}"
                                    onsubmit="return confirm('Delete this comment permanently?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete Comment" style="padding:3px 8px;">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-5 text-muted">
                                <i class="fa-solid fa-comments fa-2x mb-2 d-block opacity-25"></i>
                                No comments found.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        @if($comments->hasPages())
        <div class="card-footer bg-white border-top d-flex justify-content-between align-items-center py-3 px-4">
            <div class="text-muted small">
                Showing {{ $comments->firstItem() }}–{{ $comments->lastItem() }} of {{ $comments->total() }} comments
            </div>
            {{ $comments->links() }}
        </div>
        @endif
    </div>

</div>
@endsection
