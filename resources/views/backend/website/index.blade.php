@extends('backend.layouts.admin')

@section('title', 'Manage Website Home Portions — BlogHub Admin')

@section('content')
<div class="row align-items-center justify-content-between mb-4 gy-2">
    <div class="col-auto">
        <h1 class="app-page-title mb-0">
            <i class="fa-solid fa-globe text-primary me-2"></i> Website Home Portions Manager
        </h1>
        <div class="text-muted small">
            Control, edit, and dynamically manage all 5 content portions shown on your public homepage.
        </div>
    </div>
    <div class="col-auto">
        <div class="page-utilities d-flex align-items-center gap-2">
            <a class="btn app-btn-secondary" href="{{ route('home') }}" target="_blank">
                <i class="fa-solid fa-arrow-up-right-from-square me-1"></i> View Live Homepage
            </a>
            <a class="btn app-btn-primary" href="{{ route('blogs.create') }}">
                <i class="fa-solid fa-pen-nib me-1"></i> Write New Article
            </a>
        </div>
    </div>
</div>

@if (isset($errors) && $errors->any())
<div class="alert alert-danger alert-dismissible fade show" role="alert">
    <h6 class="alert-heading fw-bold mb-1"><i class="fa-solid fa-triangle-exclamation me-1"></i> Please correct the following errors:</h6>
    <ul class="mb-0 small ps-3">
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

<!-- Section Quick Switcher Tabs -->
<div class="app-card shadow-sm mb-4">
    <div class="app-card-body p-2">
        <ul class="nav nav-pills nav-fill flex-column flex-md-row gap-1" id="portionsTab" role="tablist">
            <li class="nav-item">
                <a class="nav-link py-2 px-3 {{ $section === 'all' ? 'active' : '' }}" href="{{ route('dashboard.website.section', 'all') }}">
                    <i class="fa-solid fa-layer-group me-1.5 text-primary"></i> All Portions
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link py-2 px-3 {{ $section === 'discover' ? 'active' : '' }}" href="{{ route('dashboard.website.section', 'discover') }}">
                    <i class="fa-solid fa-wand-magic-sparkles me-1.5 text-warning"></i> 1. Discover Stories (Hero)
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link py-2 px-3 {{ $section === 'trending' ? 'active' : '' }}" href="{{ route('dashboard.website.section', 'trending') }}">
                    <i class="fa-solid fa-fire me-1.5 text-danger"></i> 2. Trending Now
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link py-2 px-3 {{ $section === 'topics' ? 'active' : '' }}" href="{{ route('dashboard.website.section', 'topics') }}">
                    <i class="fa-solid fa-shapes me-1.5 text-success"></i> 3. Explore Topics
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link py-2 px-3 {{ $section === 'latest-articles' ? 'active' : '' }}" href="{{ route('dashboard.website.section', 'latest-articles') }}">
                    <i class="fa-solid fa-newspaper me-1.5 text-info"></i> 4. Latest Articles
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link py-2 px-3 {{ $section === 'authors' ? 'active' : '' }}" href="{{ route('dashboard.website.section', 'authors') }}">
                    <i class="fa-solid fa-users me-1.5 text-secondary"></i> 5. Meet Our Authors
                </a>
            </li>
        </ul>
    </div>
</div>

<!-- ========================================================
     PORTION 1: Discover Thoughtful Stories & Expert Perspectives
     ======================================================== -->
