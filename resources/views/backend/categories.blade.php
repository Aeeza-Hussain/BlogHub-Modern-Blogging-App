@extends('backend.layouts.admin')

@section('title', 'Category Management — BlogHub Admin')

@section('content')

{{-- Page Header --}}
<div class="bh-page-header">
    <div>
        <h1 class="bh-page-title"><i class="fa-solid fa-tags text-primary me-2"></i>Category Management</h1>
        <p class="bh-page-sub">Organize blog articles into categories and topics for easy reader discovery.</p>
    </div>
    <div>
        <button type="button" class="bh-btn bh-btn-primary" data-bs-toggle="modal" data-bs-target="#createCategoryModal">
            <i class="fa-solid fa-plus me-1"></i> Add New Category
        </button>
    </div>
</div>

{{-- Stats Row --}}
<div class="row g-3 mb-4">
    <div class="col-6 col-md-6">
        <div class="bh-stat">
            <div class="bh-stat-icon" style="background:rgba(99,102,241,0.1); color:#6366f1;">
                <i class="fa-solid fa-tags"></i>
            </div>
            <div>
                <div class="bh-stat-num">{{ number_format($totalCategories) }}</div>
                <div class="bh-stat-label">Total Categories</div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-6">
        <div class="bh-stat">
            <div class="bh-stat-icon" style="background:rgba(16,185,129,0.1); color:#10b981;">
                <i class="fa-solid fa-newspaper"></i>
            </div>
            <div>
                <div class="bh-stat-num">{{ number_format($totalCategorizedPosts) }}</div>
                <div class="bh-stat-label">Categorized Articles</div>
            </div>
        </div>
    </div>
</div>

{{-- Search Card --}}
<div class="bh-card mb-4">
    <div class="bh-card-body p-3">
        <form method="GET" action="{{ route('dashboard.categories') }}" class="row g-2 align-items-center">
            <div class="col-12 col-md-10">
                <div class="input-group">
                    <span class="input-group-text bg-white border-end-0">
                        <i class="fa-solid fa-search text-muted"></i>
                    </span>
                    <input type="text" name="search" value="{{ request('search') }}"
                           class="form-control border-start-0 ps-0"
                           placeholder="Search categories by name or description...">
                </div>
            </div>
            <div class="col-12 col-md-2 d-flex gap-2">
                <button type="submit" class="bh-btn bh-btn-primary w-100 justify-content-center">
                    <i class="fa-solid fa-filter me-1"></i> Filter
                </button>
                <a href="{{ route('dashboard.categories') }}" class="bh-btn bh-btn-ghost" title="Reset">
                    <i class="fa-solid fa-arrow-rotate-left"></i>
                </a>
            </div>
        </form>
    </div>
</div>

{{-- Categories Table --}}
<div class="bh-card">
    <div class="bh-card-header">
        <h2 class="bh-card-title"><i class="fa-solid fa-list me-2" style="color:var(--brand);"></i> Category List</h2>
        <span class="text-muted small">Showing {{ $categories->firstItem() ?? 0 }} - {{ $categories->lastItem() ?? 0 }} of {{ $categories->total() }} categories</span>
    </div>

    <div class="table-responsive">
        <table class="bh-table">
            <thead>
                <tr>
                    <th>Category Name</th>
                    <th>Description</th>
                    <th>Number of Posts</th>
                    <th>Created Date</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($categories as $cat)
                <tr>
                    <td>
                        <div class="d-flex align-items-center gap-2">
                            <div style="width:34px; height:34px; border-radius:8px; background:{{ $cat->color ?? '#C8461F' }}1a; color:{{ $cat->color ?? '#C8461F' }}; display:flex; align-items:center; justify-content:center; flex-shrink:0;">
                                <i class="fa-solid {{ $cat->icon ?? 'fa-folder' }}"></i>
                            </div>
                            <div>
                                <span class="fw-semibold text-dark">{{ $cat->name }}</span>
                                <div class="text-muted small">/{{ $cat->slug }}</div>
                            </div>
                        </div>
                    </td>
                    <td class="text-muted small" style="max-width:300px;">
                        {{ $cat->description ? Str::limit($cat->description, 80) : '—' }}
                    </td>
                    <td>
                        <span class="bh-badge" style="background:#dbeafe; color:#1e40af;">
                            {{ $cat->total_posts ?? 0 }} posts
                        </span>
                    </td>
                    <td class="text-muted small">
                        {{ $cat->created_at ? $cat->created_at->format('M d, Y') : '—' }}
                    </td>
                    <td class="text-end">
                        <div class="d-inline-flex align-items-center gap-1">
                            {{-- View Category Articles --}}
                            <a href="{{ route('dashboard.all-articles', ['category' => $cat->id]) }}" class="bh-btn bh-btn-ghost bh-btn-icon bh-btn-sm" title="View Articles in Category">
                                <i class="fa-solid fa-newspaper"></i>
                            </a>

                            {{-- Edit Category Modal Trigger --}}
                            <button type="button" class="bh-btn bh-btn-ghost bh-btn-icon bh-btn-sm" title="Edit Category"
                                    onclick="editCategoryModal({{ json_encode($cat) }})">
                                <i class="fa-solid fa-pen"></i>
                            </button>

                            {{-- Delete Category --}}
                            <form action="{{ route('dashboard.categories.delete', $cat->id) }}" method="POST" class="d-inline"
                                  onsubmit="return confirm('Permanently delete category \"{{ addslashes($cat->name) }}\"?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bh-btn bh-btn-ghost bh-btn-icon bh-btn-sm text-danger" title="Delete Category">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center py-5 text-muted">
                        <i class="fa-solid fa-tags fa-2x mb-2 d-block text-secondary"></i>
                        No categories found. Create your first category above!
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($categories->hasPages())
    <div class="bh-card-body border-top p-3 d-flex justify-content-end">
        {{ $categories->links() }}
    </div>
    @endif
