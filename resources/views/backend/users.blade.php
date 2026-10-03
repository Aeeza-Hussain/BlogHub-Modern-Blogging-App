@extends('backend.layouts.admin')

@section('title', 'User Management — BlogHub Admin')

@section('content')

{{-- Page Header --}}
<div class="bh-page-header">
    <div>
        <h1 class="bh-page-title"><i class="fa-solid fa-users text-primary me-2"></i>User Management</h1>
        <p class="bh-page-sub">View, search, filter, edit details, activate/deactivate, and manage roles for all registered accounts.</p>
    </div>
</div>

{{-- Stats Row --}}
<div class="row g-3 mb-4">
    <div class="col-6 col-md-3">
        <div class="bh-stat">
            <div class="bh-stat-icon" style="background:rgba(59,130,246,0.1); color:#3b82f6;">
                <i class="fa-solid fa-users"></i>
            </div>
            <div>
                <div class="bh-stat-num">{{ number_format($totalUsers) }}</div>
                <div class="bh-stat-label">Total Accounts</div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="bh-stat">
            <div class="bh-stat-icon" style="background:rgba(16,185,129,0.1); color:#10b981;">
                <i class="fa-solid fa-user-check"></i>
            </div>
            <div>
                <div class="bh-stat-num">{{ number_format($activeUsers) }}</div>
                <div class="bh-stat-label">Active Users</div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="bh-stat">
            <div class="bh-stat-icon" style="background:rgba(168,85,247,0.1); color:#a855f7;">
                <i class="fa-solid fa-feather"></i>
            </div>
            <div>
                <div class="bh-stat-num">{{ number_format($totalAuthors) }}</div>
                <div class="bh-stat-label">Authors</div>
            </div>
        </div>
    </div>
    <div class="col-6 col-md-3">
        <div class="bh-stat">
            <div class="bh-stat-icon" style="background:rgba(200,70,31,0.1); color:#C8461F;">
                <i class="fa-solid fa-shield-halved"></i>
            </div>
            <div>
                <div class="bh-stat-num">{{ number_format($totalAdmins) }}</div>
                <div class="bh-stat-label">Administrators</div>
            </div>
        </div>
    </div>
</div>

{{-- Filters Card --}}
<div class="bh-card mb-4">
    <div class="bh-card-body p-3">
        <form method="GET" action="{{ route('dashboard.users') }}" class="row g-2 align-items-center">
            <div class="col-12 col-md-5">
                <div class="input-group">
                    <span class="input-group-text bg-white border-end-0">
                        <i class="fa-solid fa-search text-muted"></i>
                    </span>
                    <input type="text" name="search" value="{{ request('search') }}"
                           class="form-control border-start-0 ps-0"
                           placeholder="Search users by name, email, or contact...">
                </div>
            </div>
            <div class="col-6 col-md-3">
                <select name="role" class="form-select">
                    <option value="all" {{ request('role','all') == 'all' ? 'selected' : '' }}>All Roles</option>
                    <option value="1" {{ request('role') == '1' ? 'selected' : '' }}>Admin</option>
                    <option value="2" {{ request('role') == '2' ? 'selected' : '' }}>Author</option>
                    <option value="0" {{ request('role') == '0' ? 'selected' : '' }}>Regular User</option>
                </select>
            </div>
            <div class="col-6 col-md-2">
                <select name="status" class="form-select">
                    <option value="all" {{ request('status','all') == 'all' ? 'selected' : '' }}>All Status</option>
                    <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                    <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive / Suspended</option>
                </select>
            </div>
            <div class="col-12 col-md-2 d-flex gap-2">
                <button type="submit" class="bh-btn bh-btn-primary w-100 justify-content-center">
                    <i class="fa-solid fa-filter me-1"></i> Filter
                </button>
                <a href="{{ route('dashboard.users') }}" class="bh-btn bh-btn-ghost" title="Reset Filters">
                    <i class="fa-solid fa-arrow-rotate-left"></i>
                </a>
            </div>
        </form>
    </div>
</div>

