@extends('backend.layouts.admin')

@section('title', 'BlogHub - Analytics & Charts')

@section('content')
<h1 class="app-page-title"><i class="fa-solid fa-chart-line text-primary me-2"></i> Analytics &amp; Reports</h1>

<div class="app-card shadow-sm mb-4 border-left-decoration">
    <div class="inner">
        <div class="app-card-body p-4">
            <div class="row gx-5 gy-3 align-items-center">
                <div class="col-12 col-lg-9">
                    <div>Real-time analytics for your blog audience, article traffic trends, and category engagement powered by Chart.js.</div>
                </div>
                <div class="col-12 col-lg-3 text-lg-end">
                    <a class="btn app-btn-primary" href="{{ route('dashboard.articles') }}">
                        <i class="fa-solid fa-list me-1"></i> Manage Articles
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-4 mb-4">
    <div class="col-12 col-lg-6">
        <div class="app-card app-card-chart h-100 shadow-sm">
            <div class="app-card-header p-3 border-0">
                <h4 class="app-card-title"><i class="fa-solid fa-wave-square me-2 text-success"></i> Readership Growth</h4>
            </div>
            <div class="app-card-body p-4">
                <div class="chart-container">
                    <canvas id="chart-line" style="max-height: 280px;"></canvas>
                </div>
            </div>
        </div>
    </div>

    <div class="col-12 col-lg-6">
        <div class="app-card app-card-chart h-100 shadow-sm">
            <div class="app-card-header p-3 border-0">
                <h4 class="app-card-title"><i class="fa-solid fa-chart-simple me-2 text-primary"></i> Posts per Category</h4>
            </div>
            <div class="app-card-body p-4">
                <div class="chart-container">
                    <canvas id="chart-bar" style="max-height: 280px;"></canvas>
                </div>
            </div>
        </div>
    </div>

    <div class="col-12 col-lg-6">
        <div class="app-card app-card-chart h-100 shadow-sm">
            <div class="app-card-header p-3 border-0">
                <h4 class="app-card-title"><i class="fa-solid fa-chart-pie me-2 text-warning"></i> Category Share</h4>
            </div>
            <div class="app-card-body p-4">
                <div class="chart-container">
                    <canvas id="chart-pie" style="max-height: 280px;"></canvas>
                </div>
            </div>
        </div>
    </div>

    <div class="col-12 col-lg-6">
        <div class="app-card app-card-chart h-100 shadow-sm">
            <div class="app-card-header p-3 border-0">
                <h4 class="app-card-title"><i class="fa-solid fa-chart-donut me-2 text-info"></i> Traffic Sources</h4>
            </div>
            <div class="app-card-body p-4">
                <div class="chart-container">
                    <canvas id="chart-doughnut" style="max-height: 280px;"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="app-card shadow-sm mb-4">
    <div class="app-card-header p-3">
        <h4 class="app-card-title"><i class="fa-solid fa-fire text-danger me-2"></i> Top Performing Articles</h4>
    </div>
    <div class="app-card-body">
        <div class="table-responsive">
            <table class="table app-table-hover mb-0">
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
                        <td class="fw-bold">{{ $top->title }}</td>
                        <td><span class="badge bg-primary">{{ $top->category->name }}</span></td>
                        <td><i class="fa-solid fa-eye me-1 text-muted"></i> {{ number_format($top->views_count) }}</td>
                        <td><i class="fa-solid fa-heart me-1 text-danger"></i> {{ number_format($top->likes_count) }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener("DOMContentLoaded", function() {
        var catLabels = {!! json_encode($categoryNames) !!};
        var catCounts = {!! json_encode($categoryCounts) !!};

        // Line Chart
        new Chart(document.getElementById('chart-line').getContext('2d'), {
            type: 'line',
            data: {
                labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
                datasets: [{
                    label: 'Page Views',
                    borderColor: '#15a362',
                    backgroundColor: 'rgba(21, 163, 98, 0.1)',
                    data: [650, 890, 1200, 1400, 1800, 2400, 3100],
                    fill: true,
                    tension: 0.3
                }]
            },
            options: { responsive: true, maintainAspectRatio: false }
        });

        // Bar Chart
        new Chart(document.getElementById('chart-bar').getContext('2d'), {
            type: 'bar',
            data: {
                labels: catLabels,
                datasets: [{
                    label: 'Articles',
                    backgroundColor: '#3b82f6',
                    data: catCounts
                }]
            },
            options: { responsive: true, maintainAspectRatio: false }
        });

        // Pie Chart
        new Chart(document.getElementById('chart-pie').getContext('2d'), {
            type: 'pie',
            data: {
                labels: catLabels,
                datasets: [{
                    backgroundColor: ['#3b82f6', '#10b981', '#f59e0b', '#ef4444', '#8b5cf6'],
                    data: catCounts
                }]
            },
            options: { responsive: true, maintainAspectRatio: false }
        });

        // Doughnut Chart
        new Chart(document.getElementById('chart-doughnut').getContext('2d'), {
            type: 'doughnut',
            data: {
                labels: ['Direct', 'Organic Search', 'Social Media', 'Referral'],
                datasets: [{
                    backgroundColor: ['#4f46e5', '#06b6d4', '#ec4899', '#f97316'],
                    data: [40, 35, 15, 10]
                }]
            },
            options: { responsive: true, maintainAspectRatio: false }
        });
    });
</script>
@endsection
