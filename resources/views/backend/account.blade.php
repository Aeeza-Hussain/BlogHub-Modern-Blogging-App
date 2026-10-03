@extends('backend.layouts.admin')

@section('title', auth()->user()->isAdmin() ? 'Admin Profile — BlogHub' : 'Author Profile — Creator Studio')

@section('content')

{{-- Page Header --}}
<div class="bh-page-header">
    <div>
        <h1 class="bh-page-title">
            <i class="fa-solid fa-circle-user text-primary me-2"></i>
            {{ auth()->user()->isAdmin() ? 'Admin Profile & Security' : 'My Author Profile & Settings' }}
        </h1>
        <p class="bh-page-sub">
            @if(auth()->user()->isAdmin())
                Update your administrative credentials, personal details, and platform security password.
            @else
                Manage your public byline, biography, avatar, social media links, and account security.
            @endif
        </p>
    </div>
    @if(isset($author) && $author->slug)
    <div>
        <a href="{{ route('authors.show', $author->slug) }}" target="_blank" class="bh-btn bh-btn-ghost">
            <i class="fa-solid fa-arrow-up-right-from-square me-1"></i> View Live Author Page
        </a>
    </div>
    @endif
</div>

<div class="row g-4">
    {{-- Left: Edit Forms --}}
    <div class="col-12 col-lg-7">
        {{-- Profile Information Card --}}
        <div class="bh-card mb-4">
            <div class="bh-card-header">
                <h2 class="bh-card-title"><i class="fa-solid fa-id-card me-2" style="color:var(--brand);"></i> Profile Information</h2>
            </div>
            <div class="bh-card-body p-4">
                <form action="{{ route('dashboard.account.profile') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    {{-- Avatar Preview & Upload --}}
                    <div class="d-flex align-items-center gap-3 mb-4 pb-3 border-bottom">
                        <img id="avatarPreview"
                             src="{{ auth()->user()->image ? asset('storage/' . auth()->user()->image) : ($author->avatar ?? 'https://ui-avatars.com/api/?name=' . urlencode(auth()->user()->name) . '&background=C8461F&color=fff&bold=true') }}"
                             alt="{{ auth()->user()->name }}"
                             style="width:68px; height:68px; border-radius:50%; object-fit:cover;" class="border shadow-sm">
                        <div>
                            <label class="form-label fw-semibold small mb-1">Profile Picture</label>
                            <input type="file" name="avatar" class="form-control form-control-sm" accept="image/*"
                                   onchange="document.getElementById('avatarPreview').src = window.URL.createObjectURL(this.files[0])">
                            <span class="text-muted small" style="font-size:0.75rem;">Supported: JPG, PNG, WebP (Max 3MB)</span>
                        </div>
                    </div>

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Full Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control" value="{{ old('name', auth()->user()->name) }}" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Email Address <span class="text-danger">*</span></label>
                            <input type="email" name="email" class="form-control" value="{{ old('email', auth()->user()->email) }}" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Phone / Contact</label>
                            <input type="text" name="contact" class="form-control" value="{{ old('contact', auth()->user()->contact) }}" placeholder="+1 234 567 8900">
                        </div>

                        @if(!auth()->user()->isAdmin())
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Specialty / Title</label>
                            <input type="text" name="specialty" class="form-control" value="{{ old('specialty', $author->specialty ?? '') }}" placeholder="e.g. Senior Tech Writer &amp; AI Researcher">
                        </div>
                        @endif

                        <div class="col-12">
                            <label class="form-label fw-semibold">Bio / About Me</label>
                            <textarea name="about" rows="3" class="form-control" placeholder="Share a few words about your background and writing focus...">{{ old('about', auth()->user()->about ?? ($author->bio ?? '')) }}</textarea>
                        </div>

                        {{-- Social Links for Authors --}}
                        @if(!auth()->user()->isAdmin())
                        <div class="col-12 mt-3">
                            <h6 class="fw-bold text-dark border-bottom pb-2 mb-3">
                                <i class="fa-solid fa-share-nodes text-primary me-2"></i>Social Media Links
                            </h6>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold small"><i class="fa-brands fa-x-twitter me-1"></i> Twitter / X Profile</label>
                            <input type="url" name="twitter" class="form-control form-control-sm" value="{{ old('twitter', $author->twitter ?? '') }}" placeholder="https://x.com/username">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold small"><i class="fa-brands fa-linkedin me-1 text-primary"></i> LinkedIn Profile</label>
                            <input type="url" name="linkedin" class="form-control form-control-sm" value="{{ old('linkedin', $author->linkedin ?? '') }}" placeholder="https://linkedin.com/in/username">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold small"><i class="fa-brands fa-github me-1"></i> GitHub Profile</label>
                            <input type="url" name="github" class="form-control form-control-sm" value="{{ old('github', $author->github ?? '') }}" placeholder="https://github.com/username">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold small"><i class="fa-solid fa-globe me-1 text-success"></i> Portfolio / Website</label>
                            <input type="url" name="website" class="form-control form-control-sm" value="{{ old('website', $author->website ?? '') }}" placeholder="https://yourwebsite.com">
                        </div>
                        @endif

                        <div class="col-12 text-end mt-4">
                            <button type="submit" class="bh-btn bh-btn-primary">
                                <i class="fa-solid fa-save me-1"></i> Save Profile Details
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        {{-- Change Password Card --}}
        <div class="bh-card mb-4">
            <div class="bh-card-header">
                <h2 class="bh-card-title"><i class="fa-solid fa-lock me-2" style="color:#10b981;"></i> Change Password</h2>
            </div>
            <div class="bh-card-body p-4">
                <form action="{{ route('dashboard.account.password') }}" method="POST">
                    @csrf
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label fw-semibold">Current Password</label>
                            <input type="password" name="current_password" class="form-control" required placeholder="••••••••">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">New Password</label>
                            <input type="password" name="password" class="form-control" required placeholder="Minimum 6 characters">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Confirm New Password</label>
                            <input type="password" name="password_confirmation" class="form-control" required placeholder="Repeat new password">
                        </div>
                        <div class="col-12 text-end mt-3">
                            <button type="submit" class="bh-btn bh-btn-ghost text-dark fw-bold border">
                                <i class="fa-solid fa-key me-1 text-success"></i> Update Password
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        {{-- Notification Preferences Card --}}
        @php
            $userPrefs = auth()->user()->getNotificationPreferences();
        @endphp
        <div class="bh-card mb-4">
            <div class="bh-card-header">
                <h2 class="bh-card-title"><i class="fa-solid fa-bell me-2" style="color:#f59e0b;"></i> Notification Preferences</h2>
            </div>
            <div class="bh-card-body p-4">
                <p class="text-muted small mb-4">Choose which notifications you want to receive via email for your author activity.</p>
                <form action="{{ route('dashboard.account.notifications') }}" method="POST">
                    @csrf
                    <div class="d-flex flex-column gap-3 mb-4">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" name="email_new_comment" id="pref_comment" value="1" {{ !empty($userPrefs['email_new_comment']) ? 'checked' : '' }}>
                            <label class="form-check-label fw-semibold text-dark" for="pref_comment">
                                New Comment Alerts
                            </label>
                            <div class="text-muted small">Receive an email when a reader posts a comment or reply on your articles.</div>
                        </div>

                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" name="email_article_status" id="pref_status" value="1" {{ !empty($userPrefs['email_article_status']) ? 'checked' : '' }}>
                            <label class="form-check-label fw-semibold text-dark" for="pref_status">
                                Editorial Review Updates
                            </label>
                            <div class="text-muted small">Get notified when your submitted article is approved, published, or requested for edits.</div>
                        </div>

                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" name="email_weekly_digest" id="pref_digest" value="1" {{ !empty($userPrefs['email_weekly_digest']) ? 'checked' : '' }}>
                            <label class="form-check-label fw-semibold text-dark" for="pref_digest">
                                Weekly Performance Digest
                            </label>
                            <div class="text-muted small">Summary of your top articles, reader view trends, and reactions every Monday.</div>
                        </div>

                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" name="email_platform_updates" id="pref_updates" value="1" {{ !empty($userPrefs['email_platform_updates']) ? 'checked' : '' }}>
                            <label class="form-check-label fw-semibold text-dark" for="pref_updates">
                                Platform Announcements &amp; Features
                            </label>
                            <div class="text-muted small">Occasional newsletters with new BlogHub features, writing tips, and creator spotlights.</div>
                        </div>
                    </div>

                    <div class="text-end">
                        <button type="submit" class="bh-btn bh-btn-primary">
                            <i class="fa-solid fa-check me-1"></i> Save Preferences
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Right: Profile Preview / Role Details --}}
    <div class="col-12 col-lg-5">
        @if(!auth()->user()->isAdmin())
        {{-- Professional Author Profile Preview --}}
        <div class="bh-card mb-4">
            <div class="bh-card-header">
                <h2 class="bh-card-title"><i class="fa-solid fa-eye me-2" style="color:var(--brand);"></i> Public Author Preview</h2>
                <span class="badge bg-light text-muted border">Live Preview</span>
            </div>
            <div class="bh-card-body p-4 text-center">
                <div class="mb-3">
                    <img src="{{ auth()->user()->image ? asset('storage/' . auth()->user()->image) : ($author->avatar ?? 'https://ui-avatars.com/api/?name=' . urlencode(auth()->user()->name) . '&background=C8461F&color=fff&bold=true') }}"
                         alt="{{ auth()->user()->name }}"
                         style="width:90px; height:90px; border-radius:50%; object-fit:cover; border:3px solid var(--border);" class="shadow-sm">
                </div>
                <h4 class="fw-bold text-dark mb-1">{{ auth()->user()->name }}</h4>
                <div class="text-primary fw-medium small mb-2">{{ $author->specialty ?? 'Author & Contributor' }}</div>
                
                <p class="text-muted small px-3 mb-3" style="line-height:1.6;">
                    {{ auth()->user()->about ?? ($author->bio ?? 'Contributing author on BlogHub, sharing insights, perspectives, and expert knowledge with our community.') }}
                </p>

                {{-- Social Icons Preview --}}
                <div class="d-flex align-items-center justify-content-center gap-2 mb-4">
                    @if($author->twitter)
                        <a href="{{ $author->twitter }}" target="_blank" class="bh-icon-btn border shadow-xs" title="Twitter / X"><i class="fa-brands fa-x-twitter"></i></a>
                    @endif
                    @if($author->linkedin)
                        <a href="{{ $author->linkedin }}" target="_blank" class="bh-icon-btn border shadow-xs" title="LinkedIn"><i class="fa-brands fa-linkedin text-primary"></i></a>
                    @endif
                    @if($author->github)
                        <a href="{{ $author->github }}" target="_blank" class="bh-icon-btn border shadow-xs" title="GitHub"><i class="fa-brands fa-github"></i></a>
                    @endif
                    @if($author->website)
                        <a href="{{ $author->website }}" target="_blank" class="bh-icon-btn border shadow-xs" title="Website"><i class="fa-solid fa-globe text-success"></i></a>
                    @endif
                </div>

                <div class="d-flex justify-content-around py-3 rounded bg-light border">
                    <div>
                        <div class="fw-bold fs-5 text-dark">{{ $author->articles()->count() }}</div>
                        <div class="text-muted small" style="font-size:0.75rem;">Stories</div>
                    </div>
                    <div>
                        <div class="fw-bold fs-5 text-dark">{{ number_format($author->articles()->sum('views_count')) }}</div>
                        <div class="text-muted small" style="font-size:0.75rem;">Total Views</div>
                    </div>
                    <div>
                        <div class="fw-bold fs-5 text-dark">{{ $author->followers_count ?? 120 }}</div>
                        <div class="text-muted small" style="font-size:0.75rem;">Followers</div>
                    </div>
                </div>
            </div>
        </div>

        @else
        {{-- Admin Privileges Card --}}
        <div class="bh-card mb-4">
            <div class="bh-card-header">
                <h2 class="bh-card-title"><i class="fa-solid fa-shield-halved me-2 text-danger"></i> Administrator Access</h2>
                <span class="bh-badge" style="background:#fee2e2; color:#dc2626;">Super Admin</span>
            </div>
            <div class="bh-card-body p-4">
                <p class="text-muted small mb-3">You possess full elevated administrative privileges across BlogHub.</p>
                <ul class="list-group list-group-flush small">
                    <li class="list-group-item d-flex align-items-center gap-2 px-0">
                        <i class="fa-solid fa-circle-check text-success"></i> Full User and Author Management
                    </li>
                    <li class="list-group-item d-flex align-items-center gap-2 px-0">
                        <i class="fa-solid fa-circle-check text-success"></i> Editorial Post Review &amp; Publishing
                    </li>
                    <li class="list-group-item d-flex align-items-center gap-2 px-0">
                        <i class="fa-solid fa-circle-check text-success"></i> Global Category Creation &amp; Deletion
                    </li>
                    <li class="list-group-item d-flex align-items-center gap-2 px-0">
                        <i class="fa-solid fa-circle-check text-success"></i> Platform Comments Moderation
                    </li>
                    <li class="list-group-item d-flex align-items-center gap-2 px-0">
                        <i class="fa-solid fa-circle-check text-success"></i> Platform-Wide Analytics &amp; Reports
                    </li>
                    <li class="list-group-item d-flex align-items-center gap-2 px-0">
                        <i class="fa-solid fa-circle-check text-success"></i> Global Configuration &amp; Settings
                    </li>
                </ul>
            </div>
        </div>
        @endif

        {{-- Account Meta Card --}}
        <div class="bh-card">
            <div class="bh-card-header">
                <h2 class="bh-card-title"><i class="fa-solid fa-circle-info me-2 text-primary"></i> Account Details</h2>
            </div>
            <div class="bh-card-body p-3">
                <div class="list-group list-group-flush small">
                    <div class="list-group-item d-flex justify-content-between px-0">
                        <span class="text-muted">Account ID:</span>
                        <strong class="text-dark">#{{ auth()->id() }}</strong>
                    </div>
                    <div class="list-group-item d-flex justify-content-between px-0">
                        <span class="text-muted">Role:</span>
                        <strong class="{{ auth()->user()->isAdmin() ? 'text-danger' : 'text-primary' }}">
                            {{ auth()->user()->isAdmin() ? 'Platform Administrator' : 'Verified Author' }}
                        </strong>
                    </div>
                    <div class="list-group-item d-flex justify-content-between px-0">
                        <span class="text-muted">Member Since:</span>
                        <span class="text-dark">{{ auth()->user()->created_at->format('M d, Y') }}</span>
                    </div>
                    <div class="list-group-item d-flex justify-content-between px-0">
                        <span class="text-muted">Account Status:</span>
                        <span class="text-success fw-bold"><i class="fa-solid fa-circle-check me-1"></i>Active</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
