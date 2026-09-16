@extends('layouts.admin')

@section('title', 'BlogHub - Notifications & Feedback')

@section('content')
<div class="position-relative mb-4">
    <div class="row g-3 justify-content-between align-items-center">
        <div class="col-auto">
            <h1 class="app-page-title mb-0"><i class="fa-solid fa-bell text-primary me-2"></i> Notifications &amp; Inquiries</h1>
        </div>
    </div>
</div>

<h4 class="mb-3 text-muted">Contact Form Submissions</h4>

@forelse($messages as $msg)
<div class="app-card app-card-notification shadow-sm mb-4">
    <div class="app-card-header px-4 py-3">
        <div class="row g-3 align-items-center">
            <div class="col-12 col-lg-auto text-center text-lg-start">						        
                <div class="app-icon-holder bg-light text-primary fs-5">
                    <i class="fa-solid fa-envelope"></i>
                </div>
            </div>
            <div class="col-12 col-lg-auto text-center text-lg-start">
                <div class="notification-type mb-2"><span class="badge bg-primary">Inquiry</span></div>
                <h4 class="notification-title mb-1">{{ $msg->subject }}</h4>
                <ul class="notification-meta list-inline mb-0">
                    <li class="list-inline-item">{{ $msg->created_at->diffForHumans() }}</li>
                    <li class="list-inline-item">|</li>
                    <li class="list-inline-item"><strong>{{ $msg->name }}</strong> ({{ $msg->email }})</li>
                </ul>
            </div>
        </div>
    </div>
    <div class="app-card-body p-4">
        <div class="notification-content">{{ $msg->message }}</div>
    </div>
</div>
@empty
<div class="app-card shadow-sm p-4 text-center text-muted mb-4">
    No contact form submissions recorded yet.
</div>
@endforelse

<h4 class="mt-5 mb-3 text-muted">Latest User Comments</h4>

@forelse($comments as $comment)
<div class="app-card app-card-notification shadow-sm mb-4 border-left-decoration">
    <div class="app-card-header px-4 py-3">
        <div class="row g-3 align-items-center">
            <div class="col-12 col-lg-auto text-center text-lg-start">						        
                <img class="profile-image rounded-circle" src="{{ $comment->user_avatar ?? 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=80' }}" style="width: 45px; height: 45px; object-fit: cover;" alt="">
            </div>
            <div class="col-12 col-lg-auto text-center text-lg-start">
                <div class="notification-type mb-2"><span class="badge bg-success">Comment</span></div>
                <h4 class="notification-title mb-1">Comment on: "{{ $comment->article->title ?? 'Article' }}"</h4>
                <ul class="notification-meta list-inline mb-0">
                    <li class="list-inline-item">{{ $comment->created_at->diffForHumans() }}</li>
                    <li class="list-inline-item">|</li>
                    <li class="list-inline-item">By <strong>{{ $comment->user_name }}</strong></li>
                </ul>
            </div>
        </div>
    </div>
    <div class="app-card-body p-4">
        <div class="notification-content">"{{ $comment->content }}"</div>
    </div>
    @if($comment->article)
    <div class="app-card-footer px-4 py-3">
        <a class="action-link" href="{{ route('blogs.show', $comment->article->slug) }}" target="_blank">View Post <i class="fa-solid fa-arrow-right me-1"></i></a>
    </div>
    @endif
</div>
@empty
<div class="app-card shadow-sm p-4 text-center text-muted">
    No recent user comments available.
</div>
@endforelse
@endsection
