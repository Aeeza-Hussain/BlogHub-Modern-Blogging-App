@extends('backend.layouts.admin')

@section('title', 'Analytics & Stats — BlogHub')

@section('content')

{{-- Page Header --}}
<div class="bh-page-header">
    <div>
        <h1 class="bh-page-title">Analytics &amp; Stats</h1>
        <p class="bh-page-sub">Track your readership, category engagement, and top-performing content.</p>
    </div>
    <a href="{{ route('dashboard.articles') }}" class="bh-btn bh-btn-ghost">
        <i class="fa-solid fa-newspaper"></i> My Articles
    </a>
</div>

{{-- Charts Grid --}}
<div class="row g-3 mb-4">
    <div class="col-12 col-lg-6">
        <div class="bh-card" style="height:100%;">
            <div class="bh-card-header">
                <div class="bh-card-title"><i class="fa-solid fa-chart-area me-2" style="color:#10b981;"></i> Readership Growth</div>
            </div>
            <div class="bh-card-body">
                <canvas id="chart-line" style="max-height:260px;"></canvas>
            </div>
        </div>
    </div>
    <div class="col-12 col-lg-6">
        <div class="bh-card" style="height:100%;">
            <div class="bh-card-header">
                <div class="bh-card-title"><i class="fa-solid fa-chart-simple me-2" style="color:#2563eb;"></i> Posts per Category</div>
            </div>
            <div class="bh-card-body">
                <canvas id="chart-bar" style="max-height:260px;"></canvas>
            </div>
        </div>
    </div>
    <div class="col-12 col-lg-6">
        <div class="bh-card" style="height:100%;">
            <div class="bh-card-header">
                <div class="bh-card-title"><i class="fa-solid fa-chart-pie me-2" style="color:#f59e0b;"></i> Category Share</div>
            </div>
            <div class="bh-card-body">
                <canvas id="chart-pie" style="max-height:260px;"></canvas>
            </div>
        </div>
    </div>
    <div class="col-12 col-lg-6">
        <div class="bh-card" style="height:100%;">
            <div class="bh-card-header">
                <div class="bh-card-title"><i class="fa-solid fa-bullseye me-2" style="color:#8b5cf6;"></i> Traffic Sources</div>
            </div>
            <div class="bh-card-body">
                <canvas id="chart-doughnut" style="max-height:260px;"></canvas>
            </div>
        </div>
    </div>
</div>

{{-- Top Articles --}}
<div class="bh-card">
    <div class="bh-card-header">
        <div class="bh-card-title"><i class="fa-solid fa-fire me-2" style="color:#dc2626;"></i> Top Performing Articles</div>
    </div>
    <div style="overflow-x:auto;">
        <table class="bh-table">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Category</th>
                    <th>Views</th>
                    <th>Likes</th>
                </tr>
            </thead>
            <tbody>
                @foreach($topArticles as $top)
                <tr>
                    <td>
                        <span class="fw-semibold">{{ Str::limit($top->title, 50) }}</span>
                    </td>
                    <td>
                        <span class="bh-badge" style="background:rgba(37,99,235,0.1); color:#2563eb;">
                            {{ $top->category->name ?? '—' }}
                        </span>
                    </td>
                    <td>
                        <i class="fa-solid fa-eye me-1" style="opacity:.4;"></i>{{ number_format($top->views_count) }}
                    </td>
                    <td>
                        <i class="fa-solid fa-heart me-1 text-danger" style="opacity:.5;"></i>{{ number_format($top->likes_count) }}
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@endsection

@section('scripts')
<script>
document.addEventListener("DOMContentLoaded", function() {
    var catLabels = {!! json_encode($categoryNames) !!};
    var catCounts = {!! json_encode($categoryCounts) !!};
    var chartColors = ['#C8461F', '#2563eb', '#10b981', '#f59e0b', '#8b5cf6', '#ec4899', '#06b6d4'];
    var opts = { responsive: true, maintainAspectRatio: false, plugins: { legend: { labels: { font: { size: 11 } } } } };

    new Chart(document.getElementById('chart-line').getContext('2d'), {
        type: 'line',
        data: {
            labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
            datasets: [{
                label: 'Page Views',
                borderColor: '#C8461F',
                backgroundColor: 'rgba(200,70,31,0.08)',
                data: [650, 890, 1200, 1400, 1800, 2400, 3100],
                fill: true, tension: 0.4, borderWidth: 2, pointRadius: 3, pointBackgroundColor: '#C8461F'
            }]
        },
        options: { ...opts, plugins: { legend: { display: false } },
            scales: { y: { beginAtZero: true, grid: { color:'#f1f5f9' } }, x: { grid: { display: false } } }
        }
    });

    new Chart(document.getElementById('chart-bar').getContext('2d'), {
        type: 'bar',
        data: { labels: catLabels, datasets: [{ label: 'Articles', backgroundColor: '#2563eb', borderRadius: 4, data: catCounts }] },
        options: { ...opts, plugins: { legend: { display: false } },
            scales: { y: { beginAtZero: true, grid: { color:'#f1f5f9' } }, x: { grid: { display: false } } }
        }
    });

    new Chart(document.getElementById('chart-pie').getContext('2d'), {
        type: 'pie',
        data: { labels: catLabels, datasets: [{ backgroundColor: chartColors.slice(0, catLabels.length), data: catCounts }] },
        options: opts
    });

    new Chart(document.getElementById('chart-doughnut').getContext('2d'), {
        type: 'doughnut',
        data: {
            labels: ['Direct', 'Organic', 'Social', 'Referral'],
            datasets: [{ backgroundColor: ['#C8461F', '#2563eb', '#ec4899', '#f59e0b'], data: [40, 35, 15, 10] }]
        },
        options: opts
    });
});
</script>
@endsection
