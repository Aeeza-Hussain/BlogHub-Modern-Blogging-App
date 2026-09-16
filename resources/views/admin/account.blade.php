@extends('layouts.admin')

@section('title', 'BlogHub - Author Account')

@section('content')
<h1 class="app-page-title"><i class="fa-solid fa-user-gear text-primary me-2"></i> Account &amp; Profile</h1>

<div class="row gy-4">
    <div class="col-12 col-lg-6">
        <div class="app-card app-card-account shadow-sm d-flex flex-column align-items-start h-100">
            <div class="app-card-header p-3 border-bottom-0">
                <div class="row align-items-center gx-3">
                    <div class="col-auto">
                        <div class="app-icon-holder bg-light text-primary">
                            <i class="fa-solid fa-user"></i>
                        </div>
                    </div>
                    <div class="col-auto">
                        <h4 class="app-card-title">Author Profile</h4>
                    </div>
                </div>
            </div>
            <div class="app-card-body px-4 w-100">
                <div class="item border-bottom py-3">
                    <div class="row justify-content-between align-items-center">
                        <div class="col-auto">
                            <div class="item-label mb-2"><strong>Avatar</strong></div>
                            <div class="item-data">
                                <img class="profile-image rounded-circle" src="{{ $author->avatar ?? 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=100' }}" style="width: 60px; height: 60px; object-fit: cover;" alt="Avatar">
                            </div>
                        </div>
                        <div class="col text-end">
                            <button class="btn-sm app-btn-secondary" disabled>Change</button>
                        </div>
                    </div>
                </div>
                
                <div class="item border-bottom py-3">
                    <div class="row justify-content-between align-items-center">
                        <div class="col-auto">
                            <div class="item-label"><strong>Name</strong></div>
                            <div class="item-data fw-bold">{{ $author->name ?? 'Sarah Jenkins' }}</div>
                        </div>
                        <div class="col text-end">
                            <button class="btn-sm app-btn-secondary" disabled>Edit</button>
                        </div>
                    </div>
                </div>

                <div class="item border-bottom py-3">
                    <div class="row justify-content-between align-items-center">
                        <div class="col-auto">
                            <div class="item-label"><strong>Role &amp; Specialty</strong></div>
                            <div class="item-data">{{ $author->specialty ?? 'Senior Tech Writer & Editor' }}</div>
                        </div>
                    </div>
                </div>

                <div class="item border-bottom py-3">
                    <div class="row justify-content-between align-items-center">
                        <div class="col-auto">
                            <div class="item-label"><strong>Bio</strong></div>
                            <div class="item-data text-muted">{{ $author->bio ?? 'Passionate software developer and technical communicator covering web frameworks, UI/UX, and cloud solutions.' }}</div>
                        </div>
                    </div>
                </div>

                <div class="item py-3">
                    <div class="row justify-content-between align-items-center">
                        <div class="col-auto">
                            <div class="item-label"><strong>Community Stats</strong></div>
                            <div class="item-data"><span class="badge bg-primary me-2">{{ $author->followers_count ?? 120 }} Followers</span> <span class="badge bg-secondary">{{ $author->following_count ?? 45 }} Following</span></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="app-card-footer p-4 mt-auto">
                <a class="btn app-btn-secondary" href="{{ route('authors.show', $author->slug ?? 'sarah-jenkins') }}" target="_blank">View Public Profile</a>
            </div>
        </div>
    </div>

    <div class="col-12 col-lg-6">
        <div class="app-card app-card-account shadow-sm d-flex flex-column align-items-start h-100">
            <div class="app-card-header p-3 border-bottom-0">
                <div class="row align-items-center gx-3">
                    <div class="col-auto">
                        <div class="app-icon-holder bg-light text-success">
                            <i class="fa-solid fa-shield-halved"></i>
                        </div>
                    </div>
                    <div class="col-auto">
                        <h4 class="app-card-title">Security &amp; Preferences</h4>
                    </div>
                </div>
            </div>
            <div class="app-card-body px-4 w-100">
                <div class="item border-bottom py-3">
                    <div class="row justify-content-between align-items-center">
                        <div class="col-auto">
                            <div class="item-label"><strong>Account Email</strong></div>
                            <div class="item-data">admin@bloghub.com</div>
                        </div>
                        <div class="col text-end">
                            <button class="btn-sm app-btn-secondary" disabled>Change</button>
                        </div>
                    </div>
                </div>

                <div class="item border-bottom py-3">
                    <div class="row justify-content-between align-items-center">
                        <div class="col-auto">
                            <div class="item-label"><strong>Password</strong></div>
                            <div class="item-data">••••••••••••</div>
                        </div>
                        <div class="col text-end">
                            <button class="btn-sm app-btn-secondary" disabled>Update</button>
                        </div>
                    </div>
                </div>

                <div class="item border-bottom py-3">
                    <div class="row justify-content-between align-items-center">
                        <div class="col-auto">
                            <div class="item-label"><strong>Two-Factor Auth</strong></div>
                            <div class="item-data text-success"><i class="fa-solid fa-circle-check me-1"></i> Enabled</div>
                        </div>
                    </div>
                </div>

                <div class="item py-3">
                    <div class="row justify-content-between align-items-center">
                        <div class="col-auto">
                            <div class="item-label"><strong>Notification Email Alerts</strong></div>
                            <div class="item-data">New comments, Contact messages</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="app-card-footer p-4 mt-auto">
                <a class="btn app-btn-secondary" href="{{ route('dashboard.settings') }}">Go to System Settings</a>
            </div>
        </div>
    </div>
</div>
@endsection
