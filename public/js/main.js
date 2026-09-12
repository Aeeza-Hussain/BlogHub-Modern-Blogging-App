/* ==========================================
   BlogHub Client-Side Interactivity (SRS V2.0)
   ========================================== */

document.addEventListener('DOMContentLoaded', () => {
  initDarkMode();
  initScrollProgress();
  initBackToTop();
  initLikeButtons();
  initCopyLinkButtons();
  initFormValidations();
  initPasswordToggles();
  initPasswordStrengthMeter();
  initStatsCounters();
  initGridListToggle();
  initLiveSearch();
});

/* 1. Dark Mode Toggle & Persistence */
function initDarkMode() {
  const toggleBtn = document.getElementById('dark-mode-toggle');
  const savedTheme = localStorage.getItem('bh-theme') || 'light';
  
  document.documentElement.setAttribute('data-theme', savedTheme);
  updateThemeIcon(savedTheme);

  if (toggleBtn) {
    toggleBtn.addEventListener('click', () => {
      const currentTheme = document.documentElement.getAttribute('data-theme');
      const newTheme = currentTheme === 'dark' ? 'light' : 'dark';
      
      document.documentElement.setAttribute('data-theme', newTheme);
      localStorage.setItem('bh-theme', newTheme);
      updateThemeIcon(newTheme);
      showToast(newTheme === 'dark' ? 'Dark mode enabled 🌙' : 'Light mode enabled ☀️', 'info');
    });
  }
}

function updateThemeIcon(theme) {
  const toggleBtn = document.getElementById('dark-mode-toggle');
  if (toggleBtn) {
    const icon = toggleBtn.querySelector('i');
    if (icon) {
      icon.className = theme === 'dark' ? 'fas fa-sun text-warning' : 'fas fa-moon';
    }
  }
}

/* 2. Scroll Progress Bar */
function initScrollProgress() {
  const progressBar = document.getElementById('scroll-progress');
  if (!progressBar) return;

  window.addEventListener('scroll', () => {
    const winScroll = document.body.scrollTop || document.documentElement.scrollTop;
    const height = document.documentElement.scrollHeight - document.documentElement.clientHeight;
    const scrolled = (winScroll / height) * 100;
    progressBar.style.width = scrolled + '%';
  });
}

/* 3. Back to Top Floating Button */
function initBackToTop() {
  const backToTopBtn = document.getElementById('back-to-top');
  if (!backToTopBtn) return;

  window.addEventListener('scroll', () => {
    if (window.scrollY > 300) {
      backToTopBtn.classList.add('show');
    } else {
      backToTopBtn.classList.remove('show');
    }
  });

  backToTopBtn.addEventListener('click', () => {
    window.scrollTo({ top: 0, behavior: 'smooth' });
  });
}

/* 4. Like / Bookmark Animations & Counter */
function initLikeButtons() {
  document.querySelectorAll('.btn-like-toggle').forEach(btn => {
    btn.addEventListener('click', function(e) {
      e.preventDefault();
      const icon = this.querySelector('i');
      const countSpan = this.querySelector('.like-count');
      let count = parseInt(countSpan ? countSpan.textContent : '0', 10);
      
      const isLiked = this.classList.contains('active');
      if (isLiked) {
        this.classList.remove('active');
        if (icon) icon.className = 'far fa-heart';
        count = Math.max(0, count - 1);
        showToast('Article unliked', 'info');
      } else {
        this.classList.add('active');
        if (icon) {
          icon.className = 'fas fa-heart text-danger animate-pulse';
          setTimeout(() => icon.classList.remove('animate-pulse'), 350);
        }
        count += 1;
        showToast('Article added to liked list ❤️', 'success');
      }
      
      if (countSpan) countSpan.textContent = count;
    });
  });

  document.querySelectorAll('.btn-bookmark-toggle').forEach(btn => {
    btn.addEventListener('click', function(e) {
      e.preventDefault();
      const icon = this.querySelector('i');
      const isBookmarked = this.classList.contains('active');
      
      if (isBookmarked) {
        this.classList.remove('active');
        if (icon) icon.className = 'far fa-bookmark';
        showToast('Removed from bookmarks', 'info');
      } else {
        this.classList.add('active');
        if (icon) icon.className = 'fas fa-bookmark text-primary';
        showToast('Article saved to bookmarks 📌', 'success');
      }
    });
  });
}

