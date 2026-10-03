@extends('backend.layouts.admin')

@section('title', 'Author Management — BlogHub Admin')

@section('content')

{{-- Page Header --}}
<div class="bh-page-header">
    <div>
        <h1 class="bh-page-title"><i class="fa-solid fa-feather text-primary me-2"></i>Author Management</h1>
        <p class="bh-page-sub">Oversee content creators, view their editorial output, edit profiles, and regulate publishing access.</p>
    </div>
    <div>
        <button type="button" class="bh-btn bh-btn-primary" data-bs-toggle="modal" data-bs-target="#createAuthorModal">
            <i class="fa-solid fa-plus me-1"></i> Add New Author
        </button>
    </div>
</div>

{{-- Stats Row --}}
<div class="row g-3 mb-4">
    <div class="col-6 col-md-4">
        <div class="bh-stat">
            <div class="bh-stat-icon" style="background:rgba(168,85,247,0.1); color:#a855f7;">
                <i class="fa-solid fa-feather"></i>
            </div>
            <div>
                <div class="bh-stat-num">{{ number_format($totalAuthors) }}</div>
                <div class="bh-stat-label">Total Authors</div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-4">
        <div class="bh-stat">
            <div class="bh-stat-icon" style="background:rgba(16,185,129,0.1); color:#10b981;">
                <i class="fa-solid fa-circle-check"></i>
            </div>
            <div>
                <div class="bh-stat-num">{{ number_format($activeAuthors) }}</div>
                <div class="bh-stat-label">Active Authors</div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-4">
        <div class="bh-stat">
            <div class="bh-stat-icon" style="background:rgba(239,68,68,0.1); color:#ef4444;">
                <i class="fa-solid fa-ban"></i>
            </div>
            <div>
                <div class="bh-stat-num">{{ number_format($inactiveAuthors) }}</div>
                <div class="bh-stat-label">Inactive Authors</div>
            </div>
        </div>
    </div>
</div>

{{-- Search & Filter Card --}}
<div class="bh-card mb-4">
    <div class="bh-card-body p-3">
        <form method="GET" action="{{ route('dashboard.authors') }}" class="row g-2 align-items-center">
            <div class="col-12 col-md-7">
                <div class="input-group">
                    <span class="input-group-text bg-white border-end-0">
                        <i class="fa-solid fa-search text-muted"></i>
                    </span>
                    <input type="text" name="search" value="{{ request('search') }}"
                           class="form-control border-start-0 ps-0"
                           placeholder="Search authors by name, specialty, bio, or email...">
                </div>
            </div>
            <div class="col-6 col-md-3">
                <select name="status" class="form-select">
                    <option value="all" {{ request('status','all') == 'all' ? 'selected' : '' }}>All Status</option>
                    <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                    <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive / Suspended</option>
                </select>
            </div>
            <div class="col-6 col-md-2 d-flex gap-2">
                <button type="submit" class="bh-btn bh-btn-primary w-100 justify-content-center">
                    <i class="fa-solid fa-filter me-1"></i> Filter
                </button>
                <a href="{{ route('dashboard.authors') }}" class="bh-btn bh-btn-ghost" title="Reset">
                    <i class="fa-solid fa-arrow-rotate-left"></i>
                </a>
            </div>
        </form>
    </div>
</div>

