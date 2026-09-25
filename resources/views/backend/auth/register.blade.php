@extends('layouts.app')

@section('title', 'Create Account & Author Profile — BlogHub')

@push('styles')
<style>
  /* ===================================================
     Ultra-Professional BlogHub Registration Architecture
     =================================================== */
  .bh-reg-wrapper {
    min-height: calc(100vh - 80px);
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 3rem 1rem;
    background: radial-gradient(circle at 15% 15%, rgba(200, 70, 31, 0.04) 0%, transparent 45%),
                radial-gradient(circle at 85% 85%, rgba(31, 42, 68, 0.05) 0%, transparent 50%),
                var(--bh-bg, #f8fafc);
  }

  [data-theme="dark"] .bh-reg-wrapper {
    background: radial-gradient(circle at 15% 15%, rgba(255, 107, 74, 0.07) 0%, transparent 45%),
                radial-gradient(circle at 85% 85%, rgba(99, 102, 241, 0.08) 0%, transparent 50%),
                var(--bh-bg, #0f172a);
  }

  .bh-reg-card {
    background: var(--bh-card-bg, #ffffff);
    border: 1px solid var(--bh-border, #e2e8f0);
    border-radius: 20px;
    box-shadow: 0 20px 45px -12px rgba(15, 23, 42, 0.1);
    overflow: hidden;
    width: 100%;
    max-width: 1100px;
  }

  [data-theme="dark"] .bh-reg-card {
    border-color: rgba(255, 255, 255, 0.08);
    box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5);
  }

  /* Left Editorial Sidebar */
  .bh-reg-sidebar {
    background: radial-gradient(circle at 0% 0%, rgba(200, 70, 31, 0.28) 0%, transparent 55%),
                radial-gradient(circle at 100% 100%, rgba(99, 102, 241, 0.22) 0%, transparent 60%),
                #121826;
    color: #ffffff;
    padding: 3rem 2.25rem;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    position: relative;
    overflow: hidden;
  }

  .bh-reg-badge {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    background: rgba(255, 255, 255, 0.08);
    border: 1px solid rgba(255, 255, 255, 0.12);
    border-radius: 30px;
    padding: 0.35rem 0.85rem;
    font-size: 0.78rem;
    letter-spacing: 0.03em;
    font-weight: 600;
    color: #ffd8cc;
  }

  /* Niche Showcase Cards on Left Side */
  .bh-niche-showcase-list {
    margin: 1.5rem 0;
  }

  .bh-niche-showcase-card {
    background: rgba(255, 255, 255, 0.04);
    border: 1px solid rgba(255, 255, 255, 0.08);
    backdrop-filter: blur(8px);
    -webkit-backdrop-filter: blur(8px);
    border-radius: 12px;
    padding: 0.65rem 0.9rem;
    margin-bottom: 0.65rem;
    display: flex;
    align-items: center;
    gap: 0.75rem;
    transition: all 0.25s ease;
  }

  .bh-niche-showcase-card:hover {
    background: rgba(255, 255, 255, 0.08);
    transform: translateX(4px);
    border-color: rgba(255, 255, 255, 0.18);
  }

  .bh-nsc-icon {
    width: 32px;
    height: 32px;
    border-radius: 8px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 0.85rem;
    color: #ffffff;
    flex-shrink: 0;
  }

  .bh-nsc-title {
    font-size: 0.84rem;
    font-weight: 600;
    color: #ffffff;
    line-height: 1.2;
    display: block;
  }

  .bh-nsc-sub {
    font-size: 0.7rem;
    color: #94a3b8;
    display: block;
  }

  .bh-nsc-pill {
    margin-left: auto;
    font-size: 0.68rem;
    font-weight: 600;
    padding: 2px 7px;
    border-radius: 10px;
    background: rgba(255, 255, 255, 0.1);
    color: #cbd5e1;
  }

  .bh-nsc-pill.hot {
    background: rgba(200, 70, 31, 0.3);
    color: #ff9d85;
    border: 1px solid rgba(200, 70, 31, 0.4);
  }

  /* Community Trust Footer */
  .bh-community-trust {
    background: rgba(255, 255, 255, 0.03);
    border: 1px solid rgba(255, 255, 255, 0.07);
    border-radius: 14px;
    padding: 1rem 1.15rem;
  }

  .bh-avatar-stack {
    display: flex;
    align-items: center;
  }

  .bh-avatar-stack img {
    width: 28px;
    height: 28px;
    border-radius: 50%;
    border: 2px solid #121826;
    margin-left: -7px;
    object-fit: cover;
  }

  .bh-avatar-stack img:first-child {
    margin-left: 0;
  }

  /* Right Form Area */
  .bh-reg-main {
    padding: 3rem 2.75rem;
  }

  @media (max-width: 768px) {
    .bh-reg-main {
      padding: 2rem 1.5rem;
    }
  }

  /* Refined Form Controls with Inset Icons */
  .bh-field-group {
    position: relative;
    margin-bottom: 1.25rem;
  }

  .bh-field-label {
    display: flex;
    align-items: center;
    justify-content: space-between;
    font-size: 0.82rem;
    font-weight: 600;
    color: var(--bh-ink, #334155);
    margin-bottom: 0.4rem;
    letter-spacing: 0.01em;
  }

  .bh-input-wrapper {
    position: relative;
    display: flex;
    align-items: center;
  }

  .bh-input-icon {
    position: absolute;
    left: 1rem;
    color: #94a3b8;
    font-size: 0.95rem;
    pointer-events: none;
    z-index: 5;
    transition: color 0.2s ease;
  }

  .bh-modern-input,
  .bh-modern-select,
  .bh-modern-textarea {
    width: 100%;
    padding: 0.72rem 1rem 0.72rem 2.65rem;
    font-size: 0.92rem;
    color: var(--bh-ink, #1F2A44);
    background-color: var(--bh-card-bg, #ffffff);
    border: 1.5px solid var(--bh-border, #e2e8f0);
    border-radius: 10px;
    transition: all 0.2s ease;
    box-shadow: 0 1px 2px rgba(0, 0, 0, 0.02);
  }

  .bh-modern-textarea {
    padding-left: 2.65rem;
    resize: vertical;
    min-height: 90px;
  }

  .bh-modern-input:focus,
  .bh-modern-select:focus,
  .bh-modern-textarea:focus {
    border-color: var(--bh-accent, #C8461F);
    box-shadow: 0 0 0 3px rgba(200, 70, 31, 0.12);
    outline: none;
  }

  .bh-input-wrapper:focus-within .bh-input-icon {
    color: var(--bh-accent, #C8461F);
  }

  .bh-toggle-btn {
    position: absolute;
    right: 0.75rem;
    background: transparent;
    border: none;
    color: #94a3b8;
    padding: 0.25rem 0.5rem;
    cursor: pointer;
    font-size: 0.95rem;
    transition: color 0.2s;
    z-index: 5;
  }

  .bh-toggle-btn:hover {
    color: var(--bh-ink, #1F2A44);
  }

  /* Compact Avatar Upload Component */
  .bh-avatar-upload-card {
    background: var(--bh-light-subtle, #f8fafc);
    border: 1px dashed var(--bh-border, #cbd5e1);
    border-radius: 12px;
    padding: 1rem 1.25rem;
    margin-bottom: 1.5rem;
    display: flex;
    align-items: center;
    gap: 1.25rem;
    transition: border-color 0.2s;
  }

  .bh-avatar-upload-card:hover {
    border-color: var(--bh-accent, #C8461F);
  }

  .bh-avatar-thumb {
    width: 68px;
    height: 68px;
    border-radius: 50%;
    object-fit: cover;
    border: 2px solid var(--bh-border, #e2e8f0);
    background: var(--bh-card-bg, #ffffff);
    flex-shrink: 0;
  }

  .bh-avatar-thumb-placeholder {
    width: 68px;
    height: 68px;
    border-radius: 50%;
    border: 2px solid var(--bh-border, #e2e8f0);
    background: var(--bh-card-bg, #ffffff);
    display: flex;
    align-items: center;
    justify-content: center;
    color: #94a3b8;
    font-size: 1.5rem;
    flex-shrink: 0;
  }

  /* Custom Searchable Niche Dropdown */
  .bh-niche-custom-dropdown {
    position: relative;
    width: 100%;
  }

  .bh-niche-btn-trigger {
    width: 100%;
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 0.72rem 1rem 0.72rem 2.65rem;
    background: var(--bh-card-bg, #ffffff);
    border: 1.5px solid var(--bh-border, #e2e8f0);
    border-radius: 10px;
    color: var(--bh-ink, #1F2A44);
    font-size: 0.92rem;
    text-align: left;
    transition: all 0.2s ease;
    cursor: pointer;
  }

  .bh-niche-btn-trigger:focus,
  .bh-niche-btn-trigger.active {
    border-color: var(--bh-accent, #C8461F);
    box-shadow: 0 0 0 3px rgba(200, 70, 31, 0.12);
    outline: none;
  }

  .bh-niche-menu-popover {
    position: absolute;
    top: calc(100% + 6px);
    left: 0;
    right: 0;
    background: var(--bh-card-bg, #ffffff);
    border: 1px solid var(--bh-border, #e2e8f0);
    border-radius: 12px;
    box-shadow: 0 15px 35px rgba(0, 0, 0, 0.15);
    z-index: 1050;
    display: none;
    overflow: hidden;
    animation: dropdownSlide 0.2s ease-out forwards;
  }

  @keyframes dropdownSlide {
    from { opacity: 0; transform: translateY(-6px); }
    to { opacity: 1; transform: translateY(0); }
  }

  .bh-niche-menu-popover.show {
    display: block;
  }

  .bh-niche-search-bar {
    padding: 0.75rem;
    background: var(--bh-light-subtle, #f8fafc);
    border-bottom: 1px solid var(--bh-border, #e2e8f0);
    position: relative;
  }

  .bh-niche-search-input {
    width: 100%;
    padding: 0.45rem 0.75rem 0.45rem 2.1rem;
    font-size: 0.85rem;
    border: 1px solid var(--bh-border, #e2e8f0);
    border-radius: 6px;
    background: var(--bh-card-bg, #ffffff);
    color: var(--bh-ink, #1F2A44);
  }

  .bh-niche-search-input:focus {
    border-color: var(--bh-accent, #C8461F);
    outline: none;
  }

  .bh-niche-chips {
    display: flex;
    flex-wrap: wrap;
    gap: 6px;
    padding: 0.5rem 0.75rem;
    border-bottom: 1px solid var(--bh-border, #e2e8f0);
    background: var(--bh-card-bg, #ffffff);
  }

  .bh-niche-chip-btn {
    font-size: 0.74rem;
    font-weight: 500;
    padding: 2px 10px;
    border-radius: 14px;
    border: 1px solid var(--bh-border, #e2e8f0);
    background: var(--bh-light-subtle, #f8fafc);
    color: var(--bh-ink, #1F2A44);
    cursor: pointer;
    transition: all 0.15s ease;
  }

  .bh-niche-chip-btn:hover,
  .bh-niche-chip-btn.active {
    background: var(--bh-accent, #C8461F);
    color: #ffffff;
    border-color: var(--bh-accent, #C8461F);
  }

  .bh-niche-items-container {
    max-height: 240px;
    overflow-y: auto;
    margin: 0;
    padding: 0.35rem 0;
    list-style: none;
  }

  .bh-niche-item {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 0.6rem 1rem;
    cursor: pointer;
    transition: background 0.15s;
    border-left: 3px solid transparent;
  }

  .bh-niche-item:hover {
    background: rgba(200, 70, 31, 0.06);
  }

  .bh-niche-item.selected {
    background: rgba(200, 70, 31, 0.1);
    border-left-color: var(--bh-accent, #C8461F);
  }

  .bh-niche-badge-icon {
    width: 28px;
    height: 28px;
    border-radius: 6px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    color: #ffffff;
    font-size: 0.8rem;
    flex-shrink: 0;
  }

  /* Submit Button with High-End Gradient */
  .bh-btn-register-primary {
    background: linear-gradient(135deg, #C8461F 0%, #e05327 100%);
    color: #ffffff;
    border: none;
    border-radius: 10px;
    padding: 0.85rem 1.5rem;
    font-size: 1rem;
    font-weight: 600;
    letter-spacing: 0.01em;
    width: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    box-shadow: 0 4px 15px rgba(200, 70, 31, 0.25);
    transition: all 0.25s ease;
  }

  .bh-btn-register-primary:hover {
    transform: translateY(-1px);
    box-shadow: 0 8px 25px rgba(200, 70, 31, 0.35);
    background: linear-gradient(135deg, #b83d18 0%, #d44920 100%);
    color: #ffffff;
  }

  /* Dark mode adaptations */
  [data-theme="dark"] .bh-avatar-upload-card {
    background: #1e293b;
    border-color: #334155;
  }
  [data-theme="dark"] .bh-modern-input,
  [data-theme="dark"] .bh-modern-select,
  [data-theme="dark"] .bh-modern-textarea,
  [data-theme="dark"] .bh-niche-btn-trigger {
    background-color: #1e293b;
    border-color: #334155;
    color: #f8fafc;
  }
  [data-theme="dark"] .bh-niche-search-bar {
    background: #0f172a;
    border-color: #334155;
  }
  [data-theme="dark"] .bh-niche-search-input {
    background: #1e293b;
    border-color: #334155;
    color: #f8fafc;
  }
  [data-theme="dark"] .bh-niche-chips {
    background: #1e293b;
    border-color: #334155;
  }
  [data-theme="dark"] .bh-niche-chip-btn {
    background: #0f172a;
    border-color: #334155;
    color: #cbd5e1;
  }
  [data-theme="dark"] .bh-field-label {
    color: #e2e8f0;
  }
</style>
@endpush

@section('content')
<div class="bh-reg-wrapper">
  <div class="bh-reg-card">
    <div class="row g-0">
      
      <!-- ==============================================
           LEFT PANEL: Editorial Niche Showcase & Creator Studio
           ============================================== -->
      <div class="col-lg-4 d-none d-lg-flex bh-reg-sidebar">
        <div>
          <!-- Header Badge -->
          <div class="bh-reg-badge mb-3">
            <i class="fa-solid fa-feather-pointed text-warning"></i>
            <span>CREATOR NETWORK</span>
          </div>

          <h3 class="fw-bold text-white mb-2" style="font-size: 1.7rem; letter-spacing: -0.02em; line-height: 1.25;">
            Where Modern Voices Build Their Legacy.
          </h3>
          <p class="text-white-50 small mb-3">
            Join thousands of writers sharing stories across the world's most vibrant topics:
          </p>

          <!-- Featured Niche Showcase Cards -->
          <div class="bh-niche-showcase-list">
            <!-- 1. AI -->
            <div class="bh-niche-showcase-card">
              <span class="bh-nsc-icon" style="background: linear-gradient(135deg, #7C3AED, #9333EA);">
                <i class="fa-solid fa-brain"></i>
              </span>
              <div>
                <span class="bh-nsc-title">Artificial Intelligence</span>
                <span class="bh-nsc-sub">Machine learning &amp; neural tech</span>
              </div>
              <span class="bh-nsc-pill hot">Trending</span>
            </div>

            <!-- 2. Tech -->
            <div class="bh-niche-showcase-card">
              <span class="bh-nsc-icon" style="background: linear-gradient(135deg, #2563EB, #3B82F6);">
                <i class="fa-solid fa-laptop-code"></i>
              </span>
              <div>
                <span class="bh-nsc-title">Technology &amp; Code</span>
                <span class="bh-nsc-sub">Software engineering &amp; cloud</span>
              </div>
              <span class="bh-nsc-pill">Popular</span>
            </div>

            <!-- 3. Cooking -->
            <div class="bh-niche-showcase-card">
              <span class="bh-nsc-icon" style="background: linear-gradient(135deg, #D97706, #F59E0B);">
                <i class="fa-solid fa-utensils"></i>
              </span>
              <div>
                <span class="bh-nsc-title">Food &amp; Cooking</span>
                <span class="bh-nsc-sub">Culinary arts &amp; recipes</span>
              </div>
            </div>

            <!-- 4. Sports -->
            <div class="bh-niche-showcase-card">
              <span class="bh-nsc-icon" style="background: linear-gradient(135deg, #DC2626, #EF4444);">
                <i class="fa-solid fa-futbol"></i>
              </span>
              <div>
                <span class="bh-nsc-title">Sports &amp; Fitness</span>
                <span class="bh-nsc-sub">Athletics &amp; active wellness</span>
              </div>
            </div>

            <!-- 5. Fashion -->
            <div class="bh-niche-showcase-card">
              <span class="bh-nsc-icon" style="background: linear-gradient(135deg, #DB2777, #EC4899);">
                <i class="fa-solid fa-shirt"></i>
              </span>
              <div>
                <span class="bh-nsc-title">Fashion &amp; Style</span>
                <span class="bh-nsc-sub">Runway trends &amp; aesthetics</span>
              </div>
            </div>
          </div>
        </div>

        <!-- Community Trust Card at Bottom -->
        <div class="bh-community-trust mt-3">
          <div class="d-flex align-items-center justify-content-between mb-2">
            <div class="bh-avatar-stack">
              <img src="https://images.unsplash.com/photo-1534528741775-53994a69daeb?w=60&auto=format&fit=crop&q=80" alt="Author">
              <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=60&auto=format&fit=crop&q=80" alt="Author">
              <img src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?w=60&auto=format&fit=crop&q=80" alt="Author">
            </div>
            <div class="text-warning small" style="font-size: 0.72rem;">
              <i class="fa-solid fa-star"></i>
              <i class="fa-solid fa-star"></i>
              <i class="fa-solid fa-star"></i>
              <i class="fa-solid fa-star"></i>
              <i class="fa-solid fa-star"></i>
            </div>
          </div>
          <p class="text-white-50 small mb-0" style="font-size: 0.78rem; line-height: 1.4;">
            Join over <strong>15,000+</strong> writers and reach millions of monthly readers on BlogHub.
          </p>
        </div>
      </div>

      <!-- ==============================================
           RIGHT PANEL: Streamlined Registration Form
           ============================================== -->
      <div class="col-12 col-lg-8 bh-reg-main">
        
        <!-- Header -->
        <div class="d-flex align-items-center justify-content-between mb-4 pb-2 border-bottom">
          <div>
            <h2 class="fw-bold fs-3 mb-1" style="color: var(--bh-ink, #0f172a); letter-spacing: -0.02em;">Create Author Account</h2>
            <p class="text-muted small mb-0">Fill out your profile details to join our writer network</p>
          </div>
          <div class="d-none d-sm-block text-end">
            <span class="small text-muted d-block">Already a member?</span>
            <a href="{{ route('login') }}" class="fw-bold text-accent text-decoration-none small">Sign in instead &rarr;</a>
          </div>
        </div>

        <!-- Error Notifications -->
        @if ($errors->any())
          <div class="alert alert-danger border-0 rounded-3 shadow-sm mb-4 p-3" role="alert">
            <div class="d-flex align-items-center gap-2 fw-semibold mb-1">
              <i class="fa-solid fa-circle-exclamation text-danger"></i>
              <span>Please review the form errors:</span>
            </div>
            <ul class="mb-0 ps-3 small text-danger">
              @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
              @endforeach
            </ul>
          </div>
        @endif

        <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data" novalidate id="registerForm">
          @csrf

          <!-- 1. Profile Picture Upload Section -->
          <div class="bh-avatar-upload-card">
            <div id="avatarPlaceholderBox" class="bh-avatar-thumb-placeholder">
              <i class="fa-regular fa-user"></i>
            </div>
            <img id="avatarImgPreview" src="" alt="Avatar" class="bh-avatar-thumb d-none">

            <div class="flex-grow-1">
              <div class="d-flex align-items-center gap-2 flex-wrap mb-1">
                <label for="imageInput" class="btn btn-sm btn-outline-secondary rounded-pill px-3 py-1 font-mono small fw-semibold">
                  <i class="fa-solid fa-arrow-up-from-bracket me-1 text-accent"></i> Upload Profile Photo
                </label>
                <button type="button" id="resetAvatarBtn" class="btn btn-sm btn-link text-muted p-0 small text-decoration-none d-none">
                  <i class="fa-solid fa-xmark"></i> Remove
                </button>
              </div>
              <input type="file" id="imageInput" name="image" class="d-none @error('image') is-invalid @enderror" accept="image/jpeg,image/png,image/jpg,image/webp,image/gif">
              <div class="text-muted" style="font-size: 0.76rem;">
                Recommended: Square image (JPG, PNG, WebP), max 4MB.
              </div>
              @error('image')
                <div class="text-danger small mt-1"><i class="fa-solid fa-circle-info me-1"></i>{{ $message }}</div>
              @enderror
            </div>
          </div>

          <!-- 2. Row: Full Name & Email Address -->
          <div class="row g-3">
            <div class="col-12 col-md-6">
              <div class="bh-field-group">
                <label for="name" class="bh-field-label">
                  <span>Full Name <span class="text-danger">*</span></span>
                </label>
                <div class="bh-input-wrapper">
                  <i class="fa-regular fa-user bh-input-icon"></i>
                  <input id="name" type="text" class="bh-modern-input @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus placeholder="Enter your full name">
                </div>
                @error('name')
                  <div class="text-danger small mt-1"><i class="fa-solid fa-circle-info me-1"></i>{{ $message }}</div>
                @enderror
              </div>
            </div>

            <div class="col-12 col-md-6">
              <div class="bh-field-group">
                <label for="email" class="bh-field-label">
                  <span>Email Address <span class="text-danger">*</span></span>
                </label>
                <div class="bh-input-wrapper">
                  <i class="fa-regular fa-envelope bh-input-icon"></i>
                  <input id="email" type="email" class="bh-modern-input @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" placeholder="Enter your email address">
                </div>
                @error('email')
                  <div class="text-danger small mt-1"><i class="fa-solid fa-circle-info me-1"></i>{{ $message }}</div>
                @enderror
              </div>
            </div>
          </div>

          <!-- 3. Row: Contact Phone + Gender Dropdown + Date of Birth -->
          <div class="row g-3">
            <div class="col-12 col-md-4">
              <div class="bh-field-group">
                <label for="contact" class="bh-field-label">
                  <span>Contact Number</span>
                </label>
                <div class="bh-input-wrapper">
                  <i class="fa-solid fa-phone bh-input-icon"></i>
                  <input id="contact" type="tel" class="bh-modern-input @error('contact') is-invalid @enderror" name="contact" value="{{ old('contact') }}" autocomplete="tel" placeholder="Enter contact number">
                </div>
                @error('contact')
                  <div class="text-danger small mt-1"><i class="fa-solid fa-circle-info me-1"></i>{{ $message }}</div>
                @enderror
              </div>
            </div>

            <div class="col-12 col-md-4">
              <div class="bh-field-group">
                <label for="gender" class="bh-field-label">
                  <span>Gender</span>
                </label>
                <div class="bh-input-wrapper">
                  <i class="fa-solid fa-venus-mars bh-input-icon"></i>
                  <select id="gender" name="gender" class="bh-modern-select @error('gender') is-invalid @enderror">
                    <option value="" disabled {{ old('gender') ? '' : 'selected' }}>Select gender...</option>
                    <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Male</option>
                    <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Female</option>
                    <option value="other" {{ old('gender') == 'other' ? 'selected' : '' }}>Other</option>
                    <option value="prefer_not_to_say" {{ old('gender') == 'prefer_not_to_say' ? 'selected' : '' }}>Prefer not to say</option>
                  </select>
                </div>
                @error('gender')
                  <div class="text-danger small mt-1"><i class="fa-solid fa-circle-info me-1"></i>{{ $message }}</div>
                @enderror
              </div>
            </div>

            <div class="col-12 col-md-4">
              <div class="bh-field-group">
                <label for="dob" class="bh-field-label">
                  <span>Date of Birth</span>
                </label>
                <div class="bh-input-wrapper">
                  <i class="fa-regular fa-calendar bh-input-icon"></i>
                  <input id="dob" type="date" class="bh-modern-input @error('dob') is-invalid @enderror" name="dob" value="{{ old('dob') }}" max="{{ date('Y-m-d') }}">
                </div>
                @error('dob')
                  <div class="text-danger small mt-1"><i class="fa-solid fa-circle-info me-1"></i>{{ $message }}</div>
                @enderror
              </div>
            </div>
          </div>

          <!-- 4. Primary Niche / Category (Searchable Dropdown) -->
          <div class="bh-field-group">
            <label class="bh-field-label">
              <span>Primary Niche / Writing Category <span class="text-danger">*</span></span>
              <span class="text-muted" style="font-size: 0.72rem;">Searchable Dropdown</span>
            </label>

            <!-- Hidden input submitted with the form -->
            <input type="hidden" name="niche" id="nicheInput" value="{{ old('niche', '') }}">

            <div class="bh-niche-custom-dropdown" id="nicheDropdownWrapper">
              
              <!-- Inset Icon & Trigger Button -->
              <div class="bh-input-wrapper">
                <i class="fa-solid fa-shapes bh-input-icon" id="nichePrefixIcon"></i>
                <button type="button" class="bh-niche-btn-trigger" id="nicheTriggerBtn" aria-haspopup="true" aria-expanded="false">
                  <span class="d-flex align-items-center gap-2" id="nicheDisplayContainer">
                    <span class="text-muted" id="nicheSelectedText">Choose your primary niche (e.g. AI, Tech, Sports, Cooking, Fashion)...</span>
                  </span>
                  <i class="fa-solid fa-chevron-down text-muted transition-transform" id="nicheChevron"></i>
                </button>
              </div>

              <!-- Floating Filterable Menu -->
              <div class="bh-niche-menu-popover" id="nicheMenuPopover">
                
                <!-- Search Input Bar -->
                <div class="bh-niche-search-bar">
                  <div class="position-relative">
                    <i class="fa-solid fa-magnifying-glass position-absolute top-50 start-0 translate-middle-y ms-2 text-muted" style="font-size: 0.8rem;"></i>
                    <input type="text" class="bh-niche-search-input" id="nicheSearchInput" placeholder="Type to filter niches (e.g. AI, Cooking, Tech, Fashion)..." autocomplete="off">
                    <button type="button" id="nicheClearSearch" class="btn btn-sm btn-link position-absolute top-50 end-0 translate-middle-y me-2 text-muted p-0 d-none" style="text-decoration: none;">
                      <i class="fa-solid fa-xmark"></i>
                    </button>
                  </div>
                </div>

                <!-- Quick Filter Pill Chips -->
                <div class="bh-niche-chips">
                  <button type="button" class="bh-niche-chip-btn active" data-filter="all">All</button>
                  <button type="button" class="bh-niche-chip-btn" data-filter="ai">AI</button>
                  <button type="button" class="bh-niche-chip-btn" data-filter="tech">Tech</button>
                  <button type="button" class="bh-niche-chip-btn" data-filter="sports">Sports</button>
                  <button type="button" class="bh-niche-chip-btn" data-filter="cooking">Cooking</button>
                  <button type="button" class="bh-niche-chip-btn" data-filter="fashion">Fashion</button>
                </div>

                <!-- Niches List -->
                <ul class="bh-niche-items-container" id="nicheOptionsList">
                  @php
                    $availableNiches = $niches ?? [
                      ['id' => 'ai', 'name' => 'Artificial Intelligence (AI)', 'icon' => 'fa-brain', 'color' => '#7C3AED', 'description' => 'Machine learning, generative AI, LLMs & robotics'],
                      ['id' => 'tech', 'name' => 'Technology & Coding', 'icon' => 'fa-laptop-code', 'color' => '#2563EB', 'description' => 'Web development, software engineering & cloud systems'],
                      ['id' => 'sports', 'name' => 'Sports & Fitness', 'icon' => 'fa-futbol', 'color' => '#DC2626', 'description' => 'Athletics, football, workout routines & fitness advice'],
                      ['id' => 'cooking', 'name' => 'Cooking & Food', 'icon' => 'fa-utensils', 'color' => '#D97706', 'description' => 'Gourmet recipes, baking, dining & culinary culture'],
                      ['id' => 'fashion', 'name' => 'Fashion & Style', 'icon' => 'fa-shirt', 'color' => '#DB2777', 'description' => 'Runway trends, seasonal styling, beauty & cosmetics'],
                      ['id' => 'business', 'name' => 'Business & Startups', 'icon' => 'fa-chart-line', 'color' => '#059669', 'description' => 'Entrepreneurship, leadership, venture & market trends'],
                      ['id' => 'finance', 'name' => 'Finance & Crypto', 'icon' => 'fa-coins', 'color' => '#0D9488', 'description' => 'Personal finance, stock markets, cryptocurrency & investing'],
                      ['id' => 'health', 'name' => 'Health & Wellness', 'icon' => 'fa-heart-pulse', 'color' => '#10B981', 'description' => 'Mental health, nutrition, wellness & longevity'],
                      ['id' => 'travel', 'name' => 'Travel & Tourism', 'icon' => 'fa-plane-departure', 'color' => '#3B82F6', 'description' => 'Destination guides, culture, wanderlust & city reviews'],
                      ['id' => 'entertainment', 'name' => 'Entertainment & Gaming', 'icon' => 'fa-gamepad', 'color' => '#8B5CF6', 'description' => 'Video games, cinema reviews, pop culture & streaming'],
                      ['id' => 'lifestyle', 'name' => 'Culture & Lifestyle', 'icon' => 'fa-book-open', 'color' => '#E11D48', 'description' => 'Books, philosophy, habits & thoughtful living'],
                      ['id' => 'design', 'name' => 'Design & Creative Arts', 'icon' => 'fa-palette', 'color' => '#C8461F', 'description' => 'UI/UX design, visual branding, typography & digital art'],
                    ];
                  @endphp

                  @foreach ($availableNiches as $item)
                    <li class="bh-niche-item" 
                        data-id="{{ $item['id'] }}" 
                        data-name="{{ $item['name'] }}" 
                        data-icon="{{ $item['icon'] }}" 
                        data-color="{{ $item['color'] }}"
                        data-keywords="{{ strtolower($item['name'] . ' ' . $item['description'] . ' ' . $item['id']) }}">
                      <div class="d-flex align-items-center gap-2.5">
                        <span class="bh-niche-badge-icon" style="background-color: {{ $item['color'] }};">
                          <i class="fa-solid {{ $item['icon'] }}"></i>
                        </span>
                        <div>
                          <div class="fw-semibold small niche-title-text">{{ $item['name'] }}</div>
                          <div class="text-muted" style="font-size: 0.72rem;">{{ $item['description'] }}</div>
                        </div>
                      </div>
                      <i class="fa-solid fa-check text-accent niche-check-icon d-none"></i>
                    </li>
                  @endforeach
                </ul>

                <!-- Empty State -->
                <div id="nicheEmptyState" class="text-center py-4 px-3 text-muted small d-none">
                  <i class="fa-solid fa-magnifying-glass-minus fs-4 mb-2 d-block text-secondary"></i>
                  No niches found matching your search.
                </div>

              </div>
            </div>
            @error('niche')
              <div class="text-danger small mt-1"><i class="fa-solid fa-circle-info me-1"></i>{{ $message }}</div>
            @enderror
          </div>

          <!-- 5. About / Bio Field -->
          <div class="bh-field-group">
            <label for="about" class="bh-field-label">
              <span>About / Bio</span>
              <span class="text-muted" style="font-size: 0.72rem;" id="bioCharCounter">0 / 500</span>
            </label>
            <div class="bh-input-wrapper">
              <i class="fa-regular fa-pen-to-square bh-input-icon" style="top: 0.85rem;"></i>
              <textarea id="about" class="bh-modern-textarea @error('about') is-invalid @enderror" name="about" rows="3" maxlength="500" placeholder="Write a brief bio about yourself or your writing passion...">{{ old('about') }}</textarea>
            </div>
            @error('about')
              <div class="text-danger small mt-1"><i class="fa-solid fa-circle-info me-1"></i>{{ $message }}</div>
            @enderror
          </div>

          <!-- 6. Row: Password & Confirm Password -->
          <div class="row g-3">
            <div class="col-12 col-md-6">
              <div class="bh-field-group">
                <label for="password" class="bh-field-label">
                  <span>Password <span class="text-danger">*</span></span>
                </label>
                <div class="bh-input-wrapper">
                  <i class="fa-solid fa-lock bh-input-icon"></i>
                  <input id="password" type="password" class="bh-modern-input @error('password') is-invalid @enderror" name="password" required autocomplete="new-password" placeholder="Enter password (min 6 characters)">
                  <button type="button" class="bh-toggle-btn" id="togglePassword" aria-label="Toggle password visibility">
                    <i class="fa-regular fa-eye" id="toggleIcon"></i>
                  </button>
                </div>
                @error('password')
                  <div class="text-danger small mt-1"><i class="fa-solid fa-circle-info me-1"></i>{{ $message }}</div>
                @enderror
              </div>
            </div>

            <div class="col-12 col-md-6">
              <div class="bh-field-group">
                <label for="password-confirm" class="bh-field-label">
                  <span>Confirm Password <span class="text-danger">*</span></span>
                </label>
                <div class="bh-input-wrapper">
                  <i class="fa-solid fa-shield-halved bh-input-icon"></i>
                  <input id="password-confirm" type="password" class="bh-modern-input" name="password_confirmation" required autocomplete="new-password" placeholder="Confirm password">
                  <button type="button" class="bh-toggle-btn" id="toggleConfirmPassword" aria-label="Toggle confirm password visibility">
                    <i class="fa-regular fa-eye" id="toggleConfirmIcon"></i>
                  </button>
                </div>
                <div id="passwordMismatchNotice" class="text-danger small mt-1 d-none">
                  <i class="fa-solid fa-circle-exclamation me-1"></i> Passwords do not match.
                </div>
              </div>
            </div>
          </div>

          <!-- Terms agreement note -->
          <div class="small text-muted my-3">
            By creating an account, you agree to our 
            <a href="{{ route('terms') }}" class="text-accent text-decoration-none fw-semibold" target="_blank">Terms</a> and 
            <a href="{{ route('privacy') }}" class="text-accent text-decoration-none fw-semibold" target="_blank">Privacy Policy</a>.
          </div>

          <!-- Submit Button -->
          <button type="submit" id="submitRegisterBtn" class="bh-btn-register-primary">
            <span>Create Author Account</span>
            <i class="fa-solid fa-arrow-right"></i>
          </button>
        </form>

        <!-- Mobile Sign In Prompt -->
        <div class="text-center mt-4 d-block d-sm-none">
          <p class="small text-muted mb-0">
            Already have an account? 
            <a href="{{ route('login') }}" class="fw-bold text-accent text-decoration-none">Sign In</a>
          </p>
        </div>

      </div>

    </div>
  </div>
</div>
@endsection

@push('scripts')
<script>
  document.addEventListener('DOMContentLoaded', function () {
    
    // ==========================================
    // 1. Password Visibility Toggles & Match Check
    // ==========================================
    const toggleBtn = document.getElementById('togglePassword');
    const passInput = document.getElementById('password');
    const toggleIcon = document.getElementById('toggleIcon');

    const toggleConfirmBtn = document.getElementById('toggleConfirmPassword');
    const confirmInput = document.getElementById('password-confirm');
    const toggleConfirmIcon = document.getElementById('toggleConfirmIcon');
    const mismatchNotice = document.getElementById('passwordMismatchNotice');

    if (toggleBtn && passInput && toggleIcon) {
      toggleBtn.addEventListener('click', function () {
        const isPassword = passInput.getAttribute('type') === 'password';
        passInput.setAttribute('type', isPassword ? 'text' : 'password');
        toggleIcon.className = isPassword ? 'fa-regular fa-eye-slash' : 'fa-regular fa-eye';
      });
    }

    if (toggleConfirmBtn && confirmInput && toggleConfirmIcon) {
      toggleConfirmBtn.addEventListener('click', function () {
        const isPassword = confirmInput.getAttribute('type') === 'password';
        confirmInput.setAttribute('type', isPassword ? 'text' : 'password');
        toggleConfirmIcon.className = isPassword ? 'fa-regular fa-eye-slash' : 'fa-regular fa-eye';
      });
    }

    function checkPasswordMatch() {
      if (!confirmInput.value) {
        mismatchNotice.classList.add('d-none');
        return;
      }
      if (passInput.value !== confirmInput.value) {
        mismatchNotice.classList.remove('d-none');
      } else {
        mismatchNotice.classList.add('d-none');
      }
    }

    if (passInput && confirmInput && mismatchNotice) {
      passInput.addEventListener('input', checkPasswordMatch);
      confirmInput.addEventListener('input', checkPasswordMatch);
    }

    // ==========================================
    // 2. Profile Avatar Live Preview & Synchronization
    // ==========================================
    const imageInput = document.getElementById('imageInput');
    const avatarPlaceholderBox = document.getElementById('avatarPlaceholderBox');
    const avatarImgPreview = document.getElementById('avatarImgPreview');
    const resetAvatarBtn = document.getElementById('resetAvatarBtn');

    if (imageInput) {
      imageInput.addEventListener('change', function (e) {
        const file = e.target.files[0];
        if (file) {
          if (file.size > 4 * 1024 * 1024) {
            alert('Avatar image is too large! Please choose an image smaller than 4MB.');
            imageInput.value = '';
            return;
          }
          const reader = new FileReader();
          reader.onload = function (event) {
            const dataUrl = event.target.result;
            if (avatarImgPreview) {
              avatarImgPreview.src = dataUrl;
              avatarImgPreview.classList.remove('d-none');
            }
            if (avatarPlaceholderBox) {
              avatarPlaceholderBox.classList.add('d-none');
            }
            if (resetAvatarBtn) {
              resetAvatarBtn.classList.remove('d-none');
            }
          };
          reader.readAsDataURL(file);
        }
      });
    }

    if (resetAvatarBtn && imageInput) {
      resetAvatarBtn.addEventListener('click', function () {
        imageInput.value = '';
        if (avatarImgPreview) {
          avatarImgPreview.src = '';
          avatarImgPreview.classList.add('d-none');
        }
        if (avatarPlaceholderBox) {
          avatarPlaceholderBox.classList.remove('d-none');
        }
        resetAvatarBtn.classList.add('d-none');
      });
    }

    // ==========================================
    // 3. About / Bio Character Counter
    // ==========================================
    const aboutInput = document.getElementById('about');
    const bioCharCounter = document.getElementById('bioCharCounter');
    if (aboutInput && bioCharCounter) {
      bioCharCounter.textContent = `${aboutInput.value.length} / 500`;
      aboutInput.addEventListener('input', function () {
        bioCharCounter.textContent = `${this.value.length} / 500`;
      });
    }

    // ==========================================
    // 4. Custom Searchable Niche Dropdown
    // ==========================================
    const nicheDropdownWrapper = document.getElementById('nicheDropdownWrapper');
    const nicheTriggerBtn = document.getElementById('nicheTriggerBtn');
    const nicheMenuPopover = document.getElementById('nicheMenuPopover');
    const nicheSearchInput = document.getElementById('nicheSearchInput');
    const nicheClearSearch = document.getElementById('nicheClearSearch');
    const nicheEmptyState = document.getElementById('nicheEmptyState');
    const nicheInput = document.getElementById('nicheInput');
    const nicheSelectedText = document.getElementById('nicheSelectedText');
    const nicheChevron = document.getElementById('nicheChevron');
    const nichePrefixIcon = document.getElementById('nichePrefixIcon');
    const quickTagBtns = document.querySelectorAll('.bh-niche-chip-btn');
    const nicheItems = document.querySelectorAll('.bh-niche-item');

    function toggleNicheDropdown(forceClose = false) {
      const isOpen = nicheMenuPopover.classList.contains('show');
      if (isOpen || forceClose) {
        nicheMenuPopover.classList.remove('show');
        nicheTriggerBtn.classList.remove('active');
        if (nicheChevron) nicheChevron.style.transform = 'rotate(0deg)';
      } else {
        nicheMenuPopover.classList.add('show');
        nicheTriggerBtn.classList.add('active');
        if (nicheChevron) nicheChevron.style.transform = 'rotate(180deg)';
        setTimeout(() => nicheSearchInput && nicheSearchInput.focus(), 60);
      }
    }

    if (nicheTriggerBtn) {
      nicheTriggerBtn.addEventListener('click', function (e) {
        e.stopPropagation();
        toggleNicheDropdown();
      });
    }

    document.addEventListener('click', function (e) {
      if (nicheDropdownWrapper && !nicheDropdownWrapper.contains(e.target)) {
        toggleNicheDropdown(true);
      }
    });

    function selectNicheOption(item) {
      const name = item.getAttribute('data-name');
      const icon = item.getAttribute('data-icon');
      const color = item.getAttribute('data-color');

      if (nicheInput) nicheInput.value = name;

      // Update Trigger Button Display
      if (nicheSelectedText) {
        nicheSelectedText.innerHTML = `
          <span class="bh-niche-badge-icon me-1" style="background-color: ${color}; width: 22px; height: 22px; font-size: 0.7rem; border-radius: 4px;">
            <i class="fa-solid ${icon}"></i>
          </span>
          <span class="fw-semibold text-dark">${name}</span>
        `;
      }
      if (nichePrefixIcon) {
        nichePrefixIcon.style.color = color;
      }

      // Update checkmark
      nicheItems.forEach(opt => {
        const check = opt.querySelector('.niche-check-icon');
        if (opt === item) {
          opt.classList.add('selected');
          if (check) check.classList.remove('d-none');
        } else {
          opt.classList.remove('selected');
          if (check) check.classList.add('d-none');
        }
      });

      toggleNicheDropdown(true);
    }

    nicheItems.forEach(item => {
      item.addEventListener('click', function (e) {
        e.stopPropagation();
        selectNicheOption(this);
      });
    });

    // Restore old value if exists
    const initialNiche = nicheInput ? nicheInput.value.trim() : '';
    if (initialNiche) {
      nicheItems.forEach(item => {
        if (item.getAttribute('data-name') === initialNiche) {
          selectNicheOption(item);
        }
      });
    }

    // Live search filter
    function filterNichesList() {
      const query = (nicheSearchInput.value || '').trim().toLowerCase();
      
      if (nicheClearSearch) {
        nicheClearSearch.classList.toggle('d-none', query.length === 0);
      }

      let visible = 0;
      nicheItems.forEach(item => {
        const keywords = item.getAttribute('data-keywords') || '';
        if (keywords.includes(query)) {
          item.style.display = 'flex';
          visible++;
        } else {
          item.style.display = 'none';
        }
      });

      if (nicheEmptyState) {
        nicheEmptyState.classList.toggle('d-none', visible > 0);
      }
    }

    if (nicheSearchInput) {
      nicheSearchInput.addEventListener('input', filterNichesList);
      nicheSearchInput.addEventListener('click', (e) => e.stopPropagation());
    }

    if (nicheClearSearch && nicheSearchInput) {
      nicheClearSearch.addEventListener('click', function (e) {
        e.stopPropagation();
        nicheSearchInput.value = '';
        filterNichesList();
        nicheSearchInput.focus();
      });
    }

    // Quick filter chips
    quickTagBtns.forEach(btn => {
      btn.addEventListener('click', function (e) {
        e.stopPropagation();
        quickTagBtns.forEach(b => b.classList.remove('active'));
        this.classList.add('active');

        const filter = this.getAttribute('data-filter');
        if (filter === 'all') {
          if (nicheSearchInput) nicheSearchInput.value = '';
        } else {
          if (nicheSearchInput) nicheSearchInput.value = filter;
        }
        filterNichesList();
      });
    });

  });
</script>
@endpush
