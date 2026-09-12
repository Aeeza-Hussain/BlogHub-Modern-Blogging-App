# BlogHub — Modern Blogging & Content Management Platform

> **Capstone Frontend & Backend Prototype (SRS v2.0)**  
> A high-performance, multi-category publishing platform built with **Laravel 12**, **Bootstrap 5.3**, **MySQL**, **Blade Components**, and modern Vanilla JavaScript.

---

## 🌟 Key Features

- **🎨 Modern Design System**: Built with custom HSL/HEX color tokens (Navy `#1F2A44`, Coral `#C8461F`, Moss `#3F5A45`), typography scaling (`Fraunces`, `Inter`, `IBM Plex Mono`), glassmorphism cards, and smooth micro-animations.
- **🌙 Theme Switching**: Persistent Dark/Light mode toggle powered by `localStorage` and `data-theme` CSS variables.
- **📚 15 Complete Views & Templates**:
  - **Public / Marketing**: Home (Hero, Featured Grid, Trending Carousel, Animated Stats, Testimonials, Newsletter), About Us, Contact Us with interactive map & FAQ accordion, Privacy Policy, Terms & Conditions, and Custom 404 Error page.
  - **Content & Search**: Article Listing with live JS search & category/author filtering, Single Article Detail with formatted rich content & code snippets, Categories Directory, Search Results page.
  - **Authors & Profile**: Author Directory with follow toggle state, Detailed Author Profile with cover image & published articles.
  - **Account & Auth**: Member Login, Author Registration with password strength meter, Forgot Password with 6-digit OTP UI states.
- **⚡ Student-Friendly Laravel CRUD**: Clean, Eloquent models (`Article`, `Category`, `Author`, `Comment`, `ContactMessage`), standard controllers, and RESTful routes in `routes/web.php`.
- **🗄️ MySQL Database & Seeders**: Seeded with 22+ long-form articles, 10 topic categories, 8 author profiles, and 85+ comments.

---

## 🛠️ Technology Stack

- **Framework**: Laravel 12 (PHP 8.2+)
- **Styling**: Bootstrap 5.3 + Custom Modern CSS3 (`public/css/style.css`)
- **Scripting**: Vanilla JavaScript ES6+ (`public/js/main.js`)
- **Database**: MySQL 8.0+
- **Icons & Fonts**: FontAwesome 6.5, Google Fonts (`Fraunces`, `Inter`, `IBM Plex Mono`)

---

## 🚀 Quick Setup Instructions

1. **Clone the Repository**:
   ```bash
   git clone https://github.com/YOUR_USERNAME/bloghub-laravel-platform.git
   cd bloghub-laravel-platform
   ```

2. **Install Dependencies**:
   ```bash
   composer install
   npm install
   ```

3. **Configure Environment File**:
   Copy `.env.example` to `.env`:
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. **Setup Database & Run Migrations**:
   Ensure MySQL server is running and configure your database parameters in `.env`:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=Bloghubnew_db
   DB_USERNAME=root
   DB_PASSWORD=
   ```
   Then run migrations with dummy data seeder:
   ```bash
   php artisan migrate:fresh --seed
   ```

5. **Start Local Development Server**:
   ```bash
   php artisan serve
   ```
   Open your browser at `http://127.0.0.1:8000`.

---

## 📂 Folder Structure

```
BlogHub/
├── app/
│   ├── Http/Controllers/    # ArticleController, HomeController, AuthorController, etc.
│   └── Models/              # Article, Category, Author, Comment, ContactMessage
├── database/
│   ├── migrations/          # Table definitions for BlogHub
│   └── seeders/             # BlogHubSeeder with realistic dummy data
├── public/
│   ├── css/style.css        # BlogHub design system & dark mode rules
│   └── js/main.js           # Client-side interactivity (dark mode, search, toasts)
├── resources/views/
│   ├── components/          # Reusable Blade components (navbar, footer, blog-card, etc.)
│   ├── blogs/               # Blog listing, details, and create CRUD views
│   ├── authors/             # Author directory & profile views
│   ├── categories/          # Categories directory view
│   ├── auth/                # Login, Register, Forgot Password views
│   ├── legal/               # Privacy & Terms views
│   └── home.blade.php       # Flagship landing page
└── routes/web.php           # Application web routes
```

---

## 📄 License
Designed for educational & capstone submission under the MIT License.