</div>

{{-- Create Category Modal --}}
<div class="modal fade" id="createCategoryModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <form action="{{ route('dashboard.categories.store') }}" method="POST" class="modal-content">
            @csrf
            <div class="modal-header">
                <h5 class="modal-title"><i class="fa-solid fa-plus me-2 text-primary"></i>Add New Category</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label fw-semibold">Category Name <span class="text-danger">*</span></label>
                    <input type="text" name="name" class="form-control" required placeholder="e.g. Artificial Intelligence">
                </div>
                <div class="row g-2 mb-3">
                    <div class="col-7">
                        <label class="form-label fw-semibold">FontAwesome Icon</label>
                        <input type="text" name="icon" class="form-control" placeholder="e.g. fa-robot" value="fa-folder">
                    </div>
                    <div class="col-5">
                        <label class="form-label fw-semibold">Accent Color</label>
                        <input type="color" name="color" class="form-control form-control-color w-100" value="#C8461F">
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-semibold">Description</label>
                    <textarea name="description" rows="3" class="form-control" placeholder="Brief description of this topic..."></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-primary btn-sm"><i class="fa-solid fa-check me-1"></i>Create Category</button>
            </div>
        </form>
    </div>
</div>

{{-- Edit Category Modal --}}
<div class="modal fade" id="editCategoryModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <form id="editCategoryForm" method="POST" class="modal-content">
            @csrf
            @method('PUT')
            <div class="modal-header">
                <h5 class="modal-title"><i class="fa-solid fa-pen-to-square me-2 text-primary"></i>Edit Category</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label fw-semibold">Category Name <span class="text-danger">*</span></label>
                    <input type="text" name="name" id="ecName" class="form-control" required>
                </div>
                <div class="row g-2 mb-3">
                    <div class="col-7">
                        <label class="form-label fw-semibold">FontAwesome Icon</label>
                        <input type="text" name="icon" id="ecIcon" class="form-control">
                    </div>
                    <div class="col-5">
                        <label class="form-label fw-semibold">Accent Color</label>
                        <input type="color" name="color" id="ecColor" class="form-control form-control-color w-100">
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-semibold">Description</label>
                    <textarea name="description" id="ecDesc" rows="3" class="form-control"></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-primary btn-sm"><i class="fa-solid fa-save me-1"></i>Save Changes</button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
function editCategoryModal(cat) {
    const form = document.getElementById('editCategoryForm');
    form.action = `/dashboard/categories/${cat.id}`;
    document.getElementById('ecName').value = cat.name;
    document.getElementById('ecIcon').value = cat.icon || 'fa-folder';
    document.getElementById('ecColor').value = cat.color || '#C8461F';
    document.getElementById('ecDesc').value = cat.description || '';
    new bootstrap.Modal(document.getElementById('editCategoryModal')).show();
}
</script>
@endpush

@endsection
