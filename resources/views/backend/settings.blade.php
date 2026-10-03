@extends('backend.layouts.admin')

@section('title', 'Platform Settings — BlogHub Admin')

@section('content')

{{-- Page Header --}}
<div class="bh-page-header d-flex flex-column flex-md-row align-items-start align-items-md-center justify-content-between gap-3 mb-4">
    <div>
        <h1 class="bh-page-title d-flex align-items-center gap-2">
            <span class="d-inline-flex align-items-center justify-content-center rounded-3 text-white" style="width:38px; height:38px; background:linear-gradient(135deg, var(--bh-accent, #C8461F), #ea580c); font-size:1.1rem;">
                <i class="fa-solid fa-sliders"></i>
            </span>
            <span>Platform Settings</span>
        </h1>
        <p class="bh-page-sub mb-0">Manage global identity, visual branding, user access control, comment moderation, email alerts, and external social channels.</p>
    </div>
    <div class="d-flex align-items-center gap-2">
        <a href="{{ route('home') }}" target="_blank" class="bh-btn bh-btn-ghost">
            <i class="fa-solid fa-arrow-up-right-from-square me-1"></i> View Live Site
        </a>
    </div>
</div>

{{-- Settings Tabs & Content Layout --}}
<div class="row g-4">
    {{-- Left Navigation Tabs Column --}}
    <div class="col-12 col-lg-3">
        <div class="bh-card sticky-top" style="top: 80px; z-index: 10;">
            <div class="p-3 border-bottom">
                <span class="text-uppercase fw-bold text-muted font-mono" style="font-size: 0.72rem; letter-spacing: 0.08em;">Configuration Tabs</span>
            </div>
            <div class="list-group list-group-flush p-2" id="settingsTab" role="tablist">
                <button class="list-group-item list-group-item-action active d-flex align-items-center gap-3 rounded-2 py-2 px-3 border-0 mb-1"
                        id="tab-btn-general" data-bs-toggle="pill" data-bs-target="#tab-general" type="button" role="tab" aria-controls="tab-general" aria-selected="true">
                    <i class="fa-solid fa-globe fa-fw text-primary"></i>
                    <div class="text-start">
                        <div class="fw-semibold text-dark" style="font-size: 0.9rem;">General Settings</div>
                        <div class="text-muted" style="font-size: 0.75rem;">Identity, email, logos</div>
                    </div>
                </button>

                <button class="list-group-item list-group-item-action d-flex align-items-center gap-3 rounded-2 py-2 px-3 border-0 mb-1"
                        id="tab-btn-appearance" data-bs-toggle="pill" data-bs-target="#tab-appearance" type="button" role="tab" aria-controls="tab-appearance" aria-selected="false">
                    <i class="fa-solid fa-palette fa-fw" style="color:#8b5cf6;"></i>
                    <div class="text-start">
                        <div class="fw-semibold text-dark" style="font-size: 0.9rem;">Appearance</div>
                        <div class="text-muted" style="font-size: 0.75rem;">Theme, branding color</div>
                    </div>
                </button>

                <button class="list-group-item list-group-item-action d-flex align-items-center gap-3 rounded-2 py-2 px-3 border-0 mb-1"
                        id="tab-btn-access" data-bs-toggle="pill" data-bs-target="#tab-access" type="button" role="tab" aria-controls="tab-access" aria-selected="false">
                    <i class="fa-solid fa-user-shield fa-fw" style="color:#0ea5e9;"></i>
                    <div class="text-start">
                        <div class="fw-semibold text-dark" style="font-size: 0.9rem;">User &amp; Access</div>
                        <div class="text-muted" style="font-size: 0.75rem;">Signups, author approvals</div>
                    </div>
                </button>

                <button class="list-group-item list-group-item-action d-flex align-items-center gap-3 rounded-2 py-2 px-3 border-0 mb-1"
                        id="tab-btn-comments" data-bs-toggle="pill" data-bs-target="#tab-comments" type="button" role="tab" aria-controls="tab-comments" aria-selected="false">
                    <i class="fa-solid fa-comments fa-fw" style="color:#10b981;"></i>
                    <div class="text-start">
                        <div class="fw-semibold text-dark" style="font-size: 0.9rem;">Comment Settings</div>
                        <div class="text-muted" style="font-size: 0.75rem;">Replies, moderation, auth</div>
                    </div>
                </button>

                <button class="list-group-item list-group-item-action d-flex align-items-center gap-3 rounded-2 py-2 px-3 border-0 mb-1"
                        id="tab-btn-notifications" data-bs-toggle="pill" data-bs-target="#tab-notifications" type="button" role="tab" aria-controls="tab-notifications" aria-selected="false">
                    <i class="fa-solid fa-bell fa-fw" style="color:#f59e0b;"></i>
                    <div class="text-start">
                        <div class="fw-semibold text-dark" style="font-size: 0.9rem;">Notifications</div>
                        <div class="text-muted" style="font-size: 0.75rem;">System &amp; admin alerts</div>
                    </div>
                </button>

                <button class="list-group-item list-group-item-action d-flex align-items-center gap-3 rounded-2 py-2 px-3 border-0"
                        id="tab-btn-social" data-bs-toggle="pill" data-bs-target="#tab-social" type="button" role="tab" aria-controls="tab-social" aria-selected="false">
                    <i class="fa-solid fa-share-nodes fa-fw" style="color:#ec4899;"></i>
                    <div class="text-start">
                        <div class="fw-semibold text-dark" style="font-size: 0.9rem;">Social Links</div>
                        <div class="text-muted" style="font-size: 0.75rem;">Channels &amp; footer links</div>
                    </div>
                </button>
            </div>

            <div class="p-3 border-top bg-light-subtle rounded-bottom-3 small text-muted">
                <i class="fa-solid fa-shield-halved text-success me-1"></i> Admin platform control
            </div>
        </div>
    </div>

    {{-- Right Content Column (Pill Panes) --}}
    <div class="col-12 col-lg-9">
        <div class="tab-content" id="settingsTabContent">

            {{-- 1. GENERAL SETTINGS --}}
            <div class="tab-pane fade show active" id="tab-general" role="tabpanel" aria-labelledby="tab-btn-general">
                <form action="{{ route('dashboard.settings.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="setting_tab" value="general">

                    <div class="bh-card mb-4">
                        <div class="bh-card-header d-flex align-items-center justify-content-between">
                            <h2 class="bh-card-title d-flex align-items-center gap-2">
                                <i class="fa-solid fa-globe text-primary"></i> General Identity Settings
                            </h2>
                            <span class="badge bg-primary-subtle text-primary border border-primary-subtle px-2 py-1">Identity &amp; Contact</span>
                        </div>
                        <div class="bh-card-body p-4">
                            <div class="row g-4">
                                <div class="col-12 col-md-6">
                                    <label class="form-label fw-semibold">BlogHub Site Name <span class="text-danger">*</span></label>
                                    <input type="text" name="site_name" class="form-control" value="{{ old('site_name', $settings['site_name'] ?? 'BlogHub') }}" required maxlength="100">
                                    <div class="form-text">Visible in the navigation bar, page titles, footer, and emails.</div>
                                </div>

                                <div class="col-12 col-md-6">
                                    <label class="form-label fw-semibold">Contact Email <span class="text-danger">*</span></label>
                                    <input type="email" name="contact_email" class="form-control" value="{{ old('contact_email', $settings['contact_email'] ?? 'contact@bloghub.com') }}" required maxlength="150">
                                    <div class="form-text">Public inquiry email shown in footer and contact page.</div>
                                </div>

                                <div class="col-12">
                                    <label class="form-label fw-semibold">Website Description</label>
                                    <textarea name="site_description" rows="3" class="form-control" placeholder="A modern and thoughtful platform for stories, ideas, and expert knowledge...">{{ old('site_description', $settings['site_description'] ?? '') }}</textarea>
                                    <div class="form-text">Used in search engine meta descriptions and footer platform overview.</div>
                                </div>

                                <div class="col-12"><hr class="my-2 border-secondary border-opacity-10"></div>

                                {{-- Logo Upload --}}
                                <div class="col-12 col-md-6">
                                    <label class="form-label fw-semibold">Site Logo</label>
                                    <div class="d-flex align-items-center gap-3 p-3 rounded-3 border bg-light-subtle">
                                        <div class="d-flex align-items-center justify-content-center bg-white border rounded p-2" style="width: 64px; height: 64px; min-width: 64px;">
                                            @if(!empty($settings['site_logo']))
                                                <img id="logoPreview" src="{{ asset('storage/' . $settings['site_logo']) }}" alt="Logo" style="max-width: 100%; max-height: 100%; object-fit: contain;">
                                            @else
                                                <div id="logoDefaultIcon" class="bg-primary text-white rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                                    <i class="fa-solid fa-feather-alt fs-5"></i>
                                                </div>
                                                <img id="logoPreview" src="" alt="Preview" style="max-width: 100%; max-height: 100%; object-fit: contain; display:none;">
                                            @endif
                                        </div>
                                        <div class="flex-grow-1">
                                            <input type="file" name="site_logo" id="site_logo_input" class="form-control form-control-sm mb-1" accept="image/*"
                                                   onchange="if(this.files && this.files[0]){ var r = new FileReader(); r.onload = function(e){ var p = document.getElementById('logoPreview'); p.src = e.target.result; p.style.display='block'; var d = document.getElementById('logoDefaultIcon'); if(d) d.style.display='none'; }; r.readAsDataURL(this.files[0]); }">
                                            <span class="text-muted small" style="font-size:0.75rem;">PNG, SVG, JPG, WebP (Max 2MB)</span>
                                            @if(!empty($settings['site_logo']))
                                            <div class="form-check mt-1">
                                                <input class="form-check-input" type="checkbox" name="remove_site_logo" value="1" id="remove_logo">
                                                <label class="form-check-label text-danger small" for="remove_logo">Remove custom logo</label>
                                            </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                {{-- Favicon Upload --}}
                                <div class="col-12 col-md-6">
                                    <label class="form-label fw-semibold">Site Favicon</label>
                                    <div class="d-flex align-items-center gap-3 p-3 rounded-3 border bg-light-subtle">
                                        <div class="d-flex align-items-center justify-content-center bg-white border rounded p-2" style="width: 64px; height: 64px; min-width: 64px;">
                                            @if(!empty($settings['site_favicon']))
                                                <img id="faviconPreview" src="{{ asset('storage/' . $settings['site_favicon']) }}" alt="Favicon" style="max-width: 32px; max-height: 32px; object-fit: contain;">
                                            @else
                                                <i id="faviconDefaultIcon" class="fa-solid fa-globe fs-2 text-muted"></i>
                                                <img id="faviconPreview" src="" alt="Favicon Preview" style="max-width: 32px; max-height: 32px; object-fit: contain; display:none;">
                                            @endif
                                        </div>
                                        <div class="flex-grow-1">
                                            <input type="file" name="site_favicon" id="site_favicon_input" class="form-control form-control-sm mb-1" accept="image/x-icon,image/png,image/svg+xml"
                                                   onchange="if(this.files && this.files[0]){ var r = new FileReader(); r.onload = function(e){ var p = document.getElementById('faviconPreview'); p.src = e.target.result; p.style.display='block'; var d = document.getElementById('faviconDefaultIcon'); if(d) d.style.display='none'; }; r.readAsDataURL(this.files[0]); }">
                                            <span class="text-muted small" style="font-size:0.75rem;">ICO, PNG, SVG (Max 1MB)</span>
                                            @if(!empty($settings['site_favicon']))
                                            <div class="form-check mt-1">
                                                <input class="form-check-input" type="checkbox" name="remove_site_favicon" value="1" id="remove_favicon">
                                                <label class="form-check-label text-danger small" for="remove_favicon">Remove favicon</label>
                                            </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="bh-card-footer p-3 bg-light-subtle d-flex justify-content-end">
                            <button type="submit" class="bh-btn bh-btn-primary">
                                <i class="fa-solid fa-floppy-disk me-1"></i> Save General Settings
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            {{-- 2. APPEARANCE SETTINGS --}}
            <div class="tab-pane fade" id="tab-appearance" role="tabpanel" aria-labelledby="tab-btn-appearance">
                <form action="{{ route('dashboard.settings.update') }}" method="POST">
                    @csrf
                    <input type="hidden" name="setting_tab" value="appearance">

                    <div class="bh-card mb-4">
                        <div class="bh-card-header d-flex align-items-center justify-content-between">
                            <h2 class="bh-card-title d-flex align-items-center gap-2">
                                <i class="fa-solid fa-palette text-purple" style="color:#8b5cf6;"></i> Appearance &amp; Visual Branding
                            </h2>
                            <span class="badge bg-purple-subtle text-purple border border-purple-subtle px-2 py-1" style="background:#f3e8ff; color:#7e22ce;">Theme &amp; Style</span>
                        </div>
                        <div class="bh-card-body p-4">
                            <div class="row g-4">
                                {{-- Theme Mode Preference --}}
                                <div class="col-12 col-md-6">
                                    <label class="form-label fw-semibold">Default Light / Dark Mode Preference</label>
                                    @php $currentTheme = old('theme_mode', $settings['theme_mode'] ?? 'light'); @endphp
                                    <select name="theme_mode" class="form-select">
                                        <option value="light" {{ $currentTheme === 'light' ? 'selected' : '' }}>Light Mode (Default Editorial Clean)</option>
                                        <option value="dark" {{ $currentTheme === 'dark' ? 'selected' : '' }}>Dark Mode (High Contrast Night)</option>
                                        <option value="system" {{ $currentTheme === 'system' ? 'selected' : '' }}>System Auto-Detect (Follows OS)</option>
                                    </select>
                                    <div class="form-text">Sets default mode for first-time visitors before manual toggle.</div>
                                </div>

                                {{-- Brand Accent Color --}}
                                <div class="col-12 col-md-6">
                                    <label class="form-label fw-semibold">Primary Brand Accent Color</label>
                                    <div class="input-group">
                                        <input type="color" class="form-control form-control-color" id="primaryColorPicker"
                                               value="{{ old('primary_color', $settings['primary_color'] ?? '#C8461F') }}"
                                               title="Choose brand color"
                                               onchange="document.getElementById('primaryColorText').value = this.value">
                                        <input type="text" name="primary_color" id="primaryColorText" class="form-control font-mono"
                                               value="{{ old('primary_color', $settings['primary_color'] ?? '#C8461F') }}"
                                               onchange="document.getElementById('primaryColorPicker').value = this.value" maxlength="7">
                                    </div>
                                    <div class="form-text">Default: <code>#C8461F</code> (BlogHub signature vermilion orange).</div>
                                </div>

                                {{-- Site Tagline --}}
                                <div class="col-12 col-md-8">
                                    <label class="form-label fw-semibold">Hero / Platform Tagline</label>
                                    <input type="text" name="site_tagline" class="form-control"
                                           value="{{ old('site_tagline', $settings['site_tagline'] ?? 'Discover Thoughtful Stories & Expert Perspectives') }}" maxlength="255">
                                    <div class="form-text">Catchy slogan displayed in the browser title and hero headers.</div>
                                </div>

                                {{-- Posts Per Page --}}
                                <div class="col-12 col-md-4">
                                    <label class="form-label fw-semibold">Articles Per Page</label>
                                    <input type="number" name="posts_per_page" class="form-control"
                                           value="{{ old('posts_per_page', $settings['posts_per_page'] ?? '9') }}" min="3" max="50">
                                    <div class="form-text">Default pagination size across blogs listing.</div>
                                </div>
                            </div>
                        </div>
                        <div class="bh-card-footer p-3 bg-light-subtle d-flex justify-content-end">
                            <button type="submit" class="bh-btn bh-btn-primary">
                                <i class="fa-solid fa-floppy-disk me-1"></i> Save Appearance Settings
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            {{-- 3. USER & ACCESS SETTINGS --}}
            <div class="tab-pane fade" id="tab-access" role="tabpanel" aria-labelledby="tab-btn-access">
                <form action="{{ route('dashboard.settings.update') }}" method="POST">
                    @csrf
                    <input type="hidden" name="setting_tab" value="access">

                    <div class="bh-card mb-4">
                        <div class="bh-card-header d-flex align-items-center justify-content-between">
                            <h2 class="bh-card-title d-flex align-items-center gap-2">
                                <i class="fa-solid fa-user-shield text-info"></i> User Registration &amp; Access Controls
                            </h2>
                            <span class="badge bg-info-subtle text-info border border-info-subtle px-2 py-1">Registration Policy</span>
                        </div>
                        <div class="bh-card-body p-4">
                            <div class="d-flex flex-column gap-4">
                                {{-- Enable Public Registration --}}
                                <div class="p-3 rounded-3 border bg-light-subtle d-flex align-items-start gap-3">
                                    <div class="form-check form-switch pt-1">
                                        <input class="form-check-input" type="checkbox" name="enable_public_registration" id="enable_public_registration" value="1"
                                               {{ !empty($settings['enable_public_registration']) ? 'checked' : '' }}>
                                    </div>
                                    <div class="flex-grow-1">
                                        <label class="form-check-label fw-semibold text-dark d-block mb-1" for="enable_public_registration">
                                            Enable Public User Registration
                                        </label>
                                        <div class="text-muted small">
                                            When enabled, visitors can freely sign up for BlogHub accounts. When disabled, the registration page will show an enrollment pause message and block new signups.
                                        </div>
                                    </div>
                                </div>

                                {{-- Author Registration Approval --}}
                                <div class="p-3 rounded-3 border bg-light-subtle d-flex align-items-start gap-3">
                                    <div class="form-check form-switch pt-1">
                                        <input class="form-check-input" type="checkbox" name="require_author_approval" id="require_author_approval" value="1"
                                               {{ !empty($settings['require_author_approval']) ? 'checked' : '' }}>
                                    </div>
                                    <div class="flex-grow-1">
                                        <label class="form-check-label fw-semibold text-dark d-block mb-1" for="require_author_approval">
                                            Require Administrator Approval for New Authors
                                        </label>
                                        <div class="text-muted small">
                                            When enabled, newly registered users start as regular readers (user_type = 0) and cannot publish until an Administrator upgrades them in Author Management. When disabled, new signups automatically gain Creator Studio access.
                                        </div>
                                    </div>
                                </div>

                                {{-- Default Role Selection --}}
                                <div class="p-3 rounded-3 border bg-light-subtle">
                                    <label class="form-label fw-semibold text-dark mb-1">Default Role Assigned on Registration</label>
                                    @php $defaultRole = old('default_user_role', $settings['default_user_role'] ?? 'author'); @endphp
                                    <select name="default_user_role" class="form-select form-select-sm" style="max-width: 320px;">
                                        <option value="author" {{ $defaultRole === 'author' ? 'selected' : '' }}>Author (Creator Studio access)</option>
                                        <option value="reader" {{ $defaultRole === 'reader' ? 'selected' : '' }}>Reader / Member (Read, Like &amp; Comment only)</option>
                                    </select>
                                    <div class="text-muted small mt-1">Configures permissions immediately granted upon successful registration.</div>
                                </div>
                            </div>
                        </div>
                        <div class="bh-card-footer p-3 bg-light-subtle d-flex justify-content-end">
                            <button type="submit" class="bh-btn bh-btn-primary">
                                <i class="fa-solid fa-floppy-disk me-1"></i> Save Access Settings
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            {{-- 4. COMMENT SETTINGS --}}
            <div class="tab-pane fade" id="tab-comments" role="tabpanel" aria-labelledby="tab-btn-comments">
                <form action="{{ route('dashboard.settings.update') }}" method="POST">
                    @csrf
                    <input type="hidden" name="setting_tab" value="comments">

                    <div class="bh-card mb-4">
                        <div class="bh-card-header d-flex align-items-center justify-content-between">
                            <h2 class="bh-card-title d-flex align-items-center gap-2">
                                <i class="fa-solid fa-comments text-success"></i> Global Comment &amp; Discussion Rules
                            </h2>
                            <span class="badge bg-success-subtle text-success border border-success-subtle px-2 py-1">Discussion Engine</span>
                        </div>
                        <div class="bh-card-body p-4">
                            <div class="d-flex flex-column gap-4">
                                {{-- 1. Enable Comments Globally --}}
                                <div class="p-3 rounded-3 border bg-light-subtle d-flex align-items-start gap-3">
                                    <div class="form-check form-switch pt-1">
                                        <input class="form-check-input" type="checkbox" name="enable_comments" id="enable_comments" value="1"
                                               {{ !empty($settings['enable_comments']) ? 'checked' : '' }}>
                                    </div>
                                    <div class="flex-grow-1">
                                        <label class="form-check-label fw-semibold text-dark d-block mb-1" for="enable_comments">
                                            Enable Comments Platform-Wide
                                        </label>
                                        <div class="text-muted small">
                                            When enabled, readers can leave comments under published stories. When disabled, the entire comment form is hidden across all articles.
                                        </div>
                                    </div>
                                </div>

                                {{-- 2. Require Authentication to Comment --}}
                                <div class="p-3 rounded-3 border bg-light-subtle d-flex align-items-start gap-3">
                                    <div class="form-check form-switch pt-1">
                                        <input class="form-check-input" type="checkbox" name="require_auth_comments" id="require_auth_comments" value="1"
                                               {{ !empty($settings['require_auth_comments']) ? 'checked' : '' }}>
                                    </div>
                                    <div class="flex-grow-1">
                                        <label class="form-check-label fw-semibold text-dark d-block mb-1" for="require_auth_comments">
                                            Require Users to be Logged In to Comment
                                        </label>
                                        <div class="text-muted small">
                                            Requires visitors to log into a verified BlogHub account before submitting thoughts, helping eliminate spam and bot interactions.
                                        </div>
                                    </div>
                                </div>

                                {{-- 3. Comment Moderation --}}
                                <div class="p-3 rounded-3 border bg-light-subtle d-flex align-items-start gap-3">
                                    <div class="form-check form-switch pt-1">
                                        <input class="form-check-input" type="checkbox" name="enable_comment_moderation" id="enable_comment_moderation" value="1"
                                               {{ !empty($settings['enable_comment_moderation']) ? 'checked' : '' }}>
                                    </div>
                                    <div class="flex-grow-1">
                                        <label class="form-check-label fw-semibold text-dark d-block mb-1" for="enable_comment_moderation">
                                            Enable Comment Moderation Queue
                                        </label>
                                        <div class="text-muted small">
                                            When enabled, all submitted reader comments must be approved by the article author or an admin before appearing live. When disabled, comments are published instantly.
                                        </div>
                                    </div>
                                </div>

                                {{-- 4. Enable Nested Replies --}}
                                <div class="p-3 rounded-3 border bg-light-subtle d-flex align-items-start gap-3">
                                    <div class="form-check form-switch pt-1">
                                        <input class="form-check-input" type="checkbox" name="enable_comment_replies" id="enable_comment_replies" value="1"
                                               {{ !empty($settings['enable_comment_replies']) ? 'checked' : '' }}>
                                    </div>
                                    <div class="flex-grow-1">
                                        <label class="form-check-label fw-semibold text-dark d-block mb-1" for="enable_comment_replies">
                                            Enable Threaded Comment Replies
                                        </label>
                                        <div class="text-muted small">
                                            Allows authors and other readers to reply directly to individual comments, creating engaging threaded discussions.
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="bh-card-footer p-3 bg-light-subtle d-flex justify-content-end">
                            <button type="submit" class="bh-btn bh-btn-primary">
                                <i class="fa-solid fa-floppy-disk me-1"></i> Save Comment Settings
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            {{-- 5. NOTIFICATION SETTINGS --}}
            <div class="tab-pane fade" id="tab-notifications" role="tabpanel" aria-labelledby="tab-btn-notifications">
                <form action="{{ route('dashboard.settings.update') }}" method="POST">
                    @csrf
                    <input type="hidden" name="setting_tab" value="notifications">

                    <div class="bh-card mb-4">
                        <div class="bh-card-header d-flex align-items-center justify-content-between">
                            <h2 class="bh-card-title d-flex align-items-center gap-2">
                                <i class="fa-solid fa-bell text-warning"></i> Platform Notification Triggers
                            </h2>
                            <span class="badge bg-warning-subtle text-warning-emphasis border border-warning-subtle px-2 py-1">Email &amp; Alerts</span>
                        </div>
                        <div class="bh-card-body p-4">
                            <div class="d-flex flex-column gap-4">
                                {{-- 1. Enable Email Notifications --}}
                                <div class="p-3 rounded-3 border bg-light-subtle d-flex align-items-start gap-3">
                                    <div class="form-check form-switch pt-1">
                                        <input class="form-check-input" type="checkbox" name="enable_email_notifications" id="enable_email_notifications" value="1"
                                               {{ !empty($settings['enable_email_notifications']) ? 'checked' : '' }}>
                                    </div>
                                    <div class="flex-grow-1">
                                        <label class="form-check-label fw-semibold text-dark d-block mb-1" for="enable_email_notifications">
                                            Enable System Email Notifications
                                        </label>
                                        <div class="text-muted small">
                                            Master switch for transactional email notifications dispatched by the BlogHub platform.
                                        </div>
                                    </div>
                                </div>

                                {{-- 2. New Comment Notifications --}}
                                <div class="p-3 rounded-3 border bg-light-subtle d-flex align-items-start gap-3">
                                    <div class="form-check form-switch pt-1">
                                        <input class="form-check-input" type="checkbox" name="notify_on_new_comment" id="notify_on_new_comment" value="1"
                                               {{ !empty($settings['notify_on_new_comment']) ? 'checked' : '' }}>
                                    </div>
                                    <div class="flex-grow-1">
                                        <label class="form-check-label fw-semibold text-dark d-block mb-1" for="notify_on_new_comment">
                                            New Comment Notifications to Authors
                                        </label>
                                        <div class="text-muted small">
                                            Automatically alert authors when readers post new comments or replies on their articles.
                                        </div>
                                    </div>
                                </div>

                                {{-- 3. New User / Author Alerts --}}
                                <div class="p-3 rounded-3 border bg-light-subtle d-flex align-items-start gap-3">
                                    <div class="form-check form-switch pt-1">
                                        <input class="form-check-input" type="checkbox" name="notify_on_new_user" id="notify_on_new_user" value="1"
                                               {{ !empty($settings['notify_on_new_user']) ? 'checked' : '' }}>
                                    </div>
                                    <div class="flex-grow-1">
                                        <label class="form-check-label fw-semibold text-dark d-block mb-1" for="notify_on_new_user">
                                            New User &amp; Author Notifications to Admin
                                        </label>
                                        <div class="text-muted small">
                                            Send immediate email digest notifications to {{ $settings['contact_email'] ?? 'contact@bloghub.com' }} when a new author joins the platform.
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="bh-card-footer p-3 bg-light-subtle d-flex justify-content-end">
                            <button type="submit" class="bh-btn bh-btn-primary">
                                <i class="fa-solid fa-floppy-disk me-1"></i> Save Notification Settings
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            {{-- 6. SOCIAL LINKS --}}
            <div class="tab-pane fade" id="tab-social" role="tabpanel" aria-labelledby="tab-btn-social">
                <form action="{{ route('dashboard.settings.update') }}" method="POST">
                    @csrf
                    <input type="hidden" name="setting_tab" value="social">

                    <div class="bh-card mb-4">
                        <div class="bh-card-header d-flex align-items-center justify-content-between">
                            <h2 class="bh-card-title d-flex align-items-center gap-2">
                                <i class="fa-solid fa-share-nodes text-pink" style="color:#ec4899;"></i> Social Media &amp; Community Channels
                            </h2>
                            <span class="badge bg-pink-subtle text-pink border border-pink-subtle px-2 py-1" style="background:#fdf2f8; color:#db2777;">Public Footer</span>
                        </div>
                        <div class="bh-card-body p-4">
                            <p class="text-muted small mb-4">Configure the official social profiles linked across the public BlogHub navigation, footer, and article share dialogs.</p>

                            <div class="row g-3">
                                {{-- GitHub --}}
                                <div class="col-12 col-md-6">
                                    <label class="form-label fw-semibold small">
                                        <i class="fa-brands fa-github text-dark me-1"></i> GitHub Repository / Profile URL
                                    </label>
                                    <input type="url" name="social_github" class="form-control font-mono"
                                           value="{{ old('social_github', $settings['social_github'] ?? '') }}" placeholder="https://github.com/organization">
                                </div>

                                {{-- LinkedIn --}}
                                <div class="col-12 col-md-6">
                                    <label class="form-label fw-semibold small">
                                        <i class="fa-brands fa-linkedin text-primary me-1"></i> LinkedIn Company / Page URL
                                    </label>
                                    <input type="url" name="social_linkedin" class="form-control font-mono"
                                           value="{{ old('social_linkedin', $settings['social_linkedin'] ?? '') }}" placeholder="https://linkedin.com/company/bloghub">
                                </div>

                                {{-- Instagram --}}
                                <div class="col-12 col-md-6">
                                    <label class="form-label fw-semibold small">
                                        <i class="fa-brands fa-instagram text-danger me-1"></i> Instagram Profile URL
                                    </label>
                                    <input type="url" name="social_instagram" class="form-control font-mono"
                                           value="{{ old('social_instagram', $settings['social_instagram'] ?? '') }}" placeholder="https://instagram.com/bloghub">
                                </div>

                                {{-- Twitter / X --}}
                                <div class="col-12 col-md-6">
                                    <label class="form-label fw-semibold small">
                                        <i class="fa-brands fa-x-twitter text-dark me-1"></i> Twitter / X Handle URL
                                    </label>
                                    <input type="url" name="social_twitter" class="form-control font-mono"
                                           value="{{ old('social_twitter', $settings['social_twitter'] ?? '') }}" placeholder="https://x.com/bloghub">
                                </div>

                                {{-- YouTube --}}
                                <div class="col-12 col-md-6">
                                    <label class="form-label fw-semibold small">
                                        <i class="fa-brands fa-youtube text-danger me-1"></i> YouTube Channel URL
                                    </label>
                                    <input type="url" name="social_youtube" class="form-control font-mono"
                                           value="{{ old('social_youtube', $settings['social_youtube'] ?? '') }}" placeholder="https://youtube.com/@bloghub">
                                </div>

                                {{-- Facebook --}}
                                <div class="col-12 col-md-6">
                                    <label class="form-label fw-semibold small">
                                        <i class="fa-brands fa-facebook text-primary me-1"></i> Facebook Page URL
                                    </label>
                                    <input type="url" name="social_facebook" class="form-control font-mono"
                                           value="{{ old('social_facebook', $settings['social_facebook'] ?? '') }}" placeholder="https://facebook.com/bloghub">
                                </div>
                            </div>
                        </div>
                        <div class="bh-card-footer p-3 bg-light-subtle d-flex justify-content-end">
                            <button type="submit" class="bh-btn bh-btn-primary">
                                <i class="fa-solid fa-floppy-disk me-1"></i> Save Social Links
                            </button>
                        </div>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Check if URL contains hash for active tab
    var hash = window.location.hash;
    if (hash) {
        var cleanHash = hash.replace('#', '');
        var targetBtn = document.getElementById('tab-btn-' + cleanHash);
        if (targetBtn) {
            var tabTrigger = new bootstrap.Tab(targetBtn);
            tabTrigger.show();
        }
    }

    // Update URL hash when a tab is clicked
    var tabButtons = document.querySelectorAll('#settingsTab button[data-bs-toggle="pill"]');
    tabButtons.forEach(function(btn) {
        btn.addEventListener('shown.bs.tab', function(e) {
            var targetId = e.target.getAttribute('data-bs-target').replace('#tab-', '');
            window.location.hash = targetId;
        });
    });
});
</script>
@endpush

@endsection