{{-- Users Table --}}
<div class="bh-card">
    <div class="bh-card-header">
        <h2 class="bh-card-title"><i class="fa-solid fa-list me-2" style="color:var(--brand);"></i> Registered Users</h2>
        <span class="text-muted small">Showing {{ $users->firstItem() ?? 0 }} - {{ $users->lastItem() ?? 0 }} of {{ $users->total() }} accounts</span>
    </div>

    <div class="table-responsive">
        <table class="bh-table">
            <thead>
                <tr>
                    <th>User</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Status</th>
                    <th>Registration Date</th>
                    <th class="text-end">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                <tr class="{{ $user->id === auth()->id() ? 'table-warning' : '' }}">
                    <td>
                        <div class="d-flex align-items-center gap-2">
                            <img src="{{ $user->image ? asset('storage/' . $user->image) : 'https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&background=C8461F&color=ffffff&bold=true' }}"
                                 alt="{{ $user->name }}"
                                 style="width:36px; height:36px; border-radius:50%; object-fit:cover; flex-shrink:0;">
                            <div>
                                <div class="fw-semibold text-dark">
                                    {{ $user->name }}
                                    @if($user->id === auth()->id())
                                        <span class="badge ms-1" style="background:#f59e0b; font-size:0.62rem;">You</span>
                                    @endif
                                </div>
                                @if($user->contact)
                                    <span class="text-muted small">{{ $user->contact }}</span>
                                @endif
                            </div>
                        </div>
                    </td>
                    <td class="text-muted small">{{ $user->email }}</td>
                    <td>
                        @if($user->user_type == 1)
                            <span class="bh-badge" style="background:#fee2e2; color:#dc2626;">
                                <i class="fa-solid fa-shield-halved me-1"></i> Admin
                            </span>
                        @elseif($user->user_type == 2)
                            <span class="bh-badge" style="background:#dbeafe; color:#2563eb;">
                                <i class="fa-solid fa-feather me-1"></i> Author
                            </span>
                        @else
                            <span class="bh-badge" style="background:#f3f4f6; color:#4b5563;">
                                <i class="fa-solid fa-user me-1"></i> User
                            </span>
                        @endif
                    </td>
                    <td>
                        @if($user->is_active ?? true)
                            <span class="bh-badge" style="background:#dcfce7; color:#15803d;">
                                <i class="fa-solid fa-circle-check me-1"></i> Active
                            </span>
                        @else
                            <span class="bh-badge" style="background:#fee2e2; color:#b91c1c;">
                                <i class="fa-solid fa-ban me-1"></i> Inactive
                            </span>
                        @endif
                    </td>
                    <td class="text-muted small">{{ $user->created_at->format('M d, Y') }}</td>
                    <td class="text-end">
                        <div class="d-inline-flex align-items-center gap-1">
                            {{-- View details modal trigger --}}
                            <button type="button" class="bh-btn bh-btn-ghost bh-btn-icon bh-btn-sm" title="View details"
                                    onclick="viewUserDetails({{ json_encode($user) }})">
                                <i class="fa-solid fa-eye"></i>
                            </button>

                            @if($user->id !== auth()->id())
                            {{-- Edit modal trigger --}}
                            <button type="button" class="bh-btn bh-btn-ghost bh-btn-icon bh-btn-sm" title="Edit user"
                                    onclick="editUserModal({{ json_encode($user) }})">
                                <i class="fa-solid fa-pen"></i>
                            </button>

                            {{-- Activate / Deactivate Toggle --}}
                            <form action="{{ route('dashboard.users.toggle-status', $user->id) }}" method="POST" class="d-inline"
                                  onsubmit="return confirm('Are you sure you want to {{ ($user->is_active ?? true) ? 'deactivate' : 'activate' }} this user?');">
                                @csrf
                                <button type="submit" class="bh-btn bh-btn-icon bh-btn-sm {{ ($user->is_active ?? true) ? 'text-warning' : 'text-success' }}"
                                        title="{{ ($user->is_active ?? true) ? 'Deactivate account' : 'Activate account' }}">
                                    <i class="fa-solid {{ ($user->is_active ?? true) ? 'fa-user-slash' : 'fa-user-check' }}"></i>
                                </button>
                            </form>

                            {{-- Delete Form --}}
                            <form action="{{ route('dashboard.users.delete', $user->id) }}" method="POST" class="d-inline"
                                  onsubmit="return confirm('Permanently delete {{ addslashes($user->name) }}? This cannot be undone.');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bh-btn bh-btn-ghost bh-btn-icon bh-btn-sm text-danger" title="Delete user">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </form>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center py-5 text-muted">
                        <i class="fa-solid fa-users fa-2x mb-2 d-block text-secondary"></i>
                        No users found matching your search.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($users->hasPages())
    <div class="bh-card-body border-top p-3 d-flex justify-content-end">
        {{ $users->links() }}
    </div>
    @endif
</div>