/* 5. Copy Link & Share Popup */
function initCopyLinkButtons() {
  document.querySelectorAll('.btn-copy-link').forEach(btn => {
    btn.addEventListener('click', (e) => {
      e.preventDefault();
      navigator.clipboard.writeText(window.location.href).then(() => {
        showToast('Link copied to clipboard! 📋', 'success');
      }).catch(() => {
        showToast('Failed to copy link', 'danger');
      });
    });
  });
}

/* 6. Form Validations */
function initFormValidations() {
  const forms = document.querySelectorAll('.needs-validation');
  forms.forEach(form => {
    form.addEventListener('submit', event => {
      if (!form.checkValidity()) {
        event.preventDefault();
        event.stopPropagation();
      } else {
        // If handled via AJAX or local demo submit
        if (form.getAttribute('data-ajax') === 'true') {
          event.preventDefault();
          showToast('Form submitted successfully!', 'success');
          form.reset();
          form.classList.remove('was-validated');
          return;
        }
      }
      form.classList.add('was-validated');
    }, false);
  });
}

/* 7. Password Show/Hide Toggle */
function initPasswordToggles() {
  document.querySelectorAll('.password-toggle-btn').forEach(btn => {
    btn.addEventListener('click', function() {
      const targetId = this.getAttribute('data-target');
      const input = document.getElementById(targetId);
      const icon = this.querySelector('i');
      
      if (input) {
        if (input.type === 'password') {
          input.type = 'text';
          if (icon) icon.className = 'fas fa-eye-slash';
        } else {
          input.type = 'password';
          if (icon) icon.className = 'fas fa-eye';
        }
      }
    });
  });
}

/* 8. Password Strength Indicator */
function initPasswordStrengthMeter() {
  const passwordInput = document.getElementById('register-password');
  const strengthBar = document.getElementById('password-strength-bar');
  const strengthText = document.getElementById('password-strength-text');

  if (!passwordInput || !strengthBar || !strengthText) return;

  passwordInput.addEventListener('input', () => {
    const val = passwordInput.value;
    let score = 0;

    if (val.length >= 6) score += 25;
    if (val.match(/[A-Z]/)) score += 25;
    if (val.match(/[0-9]/)) score += 25;
    if (val.match(/[^A-Za-z0-9]/)) score += 25;

    strengthBar.style.width = score + '%';

    if (score <= 25) {
      strengthBar.className = 'progress-bar bg-danger';
      strengthText.textContent = 'Weak';
    } else if (score <= 50) {
      strengthBar.className = 'progress-bar bg-warning';
      strengthText.textContent = 'Fair';
    } else if (score <= 75) {
      strengthBar.className = 'progress-bar bg-info';
      strengthText.textContent = 'Good';
    } else {
      strengthBar.className = 'progress-bar bg-success';
      strengthText.textContent = 'Strong';
    }
  });
}

/* 9. Animated Stats Counter */
function initStatsCounters() {
  const statNumbers = document.querySelectorAll('.stat-counter');
  if (statNumbers.length === 0) return;

  const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        const target = entry.target;
        const countTo = parseInt(target.getAttribute('data-target') || '0', 10);
        let current = 0;
        const increment = Math.ceil(countTo / 40);
        const timer = setInterval(() => {
          current += increment;
          if (current >= countTo) {
            target.textContent = countTo.toLocaleString();
            clearInterval(timer);
          } else {
            target.textContent = current.toLocaleString();
          }
        }, 30);
        observer.unobserve(target);
      }
    });
  }, { threshold: 0.5 });

  statNumbers.forEach(stat => observer.observe(stat));
}

