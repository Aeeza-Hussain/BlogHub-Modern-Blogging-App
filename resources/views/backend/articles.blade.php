@extends('backend.layouts.admin')

@section('title', 'BlogHub - Articles Management')

@section('content')
<div class="row g-3 mb-4 align-items-center justify-content-between">
    <div class="col-auto">
        <h1 class="app-page-title mb-0">Articles Management</h1>
    </div>
    <div class="col-auto">
        <div class="page-utilities">
            <div class="row g-2 justify-content-start justify-content-md-end align-items-center">
                <div class="col-auto">
                    <form action="{{ route('dashboard.articles') }}" method="GET" class="table-search-form row gx-1 align-items-center">
                        <div class="col-auto">
                            <input type="text" id="search-articles" name="search" class="form-control search-orders" placeholder="Search title or content..." value="{{ request('search') }}">
                        </div>
                        <div class="col-auto">
                            <button type="submit" class="btn app-btn-secondary">Search</button>
                        </div>
                    </form>
                </div>
                <div class="col-auto">
                    <form action="{{ route('dashboard.articles') }}" method="GET" id="category-filter-form">
                        <select name="category" class="form-select w-auto" onchange="this.form.submit()">
                            <option value="">All Categories</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>
                                    {{ $cat->name }}
                                </option>
                            @endforeach
                        </select>
                    </form>
                </div>
                <div class="col-auto">
                    <a class="btn app-btn-primary" href="{{ route('blogs.create') }}">
                        <i class="fa-solid fa-plus me-1"></i> New Article
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<nav id="orders-table-tab" class="orders-table-tab app-nav-tabs nav shadow-sm flex-column flex-sm-row mb-4">
    <a class="flex-sm-fill text-sm-center nav-link {{ !request('status') ? 'active' : '' }}" href="{{ route('dashboard.articles') }}">All Articles</a>
    <a class="flex-sm-fill text-sm-center nav-link {{ request('status') == 'featured' ? 'active' : '' }}" href="{{ route('dashboard.articles', ['status' => 'featured']) }}">Featured</a>
    <a class="flex-sm-fill text-sm-center nav-link {{ request('status') == 'trending' ? 'active' : '' }}" href="{{ route('dashboard.articles', ['status' => 'trending']) }}">Trending</a>
</nav>

<div class="tab-content" id="orders-table-tab-content">
    <div class="tab-pane fade show active" role="tabpanel">
        <div class="app-card app-card-orders-table shadow-sm mb-4">
            <div class="app-card-body">
                <div class="table-responsive">
                    <table class="table app-table-hover mb-0 text-left">
                        <thead>
                            <tr>
                                <th class="cell">ID</th>
                                <th class="cell">Article</th>
                                <th class="cell">Category</th>
                                <th class="cell">Author</th>
                                <th class="cell">Reads &amp; Likes</th>
                                <th class="cell">Status</th>
                                <th class="cell">Published</th>
                                <th class="cell">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($articles as $article)
                            <tr>
                                <td class="cell">#{{ $article->id }}</td>
                                <td class="cell">
                                    <div class="d-flex align-items-center">
                                        <img src="{{ $article->featured_image }}" class="rounded me-2" style="width: 45px; height: 45px; object-fit: cover;" alt="thumb">
                                        <div>
                                            <div class="fw-semibold text-dark">{{ Str::limit($article->title, 45) }}</div>
                                            <small class="text-muted"><i class="fa-solid fa-clock me-1"></i> {{ $article->reading_time }} min read</small>
                                        </div>
                                    </div>
                                </td>
                                <td class="cell">
                                    <span class="badge" style="background-color: {{ $article->category->color ?? '#20c997' }};">
                                        {{ $article->category->name }}
                                    </span>
                                </td>
                                <td class="cell">{{ $article->author->name }}</td>
                                <td class="cell">
                                    <div><i class="fa-solid fa-eye text-primary me-1"></i> {{ number_format($article->views_count) }}</div>
                                    <small class="text-muted"><i class="fa-solid fa-heart text-danger me-1"></i> {{ number_format($article->likes_count) }}</small>
                                </td>
                                <td class="cell">
                                    @if($article->is_featured)
                                        <span class="badge bg-success">Featured</span>
                                    @elseif($article->is_trending)
                                        <span class="badge bg-warning text-dark">Trending</span>
                                    @else
                                        <span class="badge bg-secondary">Standard</span>
                                    @endif
                                </td>
                                <td class="cell"><span>{{ $article->created_at->format('M d, Y') }}</span></td>
                                <td class="cell">
                                    <a class="btn-sm app-btn-secondary" href="{{ route('blogs.show', $article->slug) }}" target="_blank" title="View"><i class="fa-solid fa-eye"></i></a>
                                    <form action="{{ route('dashboard.articles.delete', $article->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this article?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-sm btn-outline-danger border-0" title="Delete"><i class="fa-solid fa-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="8" class="text-center py-4 text-muted">No articles found matching your criteria.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        
        <div class="d-flex justify-content-center">
            {{ $articles->links() }}
        </div>
    </div>
</div>
@endsection
