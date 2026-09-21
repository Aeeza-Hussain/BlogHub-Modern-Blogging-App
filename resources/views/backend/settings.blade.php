@extends('backend.layouts.admin')

@section('title', 'BlogHub - Settings')

@section('content')
<h1 class="app-page-title"><i class="fa-solid fa-gear text-primary me-2"></i> Settings</h1>
<hr class="mb-4">

<div class="row g-4 settings-section mb-4">
    <div class="col-12 col-md-4">
        <h3 class="section-title">General Settings</h3>
        <div class="section-intro">Configure main blog details, public site title, contact email, and default pagination settings.</div>
    </div>
    <div class="col-12 col-md-8">
        <div class="app-card app-card-settings shadow-sm p-4">
            <div class="app-card-body">
                <form class="settings-form" onsubmit="event.preventDefault(); alert('Settings saved successfully!');">
                    <div class="mb-3">
                        <label for="setting-site-title" class="form-label">Publication Name</label>
                        <input type="text" class="form-control" id="setting-site-title" value="BlogHub Modern Media" required>
                    </div>
                    <div class="mb-3">
                        <label for="setting-admin-email" class="form-label">Admin Contact Email</label>
                        <input type="email" class="form-control" id="setting-admin-email" value="admin@bloghub.com" required>
                    </div>
                    <div class="mb-3">
                        <label for="setting-posts-per-page" class="form-label">Posts Per Page</label>
                        <input type="number" class="form-control" id="setting-posts-per-page" value="9" min="3" max="30">
                    </div>
                    <button type="submit" class="btn app-btn-primary"><i class="fa-solid fa-floppy-disk me-1"></i> Save Changes</button>
                </form>
            </div>
        </div>
    </div>
</div>

<hr class="my-4">

<div class="row g-4 settings-section mb-4">
    <div class="col-12 col-md-4">
        <h3 class="section-title">Subscription &amp; License</h3>
        <div class="section-intro">Current platform tier, limits, and storage allotment for images and draft articles.</div>
    </div>
    <div class="col-12 col-md-8">
        <div class="app-card app-card-settings shadow-sm p-4">
            <div class="app-card-body">
                <div class="mb-2"><strong>Current License:</strong> <span class="badge bg-primary">Enterprise Publisher</span></div>
                <div class="mb-2"><strong>Status:</strong> <span class="badge bg-success">Active &amp; Verified</span></div>
                <div class="mb-2"><strong>CDN &amp; Storage:</strong> 4.2 GB / 50 GB Used</div>
                <div class="mb-4"><strong>Renewal Date:</strong> Dec 31, 2028</div>
                <div class="row justify-content-between">
                    <div class="col-auto">
                        <button class="btn app-btn-primary" disabled><i class="fa-solid fa-up-long me-1"></i> Upgrade Storage</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<hr class="my-4">

<div class="row g-4 settings-section mb-4">
    <div class="col-12 col-md-4">
        <h3 class="section-title">Notifications &amp; Activity Alerts</h3>
        <div class="section-intro">Choose when and how you receive alerts for comments, newsletter signups, and contact submissions.</div>
    </div>
    <div class="col-12 col-md-8">
        <div class="app-card app-card-settings shadow-sm p-4">
            <div class="app-card-body">
                <form class="settings-form" onsubmit="event.preventDefault(); alert('Notification preferences saved!');">
                    <div class="form-check form-switch mb-3">
                        <input class="form-check-input" type="checkbox" id="notify-comments" checked>
                        <label class="form-check-label" for="notify-comments">Email me when a new comment is posted</label>
                    </div>
                    <div class="form-check form-switch mb-3">
                        <input class="form-check-input" type="checkbox" id="notify-contact" checked>
                        <label class="form-check-label" for="notify-contact">Email me on contact form inquiries</label>
                    </div>
                    <div class="form-check form-switch mb-3">
                        <input class="form-check-input" type="checkbox" id="notify-analytics" checked>
                        <label class="form-check-label" for="notify-analytics">Send weekly readership analytics summary</label>
                    </div>
                    <div class="mt-3">
                        <button type="submit" class="btn app-btn-primary"><i class="fa-solid fa-floppy-disk me-1"></i> Save Preferences</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
