@extends('backend.layouts.admin')

@section('title', 'BlogHub - Admin Overview')

@section('content')
<h1 class="app-page-title">Dashboard Overview</h1>
    
<div class="app-card alert alert-dismissible shadow-sm mb-4 border-left-decoration" role="alert">
    <div class="inner">
        <div class="app-card-body p-3 p-lg-4">
            <h3 class="mb-3">Welcome to BlogHub Portal!</h3>
            <div class="row gx-5 gy-3">
                <div class="col-12 col-lg-9">
                    <div>Manage your blog posts, track reader analytics, moderate comments, and customize your publication directly from this central dashboard.</div>
                </div>
                <div class="col-12 col-lg-3 text-lg-end">
                    <a class="btn app-btn-primary" href="{{ route('blogs.create') }}">
                        <i class="fa-solid fa-plus me-1"></i> Create New Post
                    </a>
                </div>
            </div>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    </div>
</div>
    
<!-- KPI Stat Cards -->
<div class="row g-4 mb-4">
    <div class="col-6 col-lg-3">
        <div class="app-card app-card-stat shadow-sm h-100">
            <div class="app-card-body p-3 p-lg-4">
                <h4 class="stats-type mb-1">Total Articles</h4>
                <div class="stats-figure">{{ number_format($totalArticles) }}</div>
                <div class="stats-meta text-success">
                    <i class="fa-solid fa-file-lines me-1"></i> Published
                </div>
            </div>
            <a class="app-card-link-mask" href="{{ route('dashboard.articles') }}"></a>
        </div>
    </div>
    
    <div class="col-6 col-lg-3">
        <div class="app-card app-card-stat shadow-sm h-100">
            <div class="app-card-body p-3 p-lg-4">
                <h4 class="stats-type mb-1">Total Views</h4>
                <div class="stats-figure">{{ number_format($totalViews) }}</div>
                <div class="stats-meta text-success">
                    <i class="fa-solid fa-eye me-1"></i> +12% this month
                </div>
            </div>
            <a class="app-card-link-mask" href="{{ route('dashboard.charts') }}"></a>
        </div>
    </div>

    <div class="col-6 col-lg-3">
        <div class="app-card app-card-stat shadow-sm h-100">
            <div class="app-card-body p-3 p-lg-4">
                <h4 class="stats-type mb-1">Total Likes</h4>
                <div class="stats-figure">{{ number_format($totalLikes) }}</div>
                <div class="stats-meta text-primary">
                    <i class="fa-solid fa-heart me-1"></i> Reader Appreciation
                </div>
            </div>
            <a class="app-card-link-mask" href="{{ route('dashboard.charts') }}"></a>
        </div>
    </div>

    <div class="col-6 col-lg-3">
        <div class="app-card app-card-stat shadow-sm h-100">
            <div class="app-card-body p-3 p-lg-4">
                <h4 class="stats-type mb-1">Total Comments</h4>
                <div class="stats-figure">{{ number_format($totalComments) }}</div>
                <div class="stats-meta text-info">
                    <i class="fa-solid fa-comments me-1"></i> Active Discussions
                </div>
            </div>
            <a class="app-card-link-mask" href="{{ route('dashboard.notifications') }}"></a>
        </div>
    </div>
</div>