@if($section === 'all' || $section === 'discover')
<div class="app-card shadow-sm mb-4 border-start border-4 border-warning" id="portion-discover">
    <div class="app-card-header p-3 border-bottom d-flex align-items-center justify-content-between flex-wrap gap-2">
        <div class="d-flex align-items-center gap-2">
            <span class="badge bg-warning bg-opacity-25 text-warning p-2 rounded-circle fs-6">
                <i class="fa-solid fa-wand-magic-sparkles"></i>
            </span>
            <div>
                <h4 class="app-card-title mb-0">1. Discover Thoughtful Stories &amp; Expert Perspectives</h4>
                <div class="text-muted small">Manage hero title, badge, subtitle, featured hero story, and promo card</div>
            </div>
        </div>
        <div class="d-flex align-items-center gap-2">
            <span class="badge bg-success"><i class="fa-solid fa-circle-check me-1"></i> Live on Homepage</span>
            <a href="{{ route('home') }}" target="_blank" class="btn btn-sm app-btn-secondary">
                <i class="fa-solid fa-eye me-1"></i> View Live
            </a>
        </div>
    </div>
    
    <div class="app-card-body p-4">
        <div class="row g-4 mb-4">
            <!-- Live Preview -->
            <div class="col-lg-6">
                <h6 class="fw-bold text-muted text-uppercase mb-2" style="font-size: 0.8rem; letter-spacing: 0.5px;">
                    <i class="fa-solid fa-desktop me-1"></i> Live Homepage Hero Preview
                </h6>
                <div class="p-4 bg-light rounded-3 border h-100 d-flex flex-column justify-content-between">
                    <div>
                        <span class="badge bg-danger bg-opacity-10 text-danger mb-2 font-mono px-2 py-1">
                            <i class="fa-solid fa-sparkles me-1"></i> {{ $homeSetting->hero_badge ?? 'Premier Content Hub' }}
                        </span>
                        <h4 class="fw-bold mb-2 font-heading">{{ $homeSetting->hero_heading ?? 'Discover Thoughtful Stories & Expert Perspectives' }}</h4>
                        <p class="text-muted small mb-3">
                            {{ $homeSetting->hero_description ?? 'Explore curated articles on technology, design, science, business, and culture.' }}
                        </p>
                    </div>

                    <!-- Selected Hero Article Preview -->
                    <div class="card border shadow-sm p-3 bg-white mt-3">
                        <div class="d-flex align-items-center justify-content-between mb-2">
                            <span class="badge bg-primary text-white small">Featured Story</span>
                            <small class="text-muted font-mono"><i class="fa-regular fa-clock me-1"></i> {{ $heroArticle->reading_time ?? 5 }} min</small>
                        </div>
                        @if($heroArticle)
                            <div class="d-flex align-items-center gap-3">
                                <img src="{{ $heroArticle->featured_image }}" class="rounded" style="width: 60px; height: 60px; object-fit: cover;" alt="">
                                <div class="overflow-hidden">
                                    <h6 class="fw-bold mb-1 text-truncate">{{ $heroArticle->title }}</h6>
                                    <div class="text-muted small">By {{ $heroArticle->author->name ?? 'Staff' }} &bull; {{ $heroArticle->category->name ?? 'Topic' }}</div>
                                </div>
                            </div>
                        @else
                            <p class="text-muted small mb-0">No featured hero story selected.</p>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Edit Form -->
            <div class="col-lg-6">
                <div class="p-4 bg-white rounded-3 border">
                    <h6 class="fw-bold text-primary mb-3">
                        <i class="fa-solid fa-sliders me-1"></i> Edit Hero &amp; Intro Settings
                    </h6>
                    <form action="{{ route('dashboard.website.hero.update') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label fw-semibold small">Hero Badge Text</label>
                            <input type="text" name="hero_badge" class="form-control form-control-sm" value="{{ old('hero_badge', $homeSetting->hero_badge ?? 'Premier Content Hub') }}" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold small">Hero Main Heading</label>
                            <input type="text" name="hero_heading" class="form-control form-control-sm" value="{{ old('hero_heading', $homeSetting->hero_heading ?? 'Discover Thoughtful Stories & Expert Perspectives') }}" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold small">Hero Subtitle / Description</label>
                            <textarea name="hero_description" rows="3" class="form-control form-control-sm" required>{{ old('hero_description', $homeSetting->hero_description ?? 'Explore curated articles on technology, design, science, business, and culture. Written by passionate creators and industry experts.') }}</textarea>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-semibold small">Featured Hero Story (Main Article Banner)</label>
                            <select name="featured_article_id" class="form-select form-select-sm">
                                <option value="">-- Auto Pick (Latest Featured Article) --</option>
                                @foreach($allArticles as $art)
                                    <option value="{{ $art->id }}" {{ (isset($homeSetting) && $homeSetting->featured_article_id == $art->id) ? 'selected' : '' }}>
                                        #{{ $art->id }} - {{ Str::limit($art->title, 50) }} ({{ $art->category->name ?? 'General' }})
                                    </option>
                                @endforeach
                            </select>
                            <div class="form-text small">This article will be highlighted directly under the hero banner on the homepage.</div>
                        </div>

                        <hr class="my-3">
                        <h6 class="fw-bold text-dark mb-2" style="font-size: 0.85rem;"><i class="fa-solid fa-rectangle-ad me-1 text-accent"></i> Right-side Promo Card</h6>

                        <div class="row g-2 mb-2">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold small">Promo Heading</label>
                                <input type="text" name="promo_heading" class="form-control form-control-sm" value="{{ old('promo_heading', $homeSetting->promo_heading ?? 'Share Your Knowledge') }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold small">Promo Subheading</label>
                                <input type="text" name="promo_subheading" class="form-control form-control-sm" value="{{ old('promo_subheading', $homeSetting->promo_subheading ?? 'Join 10,000+ creators on BlogHub') }}">
                            </div>
                        </div>

                        <div class="mb-2">
                            <label class="form-label fw-semibold small">Promo Description</label>
                            <textarea name="promo_description" rows="2" class="form-control form-control-sm">{{ old('promo_description', $homeSetting->promo_description ?? 'Publish your articles, connect with readers, and grow your audience with our powerful blogging platform tools.') }}</textarea>
                        </div>

                        <div class="row g-2 mb-3">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold small">Button Text</label>
                                <input type="text" name="promo_btn_text" class="form-control form-control-sm" value="{{ old('promo_btn_text', $homeSetting->promo_btn_text ?? 'Write Article') }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold small">Button Target URL</label>
                                <input type="text" name="promo_btn_url" class="form-control form-control-sm" value="{{ old('promo_btn_url', $homeSetting->promo_btn_url ?? '/blogs/create') }}">
                            </div>
                        </div>

                        <div class="text-end">
                            <button type="submit" class="btn btn-primary btn-sm px-4">
                                <i class="fa-solid fa-floppy-disk me-1"></i> Save Hero Settings
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endif

