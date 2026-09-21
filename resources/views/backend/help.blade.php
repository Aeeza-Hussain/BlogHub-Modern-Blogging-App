@extends('backend.layouts.admin')

@section('title', 'BlogHub - Documentation & Help')

@section('content')
<h1 class="app-page-title"><i class="fa-solid fa-circle-question text-primary me-2"></i> Documentation &amp; Help Center</h1>

<div class="row g-4 mb-4">
    <div class="col-12 col-md-6">
        <div class="app-card app-card-basic d-flex flex-column align-items-start shadow-sm h-100">
            <div class="app-card-header p-3 border-bottom-0">
                <div class="row align-items-center gx-3">
                    <div class="col-auto">
                        <div class="app-icon-holder text-primary bg-light">
                            <i class="fa-solid fa-pen-nib"></i>
                        </div>
                    </div>
                    <div class="col-auto">
                        <h4 class="app-card-title">Managing Blog Articles</h4>
                    </div>
                </div>
            </div>
            <div class="app-card-body px-4">
                <div class="intro">Learn how to create, edit, categorize, and feature articles on BlogHub. Support for markdown syntax, featured images, and tags.</div>
            </div>
            <div class="app-card-footer p-4 mt-auto">
                <a class="btn app-btn-secondary" href="{{ route('blogs.create') }}">Create Article</a>
            </div>
        </div>
    </div>

    <div class="col-12 col-md-6">
        <div class="app-card app-card-basic d-flex flex-column align-items-start shadow-sm h-100">
            <div class="app-card-header p-3 border-bottom-0">
                <div class="row align-items-center gx-3">
                    <div class="col-auto">
                        <div class="app-icon-holder text-success bg-light">
                            <i class="fa-solid fa-chart-line"></i>
                        </div>
                    </div>
                    <div class="col-auto">
                        <h4 class="app-card-title">Analytics &amp; Engagement</h4>
                    </div>
                </div>
            </div>
            <div class="app-card-body px-4">
                <div class="intro">Understand reader traffic, view counts per category, likes, and comment feedback using interactive Chart.js widgets.</div>
            </div>
            <div class="app-card-footer p-4 mt-auto">
                <a class="btn app-btn-secondary" href="{{ route('dashboard.charts') }}">View Analytics</a>
            </div>
        </div>
    </div>
</div>

<h3 class="mt-5 mb-3">Frequently Asked Questions</h3>

<div class="accordion" id="help-accordion">
    <div class="accordion-item mb-3 border rounded shadow-sm">
        <h2 class="accordion-header" id="faq-heading-1">
            <button class="accordion-button fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#faq-collapse-1" aria-expanded="true" aria-controls="faq-collapse-1">
                How do I mark an article as Featured or Trending?
            </button>
        </h2>
        <div id="faq-collapse-1" class="accordion-collapse collapse show" aria-labelledby="faq-heading-1" data-bs-parent="#help-accordion">
            <div class="accordion-body">
                When creating or editing an article, check the <strong>Featured</strong> or <strong>Trending</strong> checkboxes. Featured articles appear on the main homepage hero banner, while Trending articles highlight on the trending sidebar.
            </div>
        </div>
    </div>

    <div class="accordion-item mb-3 border rounded shadow-sm">
        <h2 class="accordion-header" id="faq-heading-2">
            <button class="accordion-button collapsed fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#faq-collapse-2" aria-expanded="false" aria-controls="faq-collapse-2">
                How are page views and likes calculated?
            </button>
        </h2>
        <div id="faq-collapse-2" class="accordion-collapse collapse" aria-labelledby="faq-heading-2" data-bs-parent="#help-accordion">
            <div class="accordion-body">
                Page views increment automatically whenever a reader visits a single article view. Likes are logged via AJAX when a user clicks the heart icon on any post.
            </div>
        </div>
    </div>

    <div class="accordion-item mb-3 border rounded shadow-sm">
        <h2 class="accordion-header" id="faq-heading-3">
            <button class="accordion-button collapsed fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#faq-collapse-3" aria-expanded="false" aria-controls="faq-collapse-3">
                Where do contact messages go?
            </button>
        </h2>
        <div id="faq-collapse-3" class="accordion-collapse collapse" aria-labelledby="faq-heading-3" data-bs-parent="#help-accordion">
            <div class="accordion-body">
                All contact form submissions from the public website are automatically sent to the <strong>Notifications</strong> tab in the admin portal.
            </div>
        </div>
    </div>
</div>
@endsection
