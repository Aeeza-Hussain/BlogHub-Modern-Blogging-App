@extends('backend.layouts.admin')

@section('title', 'Help & Docs — BlogHub')

@section('content')

{{-- Page Header --}}
<div class="bh-page-header">
    <div>
        <h1 class="bh-page-title">Help &amp; Documentation</h1>
        <p class="bh-page-sub">Quick guides, FAQs, and resources to help you use BlogHub.</p>
    </div>
</div>

{{-- Quick Guide Cards --}}
<div class="row g-3 mb-4">
    @php
        $isAdmin = (auth()->user()->user_type ?? 1) == 1;
        $guides = [
            ['Managing Articles', 'Review, moderate, approve, or categorize articles submitted by platform authors.', 'fa-newspaper', '#C8461F', $isAdmin ? route('dashboard.all-articles') : route('dashboard.articles'), $isAdmin ? 'Manage Articles' : 'My Articles'],
            ['Analytics & Stats', 'Track reader traffic, view counts, likes, and engagement using interactive charts and graphs.', 'fa-chart-line', '#10b981', route('dashboard.charts'), 'View Analytics'],
            ['Website Sections', 'Customize your homepage hero, trending articles, categories, and author profiles.', 'fa-globe', '#2563eb', route('dashboard.website'), 'Manage Website'],
            ['User Management', 'View, promote, demote, or remove platform users and authors.', 'fa-users-gear', '#8b5cf6', route('dashboard.users'), 'Manage Users'],
        ];
    @endphp

    @foreach($guides as $g)
    <div class="col-12 col-md-6 col-lg-3">
        <div class="bh-card" style="height:100%; display:flex; flex-direction:column;">
            <div class="bh-card-body" style="flex:1;">
                <div style="width:40px; height:40px; border-radius:10px; background:{{ $g[3] }}12; display:flex; align-items:center; justify-content:center; margin-bottom:1rem;">
                    <i class="fa-solid {{ $g[2] }}" style="color:{{ $g[3] }}; font-size:1rem;"></i>
                </div>
                <div style="font-weight:700; font-size:0.92rem; color:var(--text-primary); margin-bottom:6px;">{{ $g[0] }}</div>
                <div style="font-size:0.82rem; color:var(--text-muted); line-height:1.5;">{{ $g[1] }}</div>
            </div>
            <div style="padding:0 1.25rem 1.25rem;">
                <a href="{{ $g[4] }}" class="bh-btn bh-btn-ghost bh-btn-sm" style="width:100%; justify-content:center;">{{ $g[5] }}</a>
            </div>
        </div>
    </div>
    @endforeach
</div>

{{-- FAQ --}}
<div class="bh-card">
    <div class="bh-card-header">
        <div class="bh-card-title"><i class="fa-solid fa-circle-question me-2" style="color:var(--brand);"></i> Frequently Asked Questions</div>
    </div>
    <div class="bh-card-body" style="padding:0;">
        @php
            $faqs = [
                ['How do I mark an article as Featured or Trending?', 'When creating or editing an article, check the <strong>Featured</strong> or <strong>Trending</strong> checkboxes. Featured articles appear on the main homepage hero banner, while Trending articles show in the trending section.'],
                ['How are page views and likes calculated?', 'Page views increment automatically when a reader visits an article. Likes are logged via AJAX when a user clicks the heart icon on any post.'],
                ['Where do contact messages go?', 'All contact form submissions from the public website automatically appear in the <strong>Notifications</strong> section of your dashboard.'],
                ['How do I manage user roles?', 'Go to <strong>Users</strong> in the sidebar. You can change any user\'s role between Admin, Author, or Regular User using the role dropdown in the actions column.'],
                ['Can authors edit or delete their own articles?', 'Yes. Authors can edit and delete their own articles from the <strong>My Articles</strong> page. They cannot modify other authors\' articles.'],
            ];
        @endphp

        <div class="accordion" id="help-accordion">
            @foreach($faqs as $i => $faq)
            <div style="border-bottom:1px solid var(--border);">
                <button class="d-flex align-items-center justify-content-between w-100 bg-transparent border-0"
                    style="padding:1rem 1.25rem; cursor:pointer; text-align:left; font-size:0.88rem; font-weight:600; color:var(--text-primary);"
                    type="button" data-bs-toggle="collapse" data-bs-target="#faq-{{ $i }}">
                    {{ $faq[0] }}
                    <i class="fa-solid fa-chevron-down" style="font-size:0.7rem; color:var(--text-light); flex-shrink:0;"></i>
                </button>
                <div id="faq-{{ $i }}" class="collapse {{ $i === 0 ? 'show' : '' }}" data-bs-parent="#help-accordion">
                    <div style="padding:0 1.25rem 1.25rem; font-size:0.84rem; color:var(--text-muted); line-height:1.6;">
                        {!! $faq[1] !!}
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>

@endsection