{{-- View User Modal --}}
<div class="modal fade" id="viewUserModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><i class="fa-solid fa-user me-2 text-primary"></i>User Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="text-center mb-3">
                    <img id="vAvatar" src="" alt="Avatar" style="width:72px; height:72px; border-radius:50%; object-fit:cover;" class="border shadow-sm mb-2">
                    <h5 id="vName" class="mb-0 fw-bold"></h5>
                    <span id="vRoleBadge" class="bh-badge mt-1"></span>
                </div>
                <div class="list-group list-group-flush small">
                    <div class="list-group-item d-flex justify-content-between px-0">
                        <span class="text-muted">Email:</span>
                        <strong id="vEmail"></strong>
                    </div>
                    <div class="list-group-item d-flex justify-content-between px-0">
                        <span class="text-muted">Contact:</span>
                        <span id="vContact">None</span>
                    </div>
                    <div class="list-group-item d-flex justify-content-between px-0">
                        <span class="text-muted">Status:</span>
                        <span id="vStatus"></span>
                    </div>
                    <div class="list-group-item d-flex justify-content-between px-0">
                        <span class="text-muted">Registered On:</span>
                        <span id="vJoined"></span>
                    </div>
                    <div class="list-group-item px-0">
                        <span class="text-muted d-block mb-1">About / Bio:</span>
                        <p id="vAbout" class="mb-0 text-dark bg-light p-2 rounded"></p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

{{-- Edit User Modal --}}
<div class="modal fade" id="editUserModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <form id="editUserForm" method="POST" class="modal-content">
            @csrf
            @method('PUT')
            <div class="modal-header">
                <h5 class="modal-title"><i class="fa-solid fa-pen-to-square me-2 text-primary"></i>Edit User Information</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label fw-semibold">Full Name</label>
                    <input type="text" name="name" id="eName" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-semibold">Email Address</label>
                    <input type="email" name="email" id="eEmail" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label fw-semibold">Contact / Phone</label>
                    <input type="text" name="contact" id="eContact" class="form-control">
                </div>
                <div class="row g-2 mb-3">
                    <div class="col-6">
                        <label class="form-label fw-semibold">Role</label>
                        <select name="user_type" id="eRole" class="form-select" required>
                            <option value="0">Regular User</option>
                            <option value="2">Author</option>
                            <option value="1">Admin</option>
                        </select>
                    </div>
                    <div class="col-6">
                        <label class="form-label fw-semibold">Account Status</label>
                        <select name="is_active" id="eStatus" class="form-select">
                            <option value="1">Active</option>
                            <option value="0">Inactive / Suspended</option>
                        </select>
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
function viewUserDetails(user) {
    document.getElementById('vName').innerText = user.name;
    document.getElementById('vEmail').innerText = user.email;
    document.getElementById('vContact').innerText = user.contact || 'Not provided';
    document.getElementById('vAbout').innerText = user.about || 'No description provided.';
    document.getElementById('vJoined').innerText = new Date(user.created_at).toLocaleDateString('en-US', { year:'numeric', month:'short', day:'numeric' });
    document.getElementById('vAvatar').src = user.image ? `/storage/${user.image}` : `https://ui-avatars.com/api/?name=${encodeURIComponent(user.name)}&background=C8461F&color=ffffff&bold=true`;

    const badge = document.getElementById('vRoleBadge');
    if (user.user_type == 1) {
        badge.innerText = 'Admin';
        badge.style.background = '#fee2e2'; badge.style.color = '#dc2626';
    } else if (user.user_type == 2) {
        badge.innerText = 'Author';
        badge.style.background = '#dbeafe'; badge.style.color = '#2563eb';
    } else {
        badge.innerText = 'User';
        badge.style.background = '#f3f4f6'; badge.style.color = '#4b5563';
    }

    const st = document.getElementById('vStatus');
    st.innerHTML = (user.is_active ?? true) ? '<span class="text-success fw-bold">Active</span>' : '<span class="text-danger fw-bold">Inactive</span>';

    new bootstrap.Modal(document.getElementById('viewUserModal')).show();
}

function editUserModal(user) {
    const form = document.getElementById('editUserForm');
    form.action = `/dashboard/users/${user.id}`;
    document.getElementById('eName').value = user.name;
    document.getElementById('eEmail').value = user.email;
    document.getElementById('eContact').value = user.contact || '';
    document.getElementById('eRole').value = user.user_type;
    document.getElementById('eStatus').value = (user.is_active ?? true) ? 1 : 0;
    new bootstrap.Modal(document.getElementById('editUserModal')).show();
}
</script>
@endpush

@endsection
