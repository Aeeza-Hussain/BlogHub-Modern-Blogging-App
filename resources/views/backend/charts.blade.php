@extends('backend.layouts.admin')

@section('title', auth()->user()->isAdmin() ? 'Analytics & Reports — BlogHub Admin' : 'Story Analytics — Creator Studio')

@section('content')

{{-- Page Header --}}
<div class="bh-page-header">
    <div>
        <h1 class="bh-page-title">
            <i class="fa-solid fa-chart-line text-primary me-2"></i>
            {{ auth()->user()->isAdmin() ? 'Platform Analytics & Reports' : 'My Content Performance & Analytics' }}
        </h1>
        <p class="bh-page-sub">
            @if(auth()->user()->isAdmin())
                High-level metrics on content growth, readership trends, category reach, and top-performing authors.
            @else
                Detailed performance insights on your stories, monthly views, reader comments, and engagement.
            @endif
        </p>
    </div>
    <div>
        <a href="{{ auth()->user()->isAdmin() ? route('dashboard.all-articles') : route('dashboard.articles') }}" class="bh-btn bh-btn-ghost">
            <i class="fa-solid fa-newspaper me-1"></i> {{ auth()->user()->isAdmin() ? 'All Articles' : 'My Posts' }}
        </a>
    </div>
</div>

@if(auth()->user()->isAdmin())
{{-- ============================================================
     1. ADMIN PLATFORM ANALYTICS
     ============================================================ --}}

{{-- Platform Overview Stats --}}
<div class="row g-3 mb-4">
    <div class="col-6 col-md-3">
        <div class="bh-stat">
            <div class="bh-stat-icon" style="background:rgba(200,70,31,0.1); color:#C8461F;">
                <i class="fa-solid fa-newspaper"></i>
            </div>
            <div>
                <div class="bh-stat-num">{{ number_format($totalPosts) }}</div>
                <div class="bh-stat-label">Total Posts</div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="bh-stat">
            <div class="bh-stat-icon" style="background:rgba(37,99,235,0.1); color:#2563EB;">
                <i class="fa-solid fa-eye"></i>
            </div>
            <div>
                <div class="bh-stat-num">{{ number_format($totalViews) }}</div>
                <div class="bh-stat-label">Platform Views</div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="bh-stat">
            <div class="bh-stat-icon" style="background:rgba(239,68,68,0.1); color:#ef4444;">
                <i class="fa-solid fa-heart"></i>
            </div>
            <div>
                <div class="bh-stat-num">{{ number_format($totalLikes) }}</div>
                <div class="bh-stat-label">Reader Likes</div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="bh-stat">
            <div class="bh-stat-icon" style="background:rgba(16,185,129,0.1); color:#10b981;">
                <i class="fa-solid fa-comments"></i>
            </div>
            <div>
                <div class="bh-stat-num">{{ number_format($totalComments) }}</div>
                <div class="bh-stat-label">Total Comments</div>
            </div>
        </div>
    </div>
</div>

{{-- Charts Grid --}}
<div class="row g-4 mb-4">
    {{-- Posts Created Over Time --}}
    <div class="col-12 col-lg-8">
        <div class="bh-card" style="height:100%;">
            <div class="bh-card-header">
                <div class="bh-card-title"><i class="fa-solid fa-chart-line me-2" style="color:var(--brand);"></i> Posts Created Over Time (Past 6 Months)</div>
            </div>
            <div class="bh-card-body">
                <canvas id="chart-monthly-posts" style="max-height:280px;"></canvas>
            </div>
        </div>
    </div>

    {{-- Category Distribution Doughnut --}}
    <div class="col-12 col-lg-4">
        <div class="bh-card" style="height:100%;">
            <div class="bh-card-header">
                <div class="bh-card-title"><i class="fa-solid fa-chart-pie me-2" style="color:#6366f1;"></i> Category-Wise Distribution</div>
            </div>
            <div class="bh-card-body d-flex flex-column align-items-center justify-content-center">
                <canvas id="chart-categories" style="max-height:260px; max-width:260px;"></canvas>
            </div>
        </div>
    </div>
