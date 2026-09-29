@extends('backend.layouts.admin')

@section('title', 'My Articles — BlogHub')

@section('content')

{{-- Page Header --}}
<div class="bh-page-header">
    <div>
        <h1 class="bh-page-title">My Articles</h1>
        <p class="bh-page-sub">Manage, edit, and track your published articles.</p>
    </div>
    <a href="{{ route('blogs.create') }}" class="bh-btn bh-btn-primary">
        <i class="fa-solid fa-plus"></i> Write New
    </a>
</div>

{{-- Filters --}}
<div class="bh-card mb-4">
    <div class="bh-card-body" style="padding:0.85rem 1.25rem;">
        <form method="GET" action="{{ route('dashboard.articles') }}" class="row g-2 align-items-center">
            <div class="col-12 col-md-5">
                <div style="position:relative;">
                    <i class="fa-solid fa-search" style="position:absolute; left:11px; top:50%; transform:translateY(-50%); color:var(--text-light); font-size:0.78rem;"></i>
                    <input type="text" name="search" value="{{ request('search') }}"
                        style="width:100%; padding:7px 12px 7px 34px; border:1px solid var(--border); border-radius:7px; font-size:0.84rem; outline:none; background:var(--bg);"
                        placeholder="Search by title or content...">
                </div>
            </div>
            <div class="col-6 col-md-3">
                <select name="category" class="form-select form-select-sm" onchange="this.form.submit()">
                    <option value="">All Categories</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>
                            {{ $cat->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-3 col-md-2">
                <select name="status" class="form-select form-select-sm" onchange="this.form.submit()">
                    <option value="" {{ !request('status') ? 'selected' : '' }}>All Status</option>
                    <option value="featured" {{ request('status') == 'featured' ? 'selected' : '' }}>Featured</option>
                    <option value="trending" {{ request('status') == 'trending' ? 'selected' : '' }}>Trending</option>
                </select>
            </div>
            <div class="col-3 col-md-2">
                <a href="{{ route('dashboard.articles') }}" class="bh-btn bh-btn-ghost bh-btn-sm" style="width:100%; justify-content:center;">Reset</a>
            </div>
        </form>
    </div>
</div>

{{-- Articles Table --}}
<div class="bh-card">
    <div style="overflow-x:auto;">
        <table class="bh-table">
            <thead>
                <tr>
                    <th>Article</th>
                    <th>Category</th>
                    <th>Views / Likes</th>
                    <th>Status</th>
                    <th>Published</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($articles as $article)
                <tr>
                    <td style="max-width:300px;">
                        <div class="d-flex align-items-center gap-3">
                            <img src="{{ $article->featured_image ?? 'https://ui-avatars.com/api/?name=' . urlencode($article->title) . '&background=C8461F&color=fff' }}"
                                 class="rounded" style="width:48px; height:36px; object-fit:cover; flex-shrink:0;">
                            <div>
                                <div class="fw-semibold" style="white-space:nowrap; overflow:hidden; text-overflow:ellipsis; max-width:220px;">
                                    {{ $article->title }}
                                </div>
                                <div style="font-size:0.75rem; color:var(--text-light);">
                                    <i class="fa-solid fa-clock me-1"></i>{{ $article->reading_time ?? '—' }} min read
                                </div>
                            </div>
                        </div>
                    </td>
                    <td>
                        <span class="bh-badge" style="background:{{ ($article->category->color ?? '#C8461F') }}15; color:{{ $article->category->color ?? '#C8461F' }};">
                            {{ $article->category->name ?? '—' }}
                        </span>
                    </td>
                    <td>
                        <div style="font-size:0.82rem;">
                            <i class="fa-solid fa-eye me-1" style="color:#2563eb; opacity:.6;"></i>{{ number_format($article->views_count) }}
                        </div>
                        <div style="font-size:0.78rem; color:var(--text-light);">
                            <i class="fa-solid fa-heart me-1" style="color:#dc2626; opacity:.6;"></i>{{ number_format($article->likes_count) }}
                        </div>
                    </td>
                    <td>
                        @if($article->is_featured)
                            <span class="bh-badge" style="background:rgba(16,185,129,0.1); color:#10b981;">Featured</span>
                        @elseif($article->is_trending)
                            <span class="bh-badge" style="background:rgba(245,158,11,0.1); color:#f59e0b;">Trending</span>
                        @else
                            <span class="bh-badge" style="background:rgba(100,116,139,0.1); color:#64748b;">Published</span>
                        @endif
                    </td>
                    <td style="color:var(--text-muted); white-space:nowrap;">{{ $article->created_at->format('M d, Y') }}</td>
                    <td>
                        <div class="d-flex gap-1">
                            <a href="{{ route('blogs.show', $article->slug) }}" target="_blank"
                               class="bh-btn bh-btn-ghost bh-btn-icon bh-btn-sm" title="View">
                                <i class="fa-solid fa-eye"></i>
                            </a>
                            <a href="{{ route('blogs.edit', $article->id) }}"
                               class="bh-btn bh-btn-ghost bh-btn-icon bh-btn-sm" title="Edit" style="color:#2563eb;">
                                <i class="fa-solid fa-pen"></i>
                            </a>
                            <form action="{{ route('dashboard.articles.delete', $article->id) }}" method="POST" class="d-inline"
                                  onsubmit="return confirm('Delete this article permanently?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bh-btn bh-btn-ghost bh-btn-icon bh-btn-sm" title="Delete" style="color:#dc2626;">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" style="text-align:center; padding:3rem; color:var(--text-light);">
                        <i class="fa-solid fa-pen-nib" style="font-size:1.8rem; opacity:.2; display:block; margin-bottom:.6rem;"></i>
                        No articles yet. <a href="{{ route('blogs.create') }}" style="color:var(--brand);">Write your first article →</a>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($articles->hasPages())
    <div style="padding:0.75rem 1.25rem; border-top:1px solid var(--border); display:flex; justify-content:center;">
        {{ $articles->links() }}
    </div>
    @endif
</div>

@endsection
