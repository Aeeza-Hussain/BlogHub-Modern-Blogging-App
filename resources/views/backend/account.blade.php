@extends('backend.layouts.admin')

@section('title', 'Account & Profile — BlogHub')

@section('content')

{{-- Page Header --}}
<div class="bh-page-header">
    <div>
        <h1 class="bh-page-title">Account &amp; Profile</h1>
        <p class="bh-page-sub">View your profile information and account security settings.</p>
    </div>
    @if(isset($author) && $author->slug)
    <a href="{{ route('authors.show', $author->slug) }}" target="_blank" class="bh-btn bh-btn-ghost">
        <i class="fa-solid fa-globe"></i> View Public Profile
    </a>
    @endif
</div>

<div class="row g-3">
    {{-- Profile Card --}}
    <div class="col-12 col-lg-6">
        <div class="bh-card" style="height:100%;">
            <div class="bh-card-header">
                <div class="bh-card-title"><i class="fa-solid fa-user me-2" style="color:var(--brand);"></i> Profile Details</div>
            </div>
            <div class="bh-card-body">
                {{-- Avatar --}}
                <div class="d-flex align-items-center gap-3 mb-4 pb-3" style="border-bottom:1px solid var(--border);">
                    <img src="{{ auth()->user()->image ? asset('storage/' . auth()->user()->image) : ($author->avatar ?? 'https://ui-avatars.com/api/?name=' . urlencode(auth()->user()->name) . '&background=C8461F&color=fff&bold=true') }}"
                         class="rounded-circle"
                         style="width:56px; height:56px; object-fit:cover; border:2px solid var(--border);">
                    <div>
                        <div style="font-weight:700; font-size:1rem; color:var(--text-primary);">{{ auth()->user()->name }}</div>
                        <div style="font-size:0.78rem; color:var(--text-muted);">{{ auth()->user()->email }}</div>
                    </div>
                </div>

                {{-- Fields --}}
                @php
                    $fields = [
                        ['Niche / Specialty', auth()->user()->niche ?? ($author->specialty ?? '—'), 'fa-tag'],
                        ['Contact', auth()->user()->contact ?? '—', 'fa-phone'],
                        ['Gender', auth()->user()->gender ? ucfirst(str_replace('_', ' ', auth()->user()->gender)) : '—', 'fa-venus-mars'],
                        ['Date of Birth', auth()->user()->dob ? auth()->user()->dob->format('M d, Y') : '—', 'fa-calendar'],
                        ['Bio', auth()->user()->about ?? ($author->bio ?? '—'), 'fa-align-left'],
                    ];
                @endphp

                @foreach($fields as $f)
                <div class="d-flex align-items-start gap-3 py-2" style="border-bottom:1px solid var(--border);">
                    <i class="fa-solid {{ $f[2] }}" style="width:16px; margin-top:3px; color:var(--text-light); font-size:0.8rem;"></i>
                    <div style="flex:1;">
                        <div style="font-size:0.72rem; font-weight:600; text-transform:uppercase; letter-spacing:.04em; color:var(--text-light); margin-bottom:2px;">{{ $f[0] }}</div>
                        <div style="font-size:0.86rem; color:var(--text-primary);">{{ $f[1] }}</div>
                    </div>
                </div>
                @endforeach

                {{-- Community Stats --}}
                <div class="d-flex gap-3 mt-3">
                    <div class="bh-badge" style="background:rgba(37,99,235,0.1); color:#2563eb; padding:4px 10px;">
                        <i class="fa-solid fa-users me-1"></i> {{ $author->followers_count ?? 0 }} Followers
                    </div>
                    <div class="bh-badge" style="background:rgba(100,116,139,0.1); color:#64748b; padding:4px 10px;">
                        {{ $author->following_count ?? 0 }} Following
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Security Card --}}
    <div class="col-12 col-lg-6">
        <div class="bh-card" style="height:100%;">
            <div class="bh-card-header">
                <div class="bh-card-title"><i class="fa-solid fa-shield-halved me-2" style="color:#10b981;"></i> Security &amp; Access</div>
            </div>
            <div class="bh-card-body">
                @php
                    $secItems = [
                        ['Account Email', auth()->user()->email, 'fa-envelope', null],
                        ['Password', '••••••••••', 'fa-lock', null],
                        ['Account Type', auth()->user()->user_type == 1 ? 'Admin' : (auth()->user()->user_type == 2 ? 'Author' : 'User'), 'fa-id-badge', null],
                        ['Member Since', auth()->user()->created_at->format('M d, Y'), 'fa-calendar-check', null],
                    ];
                @endphp

                @foreach($secItems as $s)
                <div class="d-flex align-items-center gap-3 py-3" style="border-bottom:1px solid var(--border);">
                    <i class="fa-solid {{ $s[2] }}" style="width:16px; color:var(--text-light); font-size:0.8rem;"></i>
                    <div style="flex:1;">
                        <div style="font-size:0.72rem; font-weight:600; text-transform:uppercase; letter-spacing:.04em; color:var(--text-light); margin-bottom:2px;">{{ $s[0] }}</div>
                        <div style="font-size:0.86rem; color:var(--text-primary);">{{ $s[1] }}</div>
                    </div>
                </div>
                @endforeach

                <div class="mt-4">
                    <a href="{{ route('dashboard.settings') }}" class="bh-btn bh-btn-ghost" style="width:100%; justify-content:center;">
                        <i class="fa-solid fa-gear"></i> Go to Settings
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