</div>

{{-- Two Columns: Most Popular Posts & Most Active Authors --}}
<div class="row g-4">
    {{-- Most Popular Posts --}}
    <div class="col-12 col-lg-6">
        <div class="bh-card">
            <div class="bh-card-header">
                <div class="bh-card-title"><i class="fa-solid fa-fire me-2 text-danger"></i> Most Popular Posts</div>
                <a href="{{ route('dashboard.all-articles', ['sort' => 'popular']) }}" class="bh-btn bh-btn-ghost bh-btn-sm">View All</a>
            </div>
            <div class="table-responsive">
                <table class="bh-table">
                    <thead>
                        <tr>
                            <th>Post</th>
                            <th>Author</th>
                            <th class="text-center">Views</th>
                            <th class="text-center">Likes</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($topArticles as $art)
                        <tr>
                            <td>
                                <a href="{{ route('blogs.show', $art->slug) }}" target="_blank" class="fw-semibold text-dark text-decoration-none d-block text-truncate" style="max-width:200px;">
                                    {{ $art->title }}
                                </a>
                                <span class="badge bg-light text-dark border" style="font-size:0.68rem;">{{ $art->category?->name ?? 'General' }}</span>
                            </td>
                            <td class="small text-muted">{{ $art->author?->name ?? 'Author' }}</td>
                            <td class="text-center small fw-bold text-primary">{{ number_format($art->views_count) }}</td>
                            <td class="text-center small fw-bold text-danger">{{ number_format($art->likes_count) }}</td>
                        </tr>
                        @empty
                        <tr><td colspan="4" class="text-center py-4 text-muted">No posts available.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Most Active Authors --}}
    <div class="col-12 col-lg-6">
        <div class="bh-card">
            <div class="bh-card-header">
                <div class="bh-card-title"><i class="fa-solid fa-trophy me-2 text-warning"></i> Most Active Authors</div>
                <a href="{{ route('dashboard.authors') }}" class="bh-btn bh-btn-ghost bh-btn-sm">View All</a>
            </div>
            <div class="table-responsive">
                <table class="bh-table">
                    <thead>
                        <tr>
                            <th>Author</th>
                            <th class="text-center">Total Posts</th>
                            <th class="text-center">Published</th>
                            <th class="text-center">Total Views</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($topAuthors as $topAuth)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <img src="{{ $topAuth->avatar ?? 'https://ui-avatars.com/api/?name=' . urlencode($topAuth->name) . '&background=C8461F&color=fff' }}"
                                         alt="{{ $topAuth->name }}" style="width:30px; height:30px; border-radius:50%; object-fit:cover;">
                                    <div>
                                        <div class="fw-semibold text-dark small">{{ $topAuth->name }}</div>
                                        <div class="text-muted" style="font-size:0.7rem;">{{ $topAuth->specialty }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="text-center small fw-bold">{{ $topAuth->total_articles ?? 0 }}</td>
                            <td class="text-center small">
                                <span class="bh-badge" style="background:#dcfce7; color:#15803d;">{{ $topAuth->approved_articles ?? 0 }}</span>
                            </td>
                            <td class="text-center small fw-bold text-primary">
                                {{ number_format($topAuth->articles_sum_views_count ?? 0) }}
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="4" class="text-center py-4 text-muted">No author activity yet.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@else
{{-- ============================================================
     2. AUTHOR OWN CONTENT ANALYTICS
     ============================================================ --}}

{{-- Author Overview Stats --}}
<div class="row g-3 mb-4">
    <div class="col-6 col-md-3">
        <div class="bh-stat">
            <div class="bh-stat-icon" style="background:rgba(37,99,235,0.1); color:#2563EB;">
                <i class="fa-solid fa-eye"></i>
            </div>
            <div>
                <div class="bh-stat-num">{{ number_format($totalViews) }}</div>
                <div class="bh-stat-label">Total Story Views</div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="bh-stat">
            <div class="bh-stat-icon" style="background:rgba(239,68,68,0.1); color:#ef4444;">
                <i class="fa-solid fa-heart"></i>
            </div>
            <div>
                <div class="bh-stat-num">{{ number_format($totalLikes) }}</div>
                <div class="bh-stat-label">Reader Applauds / Likes</div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="bh-stat">
            <div class="bh-stat-icon" style="background:rgba(16,185,129,0.1); color:#10b981;">
                <i class="fa-solid fa-comments"></i>
            </div>
            <div>
                <div class="bh-stat-num">{{ number_format($totalComments) }}</div>
                <div class="bh-stat-label">Comments Received</div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="bh-stat">
            <div class="bh-stat-icon" style="background:rgba(200,70,31,0.1); color:#C8461F;">
                <i class="fa-solid fa-newspaper"></i>
            </div>
            <div>
                <div class="bh-stat-num">{{ number_format($publishedPosts) }} / {{ number_format($totalPosts) }}</div>
                <div class="bh-stat-label">Published / Total Posts</div>
            </div>
        </div>
    </div>
</div>

{{-- Charts Grid --}}
<div class="row g-4 mb-4">
    {{-- Views Trend --}}
    <div class="col-12 col-lg-8">
        <div class="bh-card" style="height:100%;">
            <div class="bh-card-header">
                <div class="bh-card-title"><i class="fa-solid fa-chart-area me-2" style="color:#2563eb;"></i> Views Over Time (Past 6 Months)</div>
            </div>
            <div class="bh-card-body">
                <canvas id="chart-author-views" style="max-height:280px;"></canvas>
            </div>
        </div>
    </div>

    {{-- Category Breakdown --}}
    <div class="col-12 col-lg-4">
        <div class="bh-card" style="height:100%;">
            <div class="bh-card-header">
                <div class="bh-card-title"><i class="fa-solid fa-chart-pie me-2" style="color:#10b981;"></i> Stories by Topic</div>
            </div>
            <div class="bh-card-body d-flex flex-column align-items-center justify-content-center">
                <canvas id="chart-author-categories" style="max-height:260px; max-width:260px;"></canvas>
            </div>
        </div>
    </div>
</div>

{{-- Top Performing Stories Table --}}
<div class="bh-card">
    <div class="bh-card-header">
        <div class="bh-card-title"><i class="fa-solid fa-fire me-2 text-danger"></i> My Top-Performing Stories</div>
        <a href="{{ route('dashboard.articles', ['sort' => 'popular']) }}" class="bh-btn bh-btn-ghost bh-btn-sm">View All</a>
    </div>
    <div class="table-responsive">
        <table class="bh-table">
            <thead>
                <tr>
                    <th>Story</th>
                    <th>Category</th>
                    <th>Published On</th>
                    <th class="text-center">Views</th>
                    <th class="text-center">Likes</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($topArticles as $top)
                <tr>
                    <td>
                        <a href="{{ route('blogs.show', $top->slug) }}" target="_blank" class="fw-semibold text-dark text-decoration-none d-block text-truncate" style="max-width:260px;">
                            {{ $top->title }}
                        </a>
                    </td>
                    <td>
                        <span class="badge bg-light text-dark border">{{ $top->category?->name ?? 'General' }}</span>
                    </td>
                    <td class="text-muted small">
                        {{ $top->published_at ? $top->published_at->format('M d, Y') : 'Draft / In Review' }}
                    </td>
                    <td class="text-center small fw-bold text-primary">
                        <i class="fa-regular fa-eye me-1"></i>{{ number_format($top->views_count) }}
                    </td>
                    <td class="text-center small fw-bold text-danger">
                        <i class="fa-regular fa-heart me-1"></i>{{ number_format($top->likes_count) }}
                    </td>
                    <td class="text-end">
                        <a href="{{ route('blogs.edit', $top->id) }}" class="bh-btn bh-btn-ghost bh-btn-icon bh-btn-sm" title="Edit story">
                            <i class="fa-solid fa-pen"></i>
                        </a>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" class="text-center py-4 text-muted">No published stories yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endif

@endsection

@section('scripts')
<script>
document.addEventListener("DOMContentLoaded", function() {
    var palette = ['#C8461F', '#2563eb', '#10b981', '#f59e0b', '#8b5cf6', '#ec4899', '#06b6d4', '#64748b'];

    @if(auth()->user()->isAdmin())
    // 1. Admin Monthly Posts Line Chart
    var monthlyData = {!! json_encode($monthlyPosts) !!};
    var monthLabels = Object.keys(monthlyData);
    var monthValues = Object.values(monthlyData);

    var ctxPosts = document.getElementById('chart-monthly-posts');
    if (ctxPosts) {
        new Chart(ctxPosts.getContext('2d'), {
            type: 'line',
            data: {
                labels: monthLabels,
                datasets: [{
                    label: 'Posts Published',
                    borderColor: '#C8461F',
                    backgroundColor: 'rgba(200,70,31,0.08)',
                    data: monthValues,
                    fill: true,
                    tension: 0.35,
                    borderWidth: 2.5,
                    pointRadius: 4,
                    pointBackgroundColor: '#C8461F'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: {
                    y: { beginAtZero: true, grid: { color: '#f1f5f9' }, ticks: { precision: 0 } },
                    x: { grid: { display: false } }
                }
            }
        });
    }

    // 2. Admin Category Doughnut Chart
    var catLabels = {!! json_encode($categoryNames) !!};
    var catCounts = {!! json_encode($categoryCounts) !!};
    var ctxCats = document.getElementById('chart-categories');
    if (ctxCats) {
        new Chart(ctxCats.getContext('2d'), {
            type: 'doughnut',
            data: {
                labels: catLabels,
                datasets: [{
                    data: catCounts,
                    backgroundColor: palette.slice(0, catLabels.length)
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { position: 'bottom', labels: { boxWidth: 12, font: { size: 11 } } } }
            }
        });
    }

    @else
    // Author Views Over Time
    var authorViewsData = {!! json_encode($monthlyViews) !!};
    var aViewLabels = Object.keys(authorViewsData);
    var aViewValues = Object.values(authorViewsData);

    var ctxAViews = document.getElementById('chart-author-views');
    if (ctxAViews) {
        new Chart(ctxAViews.getContext('2d'), {
            type: 'line',
            data: {
                labels: aViewLabels,
                datasets: [{
                    label: 'Story Views',
                    borderColor: '#2563EB',
                    backgroundColor: 'rgba(37,99,235,0.08)',
                    data: aViewValues,
                    fill: true,
                    tension: 0.35,
                    borderWidth: 2.5,
                    pointRadius: 4,
                    pointBackgroundColor: '#2563EB'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: {
                    y: { beginAtZero: true, grid: { color: '#f1f5f9' } },
                    x: { grid: { display: false } }
                }
            }
        });
    }

    // Author Categories
    var aCatLabels = {!! json_encode($categoryNames) !!};
    var aCatCounts = {!! json_encode($categoryCounts) !!};
    var ctxACats = document.getElementById('chart-author-categories');
    if (ctxACats) {
        new Chart(ctxACats.getContext('2d'), {
            type: 'doughnut',
            data: {
                labels: aCatLabels,
                datasets: [{
                    data: aCatCounts,
                    backgroundColor: palette.slice(0, aCatLabels.length)
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { position: 'bottom', labels: { boxWidth: 12, font: { size: 11 } } } }
            }
        });
    }
    @endif
});
</script>
@endsection
