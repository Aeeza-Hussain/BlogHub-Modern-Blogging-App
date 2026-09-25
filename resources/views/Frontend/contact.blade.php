@extends('layouts.app')

@section('title', 'Contact Us — BlogHub')

@section('content')
<section class="py-5">
  <div class="container">
    <div class="text-center max-w-700 mx-auto mb-5">
      <span class="bh-badge bh-badge-coral mb-2">Get in Touch</span>
      <h1 class="font-heading fw-bold display-5">Contact Our Team</h1>
      <p class="text-muted">Have a question, feedback, or editorial inquiry? Send us a message below.</p>
    </div>

    <div class="row g-4 mb-5">
      <!-- Contact Info Block (SRS 7.8) -->
      <div class="col-lg-5">
        <div class="bh-card p-4 p-md-5 h-100 bg-primary text-white">
          <h3 class="font-heading fw-bold mb-4 text-white">Contact Information</h3>
          <p class="text-light-50 mb-4">Feel free to reach out directly via email, phone, or visit our headquarters.</p>

          <div class="d-flex flex-column gap-4">
            <div class="d-flex align-items-center gap-3">
              <div class="bg-white text-primary rounded-circle d-flex align-items-center justify-content-center" style="width: 44px; height: 44px;">
                <i class="fas fa-map-marker-alt fs-5"></i>
              </div>
              <div>
                <h6 class="font-heading fw-bold mb-0 text-white">Headquarters</h6>
                <span class="small text-light-50">100 Innovation Boulevard, Tech City</span>
              </div>
            </div>

            <div class="d-flex align-items-center gap-3">
              <div class="bg-white text-primary rounded-circle d-flex align-items-center justify-content-center" style="width: 44px; height: 44px;">
                <i class="fas fa-envelope fs-5"></i>
              </div>
              <div>
                <h6 class="font-heading fw-bold mb-0 text-white">Email Us</h6>
                <span class="small text-light-50">support@bloghub.com</span>
              </div>
            </div>

            <div class="d-flex align-items-center gap-3">
              <div class="bg-white text-primary rounded-circle d-flex align-items-center justify-content-center" style="width: 44px; height: 44px;">
                <i class="fas fa-phone-alt fs-5"></i>
              </div>
              <div>
                <h6 class="font-heading fw-bold mb-0 text-white">Call Support</h6>
                <span class="small text-light-50">+1 (800) 555-BLOG</span>
              </div>
            </div>
          </div>

          <!-- Map Placeholder (SRS 7.8) -->
          <div class="mt-5 rounded-3 overflow-hidden border border-secondary" style="height: 160px; background: url('https://images.unsplash.com/photo-1526778548025-fa2f459cd5c1?auto=format&fit=crop&w=600&q=80') center/cover;">
            <div class="w-100 h-100 d-flex align-items-center justify-content-center bg-dark bg-opacity-50">
              <span class="bh-badge bh-badge-coral"><i class="fas fa-map-pin"></i> Interactive Map</span>
            </div>
          </div>
        </div>
      </div>

      <!-- Contact Form (SRS 7.8) -->
      <div class="col-lg-7">
        <div class="bh-card p-4 p-md-5 h-100">
          <h3 class="font-heading fw-bold mb-4">Send Us a Message</h3>

          @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
              <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
              <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
          @endif

          <form action="{{ route('contact.store') }}" method="POST" class="needs-validation" novalidate>
            @csrf
            <div class="row g-3">
              <div class="col-md-6">
                <label for="name" class="form-label font-mono small fw-semibold">Your Name</label>
                <input type="text" name="name" id="name" class="form-control" placeholder="John Doe" required>
                <div class="invalid-feedback">Please enter your name.</div>
              </div>
              <div class="col-md-6">
                <label for="email" class="form-label font-mono small fw-semibold">Email Address</label>
                <input type="email" name="email" id="email" class="form-control" placeholder="john@example.com" required>
                <div class="invalid-feedback">Please enter a valid email address.</div>
              </div>
              <div class="col-12">
                <label for="subject" class="form-label font-mono small fw-semibold">Subject</label>
                <input type="text" name="subject" id="subject" class="form-control" placeholder="Inquiry about..." required>
                <div class="invalid-feedback">Please enter a subject.</div>
              </div>
              <div class="col-12">
                <label for="message" class="form-label font-mono small fw-semibold">Message</label>
                <textarea name="message" id="message" class="form-control" rows="5" placeholder="Write your message here..." required></textarea>
                <div class="invalid-feedback">Please enter your message.</div>
              </div>
              <div class="col-12">
                <button type="submit" class="btn btn-bh-accent btn-lg w-100">Send Message</button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>

    <!-- FAQ Accordion (SRS 7.8) -->
    <div class="max-w-800 mx-auto mt-5">
      <h3 class="font-heading fw-bold text-center mb-4">Frequently Asked Questions</h3>
      <div class="accordion" id="contactFaq">
        <div class="accordion-item bh-card mb-2 border">
          <h2 class="accordion-header">
            <button class="accordion-button font-heading fw-bold bg-transparent" type="button" data-bs-toggle="collapse" data-bs-target="#faq1">
              How do I become an author on BlogHub?
            </button>
          </h2>
          <div id="faq1" class="accordion-collapse collapse show" data-bs-parent="#contactFaq">
            <div class="accordion-body text-muted small">
              You can sign up for a free author account on our Register page. Once submitted, our editorial team reviews your profile within 24 hours.
            </div>
          </div>
        </div>

        <div class="accordion-item bh-card mb-2 border">
          <h2 class="accordion-header">
            <button class="accordion-button collapsed font-heading fw-bold bg-transparent" type="button" data-bs-toggle="collapse" data-bs-target="#faq2">
              Can I customize my author profile?
            </button>
          </h2>
          <div id="faq2" class="accordion-collapse collapse" data-bs-parent="#contactFaq">
            <div class="accordion-body text-muted small">
              Yes, authors can update their avatar, cover image, bio, tagline, and specialty tags from their profile settings.
            </div>
          </div>
        </div>
      </div>
    </div>

  </div>
</section>
@endsection