/* 10. Grid / List View Toggle */
function initGridListToggle() {
  const gridBtn = document.getElementById('view-grid-btn');
  const listBtn = document.getElementById('view-list-btn');
  const container = document.getElementById('articles-container');

  if (!gridBtn || !listBtn || !container) return;

  gridBtn.addEventListener('click', () => {
    gridBtn.classList.add('active');
    listBtn.classList.remove('active');
    container.classList.remove('view-list');
    container.classList.add('view-grid');

    document.querySelectorAll('.blog-card-col').forEach(col => {
      col.className = 'col-md-6 col-lg-4 blog-card-col mb-4';
    });
  });

  listBtn.addEventListener('click', () => {
    listBtn.classList.add('active');
    gridBtn.classList.remove('active');
    container.classList.remove('view-grid');
    container.classList.add('view-list');

    document.querySelectorAll('.blog-card-col').forEach(col => {
      col.className = 'col-12 blog-card-col mb-4';
    });
  });
}

/* 11. Live Navbar Search */
function initLiveSearch() {
  const searchInput = document.getElementById('nav-search-input');
  const suggestionsBox = document.getElementById('nav-search-suggestions');

  if (!searchInput || !suggestionsBox) return;

  searchInput.addEventListener('input', () => {
    const query = searchInput.value.trim().toLowerCase();
    if (query.length < 2) {
      suggestionsBox.classList.add('d-none');
      return;
    }

    // Dummy search suggestions echo
    suggestionsBox.innerHTML = `
      <div class="list-group shadow">
        <a href="/search?q=${encodeURIComponent(query)}" class="list-group-item list-group-item-action d-flex align-items-center justify-content-between">
          <span><i class="fas fa-search me-2 text-muted"></i> Search for "<strong>${escapeHtml(query)}</strong>"</span>
          <span class="badge bg-primary rounded-pill">View All</span>
        </a>
        <a href="/blogs?category=technology" class="list-group-item list-group-item-action">
          <i class="fas fa-microchip me-2 text-primary"></i> Technology Articles related to "${escapeHtml(query)}"
        </a>
        <a href="/authors?search=${encodeURIComponent(query)}" class="list-group-item list-group-item-action">
          <i class="fas fa-user-edit me-2 text-success"></i> Search authors for "${escapeHtml(query)}"
        </a>
      </div>
    `;
    suggestionsBox.classList.remove('d-none');
  });

  document.addEventListener('click', (e) => {
    if (!searchInput.contains(e.target) && !suggestionsBox.contains(e.target)) {
      suggestionsBox.classList.add('d-none');
    }
  });
}

/* Reusable Toast Function */
function showToast(message, type = 'info') {
  let container = document.querySelector('.toast-container');
  if (!container) {
    container = document.createElement('div');
    container.className = 'toast-container';
    document.body.appendChild(container);
  }

  const toastId = 'toast-' + Date.now();
  const bgClass = type === 'success' ? 'bg-success text-white' : 
                   type === 'danger' ? 'bg-danger text-white' : 
                   type === 'warning' ? 'bg-warning text-dark' : 'bg-dark text-white';

  const html = `
    <div id="${toastId}" class="toast align-items-center ${bgClass} border-0 show shadow-lg mb-2" role="alert" aria-live="assertive" aria-atomic="true">
      <div class="d-flex">
        <div class="toast-body py-2 px-3 fw-medium">
          ${message}
        </div>
        <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
      </div>
    </div>
  `;

  container.insertAdjacentHTML('beforeend', html);
  const toastElem = document.getElementById(toastId);

  setTimeout(() => {
    if (toastElem) toastElem.remove();
  }, 4000);
}

function escapeHtml(text) {
  return text.replace(/[&<>"']/g, function(m) {
    return { '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#039;' }[m];
  });
}
