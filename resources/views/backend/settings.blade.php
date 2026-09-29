@extends('backend.layouts.admin')

@section('title', 'Settings — BlogHub')

@section('content')

{{-- Page Header --}}
<div class="bh-page-header">
    <div>
        <h1 class="bh-page-title">Settings</h1>
        <p class="bh-page-sub">Configure your publication, notifications, and platform preferences.</p>
    </div>
</div>

{{-- General Settings --}}
<div class="row g-3 mb-4">
    <div class="col-12 col-md-4">
        <div style="font-weight:700; font-size:0.95rem; color:var(--text-primary); margin-bottom:4px;">General Settings</div>
        <div style="font-size:0.82rem; color:var(--text-muted); line-height:1.5;">Configure main blog details, public site title, and default pagination.</div>
    </div>
    <div class="col-12 col-md-8">
        <div class="bh-card">
            <div class="bh-card-body">
                <form onsubmit="event.preventDefault(); alert('Settings saved successfully!');">
                    <div class="mb-3">
                        <label style="font-size:0.82rem; font-weight:600; color:var(--text-primary); margin-bottom:4px; display:block;">Publication Name</label>
                        <input type="text" class="form-control form-control-sm" value="BlogHub Modern Media" required>
                    </div>
                    <div class="mb-3">
                        <label style="font-size:0.82rem; font-weight:600; color:var(--text-primary); margin-bottom:4px; display:block;">Admin Email</label>
                        <input type="email" class="form-control form-control-sm" value="{{ auth()->user()->email }}" required>
                    </div>
                    <div class="mb-3">
                        <label style="font-size:0.82rem; font-weight:600; color:var(--text-primary); margin-bottom:4px; display:block;">Posts Per Page</label>
                        <input type="number" class="form-control form-control-sm" value="9" min="3" max="30" style="max-width:120px;">
                    </div>
                    <button type="submit" class="bh-btn bh-btn-primary">
                        <i class="fa-solid fa-floppy-disk"></i> Save Changes
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<div style="border-top:1px solid var(--border); margin:1rem 0 1.5rem;"></div>

{{-- Platform Info --}}
<div class="row g-3 mb-4">
    <div class="col-12 col-md-4">
        <div style="font-weight:700; font-size:0.95rem; color:var(--text-primary); margin-bottom:4px;">Platform Info</div>
        <div style="font-size:0.82rem; color:var(--text-muted); line-height:1.5;">Current tier, storage usage, and license status.</div>
    </div>
    <div class="col-12 col-md-8">
        <div class="bh-card">
            <div class="bh-card-body">
                <div class="d-flex flex-column gap-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <span style="font-size:0.84rem; color:var(--text-muted);">License</span>
                        <span class="bh-badge" style="background:rgba(37,99,235,0.1); color:#2563eb; padding:3px 10px;">Enterprise Publisher</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                        <span style="font-size:0.84rem; color:var(--text-muted);">Status</span>
                        <span class="bh-badge" style="background:rgba(16,185,129,0.1); color:#10b981; padding:3px 10px;">Active &amp; Verified</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                        <span style="font-size:0.84rem; color:var(--text-muted);">Storage</span>
                        <span style="font-size:0.84rem; font-weight:600;">4.2 GB / 50 GB</span>
                    </div>
                    <div>
                        <div style="width:100%; height:6px; background:var(--bg); border-radius:3px; overflow:hidden;">
                            <div style="width:8.4%; height:100%; background:var(--brand); border-radius:3px;"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div style="border-top:1px solid var(--border); margin:1rem 0 1.5rem;"></div>

{{-- Notifications --}}
<div class="row g-3 mb-4">
    <div class="col-12 col-md-4">
        <div style="font-weight:700; font-size:0.95rem; color:var(--text-primary); margin-bottom:4px;">Notification Preferences</div>
        <div style="font-size:0.82rem; color:var(--text-muted); line-height:1.5;">Choose when and how you receive alerts.</div>
    </div>
    <div class="col-12 col-md-8">
        <div class="bh-card">
            <div class="bh-card-body">
                <form onsubmit="event.preventDefault(); alert('Notification preferences saved!');">
                    <div class="form-check form-switch mb-3">
                        <input class="form-check-input" type="checkbox" id="notify-comments" checked>
                        <label class="form-check-label" for="notify-comments" style="font-size:0.84rem;">Email on new comments</label>
                    </div>
                    <div class="form-check form-switch mb-3">
                        <input class="form-check-input" type="checkbox" id="notify-contact" checked>
                        <label class="form-check-label" for="notify-contact" style="font-size:0.84rem;">Email on contact inquiries</label>
                    </div>
                    <div class="form-check form-switch mb-3">
                        <input class="form-check-input" type="checkbox" id="notify-analytics" checked>
                        <label class="form-check-label" for="notify-analytics" style="font-size:0.84rem;">Weekly analytics summary</label>
                    </div>
                    <button type="submit" class="bh-btn bh-btn-primary">
                        <i class="fa-solid fa-floppy-disk"></i> Save Preferences
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