{{-- Authors Table --}}
<div class="bh-card">
    <div class="bh-card-header">
        <h2 class="bh-card-title"><i class="fa-solid fa-list me-2" style="color:var(--brand);"></i> Registered Authors</h2>
        <span class="text-muted small">Showing {{ $authors->firstItem() ?? 0 }} - {{ $authors->lastItem() ?? 0 }} of {{ $authors->total() }} authors</span>
    </div>

    <div class="table-responsive">
        <table class="bh-table">
            <thead>
                <tr>
                    <th>Author Name</th>
                    <th>Email</th>
                    <th>Total Posts</th>
                    <th>Published</th>
                    <th>Drafts</th>
                    <th>Status</th>
                    <th>Joined Date</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($authors as $author)
                <tr>
                    <td>
                        <div class="d-flex align-items-center gap-2">
                            <img src="{{ $author->avatar ?? 'https://ui-avatars.com/api/?name=' . urlencode($author->name) . '&background=C8461F&color=ffffff&bold=true' }}"
                                 alt="{{ $author->name }}"
                                 style="width:38px; height:38px; border-radius:50%; object-fit:cover; flex-shrink:0;">
                            <div>
                                <a href="{{ route('authors.show', $author->slug) }}" target="_blank" class="fw-semibold text-dark text-decoration-none">
                                    {{ $author->name }}
                                </a>
                                <div class="text-muted small">{{ $author->specialty ?? 'Author' }}</div>
                            </div>
                        </div>
                    </td>
                    <td class="text-muted small">
                        {{ $author->user?->email ?? 'N/A' }}
                    </td>
                    <td>
                        <span class="badge bg-light text-dark border fw-bold">
                            {{ $author->total_posts ?? 0 }}
                        </span>
                    </td>
                    <td>
                        <span class="bh-badge" style="background:#dcfce7; color:#15803d;">
                            {{ $author->published_posts ?? 0 }}
                        </span>
                    </td>
                    <td>
                        <span class="bh-badge" style="background:#f3f4f6; color:#4b5563;">
                            {{ $author->draft_posts ?? 0 }}
                        </span>
                    </td>
                    <td>
                        @if($author->is_active ?? true)
                            <span class="bh-badge" style="background:#dcfce7; color:#15803d;">
                                <i class="fa-solid fa-circle-check me-1"></i> Active
                            </span>
                        @else
                            <span class="bh-badge" style="background:#fee2e2; color:#b91c1c;">
                                <i class="fa-solid fa-ban me-1"></i> Inactive
                            </span>
                        @endif
                    </td>
                    <td class="text-muted small">
                        {{ $author->created_at->format('M d, Y') }}
                    </td>
                    <td class="text-end">
                        <div class="d-inline-flex align-items-center gap-1">
                            {{-- View public profile --}}
                            <a href="{{ route('authors.show', $author->slug) }}" target="_blank" class="bh-btn bh-btn-ghost bh-btn-icon bh-btn-sm" title="View Public Profile">
                                <i class="fa-solid fa-arrow-up-right-from-square"></i>
                            </a>

                            {{-- View author's posts --}}
                            <a href="{{ route('dashboard.all-articles', ['author' => $author->id]) }}" class="bh-btn bh-btn-ghost bh-btn-icon bh-btn-sm" title="View Author's Posts">
                                <i class="fa-solid fa-file-lines"></i>
                            </a>

                            {{-- Edit Author Modal Trigger --}}
                            <button type="button" class="bh-btn bh-btn-ghost bh-btn-icon bh-btn-sm" title="Edit Author Info"
                                    onclick="editAuthorModal({{ json_encode($author) }})">
                                <i class="fa-solid fa-pen"></i>
                            </button>

                            {{-- Activate / Deactivate status toggle --}}
                            <form action="{{ route('dashboard.authors.toggle-status', $author->id) }}" method="POST" class="d-inline"
                                  onsubmit="return confirm('Are you sure you want to {{ ($author->is_active ?? true) ? 'deactivate' : 'activate' }} this author?');">
                                @csrf
                                <button type="submit" class="bh-btn bh-btn-icon bh-btn-sm {{ ($author->is_active ?? true) ? 'text-warning' : 'text-success' }}"
                                        title="{{ ($author->is_active ?? true) ? 'Deactivate author' : 'Activate author' }}">
                                    <i class="fa-solid {{ ($author->is_active ?? true) ? 'fa-user-slash' : 'fa-user-check' }}"></i>
                                </button>
                            </form>

                            {{-- Delete author account --}}
                            <form action="{{ route('dashboard.authors.delete', $author->id) }}" method="POST" class="d-inline"
                                  onsubmit="return confirm('Permanently remove {{ addslashes($author->name) }} as an author? This will not delete their articles.');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bh-btn bh-btn-ghost bh-btn-icon bh-btn-sm text-danger" title="Delete Author">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="text-center py-5 text-muted">
                        <i class="fa-solid fa-feather fa-2x mb-2 d-block text-secondary"></i>
                        No authors found matching your criteria.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($authors->hasPages())
    <div class="bh-card-body border-top p-3 d-flex justify-content-end">
        {{ $authors->links() }}
    </div>
    @endif
</div>

{{-- Create Author Modal --}}
<div class="modal fade" id="createAuthorModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <form action="{{ route('dashboard.authors.store') }}" method="POST" enctype="multipart/form-data" class="modal-content">
            @csrf
            <div class="modal-header">
                <h5 class="modal-title"><i class="fa-solid fa-plus me-2 text-primary"></i>Add New Author</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Author Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control" required placeholder="e.g. Dr. Jane Smith">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Specialty / Role</label>
                        <input type="text" name="specialty" class="form-control" placeholder="e.g. Senior Tech Editor">
                    </div>
                    <div class="col-12">
                        <label class="form-label fw-semibold">Tagline</label>
                        <input type="text" name="tagline" class="form-control" placeholder="A brief one-line catchphrase">
                    </div>
                    <div class="col-12">
                        <label class="form-label fw-semibold">Biography</label>
                        <textarea name="bio" rows="3" class="form-control" placeholder="Detailed bio describing experience and interests..."></textarea>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Avatar Image</label>
                        <input type="file" name="avatar_file" class="form-control" accept="image/*">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Or Avatar Image URL</label>
                        <input type="url" name="avatar_url" class="form-control" placeholder="https://...">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Twitter / X URL</label>
                        <input type="url" name="twitter" class="form-control" placeholder="https://x.com/username">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">LinkedIn URL</label>
                        <input type="url" name="linkedin" class="form-control" placeholder="https://linkedin.com/in/username">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">GitHub URL</label>
                        <input type="url" name="github" class="form-control" placeholder="https://github.com/username">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Personal Website / Portfolio</label>
                        <input type="url" name="website" class="form-control" placeholder="https://mywebsite.com">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-primary btn-sm"><i class="fa-solid fa-check me-1"></i>Create Author</button>
            </div>
        </form>
    </div>
</div>

{{-- Edit Author Modal --}}
<div class="modal fade" id="editAuthorModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <form id="editAuthorForm" method="POST" enctype="multipart/form-data" class="modal-content">
            @csrf
            @method('PUT')
            <div class="modal-header">
                <h5 class="modal-title"><i class="fa-solid fa-pen-to-square me-2 text-primary"></i>Edit Author Information</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Author Name <span class="text-danger">*</span></label>
                        <input type="text" name="name" id="eaName" class="form-control" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Specialty / Role</label>
                        <input type="text" name="specialty" id="eaSpecialty" class="form-control">
                    </div>
                    <div class="col-12">
                        <label class="form-label fw-semibold">Tagline</label>
                        <input type="text" name="tagline" id="eaTagline" class="form-control">
                    </div>
                    <div class="col-12">
                        <label class="form-label fw-semibold">Biography</label>
                        <textarea name="bio" id="eaBio" rows="3" class="form-control"></textarea>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Change Avatar Image</label>
                        <input type="file" name="avatar_file" class="form-control" accept="image/*">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Or Avatar URL</label>
                        <input type="url" name="avatar_url" id="eaAvatarUrl" class="form-control">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Twitter / X URL</label>
                        <input type="url" name="twitter" id="eaTwitter" class="form-control">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">LinkedIn URL</label>
                        <input type="url" name="linkedin" id="eaLinkedin" class="form-control">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">GitHub URL</label>
                        <input type="url" name="github" id="eaGithub" class="form-control">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">Personal Website / Portfolio</label>
                        <input type="url" name="website" id="eaWebsite" class="form-control">
                    </div>
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
function editAuthorModal(author) {
    const form = document.getElementById('editAuthorForm');
    form.action = `/dashboard/authors/${author.id}`;
    document.getElementById('eaName').value = author.name;
    document.getElementById('eaSpecialty').value = author.specialty || '';
    document.getElementById('eaTagline').value = author.tagline || '';
    document.getElementById('eaBio').value = author.bio || '';
    document.getElementById('eaTwitter').value = author.twitter || '';
    document.getElementById('eaLinkedin').value = author.linkedin || '';
    document.getElementById('eaGithub').value = author.github || '';
    document.getElementById('eaWebsite').value = author.website || '';
    new bootstrap.Modal(document.getElementById('editAuthorModal')).show();
}
</script>
@endpush

@endsection
