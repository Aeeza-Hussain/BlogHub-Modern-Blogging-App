@extends('backend.layouts.admin')

@section('title', 'User Management — BlogHub Admin')

@section('content')
<div class="container-xl">

    {{-- Page Header --}}
    <div class="d-flex align-items-center justify-content-between mb-4 flex-wrap gap-2">
        <div>
            <h1 class="h3 fw-bold mb-1" style="color:#0f172a;">
                <i class="fa-solid fa-users-gear me-2" style="color:#C8461F;"></i> User Management
            </h1>
            <p class="text-muted small mb-0">View, search, promote/demote, and remove platform users.</p>
        </div>
    </div>

    {{-- Stats Row --}}
    <div class="row g-3 mb-4">
        <div class="col-6 col-md-4">
            <div class="card border-0 shadow-sm text-center py-3">
                <div class="fs-2 fw-bold" style="color:#C8461F;">{{ $totalAdmins }}</div>
                <div class="text-muted small">Admins</div>
            </div>
        </div>
        <div class="col-6 col-md-4">
            <div class="card border-0 shadow-sm text-center py-3">
                <div class="fs-2 fw-bold text-primary">{{ $totalAuthors }}</div>
                <div class="text-muted small">Authors</div>
            </div>
        </div>
        <div class="col-6 col-md-4">
            <div class="card border-0 shadow-sm text-center py-3">
                <div class="fs-2 fw-bold text-secondary">{{ $totalRegular }}</div>
                <div class="text-muted small">Regular Users</div>
            </div>
        </div>
    </div>

    {{-- Filters --}}
    <div class="card border-0 shadow-sm mb-4">
        <div class="card-body py-3">
            <form method="GET" action="{{ route('dashboard.users') }}" class="row g-2 align-items-center">
                <div class="col-12 col-md-6">
                    <div class="input-group">
                        <span class="input-group-text bg-white border-end-0">
                            <i class="fa-solid fa-search text-muted"></i>
                        </span>
                        <input type="text" name="search" value="{{ request('search') }}"
                            class="form-control border-start-0 ps-0"
                            placeholder="Search by name or email...">
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
                <div class="col-6 col-md-3 d-flex gap-2">
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fa-solid fa-filter me-1"></i> Filter
                    </button>
                    <a href="{{ route('dashboard.users') }}" class="btn btn-outline-secondary w-100">
                        Reset
                    </a>
                </div>
            </form>
        </div>
    </div>

    {{-- Users Table --}}
    <div class="card border-0 shadow-sm">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead style="background:#f8fafc; border-bottom:2px solid #e2e8f0;">
                        <tr>
                            <th class="py-3 ps-4" style="font-size:0.78rem; text-transform:uppercase; letter-spacing:.05em; color:#64748b;">#</th>
                            <th class="py-3" style="font-size:0.78rem; text-transform:uppercase; letter-spacing:.05em; color:#64748b;">User</th>
                            <th class="py-3" style="font-size:0.78rem; text-transform:uppercase; letter-spacing:.05em; color:#64748b;">Email</th>
                            <th class="py-3" style="font-size:0.78rem; text-transform:uppercase; letter-spacing:.05em; color:#64748b;">Role</th>
                            <th class="py-3" style="font-size:0.78rem; text-transform:uppercase; letter-spacing:.05em; color:#64748b;">Joined</th>
                            <th class="py-3 pe-4" style="font-size:0.78rem; text-transform:uppercase; letter-spacing:.05em; color:#64748b;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $user)
                        <tr class="{{ $user->id === auth()->id() ? 'table-warning' : '' }}">
                            <td class="ps-4 text-muted small">{{ $user->id }}</td>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <img src="{{ $user->image
                                        ? asset('storage/' . $user->image)
                                        : 'https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&background=C8461F&color=ffffff&bold=true' }}"
                                        alt="{{ $user->name }}"
                                        class="rounded-circle"
                                        style="width:38px; height:38px; object-fit:cover;">
                                    <div>
                                        <div class="fw-semibold" style="font-size:0.9rem; color:#0f172a;">
                                            {{ $user->name }}
                                            @if($user->id === auth()->id())
                                                <span class="badge ms-1" style="background:#f59e0b; font-size:0.6rem;">You</span>
                                            @endif
                                        </div>
                                        @if($user->niche)
                                            <div class="text-muted" style="font-size:0.75rem;">{{ $user->niche }}</div>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td class="text-muted small">{{ $user->email }}</td>
                            <td>
                                @if($user->user_type == 1)
                                    <span class="badge" style="background:rgba(200,70,31,0.12); color:#C8461F; font-weight:600;">
                                        <i class="fa-solid fa-shield-halved me-1"></i> Admin
                                    </span>
                                @elseif($user->user_type == 2)
                                    <span class="badge" style="background:rgba(37,99,235,0.12); color:#2563EB; font-weight:600;">
                                        <i class="fa-solid fa-pen-nib me-1"></i> Author
                                    </span>
                                @else
                                    <span class="badge" style="background:rgba(100,116,139,0.12); color:#64748b; font-weight:600;">
                                        <i class="fa-solid fa-user me-1"></i> User
                                    </span>
                                @endif
                            </td>
                            <td class="text-muted small">{{ $user->created_at->format('M d, Y') }}</td>
                            <td class="pe-4">
                                @if($user->id !== auth()->id())
                                <div class="d-flex gap-2 align-items-center">

                                    {{-- Change Role Dropdown --}}
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button"
                                            data-bs-toggle="dropdown" title="Change Role"
                                            style="font-size:0.78rem; padding:3px 8px;">
                                            <i class="fa-solid fa-user-gear"></i>
                                        </button>
                                        <ul class="dropdown-menu shadow-sm border-0">
                                            <li><h6 class="dropdown-header">Change Role</h6></li>
                                            @foreach([0 => ['label'=>'Regular User','icon'=>'fa-user','color'=>'text-secondary'],
                                                       1 => ['label'=>'Admin','icon'=>'fa-shield-halved','color'=>'text-danger'],
                                                       2 => ['label'=>'Author','icon'=>'fa-pen-nib','color'=>'text-primary']]
                                                       as $typeValue => $meta)
                                                <li>
                                                    <form method="POST" action="{{ route('dashboard.users.type', $user->id) }}">
                                                        @csrf
                                                        @method('PUT')
                                                        <input type="hidden" name="user_type" value="{{ $typeValue }}">
                                                        <button type="submit"
                                                            class="dropdown-item {{ $user->user_type == $typeValue ? 'active' : '' }}"
                                                            {{ $user->user_type == $typeValue ? 'disabled' : '' }}>
                                                            <i class="fa-solid {{ $meta['icon'] }} me-2 {{ $meta['color'] }}"></i>
                                                            {{ $meta['label'] }}
                                                            @if($user->user_type == $typeValue)
                                                                <i class="fa-solid fa-check ms-1 text-success" style="font-size:0.7rem;"></i>
                                                            @endif
                                                        </button>
                                                    </form>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>

                                    {{-- Delete User --}}
                                    <form method="POST" action="{{ route('dashboard.users.delete', $user->id) }}"
                                        onsubmit="return confirm('Delete {{ addslashes($user->name) }}? This cannot be undone.')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger" title="Delete User"
                                            style="font-size:0.78rem; padding:3px 8px;">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </form>

                                </div>
                                @else
                                    <span class="text-muted small">—</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-5 text-muted">
                                <i class="fa-solid fa-users fa-2x mb-2 d-block opacity-25"></i>
                                No users found.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        {{-- Pagination --}}
        @if($users->hasPages())
        <div class="card-footer bg-white border-top d-flex justify-content-between align-items-center py-3 px-4">
            <div class="text-muted small">
                Showing {{ $users->firstItem() }}–{{ $users->lastItem() }} of {{ $users->total() }} users
            </div>
            {{ $users->links() }}
        </div>
        @endif
    </div>

</div>
@endsection