<!-- ========================================================
     PORTION 2: Trending Now (Trending Stories Section)
     ======================================================== -->
@if($section === 'all' || $section === 'trending')
<div class="app-card shadow-sm mb-4 border-start border-4 border-danger" id="portion-trending">
    <div class="app-card-header p-3 border-bottom d-flex align-items-center justify-content-between flex-wrap gap-2">
        <div class="d-flex align-items-center gap-2">
            <span class="badge bg-danger bg-opacity-25 text-danger p-2 rounded-circle fs-6">
                <i class="fa-solid fa-fire"></i>
            </span>
            <div>
                <h4 class="app-card-title mb-0">2. Trending Now</h4>
                <div class="text-muted small">Only articles toggled ON as "Trending" below will be shown in the Trending section</div>
            </div>
        </div>
        <div class="d-flex align-items-center gap-2">
            <span class="badge bg-danger fs-6">{{ $trendingArticles->count() }} Currently Trending</span>
            <a href="{{ route('home') }}#trending" target="_blank" class="btn btn-sm app-btn-secondary">
                <i class="fa-solid fa-eye me-1"></i> View on Site
            </a>
        </div>
    </div>
    
    <div class="app-card-body p-3">
        <div class="alert alert-info py-2 px-3 small d-flex align-items-center justify-content-between flex-wrap gap-2 mb-3">
            <div>
                <i class="fa-solid fa-circle-info me-1"></i> 
                <strong>Strict Dynamic Rule Active:</strong> The home page will <em>only</em> show articles you toggle as Trending here. No random or dummy fillers!
            </div>
            <span class="badge bg-white text-dark border font-mono">{{ $trendingArticles->count() }} Active</span>
        </div>

        <div class="table-responsive">
            <table class="table app-table-hover mb-0 text-left align-middle">
                <thead>
                    <tr>
                        <th class="cell" style="width: 45%;">Article Title</th>
                        <th class="cell">Category</th>
                        <th class="cell">Author</th>
                        <th class="cell text-center">Reads</th>
                        <th class="cell text-center">Status</th>
                        <th class="cell text-end">Toggle Trending</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($allArticles as $article)
                        <tr class="{{ $article->is_trending ? 'table-warning bg-opacity-10' : '' }}">
                            <td class="cell">
                                <div class="d-flex align-items-center gap-2">
                                    <img src="{{ $article->featured_image }}" class="rounded" style="width: 42px; height: 42px; object-fit: cover;" alt="">
                                    <div>
                                        <a href="{{ route('blogs.show', $article->slug) }}" target="_blank" class="fw-bold text-decoration-none text-dark d-block">
                                            {{ Str::limit($article->title, 55) }}
                                        </a>
                                        <div class="text-muted small font-mono">{{ $article->published_at ? $article->published_at->format('M d, Y') : 'Recent' }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="cell">
                                <span class="badge bg-light text-dark border">{{ $article->category->name ?? 'General' }}</span>
                            </td>
                            <td class="cell small">{{ $article->author->name ?? 'Staff' }}</td>
                            <td class="cell text-center font-mono small">
                                <i class="fa-regular fa-eye me-1 text-muted"></i> {{ number_format($article->views_count) }}
                            </td>
                            <td class="cell text-center">
                                @if($article->is_trending)
                                    <span class="badge bg-danger text-white py-1 px-2">
                                        <i class="fa-solid fa-fire me-1"></i> Trending
                                    </span>
                                @else
                                    <span class="badge bg-secondary bg-opacity-25 text-secondary py-1 px-2">
                                        Standard
                                    </span>
                                @endif
                            </td>
                            <td class="cell text-end">
                                <form action="{{ route('dashboard.website.trending.toggle', $article->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @if($article->is_trending)
                                        <button type="submit" class="btn btn-sm btn-danger py-1 px-3" title="Click to remove from homepage Trending">
                                            <i class="fa-solid fa-xmark me-1"></i> Remove
                                        </button>
                                    @else
                                        <button type="submit" class="btn btn-sm btn-outline-danger py-1 px-3" title="Click to make this article show in Trending section">
                                            <i class="fa-solid fa-fire me-1"></i> Set Trending
                                        </button>
                                    @endif
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-4 text-muted">No articles found in the database.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endif

<!-- ========================================================
     PORTION 3: Explore Topics (Categories Section)
     ======================================================== -->
@if($section === 'all' || $section === 'topics')
<div class="app-card shadow-sm mb-4 border-start border-4 border-success" id="portion-topics">
    <div class="app-card-header p-3 border-bottom d-flex align-items-center justify-content-between flex-wrap gap-2">
        <div class="d-flex align-items-center gap-2">
            <span class="badge bg-success bg-opacity-25 text-success p-2 rounded-circle fs-6">
                <i class="fa-solid fa-shapes"></i>
            </span>
            <div>
                <h4 class="app-card-title mb-0">3. Explore Topics (Categories)</h4>
                <div class="text-muted small">Manage topic categories displayed on the homepage showcase grid and quick filter pills</div>
            </div>
        </div>
        <div class="d-flex align-items-center gap-2">
            <span class="badge bg-success fs-6">{{ $categories->count() }} Categories</span>
            <button class="btn btn-sm btn-success text-white" data-bs-toggle="modal" data-bs-target="#addCategoryModal">
                <i class="fa-solid fa-plus me-1"></i> Add New Category
            </button>
        </div>
    </div>
    
    <div class="app-card-body p-4">
        <div class="row g-3">
            @forelse($categories as $category)
                <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                    <div class="p-3 bg-light rounded-3 border h-100 d-flex flex-column justify-content-between shadow-xs">
                        <div>
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <span class="badge rounded-circle p-2 text-white" style="background-color: {{ $category->color ?? '#C8461F' }};">
                                    <i class="fa-solid {{ $category->icon ?? 'fa-folder' }}"></i>
                                </span>
                                <span class="badge bg-white text-dark border small">{{ $category->articles_count }} Articles</span>
                            </div>
                            <h6 class="fw-bold mb-1">{{ $category->name }}</h6>
                            <div class="text-muted small font-mono mb-1">/{{ $category->slug }}</div>
                            <p class="text-muted small mb-0" style="font-size: 0.8rem; line-height: 1.3;">
                                {{ Str::limit($category->description ?? 'Curated stories and articles.', 70) }}
                            </p>
                        </div>
                        <div class="mt-3 pt-2 border-top d-flex align-items-center justify-content-between">
                            <button class="btn btn-sm btn-outline-primary py-0 px-2" style="font-size: 0.75rem;" data-bs-toggle="modal" data-bs-target="#editCategoryModal_{{ $category->id }}">
                                <i class="fa-solid fa-pen-to-square me-1"></i> Edit
                            </button>
                            <form action="{{ route('dashboard.website.categories.delete', $category->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete category {{ addslashes($category->name) }}?');" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger py-0 px-2" style="font-size: 0.75rem;">
                                    <i class="fa-solid fa-trash me-1"></i> Delete
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Edit Category Modal -->
                <div class="modal fade" id="editCategoryModal_{{ $category->id }}" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form action="{{ route('dashboard.website.categories.update', $category->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="modal-header">
                                    <h5 class="modal-title fw-bold"><i class="fa-solid fa-pen-to-square text-success me-2"></i> Edit Category: {{ $category->name }}</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label class="form-label fw-semibold small">Category Name</label>
                                        <input type="text" name="name" class="form-control" value="{{ $category->name }}" required>
                                    </div>
                                    <div class="row g-2 mb-3">
                                        <div class="col-md-7">
                                            <label class="form-label fw-semibold small">FontAwesome Icon Class</label>
                                            <input type="text" name="icon" class="form-control" value="{{ $category->icon }}" placeholder="fa-shapes, fa-laptop-code, etc.">
                                        </div>
                                        <div class="col-md-5">
                                            <label class="form-label fw-semibold small">Theme Color</label>
                                            <input type="color" name="color" class="form-control form-control-color w-100" value="{{ $category->color ?? '#C8461F' }}">
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label fw-semibold small">Description</label>
                                        <textarea name="description" rows="3" class="form-control">{{ $category->description }}</textarea>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
                                    <button type="submit" class="btn btn-success btn-sm text-white">Save Changes</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center py-4 text-muted">
                    No topic categories found. Add your first category using the button above.
                </div>
            @endforelse
        </div>
    </div>
</div>

<!-- Add Category Modal -->
<div class="modal fade" id="addCategoryModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('dashboard.website.categories.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title fw-bold"><i class="fa-solid fa-plus text-success me-2"></i> Add New Topic Category</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-semibold small">Category Name</label>
                        <input type="text" name="name" class="form-control" placeholder="e.g. Artificial Intelligence" required>
                    </div>
                    <div class="row g-2 mb-3">
                        <div class="col-md-7">
                            <label class="form-label fw-semibold small">FontAwesome Icon Class</label>
                            <input type="text" name="icon" class="form-control" placeholder="fa-robot, fa-laptop-code, fa-globe" value="fa-shapes">
                        </div>
                        <div class="col-md-5">
                            <label class="form-label fw-semibold small">Badge Color</label>
                            <input type="color" name="color" class="form-control form-control-color w-100" value="#C8461F">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold small">Description</label>
                        <textarea name="description" rows="3" class="form-control" placeholder="Brief summary of what readers will find in this category..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-success btn-sm text-white">Create Category</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif

<!-- ========================================================
     PORTION 4: Latest Articles Grid
     ======================================================== -->
@if($section === 'all' || $section === 'latest-articles')
<div class="app-card shadow-sm mb-4 border-start border-4 border-info" id="portion-latest">
    <div class="app-card-header p-3 border-bottom d-flex align-items-center justify-content-between flex-wrap gap-2">
        <div class="d-flex align-items-center gap-2">
            <span class="badge bg-info bg-opacity-25 text-info p-2 rounded-circle fs-6">
                <i class="fa-solid fa-newspaper"></i>
            </span>
            <div>
                <h4 class="app-card-title mb-0">4. Latest Articles Feed</h4>
                <div class="text-muted small">Newest published stories shown in the homepage main grid</div>
            </div>
        </div>
        <div class="d-flex align-items-center gap-2">
            <span class="badge bg-info fs-6">{{ $totalArticles }} Total Articles</span>
            <a href="{{ route('blogs.create') }}" class="btn btn-sm btn-info text-white">
                <i class="fa-solid fa-plus me-1"></i> Write New Story
            </a>
            <a href="{{ route('dashboard.articles') }}" class="btn btn-sm app-btn-secondary">
                <i class="fa-solid fa-list me-1"></i> Full Articles Table
            </a>
        </div>
    </div>
    
    <div class="app-card-body p-3">
        <div class="table-responsive">
            <table class="table app-table-hover mb-0 text-left align-middle">
                <thead>
                    <tr>
                        <th class="cell" style="width: 45%;">Title</th>
                        <th class="cell">Category</th>
                        <th class="cell">Author</th>
                        <th class="cell">Published</th>
                        <th class="cell text-center">Trending</th>
                        <th class="cell text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($latestArticles as $article)
                        <tr>
                            <td class="cell">
                                <div class="d-flex align-items-center gap-2">
                                    <img src="{{ $article->featured_image }}" class="rounded" style="width: 38px; height: 38px; object-fit: cover;" alt="">
                                    <div>
                                        <a href="{{ route('blogs.show', $article->slug) }}" target="_blank" class="fw-bold text-dark text-decoration-none">
                                            {{ Str::limit($article->title, 48) }}
                                        </a>
                                    </div>
                                </div>
                            </td>
                            <td class="cell"><span class="badge bg-light text-dark border">{{ $article->category->name ?? 'General' }}</span></td>
                            <td class="cell">{{ $article->author->name ?? 'Staff' }}</td>
                            <td class="cell text-muted small">{{ $article->published_at ? $article->published_at->format('M d, Y') : $article->created_at->format('M d, Y') }}</td>
                            <td class="cell text-center">
                                <form action="{{ route('dashboard.website.trending.toggle', $article->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-sm {{ $article->is_trending ? 'btn-danger' : 'btn-outline-secondary' }} py-0 px-2" style="font-size: 0.75rem;">
                                        <i class="fa-solid fa-fire me-1"></i> {{ $article->is_trending ? 'Trending' : 'Standard' }}
                                    </button>
                                </form>
                            </td>
                            <td class="cell text-end">
                                <a href="{{ route('blogs.show', $article->slug) }}" target="_blank" class="btn btn-sm btn-outline-secondary py-1 px-2" title="View Article on Live Site">
                                    <i class="fa-solid fa-arrow-up-right-from-square"></i>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-4 text-muted">No published articles yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endif

<!-- ========================================================
     PORTION 5: Meet Our Authors (Featured Contributors)
     ======================================================== -->
@if($section === 'all' || $section === 'authors')
<div class="app-card shadow-sm mb-4 border-start border-4 border-secondary" id="portion-authors">
    <div class="app-card-header p-3 border-bottom d-flex align-items-center justify-content-between flex-wrap gap-2">
        <div class="d-flex align-items-center gap-2">
            <span class="badge bg-secondary bg-opacity-25 text-secondary p-2 rounded-circle fs-6">
                <i class="fa-solid fa-users"></i>
            </span>
            <div>
                <h4 class="app-card-title mb-0">5. Meet Our Authors</h4>
                <div class="text-muted small">Manage content contributors, editors, and columnists showcased on the homepage</div>
            </div>
        </div>
        <div class="d-flex align-items-center gap-2">
            <span class="badge bg-secondary fs-6">{{ $totalAuthors }} Authors</span>
            <button class="btn btn-sm btn-secondary text-white" data-bs-toggle="modal" data-bs-target="#addAuthorModal">
                <i class="fa-solid fa-user-plus me-1"></i> Add New Author
            </button>
            <a href="{{ route('authors.index') }}" target="_blank" class="btn btn-sm app-btn-secondary">
                <i class="fa-solid fa-arrow-up-right-from-square me-1"></i> Public Directory
            </a>
        </div>
    </div>
    
    <div class="app-card-body p-4">
        <div class="row g-3">
            @forelse($featuredAuthors as $author)
                <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                    <div class="p-3 bg-light rounded-3 border text-center h-100 d-flex flex-column align-items-center justify-content-between shadow-xs">
                        <div class="w-100">
                            <img src="{{ $author->avatar ?? 'https://ui-avatars.com/api/?name=' . urlencode($author->name) . '&background=C8461F&color=ffffff&bold=true' }}" class="rounded-circle mb-2" style="width: 56px; height: 56px; object-fit: cover;" alt="{{ $author->name }}">
                            <h6 class="fw-bold mb-0 text-dark">{{ $author->name }}</h6>
                            <span class="badge bg-primary bg-opacity-10 text-primary small my-1">{{ $author->specialty ?? 'Contributor' }}</span>
                            <div class="text-muted small font-mono mb-1"><i class="fa-solid fa-newspaper me-1"></i> {{ $author->articles_count }} Stories</div>
                            <p class="text-muted small mb-2" style="font-size: 0.75rem; line-height: 1.3;">
                                {{ Str::limit($author->bio ?? 'Passionate writer and expert contributor on BlogHub.', 70) }}
                            </p>
                        </div>
                        <div class="w-100 pt-2 border-top d-flex align-items-center justify-content-between">
                            <button class="btn btn-sm btn-outline-primary py-0 px-2" style="font-size: 0.75rem;" data-bs-toggle="modal" data-bs-target="#editAuthorModal_{{ $author->id }}">
                                <i class="fa-solid fa-pen-to-square me-1"></i> Edit
                            </button>
                            <form action="{{ route('dashboard.website.authors.delete', $author->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete author {{ addslashes($author->name) }}?');" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger py-0 px-2" style="font-size: 0.75rem;">
                                    <i class="fa-solid fa-trash me-1"></i> Delete
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Edit Author Modal -->
                <div class="modal fade" id="editAuthorModal_{{ $author->id }}" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content text-start">
                            <form action="{{ route('dashboard.website.authors.update', $author->id) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="modal-header">
                                    <h5 class="modal-title fw-bold"><i class="fa-solid fa-user-pen text-secondary me-2"></i> Edit Author: {{ $author->name }}</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label class="form-label fw-semibold small">Full Name</label>
                                        <input type="text" name="name" class="form-control" value="{{ $author->name }}" required>
                                    </div>
                                    <div class="row g-2 mb-3">
                                        <div class="col-md-6">
                                            <label class="form-label fw-semibold small">Specialty / Role</label>
                                            <input type="text" name="specialty" class="form-control" value="{{ $author->specialty }}" placeholder="e.g. Senior Tech Editor">
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label fw-semibold small">Tagline</label>
                                            <input type="text" name="tagline" class="form-control" value="{{ $author->tagline }}" placeholder="Short headline">
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label fw-semibold small">Bio</label>
                                        <textarea name="bio" rows="3" class="form-control">{{ $author->bio }}</textarea>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label fw-semibold small">Avatar Image URL</label>
                                        <input type="text" name="avatar_url" class="form-control" value="{{ $author->avatar }}" placeholder="https://...">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label fw-semibold small">Or Upload New Avatar Image</label>
                                        <input type="file" name="avatar_file" class="form-control form-control-sm" accept="image/*">
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
                                    <button type="submit" class="btn btn-primary btn-sm">Save Author</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center py-4 text-muted">
                    No authors found in the database.
                </div>
            @endforelse
        </div>
    </div>
</div>

<!-- Add Author Modal -->
<div class="modal fade" id="addAuthorModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('dashboard.website.authors.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title fw-bold"><i class="fa-solid fa-user-plus text-secondary me-2"></i> Add New Author</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label fw-semibold small">Full Name</label>
                        <input type="text" name="name" class="form-control" placeholder="e.g. Alex Morgan" required>
                    </div>
                    <div class="row g-2 mb-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold small">Specialty / Role</label>
                            <input type="text" name="specialty" class="form-control" placeholder="e.g. Lead Tech Journalist">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold small">Tagline</label>
                            <input type="text" name="tagline" class="form-control" placeholder="e.g. Writing about AI & Future Tech">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold small">Bio</label>
                        <textarea name="bio" rows="3" class="form-control" placeholder="Short biography about this author..."></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold small">Avatar Image URL (Optional)</label>
                        <input type="text" name="avatar_url" class="form-control" placeholder="https://images.unsplash.com/photo-...">
                    </div>
                    <div class="mb-3">
                        <label class="form-label fw-semibold small">Or Upload Avatar File</label>
                        <input type="file" name="avatar_file" class="form-control form-control-sm" accept="image/*">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-secondary btn-sm text-white">Create Author</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif

@endsection
