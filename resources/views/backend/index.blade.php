@extends('backend.layouts.admin')

@section('title', 'Dashboard — BlogHub')

@section('content')

{{-- Page Header --}}
<div class="bh-page-header">
    <div>
        <h1 class="bh-page-title">Dashboard</h1>
        <p class="bh-page-sub">Welcome back, {{ auth()->user()->name }}. Here's what's happening today.</p>
    </div>
    <a href="{{ route('blogs.create') }}" class="bh-btn bh-btn-primary">
        <i class="fa-solid fa-plus"></i> New Article
    </a>
</div>

{{-- Stat Cards --}}
<div class="row g-3 mb-4">
    <div class="col-6 col-lg-3">
        <a href="{{ route('dashboard.all-articles') }}" class="bh-stat">
            <div class="bh-stat-icon" style="background:rgba(200,70,31,0.1); color:#C8461F;">
                <i class="fa-solid fa-newspaper"></i>
            </div>
            <div>
                <div class="bh-stat-num">{{ number_format($totalArticles) }}</div>
                <div class="bh-stat-label">Articles</div>
            </div>
        </a>
    </div>
    <div class="col-6 col-lg-3">
        <a href="{{ route('dashboard.charts') }}" class="bh-stat">
            <div class="bh-stat-icon" style="background:rgba(37,99,235,0.1); color:#2563EB;">
                <i class="fa-solid fa-eye"></i>
            </div>
            <div>
                <div class="bh-stat-num">{{ number_format($totalViews) }}</div>
                <div class="bh-stat-label">Total Views</div>
            </div>
        </a>
    </div>
    <div class="col-6 col-lg-3">
        <a href="{{ route('dashboard.comments') }}" class="bh-stat">
            <div class="bh-stat-icon" style="background:rgba(16,185,129,0.1); color:#10b981;">
                <i class="fa-solid fa-comments"></i>
            </div>
            <div>
                <div class="bh-stat-num">{{ number_format($totalComments) }}</div>
                <div class="bh-stat-label">Comments</div>
            </div>
        </a>
    </div>
    <div class="col-6 col-lg-3">
        <a href="{{ route('dashboard.users') }}" class="bh-stat">
            <div class="bh-stat-icon" style="background:rgba(139,92,246,0.1); color:#8b5cf6;">
                <i class="fa-solid fa-users"></i>
            </div>
            <div>
                <div class="bh-stat-num">{{ number_format($totalUsers) }}</div>
                <div class="bh-stat-label">Users</div>
            </div>
        </a>
    </div>
</div>

{{-- Charts + Quick Stats --}}
<div class="row g-3 mb-4">
    {{-- Line Chart --}}
    <div class="col-12 col-lg-8">
        <div class="bh-card" style="height:100%;">
            <div class="bh-card-header">
                <div class="bh-card-title"><i class="fa-solid fa-chart-area me-2" style="color:var(--brand);"></i> Readership Trends</div>
                <a href="{{ route('dashboard.charts') }}" class="bh-btn bh-btn-ghost bh-btn-sm">View All</a>
            </div>
            <div class="bh-card-body">
                <canvas id="canvas-linechart" style="max-height:230px;"></canvas>
            </div>
        </div>
    </div>

    {{-- Quick Numbers --}}
    <div class="col-12 col-lg-4">
        <div class="bh-card" style="height:100%;">
            <div class="bh-card-header">
                <div class="bh-card-title"><i class="fa-solid fa-bolt me-2" style="color:#f59e0b;"></i> Quick Glance</div>
            </div>
            <div class="bh-card-body">
                <div class="d-flex flex-column gap-3">
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center gap-2">
                            <div style="width:8px; height:8px; border-radius:50%; background:#dc2626;"></div>
                            <span style="font-size:0.84rem;">Total Likes</span>
                        </div>
                        <span style="font-weight:700; font-size:0.92rem;">{{ number_format($totalLikes) }}</span>
                    </div>
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center gap-2">
                            <div style="width:8px; height:8px; border-radius:50%; background:#2563eb;"></div>
                            <span style="font-size:0.84rem;">Authors</span>
                        </div>
                        <span style="font-weight:700; font-size:0.92rem;">{{ number_format($totalAuthors) }}</span>
                    </div>
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center gap-2">
                            <div style="width:8px; height:8px; border-radius:50%; background:#10b981;"></div>
                            <span style="font-size:0.84rem;">Categories</span>
                        </div>
                        <span style="font-weight:700; font-size:0.92rem;">{{ $categories->count() }}</span>
                    </div>

                    <hr style="border-color:var(--border); margin:0.5rem 0;">

                    {{-- Category breakdown --}}
                    @foreach($categories->sortByDesc('articles_count')->take(5) as $cat)
                    <div>
                        <div class="d-flex justify-content-between mb-1">
                            <span style="font-size:0.78rem; color:var(--text-muted);">{{ $cat->name }}</span>
                            <span style="font-size:0.78rem; font-weight:600;">{{ $cat->articles_count }}</span>
                        </div>
                        <div style="width:100%; height:4px; background:var(--bg); border-radius:2px; overflow:hidden;">
                            <div style="width:{{ $totalArticles > 0 ? round(($cat->articles_count / $totalArticles) * 100) : 0 }}%; height:100%; background:{{ $cat->color ?? 'var(--brand)' }}; border-radius:2px;"></div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Recent Articles --}}