<!-- Analytics Charts Section -->
<div class="row g-4 mb-4">
    <div class="col-12 col-lg-6">
        <div class="app-card app-card-chart h-100 shadow-sm">
            <div class="app-card-header p-3">
                <div class="row justify-content-between align-items-center">
                    <div class="col-auto">
                        <h4 class="app-card-title"><i class="fa-solid fa-chart-line text-primary me-2"></i> Monthly Readership Trends</h4>
                    </div>
                    <div class="col-auto">
                        <div class="card-header-action">
                            <a href="{{ route('dashboard.charts') }}">View detailed analytics</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="app-card-body p-3 p-lg-4">
                <div class="chart-container">
                    <canvas id="canvas-linechart" style="max-height: 250px;"></canvas>
                </div>
            </div>
        </div>
    </div>

    <div class="col-12 col-lg-6">
        <div class="app-card app-card-chart h-100 shadow-sm">
            <div class="app-card-header p-3">
                <div class="row justify-content-between align-items-center">
                    <div class="col-auto">
                        <h4 class="app-card-title"><i class="fa-solid fa-folder-open text-primary me-2"></i> Articles by Category</h4>
                    </div>
                    <div class="col-auto">
                        <div class="card-header-action">
                            <a href="{{ route('dashboard.charts') }}">View Breakdown</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="app-card-body p-3 p-lg-4">
                <div class="chart-container">
                    <canvas id="canvas-barchart" style="max-height: 250px;"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Recent Articles Table -->
<div class="app-card app-card-orders-table shadow-sm mb-5">
    <div class="app-card-header p-3">
        <div class="row justify-content-between align-items-center">
            <div class="col-auto">
                <h4 class="app-card-title">Recent Articles</h4>
            </div>
            <div class="col-auto">
                <a class="btn app-btn-secondary btn-sm" href="{{ route('dashboard.articles') }}">View All Articles</a>
            </div>
        </div>
    </div>
    <div class="app-card-body">
        <div class="table-responsive">
            <table class="table app-table-hover mb-0 text-left">
                <thead>
                    <tr>
                        <th class="cell">ID</th>
                        <th class="cell">Title</th>
                        <th class="cell">Category</th>
                        <th class="cell">Author</th>
                        <th class="cell">Views</th>
                        <th class="cell">Published Date</th>
                        <th class="cell">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentArticles as $article)
                    <tr>
                        <td class="cell">#{{ $article->id }}</td>
                        <td class="cell">
                            <span class="truncate fw-semibold">{{ Str::limit($article->title, 40) }}</span>
                        </td>
                        <td class="cell">
                            <span class="badge" style="background-color: {{ $article->category->color ?? '#6c757d' }};">
                                {{ $article->category->name }}
                            </span>
                        </td>
                        <td class="cell">{{ $article->author->name }}</td>
                        <td class="cell"><i class="fa-solid fa-eye text-muted me-1"></i> {{ number_format($article->views_count) }}</td>
                        <td class="cell"><span>{{ $article->created_at->format('M d, Y') }}</span></td>
                        <td class="cell">
                            <a class="btn-sm app-btn-secondary" href="{{ route('blogs.show', $article->slug) }}" target="_blank"><i class="fa-solid fa-external-link"></i></a>
                            <form action="{{ route('dashboard.articles.delete', $article->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this article?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-sm btn-outline-danger border-0"><i class="fa-solid fa-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-4 text-muted">No articles found.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Line Chart (Readership)
        var lineCtx = document.getElementById('canvas-linechart').getContext('2d');
        new Chart(lineCtx, {
            type: 'line',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul'],
                datasets: [{
                    label: 'Page Views',
                    borderColor: '#15a362',
                    backgroundColor: 'rgba(21, 163, 98, 0.1)',
                    data: [1200, 1900, 3000, 5000, 4200, 6800, 8500],
                    fill: true,
                    tension: 0.3
                }]
            },
            options: { responsive: true, maintainAspectRatio: false }
        });

        // Bar Chart (Category distribution)
        var barCtx = document.getElementById('canvas-barchart').getContext('2d');
        new Chart(barCtx, {
            type: 'bar',
            data: {
                labels: {!! json_encode($categories->pluck('name')) !!},
                datasets: [{
                    label: 'Posts',
                    backgroundColor: '#5b99ea',
                    data: {!! json_encode($categories->pluck('articles_count')) !!}
                }]
            },
            options: { responsive: true, maintainAspectRatio: false }
        });
    });
</script>
@endsection