<div class="bh-card">
    <div class="bh-card-header">
        <div class="bh-card-title"><i class="fa-solid fa-clock-rotate-left me-2" style="color:var(--brand);"></i> Recent Articles</div>
        <a href="{{ route('dashboard.all-articles') }}" class="bh-btn bh-btn-ghost bh-btn-sm">View All</a>
    </div>
    <div style="overflow-x:auto;">
        <table class="bh-table">
            <thead>
                <tr>
                    <th>Article</th>
                    <th>Author</th>
                    <th>Category</th>
                    <th>Views</th>
                    <th>Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($recentArticles as $article)
                <tr>
                    <td style="max-width:280px;">
                        <div class="d-flex align-items-center gap-3">
                            <img src="{{ $article->featured_image ?? 'https://ui-avatars.com/api/?name=' . urlencode($article->title) . '&background=C8461F&color=fff' }}"
                                 class="rounded" style="width:42px; height:32px; object-fit:cover; flex-shrink:0;">
                            <span class="fw-semibold" style="white-space:nowrap; overflow:hidden; text-overflow:ellipsis; max-width:200px; display:block;">
                                {{ $article->title }}
                            </span>
                        </div>
                    </td>
                    <td>
                        <div class="d-flex align-items-center gap-2">
                            <img src="{{ $article->author->avatar ?? 'https://ui-avatars.com/api/?name=' . urlencode($article->author->name ?? 'A') . '&background=C8461F&color=fff' }}"
                                 class="rounded-circle" style="width:24px; height:24px; object-fit:cover;">
                            <span>{{ $article->author->name ?? '—' }}</span>
                        </div>
                    </td>
                    <td>
                        <span class="bh-badge" style="background:{{ ($article->category->color ?? '#C8461F') }}15; color:{{ $article->category->color ?? '#C8461F' }};">
                            {{ $article->category->name ?? '—' }}
                        </span>
                    </td>
                    <td>
                        <span style="color:var(--text-muted);">
                            <i class="fa-solid fa-eye me-1" style="opacity:.5;"></i>{{ number_format($article->views_count) }}
                        </span>
                    </td>
                    <td style="color:var(--text-muted); white-space:nowrap;">{{ $article->created_at->format('M d, Y') }}</td>
                    <td>
                        <div class="d-flex gap-1">
                            <a href="{{ route('blogs.show', $article->slug) }}" target="_blank"
                               class="bh-btn bh-btn-ghost bh-btn-icon bh-btn-sm" title="View">
                                <i class="fa-solid fa-eye"></i>
                            </a>
                            <a href="{{ route('blogs.edit', $article->id) }}"
                               class="bh-btn bh-btn-ghost bh-btn-icon bh-btn-sm" title="Edit">
                                <i class="fa-solid fa-pen"></i>
                            </a>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" style="text-align:center; padding:2.5rem; color:var(--text-light);">
                        <i class="fa-solid fa-inbox" style="font-size:1.5rem; opacity:.3; display:block; margin-bottom:.5rem;"></i>
                        No articles yet.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@endsection

@section('scripts')
<script>
document.addEventListener("DOMContentLoaded", function() {
    // Line Chart
    var lineCtx = document.getElementById('canvas-linechart');
    if (lineCtx) {
        new Chart(lineCtx.getContext('2d'), {
            type: 'line',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul'],
                datasets: [{
                    label: 'Page Views',
                    borderColor: '#C8461F',
                    backgroundColor: 'rgba(200, 70, 31, 0.08)',
                    data: [1200, 1900, 3000, 5000, 4200, 6800, 8500],
                    fill: true,
                    tension: 0.4,
                    borderWidth: 2,
                    pointRadius: 3,
                    pointBackgroundColor: '#C8461F'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: {
                    y: { beginAtZero: true, grid: { color: '#f1f5f9' }, ticks: { font: { size: 11 } } },
                    x: { grid: { display: false }, ticks: { font: { size: 11 } } }
                }
            }
        });
    }
});
</script>
@endsection
